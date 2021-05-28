<?php
/**
 * Auteur: Thomas Grossmann
 * Date: Mars 2020
 **/

function getFlashMessage()
{
    if (isset($_SESSION['flashmessage'])) {
        $message = $_SESSION['flashmessage'];
        unset($_SESSION['flashmessage']);
        return '<div class="alert alert-info">' . $message . '</div>';
    } else {
        return null;
    }
}

function setFlashMessage($message)
{
    $_SESSION['flashmessage'] = $message;
}

function buttonTask($initials, $todoID, $taskName, $state, $valueType = "null")
{
    switch ($state) {
        case 'blank':
            if (empty($initials)) {
                return "<button type='button' class='btn btn-secondary todoTaskBtn btn-block' disabled>" . $taskName . "<div class='bg-white rounded mt-1'><br></div></button>";
            } else {
                return "<button type='button' class='btn btn-success todoTaskBtn btn-block' disabled>" . $taskName . "<div class='text-dark bg-white rounded mt-1'>" . $initials . "</div></button>";
            }
        case 'edition':
            if (empty($initials)) {
                return "<button type='button' class='btn btn-secondary todoTaskBtn btn-block' disabled><i class='fas fa-times fa-lg delTodoTask d-print-none' data-id='" . $todoID . "' enable></i>" . $taskName . "<div class='bg-white rounded mt-1'><br></div></button>";
            } else {
                return "<button type='button' class='btn btn-success todoTaskBtn btn-block' disabled><i class='fas fa-times fa-lg delTodoTask d-print-none' data-id='" . $todoID . "' enable></i>" . $taskName . "<div class='text-dark bg-white rounded mt-1'>" . $initials . "</div></button>";
            }
        case 'close':
            if (empty($initials)) {
                return "<button type='button' class='btn btn-danger todoTaskBtn btn-block' disabled>" . $taskName . "<div class='bg-white rounded mt-1'><br></div></button>";
            } else {
                return "<button type='button' class='btn btn-success todoTaskBtn btn-block' disabled>" . $taskName . "<div class='text-dark bg-white rounded mt-1'>" . $initials . "</div></button>";
            }
        case 'open':
        case 'reopen':
            if (empty($initials)) {
                return "<button type='button' class='btn btn-secondary todoTaskBtn addTaskBtn' data-type='" . $valueType . "' data-id='" . $todoID . "'>" . $taskName . "<div class='bg-white rounded mt-1'><br></div></button>";
            } else {
                return "<button type='button' class='btn btn-success todoTaskBtn removeTaskBtn' data-id='" . $todoID . "'>" . $taskName . "<div class='text-dark bg-white rounded mt-1'>" . $initials . "</div></button>";
            }
    }
}

/**
 * Retourne la date formatée pour l'affichage
 * @param $date au format standard YYYY-MM-DD HH:ii:ss
 * @param $format un de quelques formats prédéfinis que l'on utilise dans l'appli
 */
function displayDate($date, $format)
{
    switch ($format) {
        case 1:
            return strftime('%A %e %b %Y', strtotime($date)); // Complet avec le jour
        default:
            return  strftime('%e %b %Y', strtotime($date)); // Complet sans le jour
    }
}


function showState($slug, $plural = 0)
{
    // todo (VB) : Utilisation de la base de données (displayname)
    switch ($slug) {
        case "blank":
            $result = "en préparation";
            break;
        case "open":
            $result = "actif";
            if ($plural) {
                $result = $result . "(s)";
            }
            break;
        case "reopen":
            $result = "en correction";
            break;
        case "close":
            $result = "clôturé";
            if ($plural) {
                $result = $result . "(s)";
            }
            break;
        case "archive":
            $result = "archivé";
            if ($plural) {
                $result = $result . "(s)";
            }
            break;
        default:
            $result = "[Non défini]";
            break;
    }

    return $result;
}


function listSheet($page, $sheets)
{
    switch ($page) {
        case "drug":
        case "todo":
            $function = "listTodoOrDrugSheet";
            break;
        case "shift":
            $function = "listShiftSheet";
            break;
        default:
            break;
    }
    $html = "<div> <!-- Sections d'affichage des différents rapport -->";
    $html .= "<div> <!-- rapports ouvertes -->
        <div class='slugOpen slugListTitle'>" . $function("open", $sheets["open"], $page) . "</div><br>";
    $html .= "<div> <!-- rapports en préparation -->
        <div class='slugBlank slugListTitle'> " . $function("blank", $sheets["blank"], $page) . "</div><br>";
    $html .= "<div> <!-- rapports en correction -->
        <div class='slugReopen slugListTitle'>" . $function("reopen", $sheets["reopen"], $page) . "</div><br>";
    $html .= "<div> <!-- rapports fermés -->
        <div class='slugClose slugListTitle'>" . $function("close", $sheets["close"], $page) . "</div>";

    return $html;
}

function listTodoOrDrugSheet($slug, $sheets, $zone)
{
    if ($zone == 'drug') {
        $detailAction = "showDrugSheet";
    } else {
        $detailAction = "showtodo";
    }
    $html = "<h3>Rapport(s) " . showState($slug, 1) . "</h3>
<i class='fas fa-caret-square-down fa-2x showSheetsList d-none' data-list='" . $slug . "' id='show-" . $slug . "'></i>
                        <i class='fas fa-caret-square-up fa-2x hideSheetsList' data-list='" . $slug . "' id='hide-" . $slug . "'></i>
                    </div>";
    if (!empty($sheets)) {
        $html = $html . "<div class='" . $slug . "Sheets' style='margin-top: 0px;'><table class='table table-bordered' style='margin-top: 0px;'>
                            <thead class='thead-dark'><th>Semaine n°</th><th class='actions'>Actions</th></thead>
                        
                            <tbody>";
        foreach ($sheets as $sheet) {
            if ($zone == 'drug') {
                $nbEmpty = 0; //todo need to define ( number of missing value in the sheet )
            } else {
                $nbEmpty = getUncheckActionForTodo($sheet['id']);
            }
            $html = $html . "<tr> <td>Semaine " . $sheet['week'];
            if ($nbEmpty > 0 and $slug == 'close') {
                $html .= " <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='bottom' title='" . $nbEmpty . " vide(s)" . "'><i class='fas fa-exclamation-triangle warning'></i></span>";
            }
            if (ican('createsheet') && (isset($sheet['template_name']))) {
                $html = $html . "<i class='fas fa-file-alt template' title='" . $sheet['template_name'] . "'></i>";
            }
            $html = $html . "<td><div class='d-flex justify-content-around'><a type='button' class='btn blueBtn m-1' href='?action=" . $detailAction . "&id=" . $sheet['id'] . "'>Détails</a>" . slugBtns($zone, $sheet, $slug) . "</div></td>";
        }
        $html = $html . "</tr> </tbody> </table></div>";
    } else {
        $html = $html . "<div class='" . $slug . "Sheets'><p>Aucun rapport de tâche n'est actuellement " . showState($slug) . ".</p></div>";
    }
    return $html;
}

function listShiftSheet($slug, $shiftList, $zone)
{
    $html = "<h3>Rapport(s) " . showState($slug, 1) . "</h3>
                    <i class='fas fa-caret-square-down fa-2x showSheetsList d-none' data-list='" . $slug . "' id='show-" . $slug . "'></i>
                    <i class='fas fa-caret-square-up fa-2x hideSheetsList' data-list='" . $slug . "' id='hide-" . $slug . "'></i>
                    </div>";
    if (count($shiftList) > 0) {
        $head = '<table class="table table-bordered ' . $slug . 'Sheets" style="margin-top:0px; text-align: center">
        <thead class="thead-dark">
        <th>Date</th>
        <th>Véhicules</th>
        <th>Responsables</th>
        <th>Équipage</th>
        <th class="actions">Action</th>
        </thead>';
        $body = "";
        foreach ($shiftList as $shift) {
            $shiftInfo = "<td>Jour : ";
            foreach ($shift["teamDay"] as $teams){
                $shiftInfo .= $teams["nova"] . " ";
            }
            $shiftInfo .= "<br>Nuit : ";
            foreach ($shift["teamNight"] as $teams){
                $shiftInfo .= $teams["nova"] . " ";
            }
            $shiftInfo .= "</td><td>Jour : ";
            foreach ($shift["teamDay"] as $teams){
                $shiftInfo .= $teams["boss"] . " ";
            }
            $shiftInfo .= "<br>Nuit : ";
            foreach ($shift["teamNight"] as $teams){
                $shiftInfo .= $teams["boss"] . " ";
            }
            $shiftInfo .= "</td><td>Jour : ";
            foreach ($shift["teamDay"] as $teams){
                $shiftInfo .= $teams["teammate"] . " ";
            }
            $shiftInfo .= "<br>Nuit : ";
            foreach ($shift["teamNight"] as $teams){
                $shiftInfo .= $teams["teammate"] . " ";
            }
            $shiftInfo .= "</td>";
            $body .= "<tr>
                <td>" . date('d.m.Y', strtotime($shift['date']));
            if (isset($shift["modelImage"])) {
                $body .= "<i class='fas fa-file-alt template' title='Modèle : " . $shift["modelImage"] . "'></i>";
            }
            $nbEmpty = getUncheckActionForShift($shift['id']);
            if ($nbEmpty != 0 and $slug == 'close') $body .= " <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='bottom' title='" . $nbEmpty . " vide(s)" . "'><i class='fas fa-exclamation-triangle warning'></i></span></td>";
            $body .= $shiftInfo;
            $body .= "<td><div class='d-flex justify-content-around'>";
            $body .= buttonForSheet("shift", $shift['id'], "Show&id=" . $shift['id'], "Détails");
            if((date('Y-m-d') <= date('Y-m-d', strtotime($shift["date"] . ' + 3 days'))) or $_SESSION['user']['admin']){
                $body .= slugBtns("shift", $shift, $slug);
            }
            $body .= "</div></td>";
            $body .= "</tr>";
        }
        $foot = "</table>";
        $table = $head . $body . $foot;
        $html .= $table;
    } else {
        $html .= "<div class='" . $slug . "Sheets'><p>Aucun rapport de tâche n'est actuellement " . showState($slug) . ".</p></div>";
    }
    return $html;
}

/**
 * function qui retourne le code html pour les boutons possibles de changement d'état et de suppression en fonction de son status et du rôle de l'autilisateur
 * @param string $page le type rapport depuis lequel la function est appelée, ex : 'shift'
 * @param array $sheet tableau contenant les informations du rapport
 * @param array $slug slug du status du rapport, ex. 'open
 * @return string code html
 */
function slugBtns($page, $sheet, $slug)
{
    $buttonList = "";
    switch ($slug) {
        case "blank":
            if (ican('opensheet')) {
                $disableReason = "";
                // Test pour vérifier si le rapport est prêt
                if (!sheetIsReady($page, $sheet['id'])) $disableReason = "Définissez les équipes avant d&#39activer le rapport";
                // Test pour vérifier si un autre rapport est déjà ouverte
                if (checkOpen($page, $sheet['base_id'])) $disableReason = "un autre rapport est déjà ouvert";
                $buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Activer", $disableReason, "open");
            }
        case "archive":
            if (ican('deletesheet')) $buttonList .= buttonForSheet($page, $sheet['id'], "DeleteSheet", "<i class='fas fa-trash'></i>");
            break;
        case "open":
            if (ican('closesheet')) {
                switch ($page) {
                    case "drug":
                        $buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Clôturer", "", "close");
                        break;
                    case "todo":
                        $buttonList .= "<input type='button' class='btn blueBtn m-1' value = Clôturer onclick=todoClose(" . $sheet['id'] . "," . $sheet['week'] . ")>";
                        break;
                    case "shift":
                        $buttonList .= "<input type='button' class='btn blueBtn m-1' value = Clôturer onclick=shiftClose('" . $sheet['date'] . "'," . $sheet['id'] . ")>";
                        break;
                    default:
                        break;
                }
            }
            break;
        case "reopen":
            $buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Refermer", "", "close");
            break;
        case "close":
            switch ($page) {
                case "drug":
                case "todo":
                    $buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Corriger", "", "reopen");
                    break;
                case "shift":
                    if(canIEditShift($sheet))$buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Corriger", "", "reopen");
                    break;
                default:
                    break;
            }
            if ($_SESSION['user']['admin'] == true)$buttonList .= buttonForSheet($page, $sheet['id'], "SheetSwitchState", "Archiver", "", "archive");
            break;
        default:
            break;
    }
    return $buttonList;
}


/**
 * function qui retourne le code html pour un bouton d'un rapport
 * @param string $page le type rapport depuis lequel la function est appelée, ex : 'shift'
 * @param int $id id du rapport
 * @param string $action action du bouton, ex. 'SheetSwitchState'
 * @param string $actionName nom de l'action affichée sur le bouton, ex. 'Clôturer'
 * @param string $disableReason si = "" bouton activé, sinon bouton désactivé avec la variable comme indication
 * @param string $newSlug optionnel, nouveau slug pour l'état du rapport si celui-ci change avec l'action, ex. 'open'
 * @return string code html
 */
function buttonForSheet($page, $id, $action, $actionName, $disableReason = "", $newSlug = "")
{
    $btn = "<form  method='POST' class='d-inline' action='?action=$page$action'>";
    $btn .= "<input type='hidden' name='id' value='$id'>";
    if (!$newSlug == "") $btn .= "<input type='hidden' name='newSlug' value='$newSlug'>";
    if ($disableReason == "") {
        $btn .= "<button type='submit' id='btn_submit_$action' class='btn blueBtn m-1'>$actionName</button></form>";
    } else {
        $btn .= "<form><span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='bottom' title='$disableReason'><button type='submit' class='btn blueBtn m-1' disabled>$actionName</button></span></form>";
    }
    return $btn;
}


function checkOpen($page, $baseID)
{
    $openSheets = 0;
    $count = 1;

    switch ($page) {
        case 'drug':
            $openSheets = getOpenDrugSheetNumber($baseID);
            break;
        case 'todo':
            $openSheets = getOpenTodoSheetNumber($baseID);
            break;
        case 'shift':
            $openSheets = getOpenShiftSheet($baseID);
            break;
    }

    if (!isset($openSheets) || $openSheets < $count) {
        return false; // A sheet can be open
    } else {
        return true; // Max number of sheets already open
    }
}


/**
 * @param $page nom de la page ex. "shift"
 * @param $bases liste des bases, avec leur id ("id") et noms ("name")
 * @param $selectedBaseID identifiant de la base selectionnée
 * @param $models liste des modèles, avec leur id ("id") et noms ("name")
 * @return string code html pour créer le header
 */
function headerForList($page, $bases, $selectedBaseID, $models, $emptyBase)
{
    switch ($page) {
        case "shift":
            $title = "Remise de Garde";
            $switchBaseAction = "shiftList";
            $newSheetAction = "?action=newShiftSheet&id=" . $selectedBaseID;
            $dateInput = "<input type='date' name='date' value='" . getNextDateForShift($selectedBaseID) . "'>";
            // <input type="week" name="week" value="2017-W01"> exemple for week
            break;
        default:
            return "<h1>Header pour la page non défini</h1>";
    }
    //Liste déroulante pour le choix de la base
    $header = "<form><h1 class='mr-3 d-inline'>" . $title . " à</h1><input type='hidden' name='action' value='" . $switchBaseAction . "'><select onchange='this.form.submit()' name='id' size='1' class='bigfont mb-3'>";
    foreach ($bases as $base) {
        $header .= "<option value='" . $base['id'] . "'";
        if ($selectedBaseID == $base['id']) {
            $header .= " selected ";
        }
        $header .= "name='base'>" . $base['name'] . "</option>";
    }
    $header .= "</select></form>";

    //Création d'une nouveau rapport
    if (ican('createsheet') && $_SESSION['base']['id'] == $selectedBaseID) {
        $header .= "<div class='sheetForm newSheet'><form method='POST' action='" . $newSheetAction . "' class='float-right'>Modèle : <select name='selectedModel' class='choseModel'>";
        if ($emptyBase == false) {
            $header .= "<option value='lastModel' selected=selected>Dernier rapport clôturé</option>";
        }
        foreach ($models as $model) {
            $header .= "<option value='" . $model['id'] . "'>" . $model['name'] . "</option>";
        }
        $header .= "</select> <button class='btn blueBtn m-1'>Nouveau Rapport</button>";
        $header .= $dateInput;
        $header .= "</form></div>";
    }
    return $header;
}

/**
 * Fonction qui génère l'ensemble des listes déroulantes, en fonction du jour et du créneau
 * @param array $missingTasks Ensemble des tâches manquantes dans une semaine (todoSheet)
 * @return string
 */
function dropdownTodoMissingTask($missingTasks)
{
    $html = "<label for='task' class='d-none' id='missingTaskLabel' style='padding-right: 15px'>Tâche</label>";

    foreach ($missingTasks[0] as $index => $nightTask) {
        $html = $html . "<select name='task" . $index . "time0' id='day" . $index . "time0' class='missingTodoTaskList d-none'>";

        foreach ($nightTask as $task) {
            $html = $html . "<option value=" . $task['id'] . ">" . $task['description'] . "</option>";

        }
        $html = $html . "</select>";
    }

    foreach ($missingTasks[1] as $index => $dayTask) {
        $html = $html . "<select name='task" . $index . "time1' id='day" . $index . "time1' class='missingTodoTaskList d-none'>";

        foreach ($dayTask as $task) {
            $html = $html . "<option value=" . $task['id'] . ">" . $task['description'] . "</option>";

        }
        $html = $html . "</select>";
    }
    return $html;
}


/**
 * @param string $page type de rapport, ex. 'shift'
 * @param int $id id du rapport
 * @return bool true si le rapport est prêt
 */
function sheetIsReady($page, $id)
{
    switch ($page) {
        case 'drug':
            return true;
        case 'todo':
            return true;
        case 'shift':
            if(nbEmptyTeams($id) == 0 ){
                return true;
            }else{
                return false;
            }
    }
}

function getPage($action){
    require "../pageList.php";
    if(in_array($action, $dashboardPages)) return "dashboard";
    if(in_array($action, $shiftPages)) return "shift";
    if(in_array($action, $todoPages)) return "todo";
    if(in_array($action, $stupPages)) return "drug";
    if(in_array($action, $adminPages)) return "admin";
    return "undefined";
}

function newCalendar($date){
    $selectedMonth = date_format(date_create($date.'-01'), 'n');
    $selectedYear = date_format(date_create($date.'-01'), 'Y');

    $dayByMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if ((is_int($selectedYear / 4) && !is_int($selectedYear / 100)) || is_int($selectedYear / 400)) {
        $dayByMonth[1]= 29;
    }
    $firstDay = date_format(date_create($selectedYear."-".$selectedMonth."-1"),"N");
    $lastDay = date_format(date_create($selectedYear."-".$selectedMonth."-".$dayByMonth[$selectedMonth-1]),"N");
    $nbDayBefore = $firstDay - 1;
    $nbDayAfter = 7 - $lastDay;
    $calendar = array();
    $week = 0;
    $calendar[$week]= array();
    $lastMonth = $selectedMonth -1;
    $nextMonth = $selectedMonth +1;
    $lastMonthYear = $selectedYear;
    $nextMonthYear = $selectedYear;
    if($lastMonth == 0){
        $lastMonth = 12;
        $lastMonthYear --;
    }
    if ($nextMonth == 13){
        $nextMonth = 1;
        $nextMonthYear++;
    }
    for ($i = 1; $i <= $nbDayBefore; $i++) {
        array_push($calendar[$week], ["date" => date_create($lastMonthYear."-".$lastMonth."-".($dayByMonth[$lastMonth-1] - $nbDayBefore + ($i))) , "color" => "lightgray"]);
    }
    for ($i = 1; $i <= $dayByMonth[$selectedMonth-1]; $i++) {
        array_push($calendar[$week], ["date" => date_create($selectedYear."-".$selectedMonth."-". $i), "color" => "lightblue"]);
        if(count($calendar[$week])==7){
            $week ++;
            $calendar[$week]= array();
        }
    }
    for ($i = 1; $i <= $nbDayAfter; $i++) {
        array_push($calendar[$week], ["date" => date_create($nextMonthYear."-".$nextMonth."-". $i), "color" => "lightgray"]);
    }
    return $calendar;
}
