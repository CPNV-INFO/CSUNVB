<?php

/**
 * Function that creates the display of weekly tasks (todosheet) for the base selected at login
 */
function listtodo()
{
    listtodoforbase($_SESSION['base']['id']);
}

/**
 * Function that creates the display of weekly tasks (todosheet) specified by base ID
 * @param int $baseID : ID of specified base
 */
function listtodoforbase($baseID)
{

    // Récupération des semaines en fonction de leur état (slug) et de la base choisie
    $sheets = getAllTodoSheetsForBase($baseID);

    $baseList = getbases();
    $templates = getAllTemplateNames();
    $lastClosedWeek = getLastWeekClosed($baseID);

    require_once VIEW . 'todo/list.php';
}

/**
 * Function that creates the display of weekly tasks (todosheet) specified by todosheet ID
 * @param int $sheetID : ID of specified todosheet
 */
function showtodo($sheetID, $edition = false)
{
    $week = getTodosheetByID($sheetID);
    $base = getbasebyid($week['base_id']);
    $days = [1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    $dates = getDaysForWeekNumber($week['week']);
    $template = getTemplateName($sheetID);
    if($edition){
        $state = 'edition';
    }else{
        $state = $week['slug'];
    }
    for ($daynight = 0; $daynight <= 1; $daynight++) {
        for ($dayofweek = 1; $dayofweek <= 7; $dayofweek++) {
            $todoThings[$daynight][$dayofweek] = readTodoThingsForDay($sheetID, $daynight, $dayofweek);
            foreach ($todoThings[$daynight][$dayofweek] as $key => $todoThing) {
                if (!is_null($todoThing['type']) && !is_null($todoThing['value'])) {
                    $todoThings[$daynight][$dayofweek][$key]['description'] = str_replace("....", "" . $todoThing['value'] . "", "" . $todoThing['description'] . "");
                }
            }
        }
    }
    require_once VIEW . 'todo/show.php';
}


/**
 * Function that creates a new todosheet in the database from a template or last closed todosheet
 */
function addWeek()
{
    $baseID = $_SESSION['base']['id']; // On ne peut ajouter un rapport que dans la base où l'on se trouve

    $week = getLastWeek($baseID); // Récupère la dernière semaine

    if ($_POST['selectModel'] == 'lastValue') {
        $template = getLastWeekClosed($baseID);
    } else {
        $template = getTemplateSheet($_POST['selectModel']);
    }

    if(isset($week['week'])){
        $newWeekNumber = nextWeekNumber($week['week']);
    } else{
        $newWeekNumber = date("yW");
    }

    $todos = readTodoForASheet($template['id']);

    $newWeekID = createNewSheet($baseID, $newWeekNumber);

    foreach ($todos as $todo) {
        addTodoThing($todo['id'], $newWeekID, $todo['day']);
    }

    setFlashMessage("La semaine " . $newWeekNumber . " a été créée."); // todo : afficher le message uniquement si la tâche a réellement été faite
    header('Location: ?action=listtodoforbase&id=' . $baseID);
}

/**
 * Function that returns the next week number or specified week
 * @param int $weekNbr
 * @return false|string
 */
function nextWeekNumber($weekNbr)
{
    $year = 2000 + intdiv($weekNbr, 100);
    $week = $weekNbr % 100;

    $time = strtotime(sprintf("%4dW%02d", $year, $week));
    $nextWeek = date(strtotime("+ 1 week", $time));

    return date("yW", $nextWeek);
}

/**
 *Function used to call updateTemplateName and pass needed data
 */
function modelWeek()
{
    $todosheetID = $_POST['todosheetID'];

    updateTemplateName($todosheetID, $_POST['template_name']);
    header('Location: ?action=showtodo&id=' . $todosheetID);
}

/**
 *Function used to call deleteTemplate and pass needed data
 */
function deleteTemplate()
{
    $todosheetID = $_POST['todosheetID'];

    deleteTemplateName($todosheetID);
    header('Location: ?action=showtodo&id=' . $todosheetID);
}

/**
 *Function used to activate amd deactivate editing mode
 */
function todoEditionMode($id)
{
    $edition = $_POST['edition'];

    if (!$edition) {
        $edition = true;
        showtodo($id, $edition); // todo : faire une redirection
    } else {
        $edition = false;
        header('Location: ?action=showtodo&id=' . $id);
    }
}





/**
 * Function to change the active status of a sheet
 */
function todoSheetSwitchState()
{

    $sheetID = $_POST['id'];
    $newSlug = $_POST['newSlug'];
    $sheet = getTodosheetByID($sheetID);
    if($newSlug== 'close'){
        closeTodoSheet($sheetID,$_SESSION["user"]["id"]);
    }else{
        changeSheetState($sheetID, $newSlug);
    }
    $message = "La semaine " . $sheet['week'] . " a été ";

    switch ($newSlug) {
        case "open":
            $message = $message . "ouvert.";
            break;
        case "reopen":
            $message = $message . "ré-ouvert.";
            break;
        case "close":
            $message = $message . "fermé.";
            break;
        case "archive":
            $message = $message . "archivé.";
            break;
        default:
            break;
    }
    setFlashMessage($message);
    header('Location: ?action=listtodoforbase&id=' . $sheet['base_id']);
}

/**
 * Function to delete a todosheet from databas
 * Shows a message if successful
 */
function todoDeleteSheet()
{
    $sheetID = $_POST['id'];
    $sheet = getTodosheetByID($sheetID);

    deleteTodoSheet($sheetID);

    setFlashMessage("La semaine " . $sheet['week'] . " a correctement été supprimée.");
    header('Location: ?action=listtodoforbase&id=' . $sheet['base_id']);
}

/**
 * Function that return html option for missing tasks
 * @return string html code
 */
function findMissingTasks_AJAX()
{
    $missingTasks = getMissingTodo($_POST["day"],$_POST["time"],$_POST["sheetID"]);
    $options = "";
    foreach ($missingTasks as $task){
        $options .= "<option name='task' value='".$task["id"]."'>".$task["description"]."</option>";
    }
    echo $options;
}

/**
 *  Function to mark a todoTask as done
 */
function checkTodo()
{
    $todoValue = "";
    if(isset($_POST["todoValue"])){
        $todoValue = $_POST["todoValue"];
    }
    validateTodo($_POST["todoID"], $todoValue);
    redirect("showtodo",$_POST["todoSheetID"]);
}

function unCheckTodo()
{
    invalidateTodo($_POST["todoID"]);
    redirect("showtodo",$_POST["todoSheetID"]);
}

function uncheckActionForTodo_AJAX($sheetID){
    echo getUncheckActionForTodo($sheetID);
}

function newTodoTask(){
    $days = [1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    if($_POST["day"]==1){
        $time = "jour";
    }else{
        $time = "nuit";
    }
    $exist = getTodoTaskByName($_POST["name"],$_POST["time"]);
    if(!$exist){
        $newID = createTodoTask($_POST["name"],$_POST["time"]);
        $res = addTodoForSheet($_POST["sheetID"],$newID,$_POST["day"]);
        if($res){
            $message = "Tâche <strong>".$_POST["name"]. "</strong> crée et ajoutée pour le rapport ( ".$days[$_POST["day"]]." ".$time." )";
        }
    }else{
        if(!alreadyOnTodoSheet($_POST["sheetID"],$exist["id"],$_POST["day"])){
            $res = addTodoForSheet($_POST["sheetID"],$exist["id"],$_POST["day"]);
            if($res){
                $message = "Tâche <strong>".$_POST["name"]. "</strong> ajoutée pour le rapport ( ".$days[$_POST["day"]]." ".$time." )";
            }
        }else{
            $message = "Echec : La tâche : <strong>".$_POST["name"]."</strong> est déjà présente pour le jour en question";
        }
    }
    if(isset($message)){
        setFlashMessage($message);
    }else{
        $message = "Echec lors de l'ajout de la tâche : <strong>".$_POST["name"]."</strong>";
    }
    redirect("todoEditionMode",$_POST["sheetID"]);
}

function oldTodoTask(){
    $days = [1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    $task = getTodoTaskByID($_POST["taskID"]);
    $res = addTodoForSheet($_POST["sheetID"],$_POST["taskID"],$_POST["day"]);
    if($res){
        if($task["dayting"]==1){
            $time = "jour";
        }else{
            $time = "nuit";
        }
        $message = "Tâche <strong>".$task["description"]. "</strong> ajoutée pour le rapport ( ".$days[$_POST["day"]]." ".$time." )";
    }else{
        $message = "Echec lors de l'ajout de la tâche : <strong>".$task["description"]."</strong>";
    }
    setFlashMessage($message);
    redirect("todoEditionMode",$_POST["sheetID"]);
}

/**
 *Function to delete a task from a todosheet
 */
function delTodoTask()
{
    $res = delTodo($_POST["todoID"]);
    if($res){
        $message = 'La tâche a été supprimée !';
    }else{
        $message = 'Echec de suppression de la tâche';
    }
    setFlashMessage($message);
    redirect("todoEditionMode",$_POST["sheetID"]);
}