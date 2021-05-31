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
    $drugSignatures = getDrugSignaturesForDrugSheet($drugSheetID);

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
    $sheetId = $_POST["id"];
    $newSlug = $_POST['newSlug'];
    updateSheetState($sheetId, getStatusID($newSlug));

    if($_POST['newSlug'] == "open"){
        fillSheet($sheetId);
    }

    redirect("listDrugSheets", $_SESSION["base"]["id"]);
}

/** This function is used to update the data of a drugsheet
 *
 */
function updateDrugSheet() {
    $novaChecks = $_POST['novaChecks'];
    $pharmaChecks = $_POST['pharmachecks'];
    $restock = $_POST['restock'];
    $drugSheetID = $_POST['drugsheetID'];

    if(ican("editsheet")){
        $errors = false;

        foreach ($novaChecks as $date => $novas){
            foreach ($novas as $novaID => $drugs){
                foreach ($drugs as $drugID => $drug){
                    $res = insertOrUpdateNovaChecks($date,$drug,$drugID,$novaID,$drugSheetID,$_SESSION['user']['id']);
                    if($res == null || $res === false ) {
                        $errors = true;
                    }
                }
            }
        }

        foreach ($pharmaChecks as $date => $bateches){
            foreach ($bateches as $batchID => $batch){
                $res = insertOrUpdatePharmaChecks($date,$batch,$batchID,$drugSheetID,$_SESSION['user']['id']);
                if($res == null || $res === false) $errors = true;
            }
        }

        foreach ($restock as $date => $batches) {
            foreach ($batches as $batchID => $novas){
                foreach ($novas as $novaID => $restockamount){
                    if($restockamount != ""){
                        $res = inertOrUpdateRestock($date,$batchID,$novaID,$restockamount,$drugSheetID);
                        if($res == null || $res === false) $errors = true;
                    }

                }
            }
        }

        $errors == true ? setFlashMessage("L'enregistrement des données à rencontré une erreur. Veuillez vérifier les données du rapport.") : setFlashMessage("L'enregistrement des données à été effectué.");


    }else{
    setFlashMessage("Vous n'avez pas les droits nécéssaires pour effectuer cette action");
    }
    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);



}

/** This function is used to activate and deactivate editing mode
 * b
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


/**
 * This function is used to add Batches to a drugsheet
 */
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

/**
 * This function is used to remove a batch from a drugsheet
 */
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

/**
 * This function is used to add a nova to a drugsheet
 */
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

/**
 * This function is used to remove a nova from a drugsheet
 */
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

/**
 * This function is used to sign a day in a drugsheet
 */
function signDrugSheetDay(){
    $drugSheetID = $_POST['drugSheetID'];
    $day = $_POST['day'];
    $userID = $_SESSION['user']['id'];
    $baseID = $_SESSION['base']['id'];

    //TODO - Contôle de droits ?

    $res = insertDrugSignatures($drugSheetID,$day,$userID,$baseID);

    if ($res == false || $res == null) {
        setFlashMessage("Une erreur est survenue. Impossible de signer cette journée.");
    } else {
        setFlashMessage("La journée à correctement été signée.");
    }

    header('Location: ?action=showDrugSheet&id=' . $drugSheetID);
}

/**
 * This function is used to show the view "List of batches"
 */
function showBatchList()
{
    $baseID = $_SESSION['base']['id'];

    $drugs = getDrugs();
    $batches = getBatchesForBase($baseID);

    foreach ($batches as $batch) {
        $batchesByDrugId[$batch["drug_id"]][] = $batch;
    }

    require_once VIEW . 'drugs/listOfbatches.php';
}

/**
 * This function is used to create a new batch
 */
function createBatch(){
    $res = insertBatchInBase($_POST['baseID'],$_POST['drugID'],$_POST['batch']);

    if ($res == false || $res == null) {
        setFlashMessage("Une erreur est survenue. Impossible d'ajouter le lot.");
    } else {
        setFlashMessage("Le lot à correctement été ajouté.");
    }
    header('Location: ?action=showBatchList');
}

/** This function is used to fill drug sheets with 0 as value for every navachecks, pharmachecks and restocks
 * @param $sheetId - The ID of the drugsheet
 */
function fillSheet($sheetId){
    $drugsheet = getDrugSheetById($sheetId);
    $dates = getDaysForWeekNumber($drugsheet["week"]);
    $novas = getNovasForSheet($sheetId);
    $batchesForSheet = getBatchesForSheet($sheetId);
    $drugs = getDrugsInDrugSheet($sheetId);
    $value = array("start"=>0,"end"=>0);
    $userId = $_SESSION['user']['id'];

    foreach ($dates as $date){
        foreach ($drugs as $drug){
            foreach ($novas as $nova){
                insertOrUpdateNovaChecks($date,$value,$drug['id'],$nova['id'],$sheetId,$userId);
            }
        }
    }

    foreach ($dates as $date){
        foreach ($batchesForSheet as $batch){
            insertOrUpdatePharmaChecks($date,$value,$batch['id'],$sheetId,$userId);
        }
    }

    foreach ($dates as $date){
        foreach ($batchesForSheet as $batch){
            foreach ($novas as $nova){
                inertOrUpdateRestock($date,$batch['id'],$nova['id'],0,$sheetId);
            }
        }
    }
}

function insertSpecialDrugExit(){
    $drugsheetId = $_POST['sheetId'];

    header('Location: ?action=showDrugSheet&id='.$drugsheetId);
}
