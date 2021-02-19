<?php
/**
 * Auteur: David Roulet / Fabien Masson + h
 * Date: Avril 2020 + 2020/11
 **/

//Affiche la page de selection de la semaine pour une base choisie
function listDrugSheets($selectedBaseID = null) {
    if (is_null($selectedBaseID))
        $selectedBaseID = $_SESSION["base"]["id"];
    $baseList = getbases();
    $slugs = getSlugs();
    foreach($slugs as $slug) {
        $drugSheetList[$slug['slug']] = getDrugSheetsByState($selectedBaseID, $slug['slug']);
    }
    require_once VIEW . 'drugs/list.php';
}

// Affichage de la page finale
function showDrugSheet($drugSheetID, $edition = false) {
    $drugsheet = getDrugSheetById($drugSheetID);
    $dates = getDaysForWeekNumber($drugsheet["week"]);
    $novas = getNovasForSheet($drugSheetID);
    $batchesForSheet = getBatchesForSheet($drugSheetID); // Obtient la liste des batches utilisées par ce rapport
    foreach ($batchesForSheet as $p) {
        $batchesForSheetByDrugId[$p["drug_id"]][] = $p;
    }
    $drugs = getDrugsInDrugSheet($drugSheetID);
    $site = getbasebyid($drugsheet['base_id']);

    //ici pour faire un check dès la generation de la page, systeme absolument affreux, a ameliorer
    $cellType = ($drugsheet['slug'] == "close") ? "p" : "input";
    $UIDs = array();

    if(ican ("modifySheet") && $edition){

        $drugsWithUsableBatches = getDrugsWithUsableBatches($drugsheet['base_id']);
        $allUsableBatches = getUsableBatches($drugsheet['base_id']); // All usable batches even thoses who are already in the sheet
        $usableBatches = array(); // usable batch without thoses who are already used in the sheet
        $allNovas = getNovas();
        $unusedNovas = array();

       foreach ($allUsableBatches as $usableBatch){
           $foundInBatch = false;
           if(isset($batchesForSheetByDrugId[$usableBatch['drug_id']])) {
               foreach ($batchesForSheetByDrugId[$usableBatch['drug_id']] as $batchForSheetByDrugId) {
                   if ($usableBatch['number'] == $batchForSheetByDrugId['number']) $foundInBatch = true;
               }
           }
            if(!$foundInBatch) $usableBatches[] = $usableBatch ;

        }

       foreach ($allNovas as $nova){
           $insheet = in_array($nova,$novas,true );

           if (!$insheet){
               $unusedNovas[] = $nova;
           }
       }
    }

    require_once VIEW . 'drugs/show.php';
}

function newDrugSheet($baseID = null) {
    if (is_null($baseID))
        $baseID = $_SESSION["base"]["id"];
    $oldSheet = getLatestDrugSheetWeekNb($baseID);
    cloneLatestDrugSheet(insertDrugSheet($baseID, $oldSheet['week']), $oldSheet['id']);
    redirect("listDrugSheets", $baseID);
}

function hasOpenDrugSheet($baseID) {
    return boolval(getOpenDrugSheet($baseID));
}

function drugsDeleteSheet($baseID = null) {
    if (is_null($baseID))
        $baseID = $_SESSION["base"]["id"];
    removeDrugSheet($_POST['id']);
    redirect("listDrugSheets", $baseID);
}
function drugSheetSwitchState() {
    updateSheetState($_POST["id"], getStatusID($_POST['newSlug']));
    redirect("listDrugSheets", $_SESSION["base"]["id"]);
}

function updateDrugSheet() {
}

/**
 *Function used to activate amd deactivate editing mode
 */
function drugSheetEditionMode()
{
    $edition = $_POST['edition'];
    $drugSheetID = $_POST['drugsheetID'];

    if (!$edition) {
        $edition = true;
        showDrugSheet($drugSheetID, $edition); // todo : faire une redirection
    } else {
        $edition = false;
        header('Location: ?action=showDrugSheet&id=' . $drugSheetID);
    }
}

function addBatchesToDrugSheet(){
    $batchToAdd = $_POST['batchToAddList'];
    $drugSheetID = $_POST['drugSheetID'];
    if(ican ("modifySheet")){
        $res = insertBatchInSheet($drugSheetID,$batchToAdd);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible d'ajouter le lot au rapport.");
        } else {
            setFlashMessage("Le lot " . $batchToAdd . " a été correctement ajouté.");
        }
    }else{
        setFlashMessage("Vous n'avez pas les droits nécéssaires pour effectuer cette action");
    }
    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);
}

function removeBatchFromDrugSheet(){
    $batchToRemove = $_POST['batch'];
    $drugSheetID = $_POST['drugSheetID'];

    if(ican ("modifySheet")){
        $res = removeBatchFromSheet($drugSheetID,$batchToRemove);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible de retirer le lot du rapport.");
        } else {
            setFlashMessage("Le lot " . $batchToRemove . " a été correctement retiré.");
        }
    }else{
        setFlashMessage("Vous n'avez pas les droits nécéssaires pour effectuer cette action");
    }
    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);
}

function addNovasToDrugSheet(){
    $drugSheetID = $_POST['drugSheetID'];
    $novaToAdd = $_POST['novaToAddList'];

    if(ican ("modifySheet")){
    $res = insertNovaInSheet($drugSheetID,$novaToAdd);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible d'ajouter l'ambulance au rapport.");
        } else {
            setFlashMessage("L'ambulance " . $novaToAdd . "  a été correctement ajoutée.");
        }

    }else{
        setFlashMessage("Vous n'avez pas les droits nécéssaires pour effectuer cette action");
    }
    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);

}
function removeNovaFromDrugSheet(){
    $drugSheetID = $_POST['drugSheetID'];
    $novaToRemove = $_POST['nova'];

    if(ican ("modifySheet")){
        $res = removeNovaFromSheet($drugSheetID,$novaToRemove);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible de retirer l'ambulance du rapport.");
        } else {
            setFlashMessage("L'ambulance " . $novaToRemove . "  a été correctement retirée.");
        }

    }else{
        setFlashMessage("Vous n'avez pas les droits nécéssaires pour effectuer cette action");
    }
    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);
}
