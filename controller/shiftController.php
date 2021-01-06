<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 */

/**
 * @param $baseID
 */
function newShiftSheet($baseID)
{
    if (isAdmin()) {
        $result = addNewShiftSheet($baseID);
        if ($result == false) {
            setFlashMessage("Une erreur est survenue. Impossible d'ajouter la feuille de garde.");
        } else {
            setFlashMessage("La feuille de garde a bien été créée !");
        }
    }
}

// Attention: cette fonction se base sur un diagramme d'état simplifié:
// blank -> open -> close -> reopen -> close
// Elle ne fonctionnera pas le jour où on pourra passer d'un état à un autre parmi plusieurs
function altershiftsheetStatus($sheet_id)
{
    $sheet = getshiftsheetByID($sheet_id);
    switch ($sheet["status"]) {
        case 'open' :
        case 'reopen' :
            closeShiftPage($sheet["id"]);
            break;
        case 'blank' :
            if (($_SESSION['user']['admin'] == true)) {
                if (getNbshiftsheet('open', $sheet["base_id"]) == 0) {
                    openShiftPage($sheet["id"]);
                } else {
                    $_SESSION["flashmessage"] = "Une autre feuille est déjà ouverte";
                }
            }
            break;
        case 'close' :
            if (($_SESSION['user']['admin'] == true)) reopenShiftPage($sheet["id"]);
            break;
        default :
            break;
    }
}

//
function listshift($baseID = null)
{
    if($baseID == null)$baseID = $_SESSION['base']['id'];
    $Bases = getbases();
    require_once VIEW . 'shift/list.php';
}

function showshift($shiftid)
{
    $shiftsheet = getshiftsheetByID($shiftid);
    $sections = getshiftsections($shiftid,$shiftsheet["baseID"]);
    $enableshiftsheetUpdate = ($shiftsheet['status'] == "open" || ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true));
    $enableshiftsheetFilling = ($shiftsheet['status'] == "open" || $shiftsheet['status'] == "reopen");

    $novas = getNovas();
    $users = getUsers();
    require_once VIEW . 'shift/show.php';
}

function checkShift()
{
    $res = checkActionForShift($_POST["action_id"], $_POST["shiftSheet_id"], $_POST["day"]);
    if ($res == false) setFlashMessage("Une erreur est survenue");
    redirect("showshift", $_POST["shiftSheet_id"]);
}

function commentShift()
{
    $res = commentActionForShift($_POST["action_id"], $_POST["shiftSheet_id"], $_POST["comment"]);
    if ($res == false) setFlashMessage("Une erreur est survenue");
    redirect("showshift", $_POST["shiftSheet_id"]);
}

function updateShift()
{
    $res = updateDataShift($_GET["id"], $_POST["novaDay"], $_POST["novaNight"], $_POST["bossDay"], $_POST["bossNight"], $_POST["teammateDay"], $_POST["teammateNight"]);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue");
    } else {
        setFlashMessage("Données enregistrées");
    }
    redirect("showshift", $_GET["id"]);
}


function displayShift($baseID = null)
{
    if($baseID == null)$baseID = $_SESSION['base']['id'];
    $shiftsheets = getshiftsheetForBase($baseID);
    require_once VIEW . 'shift/template/listForBase.php';
}

/**
 * Ajoute une action déjà à une feuille de garde
 * @param $sheetID
 */
function addActionForShift($sheetID){
    $modelID = configureModel($sheetID,$_POST["model"]);
    addShiftAction($modelID,$_POST["actionID"]);
    redirect("showshift", $sheetID);
}

/**
 * Crée une action et l'ajoute à la feuille de garde
 * @param $sheetID
 */
function creatActionForShift($sheetID){
    $actionID = creatShiftAction($_POST["actionToAdd"]);
    $modelID = configureModel($sheetID,$_POST["model"]);
    addShiftAction($modelID,$actionID);
    redirect("showshift", $sheetID);
}

/**
 * dupplique le modele de la feuille de garde si il est utilisé sur d'autre feuilles de garde afin de ne pas les mofifiers
 * @param $sheetID identifiant de la feuille de garde
 * @param $modelID identifiant du model de la feuille de garde
 * @return identifiant du nouveau model de la feuille de garde
 */
function configureModel($sheetID, $modelID){
    //si le modèle ne possède pas de nom, il n'est pas utilisé pour créer d'autre feuille, il n'y a donc pas besoin de le mofifier
    if(getModelName($modelID) != ""){
        $newID = copyModel($modelID);
        updateModelID($sheetID,$newID);
        return $newID;
    }
    return $modelID;
}

