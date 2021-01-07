<?php
//-------------------------------------- admin --------------------------------------------
/**
 * Retourne la liste des médicaments connus (table 'drugs')
 */
function getDrugs() {
    return selectMany("SELECT * FROM drugs");
}

function addNewDrug($drugName) {
    return insert("INSERT INTO drugs (name) values ('$drugName')");
}

function updateDrugName($updatedName, $drugID) {
    return execute("UPDATE drugs SET name='$updatedName' WHERE id='$drugID'");
}

//-------------------------------------- drugs --------------------------------------------
/**
 *  Retourne une sheet précise
 */
function getDrugSheetById($sheetID) {
    return selectOne("SELECT * FROM drugsheets WHERE id = '$sheetID'");
}

function getDrugSheetsByState($state) {
    return selectMany("SELECT * FROM drugsheets WHERE state = '$state'");
}

function getDrugsInDrugSheet($sheetID) {
    return selectMany("SELECT drugs.name,drugs.id FROM drugsheet_use_batch
                             JOIN batches ON drugsheet_use_batch.batch_id=batches.id
                             JOIN drugs ON batches.drug_id=drugs.id
                             WHERE drugsheet_use_batch.drugsheet_id = '$sheetID'");
}
/**
 * Retourne la liste des drugsheets pour une base donnée.
 */
function getDrugSheets($base_id) {
    return selectMany("SELECT id, week, state FROM drugsheets WHERE base_id=:id", ['id' => $base_id]);
}

/**
 * Retourne la liste des novas 'utilisées' par cette feuille
 * Les données retournées sont dans un tableau indexé par id (i.e: [ 12 => [ "id" => 12, "value" => ...], 17 => [ "id" => 17, "value" => ...] ]
 */
function getNovasForSheet($drugSheetID) {
    return selectMany("SELECT novas.id as id, number FROM novas INNER JOIN drugsheet_use_nova ON nova_id = novas.id WHERE drugsheet_id ='$drugSheetID'");
}

/**
 * Retourne les batches de médicaments utilisés sur un rapport précis
 * @param $drugSheetID
 * @return array|mixed|null
 */
function getBatchesForSheet($drugSheetID) {
    return selectMany("SELECT batches.id AS id, number, drug_id FROM batches INNER JOIN drugsheet_use_batch ON batches.id = batch_id WHERE drugsheet_id='$drugSheetID'");
}

/**
 * Retourne le pharmacheck du jour donné pour un batch précis lors de son utilisation dans une drugsheet
 */
function getPharmaCheckByDateAndBatch($date, $batch, $drugSheetID) {
    $res = selectOne("SELECT start,end FROM pharmachecks WHERE date='$date' AND batch_id='$batch' AND drugsheet_id='$drugSheetID'");
    return $res;
}

/**
 * Retourne le novacheck du jour donné pour un médicament précis dans une nova lors de son utilisation dans une drugsheet
 */
function getNovaCheckByDateAndDrug($date, $drug, $nova, $drugSheetID) {
    return selectOne("SELECT start,end FROM novachecks WHERE date='$date' AND drug_id='$drug' AND nova_id='$nova' AND drugsheet_id='$drugSheetID'");
}

/**
 * Retourne le restock du jour donné pour un batch précis dans une nova lors de son utilisation dans une drugsheet
 */
function getRestockByDateAndDrug($date, $batch, $nova) {
    $res = selectOne("SELECT quantity FROM restocks WHERE date='$date' AND batch_id='$batch' AND nova_id='$nova'");
    return $res ? $res['quantity'] : ''; // chaîne vide si pas de restock
}

function getLatestDrugSheetWeekNb($base_id) {
    return selectOne("SELECT id,MAX(week) as 'week' FROM drugsheets WHERE base_id ='$base_id' GROUP BY base_id");
}

function insertDrugSheet($base_id, $lastWeek) {
    //magnifique, passe a la nouvelle annee grace a +48 si 52eme semaine
    (($lastWeek % 100) == 52) ? $lastWeek += 49 : $lastWeek++;
    return insert("INSERT INTO drugsheets (base_id,state,week) VALUES ('$base_id', 'vierge', '$lastWeek')");
}

function cloneLatestDrugSheet($newSheetID, $oldSheetID) {
    //clone last used novas
    $queryResult = selectMany("SELECT nova_id FROM drugsheet_use_nova WHERE drugsheet_id = '$oldSheetID'");
    foreach( $queryResult as $nova) {
        insert("INSERT INTO drugsheet_use_nova (nova_id,drugsheet_id) VALUES ('$nova[nova_id]','$newSheetID')");
    }
    //clone last used drugs
    $queryResult = selectMany("SELECT batch_id FROM drugsheet_use_batch WHERE drugsheet_id = '$oldSheetID'");
    foreach( $queryResult as $batch) {
        insert("INSERT INTO drugsheet_use_batch (batch_id,drugsheet_id) VALUES ('$batch[batch_id]','$newSheetID')");
    }
}

function updateSheetState($baseID, $week, $state) {
    return execute("UPDATE drugsheets SET state='$state' WHERE base_id='$baseID' AND week='$week'");
}

function getOpenDrugSheet($baseID) {
    return selectOne("SELECT state FROM drugsheets WHERE state = 'open'");
}

function getDrugSheetState($baseID, $week) {
    return selectOne("SELECT state FROM drugsheets WHERE base_id = '$baseID' AND week = '$week'");
}