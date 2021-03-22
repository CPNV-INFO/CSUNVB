<?php

setlocale(LC_ALL, 'fr_CH'); // pour les format de dates

/**
 * getVersion : show actual project version
 */
function getVersion()
{
    return "3.0";
}

/**
 * redirect : send the browser to the desired location, depending on the action specified. It can have an id or not.
 * @param $action : the action to specify to know what to show on screen
 * @param int $id : the id of the page/element to show, not mandatory
 */
function redirect($action, $id = 0)
{
    if ($id > 0) {
        header('Location: ?action=' . $action . '&id=' . $id);
    } else {
        header('Location: ?action=' . $action);
    }
}

/**
 * inspired by source https://stackoverflow.com/questions/7447472/how-could-i-display-the-current-git-branch-name-at-the-top-of-the-page-of-my-de
 * gitBranchTag : get the tag from the corresponding GitHub branch
 */
function gitBranchTag()
{
    $stringfromfile = file('.git/HEAD', FILE_USE_INCLUDE_PATH);
    if ($stringfromfile) {
        $firstLine = $stringfromfile[0]; //get the string from the array
        $explodedstring = explode("/", $firstLine, 3); //seperate out by the "/" in the string
        $branchname = "la branche " . $explodedstring[2]; //get the one that is always the branch name
    } else {
        $branchname = "production";
    }
    return "<div style='clear: both; width: 100%; font-size: 12px; font-family: Helvetica; color: #aaaaaa; background: transparent; text-align: right;'>version " . getVersion() . " sur " . $branchname . "</div>"; //show it on the page
}

/**
 * getDaysForWeekNumber : get the 7 dates for the selected week
 * @param $weekNumber : format AASS
 * @return array : contain the 7 days
 */
function getDaysForWeekNumber($weekNumber)
{
    $year = 2000 + intdiv($weekNumber, 100);
    $week = $weekNumber % 100;

    $dates = [];
    $time = strtotime(sprintf("%4dW%02d", $year, $week));

    for ($i = 0; $i < 7; $i++) {
        $dates[] = date("Y-m-d", strtotime("+" . $i . " day", $time));
    }

    return $dates;
}

/**
 * showSheetState : Return the state of the sheet on the screen
 * @param $id id of the pages on the screen
 * @param $zone name of the zone used (shift, drugs, todo)
 * @return $state : displayname of the sheet status
 */
function showSheetState($id, $zone)
{
    if ($zone == "shift") {
        $slug = getStateFromSheet($id);
    } else if ($zone == "todo") {
        $slug = getStateFromTodo($id);
    } else if ($zone == "drugs") {
        /** $slug = getStateFromDrugs($id); */
        $slug = "tsers";
    }

    if (isset($slug['displayname'])) {
        $state = "[" . $slug['displayname'] . "]";
    } else {
        $state = "[Non défini]";
    }
    return $state;
}

/**
 * Tells if the current user (logged in) can perform a certain action according to the policy
 * @param $action : the action to check if it is doable
 * @return bool
 */
function ican($action)
{
    $policies = require('policies.php');
    return isset($policies[$_SESSION['user']['admin']][$action]);
}
