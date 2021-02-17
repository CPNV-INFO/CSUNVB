<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 */

/**
 * newShiftSheet : create a new sheet for a shift. It is created for the active base with the selected model
 * @param int $baseID
 * shows a message to confirm action or an error message
 */
function newShiftSheet($baseID)
{
    if ($_POST["selectedModel"] == "lastModel") {
        $modelID = getLastShiftModel($baseID);
    } else {
        $modelID = $_POST["selectedModel"];
    }

    $result = addNewShiftSheet($baseID, $modelID, $_POST["date"]);
    if ($result == 0) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter le rapport de garde.");
    } else {
        setFlashMessage("le rapport de garde a bien été créé !");
        writeLog("SHIFT",$result,"Rapport créé");
    }
    redirect("shiftList", $baseID);
}

/**
 * shiftList : show a list of all existing shiftsheet for a selected base
 * @param int $selectedBaseID : id of the base we want to show the shiftsheets for. By default it is the based selected when logging in..
 */
function shiftList($selectedBaseID = null)
{
    if ($selectedBaseID == null) $selectedBaseID = $_SESSION['base']['id'];
    $bases = getbases();
    $sheets = getAllShiftForBase($selectedBaseID);
    $models = getShiftModels();
    $suggestedModels = getSuggestedShiftModels();
    foreach ($models as $model){
        foreach ($sheets["close"] as &$sheet){
            if($model["id"] == $sheet["model_id"]){
                $sheet["modelImage"] = $model["name"];
                break;
            }
        }
    }
    if(count($sheets["close"])==0 and count($sheets["reopen"])==0){
        $emptyBase = true;
    }else{
        $emptyBase = false;
    }
    require_once VIEW . 'shift/list.php';
}

/**
 * shiftShow : show the detailed view of a shiftsheet
 * @param int $shiftid : id of the sheet we want to see
 */
function shiftShow($shiftid)
{
    $shiftsheet = getshiftsheetByID($shiftid);
    $sections = getshiftsections($shiftid, $shiftsheet["baseID"]);
    $enableshiftsheetUpdate = ($shiftsheet['status'] == "open" || ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true));
    $enableshiftsheetFilling = ($shiftsheet['status'] == "open" || $shiftsheet['status'] == "reopen" && $_SESSION['user']['admin'] == true);
    $model = getModelByID($shiftsheet['model']);
    $novas = getNovas();
    $users = getUsers();
    require_once VIEW . 'shift/show.php';
}

/**
 * checkShift : Mark a task as completed and who did it
 * @param none
 * shows a message to confirm action or an error message
 */
function checkShift()
{
    $res = checkActionForShift($_POST["actionID"], $_POST["sheetID"], $_POST["D/N"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de valider la tâche.");
    } else {
        setFlashMessage("La tâche a bien été validée !");
        $time = "nuit";
        if($_POST["D/N"]==1)$time = "jour";
        writeLog("SHIFT",$_POST["sheetID"],getShiftActionName($_POST["actionID"]). " ".$time. " validé");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

/**
 * checkShift : Mark a task as not completed
 * @param none
 * shows a message to confirm action or an error message
 */
function unCheckShift(){
    $res = unCheckActionForShift($_POST["actionID"], $_POST["sheetID"], $_POST["D/N"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'annuler la tâche");
    } else {
        setFlashMessage("La tâche a bien été annulée !");
        $time = "nuit";
        if($_POST["D/N"]==1)$time = "jour";
        writeLog("SHIFT",$_POST["sheetID"],getShiftActionName($_POST["actionID"]). " ".$time. " annulé");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

/**
 * commentShift : add a comment to a task
 * @param none
 * shows a message to confirm action or an error message
 */
function commentShift()
{
    $res = commentActionForShift($_POST["actionID"], $_POST["sheetID"], $_POST["comment"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter le commentaire.");
    } else {
        setFlashMessage("Le commentaire a bien été ajouté au rapport !");
        writeLog("SHIFT",$_POST["sheetID"],"Commentaire pour ".getShiftActionName($_POST["actionID"])." : ".$_POST["comment"]);
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

/**
 * updateShift : update the data of the sheet -> vehicle, teammates ...
 * @param none
 * show a message to confirm action or an error message
 */
function updateShift()
{
    $res = updateDataShift($_GET["id"], $_POST["novaDay"], $_POST["novaNight"], $_POST["bossDay"], $_POST["bossNight"], $_POST["teammateDay"], $_POST["teammateNight"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'enregistrer les données.");
    } else {
        setFlashMessage("Les données ont été correctement enregistrées.");
        writeLog("SHIFT",$_GET["id"],"Données de la feuille modifiées");//todo à mofifier quand elle seront modifiée automatiquement en précisant le champ modifié
    }
    redirect("shiftShow", $_GET["id"]);
}
/**
 * addActionForShift : add an action to a shiftsheet
 * @param int $sheetID : id of the sheet where the action is added
 * show a message to confirm action or an error message
 */
function addActionForShift($sheetID)
{
    $modelID = configureModel($sheetID, $_POST["model"]);
    $res = addShiftAction($modelID, $_POST["actionID"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'enregistrer les données.");
    } else {
        $actionName = getShiftActionName($_POST["actionID"]);
        setFlashMessage("L'action <strong>" . $actionName . "</strong> à été ajoutée au rapport");
        writeLog("SHIFT",$sheetID, "Tâche ajoutée : ". $actionName);
    }
    redirect("shiftShow", $sheetID);
}

/**
 * creatActionForShift : create an action if it doesn't exist and add it to the shiftsheet
 * @param int $sheetID : id of the sheet the action is added to
 * show a message to confirm action or an error message
 */
function creatActionForShift($sheetID)
{
    $actionID = getShiftActionID($_POST["actionToAdd"], $_POST["section"]);
    if ($actionID == null) {
        $actionID = creatShiftAction($_POST["actionToAdd"], $_POST["section"]);
        writeLog("SHIFT",$sheetID, "Tâche crée et ajoutée au rapport : " . $_POST["actionToAdd"]);
        setFlashMessage("Nouvelle action <strong>" . $_POST["actionToAdd"] . "</strong> créée et ajoutée au rapport");

    } else {
        setFlashMessage("L'action <strong>" . $_POST["actionToAdd"] . "</strong> à été ajoutée au rapport");
        writeLog("SHIFT",$sheetID, "Tâche ajoutée : ". $_POST["actionToAdd"]);
    }
    $modelID = configureModel($sheetID, $_POST["model"]);
    $res = addShiftAction($modelID, $actionID);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter l'action.");
        }
    redirect("shiftShow", $sheetID);
}

/**
 * removeActionForShift : remove an action from the list of active action on a certain shiftsheet
 * @param int $sheetID : id of the sheet the action is removed from
 * shows a message to confirm action or an error message
 */
function removeActionForShift($sheetID)
{
    $modelID = configureModel($sheetID, $_POST["model"]);
    $res = removeShiftAction($modelID, $_POST["action"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de supprimer l'action.");
    } else {
        $actionName = getShiftActionName($_POST["action"]);
        setFlashMessage("l'action <strong>" . $actionName . "</strong> a été suprimée");
        writeLog("SHIFT",$sheetID, "Tâche supprimmée : ". $actionName);
    }
    redirect("shiftShow", $sheetID);
}

/**
 * configureModel : create a model from an existing shiftsheet
 * @param int $sheetID : id of the shiftsheet
 * @param int $modelID : id of the shiftsheet's model
 * @return int : id of the model used (new or not, depending on uses)
 */
function configureModel($sheetID, $modelID)
{
    //If the model does not have a name it is not being used. no need to copy it
    if (getModelBYID($modelID)["name"] != "") {
        $newID = copyModel($modelID);
        updateModelID($sheetID, $newID);
        return $newID;
    }
    return $modelID;
}

/**
 * shiftSheetSwitchState : change the state of a shiftsheet
 * shows a message to confirm action or an error message
 */
function shiftSheetSwitchState()
{
    $res = setSlugForShift($_POST["id"], $_POST["newSlug"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de changer l'état du rapport de garde.");
    } else {
        setFlashMessage("L'état du rapport de garde a été correctement modifié.");
        writeLog("SHIFT",$_POST["id"],"Changement d'état : ".$_POST["newSlug"]);
    }
    redirect("shiftList", getBaseIDForShift($_POST["id"]));
}

/**
 * shiftDeleteSheet : delete a shiftsheet
 * shows a message to confirm action or an error message
 */
function shiftDeleteSheet()
{
    $res = shiftSheetDelete($_POST["id"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de supprimer le rapport de garde.");
    } else {
        setFlashMessage("le rapport de garde a été correctement supprimé.");
    }
    redirect("shiftList", getBaseIDForShift($_POST["id"]));
}

/**
 * removeShiftModel : remove the model from the list of suggested models
 * shows a message to confirm action or an error message
 */
function removeShiftModel(){
    $res = disableShiftModel($_POST["action_id"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de retirer le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement retiré de la liste des modèles disponibles.");
    }
    redirect("shiftShow",$_POST["shiftSheet_id"]);
}

/**
 * addShiftModel : add a model to the list of models
 * shows a message to confirm action or an error message
 */
function addShiftModel(){
    $res = enableShiftModel($_POST["action_id"],$_POST["comment"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement ajouté.");
    }
    redirect("shiftShow",$_POST["shiftSheet_id"]);
}


function reAddShiftModel(){
    $res = reEnableShiftModel($_POST["action_id"],$_POST["comment"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de réactiver le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement réactivé.");
    }
    redirect("shiftShow",$_POST["shiftSheet_id"]);
}

function shiftLog($sheetID){
    $type = "SHIFT";
    $sheet = getshiftsheetByID($sheetID);
    $logs = getLogs($type,$sheetID);
    require_once VIEW . 'main/log.php';
}
