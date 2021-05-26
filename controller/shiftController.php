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
        writeLog("SHIFT", $result, "Rapport créé");
    }
    $model = getModelByID($modelID);
    for ($i = 0; $i < $model["nbTeamD"]; $i++) {
        addShiftTeam($result, 1);
    }
    for ($i = 0; $i < $model["nbTeamN"]; $i++) {
        addShiftTeam($result, 0);
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
    foreach ($sheets as &$sheetBySlug) {
        foreach ($sheetBySlug as &$sheet) {
            $sheet["teamDay"] = getShiftTeam($sheet["id"], 1);
            $sheet["teamNight"] = getShiftTeam($sheet["id"], 0);
        }
    }

    $models = getShiftModels();
    $suggestedModels = getSuggestedShiftModels();
    foreach ($models as $model) {
        foreach ($sheets["close"] as &$sheet) {
            if ($model["id"] == $sheet["model_id"]) {
                $sheet["modelImage"] = $model["name"];
                break;
            }
        }
    }
    if (count($sheets["close"]) == 0 and count($sheets["reopen"]) == 0) {
        $emptyBase = true;
    } else {
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
    $shiftsheet["teamDay"] = getShiftTeam($shiftsheet["id"], 1);
    $shiftsheet["teamNight"] = getShiftTeam($shiftsheet["id"], 0);
    $sections = getshiftsections($shiftid, $shiftsheet["baseID"]);

    $enableDataUpdate = ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true);
    $enableFilling = canIEditShift($shiftsheet);
    $enableStateChange = ((date('Y-m-d') <= date('Y-m-d', strtotime($shiftsheet["date"] . ' + 3 days'))) or $_SESSION['user']['admin']);
    $enableStructureChange = ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true);

    $model = getModelByID($shiftsheet['model']);
    $novas = getNovas();
    $users = getUsers();
    require_once VIEW . 'shift/show.php';
}


function canIEditShift($shiftsheet)
{
    if ($shiftsheet['status'] == "open") {
        if ($_SESSION['user']['admin'] == true) {
            return true;
        } else {
            foreach ($shiftsheet["teamDay"] as $team) {
                if ($team["boss_id"] == $_SESSION['user']['id'] || $team["teammate_id"] == $_SESSION['user']['id']) return true;
            }
            foreach ($shiftsheet["teamNight"] as $team) {
                if ($team["boss_id"] == $_SESSION['user']['id'] || $team["teammate_id"] == $_SESSION['user']['id']) return true;
            }
        }
    }elseif ($shiftsheet['status'] == "reopen" or $shiftsheet['statusslug'] == "close") {
        if ($_SESSION['user']['admin'] == true) {
            return true;
        } else {
            if(date('Y-m-d') <= date('Y-m-d', strtotime($shiftsheet["date"] . ' + 3 days'))){
                foreach ($shiftsheet["teamDay"] as $team) {
                    if ($team["boss_id"] == $_SESSION['user']['id'] || $team["teammate_id"] == $_SESSION['user']['id']) return true;
                }
                foreach ($shiftsheet["teamNight"] as $team) {
                    if ($team["boss_id"] == $_SESSION['user']['id'] || $team["teammate_id"] == $_SESSION['user']['id']) return true;
                }
            }
        }
    }
    return false;
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
        if ($_POST["D/N"] == 1) $time = "jour";
        writeLog("SHIFT", $_POST["sheetID"], getShiftActionName($_POST["actionID"]) . " " . $time . " validé");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

/**
 * checkShift : Mark a task as not completed
 * @param none
 * shows a message to confirm action or an error message
 */
function unCheckShift()
{
    $res = unCheckActionForShift($_POST["actionID"], $_POST["sheetID"], $_POST["D/N"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'annuler la tâche");
    } else {
        setFlashMessage("La tâche a bien été annulée !");
        $time = "nuit";
        if ($_POST["D/N"] == 1) $time = "jour";
        writeLog("SHIFT", $_POST["sheetID"], getShiftActionName($_POST["actionID"]) . " " . $time . " annulé");
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
        writeLog("SHIFT", $_POST["sheetID"], "Commentaire pour " . getShiftActionName($_POST["actionID"]) . " : " . $_POST["comment"]);
    }
    redirect("shiftShow", $_POST["sheetID"]);
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
        writeLog("SHIFT", $sheetID, "Tâche ajoutée : " . $actionName);
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
        writeLog("SHIFT", $sheetID, "Tâche crée et ajoutée au rapport : " . $_POST["actionToAdd"]);
        setFlashMessage("Nouvelle action <strong>" . $_POST["actionToAdd"] . "</strong> créée et ajoutée au rapport");

    } else {
        setFlashMessage("L'action <strong>" . $_POST["actionToAdd"] . "</strong> à été ajoutée au rapport");
        writeLog("SHIFT", $sheetID, "Tâche ajoutée : " . $_POST["actionToAdd"]);
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
        writeLog("SHIFT", $sheetID, "Tâche supprimmée : " . $actionName);
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
    $newID = copyModel($modelID);
    updateModelID($sheetID, $newID);
    return $newID;
}

/**
 * shiftSheetSwitchState : change the state of a shiftsheet
 * shows a message to confirm action or an error message
 */
function shiftSheetSwitchState()
{
    $res = setSlugForShift($_POST["id"], $_POST["newSlug"]);
    if ($_POST["newSlug"] == 'close') closeBy($_POST["id"], $_SESSION['user']['id']);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de changer l'état du rapport de garde.");
    } else {
        setFlashMessage("L'état du rapport de garde a été correctement modifié.");
        switch ($_POST["newSlug"]) {
            case "open":
                $name = "ouvert";
                break;
            case "close":
                $name = "fermé";
                break;
            case "reopen":
                $name = "ré-ouvert";
                break;
            case "archive":
                $name = "archivé";
                break;
            default:
                $name = "";
                break;
        }
        writeLog("SHIFT", $_POST["id"], "Changement d'état : " . $name);
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
function removeShiftModel()
{
    $res = disableShiftModel($_POST["modelID"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de retirer le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement retiré de la liste des modèles disponibles.");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

/**
 * addShiftModel : add a model to the list of models
 * shows a message to confirm action or an error message
 */
function addShiftModel()
{
    $res = enableShiftModel($_POST["modelID"], $_POST["name"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement ajouté.");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}


function reAddShiftModel()
{
    $res = reEnableShiftModel($_POST["modelID"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de réactiver le modèle.");
    } else {
        setFlashMessage("Le modèle a été correctement réactivé.");
    }
    redirect("shiftShow", $_POST["sheetID"]);
}

function shiftLog($sheetID)
{
    $type = "SHIFT";
    $sheet = getshiftsheetByID($sheetID);
    $logs = getLogs($type, $sheetID);
    require_once VIEW . 'main/log.php';
}

function uncheckActionForShift_AJAX($sheetID)
{
    echo getUncheckActionForShift($sheetID);
}

function addTeamForShift($sheetID)
{
    $modelID = configureModel($sheetID, getshiftsheetByID($sheetID)["model"]);
    addTeamToModel($modelID, $_POST["day"]);
    addShiftTeam($sheetID, $_POST["day"]);
    redirect("shiftShow", $sheetID);
}

function removeTeamForShift($sheetID)
{
    if (count(getShiftTeam($sheetID, $_POST["day"])) > 1) {
        $modelID = configureModel($sheetID, getshiftsheetByID($sheetID)["model"]);
        removeTeamToModel($modelID, $_POST["day"]);
        removeLastTeamForShift($sheetID, $_POST["day"]);
        redirect("shiftShow", $sheetID);
    } else {
        setFlashMessage("Action impossible");
        redirect("shiftShow", $sheetID);
    }
}

function checkIfShiftIsReady()
{
    if (sheetIsReady("shift", $_POST["sheetID"])) {
        echo "true";
    } else {
        echo "false";
    }
}
