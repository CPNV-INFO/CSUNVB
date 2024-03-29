<?php
//-------------------------------------- admin --------------------------------------------
/**
 * Retourne la liste des médicaments connus (table 'drugs')
 */
function getDrugs() {
    return selectMany("SELECT * FROM drugs");
}

function addNewDrug($drugName) {
    return insert("INSERT INTO drugs (name) values (:drug)", ['drug' => $drugName]);
}

function updateDrugName($updatedName, $drugID) {
    return execute("UPDATE drugs SET name='$updatedName' WHERE id=:drug", ['drug' => $drugID]);
}


//-------------------------------------- drugs --------------------------------------------
/**
 *  Retourne une sheet précise
 */
function getDrugSheetById($sheetID) {
    return selectOne("SELECT drugsheets.id AS id, week, base_id, slug, displayname
                             FROM drugsheets 
                             LEFT JOIN status ON drugsheets.status_id = status.id
                             WHERE drugsheets.id =:sheetID", ['sheetID' => $sheetID]);
}

function getDrugSheetsByState($baseID, $slug) {
    $query = "SELECT week, drugsheets.id, base_id
            FROM drugsheets
            JOIN bases ON drugsheets.base_id = bases.id
            JOIN status ON drugsheets.status_id = status.id
            WHERE bases.id = :baseID AND status.slug =:slug
            ORDER BY week DESC;";
    return selectMany($query, ['baseID' => $baseID, 'slug' => $slug]);
}

function getSlugs() {
    return selectMany("SELECT slug FROM status");
}

/** This function is used to get the list of the drugs used in a drugsheet
 * @param $sheetID - The ID of the drugsheet
 * @return array|mixed|null
 */
function getDrugsInDrugSheet($sheetID) {
    return selectMany("SELECT distinct drugs.name,drugs.id FROM drugsheet_use_batch
                             JOIN batches ON drugsheet_use_batch.batch_id=batches.id
                             JOIN drugs ON batches.drug_id=drugs.id
                             WHERE drugsheet_use_batch.drugsheet_id =:sheet", ['sheet' => $sheetID]);
}
/**
 * Retourne la liste des drugsheets pour une base donnée.
 */
function getDrugSheets($base_id) {
    return selectMany("SELECT id, week, state FROM drugsheets WHERE base_id=:id", ['id' => $base_id]);
}

/**
 * Retourne la liste des novas 'utilisées' par ce rapport
 * Les données retournées sont dans un tableau indexé par id (i.e: [ 12 => [ "id" => 12, "value" => ...], 17 => [ "id" => 17, "value" => ...] ]
 */
function getNovasForSheet($drugSheetID) {
    return selectMany("SELECT novas.id as id, number FROM novas INNER JOIN drugsheet_use_nova ON nova_id = novas.id WHERE drugsheet_id =:drugsheet", ['drugsheet' => $drugSheetID]);
}

/**
 * This function is used to insert in the database that a drugsheet use a nova
 * @param $drugSheetID - The ID of the drugsheet
 * @param $novaToAdd - The number of the nova (as displayed to the user, not the ID)
 * @return string|null
 */
function insertNovaInSheet($drugSheetID,$novaToAdd){
    return insert("INSERT INTO drugsheet_use_nova (drugsheet_id,nova_id) VALUES (:drugSheetID,(SELECT novas.id from novas WHERE novas.number =:novaNumber));",['drugSheetID' =>$drugSheetID,'novaNumber' => $novaToAdd]);
}

/** This function is used to remove the usage of a nova by a drugsheet
 * @param $drugSheetID - The ID of the drugsheet
 * @param $novaToRemove - The number of the nova (as displayed to the user, not the ID)
 * @return bool|null
 */
function removeNovaFromSheet($drugSheetID,$novaToRemove){
    return execute("DELETE FROM drugsheet_use_nova WHERE drugsheet_use_nova.drugsheet_id = :drugSheetID AND drugsheet_use_nova.nova_id = (SELECT novas.id from novas WHERE novas.number =:novaNumber)",['drugSheetID' =>$drugSheetID,'novaNumber' => $novaToRemove]);
}
/**
 * Retourne les batches de médicaments utilisés sur un rapport précis
 * @param $drugSheetID
 * @return array|mixed|null
 */
function getBatchesForSheet($drugSheetID) {
    return selectMany("SELECT batches.id AS id, number, drug_id FROM batches INNER JOIN drugsheet_use_batch ON batches.id = batch_id WHERE drugsheet_id=:drugsheet", ['drugsheet' => $drugSheetID ]);
}

/** This function is used to get the list the list of the batches in a base
 * @param $baseID - The id of the base
 * @return array|mixed|null
 */
function getBatchesForBase($baseID) {
    return selectMany("SELECT batches.id AS id, number, drug_id, state FROM batches WHERE base_id=:baseID", ['baseID' => $baseID ]);
}

function getBatchByID($batchID){
    return selectOne("Select batches.number, drugs.name drugName from batches join drugs on drugs.id = batches.drug_id where batches.id = :batchId",['batchId'=>$batchID]);
}

/** This function is used to Insert a batch in a sheet
 * @param $drugSheetID - The ID of the drugsheet
 * @param $batchToAdd - The ID of the batch
 * @return string|null
 */
function insertBatchInSheet($drugSheetID,$batchToAdd){
return insert("INSERT INTO drugsheet_use_batch (drugsheet_id,batch_id) VALUES (:drugSheetID,:batchToAdd);",['drugSheetID' =>$drugSheetID,'batchToAdd' => $batchToAdd]);
}

/** This function is used to Insert a batch in a base
 * @param $baseID - The ID of the base
 * @param $drugID - The ID of the drug
 * @param $batch - The number of the new batch
 * @return string|null
 */
function insertBatchInBase($baseID,$drugID,$batch){
return insert("INSERT INTO batches (base_id,drug_id,number) VALUES (:baseID,:drugID,:batch);",['baseID'=>$baseID,'drugID'=>$drugID,'batch'=>$batch]);
}

/** This function is used to remove a batch from a sheet
 * @param $drugSheetID - The ID of the drugsheet
 * @param $batchToRemove - The ID of the batch
 * @return bool|null
 */
function removeBatchFromSheet($drugSheetID,$batchToRemove){
    return execute("DELETE FROM drugsheet_use_batch WHERE drugsheet_use_batch.drugsheet_id = :drugSheetID AND drugsheet_use_batch.batch_id = :batchToRemove",['drugSheetID' =>$drugSheetID,'batchToRemove' => $batchToRemove]);
}



/**
 * Retourne le pharmacheck du jour donné pour un batch précis lors de son utilisation dans une drugsheet
 */
function getPharmaCheckByDateAndBatch($date, $batch, $drugSheetID) {
    return selectOne("SELECT start,end FROM pharmachecks WHERE date=:batchdate AND batch_id=:batch AND drugsheet_id=:drugsheet", ['batchdate' => $date, 'batch' => $batch, 'drugsheet' => $drugSheetID]);
}

/** This function is used to insert or update a Pharmacheck
 * @param $date - The date of the pharmacheck (The date of the day in the drugsheet)
 * @param $batch - The values of the pharmacheck in an array.
 * @param $batchID - The batch ID.
 * @param $drugSheetID - The drugsheet ID
 * @return string|null
 */
function insertOrUpdatePharmaChecks($date,$batch,$batchID,$drugSheetID,$userId){
    return insert('INSERT INTO pharmachecks (date, start, end, batch_id, user_id, drugsheet_id) VALUES(:date,:batch_start,:batch_end,:batch_id,:user_id,:drugsheet_id) ON DUPLICATE KEY UPDATE START = :batch_start, END =:batch_end, user_id = :user_id;', ['date'=>$date,"batch_start"=>$batch['start'],"batch_end"=>$batch['end'],"batch_id"=>$batchID,"user_id"=>$userId,'drugsheet_id'=>$drugSheetID]);
}

/**
 * Retourne le novacheck du jour donné pour un médicament précis dans une nova lors de son utilisation dans une drugsheet
 */
function getNovaCheckByDateAndDrug($date, $drug, $nova, $drugSheetID) {
    return selectOne("SELECT start,end FROM novachecks WHERE date=:batchdate AND drug_id=:drug AND nova_id=:nova AND drugsheet_id=:drugsheet", ['batchdate' => $date, 'drug' => $drug, 'nova' => $nova, 'drugsheet' => $drugSheetID]);
}

/** This function is used to insert or update a novacheck
 * @param $date - The date of the novacheck (The date of the day in the drugsheet)
 * @param $drug - The value of the novacheck
 * @param $drugID - The drug ID
 * @param $novaID - The Nova ID
 * @param $drugSheetID - The drugsheet ID
 * @return string|null
 */
function insertOrUpdateNovaChecks($date,$drug,$drugID,$novaID,$drugSheetID,$userId){
    return insert('INSERT INTO novachecks (date, start, end, drug_id, nova_id, user_id,drugsheet_id) VALUES(:date, :start, :end,:drug_id,:nova_id,:user_id,:drugsheet_id) ON DUPLICATE KEY UPDATE START = :start, END =:end, user_id = :user_id;', ['date' => $date,'start' => $drug["start"],'end'=>$drug["end"],'drug_id'=>$drugID,'nova_id'=>$novaID,'user_id'=>$userId,'drugsheet_id'=>$drugSheetID]);
}

/**
 * Retourne le restock du jour donné pour un batch précis dans une nova lors de son utilisation dans une drugsheet
 */
function getRestockByDateAndDrug($date, $batch, $nova) {
    $res = selectOne("SELECT quantity FROM restocks WHERE date=:batchdate AND batch_id=:batch AND nova_id=:nova", ['batchdate' => $date, 'batch' => $batch, 'nova' => $nova]);
    return $res ? $res['quantity'] : ''; // chaîne vide si pas de restock
}

/** This function is used to insert or update a restock
 * @param $date - The date of the restock (The date of the day in the drugsheet)
 * @param $batchID - The batch ID
 * @param $novaID - The nova ID
 * @param $restockamount - The amount of the restock
 * @return string|null
 */
function inertOrUpdateRestock($date,$batchID,$novaID,$restockamount,$sheetID){
    return insert('INSERT INTO restocks (DATE, quantity, batch_id, nova_id, user_id, drugsheet_id) VALUES (:date,:restockamount,:batchID,:novaID,:userID,:sheetID) ON DUPLICATE KEY UPDATE quantity= :restockamount,user_id = :userID;',['date'=>$date, 'restockamount'=>$restockamount,'batchID'=>$batchID,'novaID'=>$novaID,'userID'=>$_SESSION['user']['id'],'sheetID'=>$sheetID]);
}

function getLatestDrugSheetWeekNb($base_id) {
    return selectOne("SELECT id,MAX(week) as 'week' FROM drugsheets WHERE base_id =:base GROUP BY base_id", ['base' => $base_id]);
}

function insertDrugSheet($base_id, $lastWeek) {
    //TODO: slug
    //magnifique, passe a la nouvelle annee grace a +48 si 52eme semaine
    (($lastWeek % 100) == 52) ? $lastWeek += 49 : $lastWeek++;
    return insert("INSERT INTO drugsheets (base_id,status_id,week) VALUES (:base, 1, :lastweek)", ['base'=> $base_id, 'lastweek' => $lastWeek]);
}

function cloneLatestDrugSheet($newSheetID, $oldSheetID) {
    //clone last used novas
    $queryResult = selectMany("SELECT nova_id FROM drugsheet_use_nova WHERE drugsheet_id =:oldsheet", ['oldsheet'=>$oldSheetID]);
    foreach( $queryResult as $nova) {
        insert("INSERT INTO drugsheet_use_nova (nova_id,drugsheet_id) VALUES (:nova,:newsheet)", ['nova' => $nova['nova_id'], 'newsheet'=> $newSheetID]);
    }
    //clone last used drugs
    $queryResult = selectMany("SELECT batch_id FROM drugsheet_use_batch WHERE drugsheet_id =:oldsheet", ['oldsheet' => $oldSheetID]);
    foreach( $queryResult as $batch) {
        insert("INSERT INTO drugsheet_use_batch (batch_id,drugsheet_id) VALUES (:batch, :newsheet)", ['batch' => $batch['batch_id'], 'newsheet' => $newSheetID]);
    }
}

function updateSheetState($sheetID, $state) {
    return execute("UPDATE drugsheets SET status_id='$state' WHERE id='$sheetID'");
}

function getOpenDrugSheet($baseID) {
    return selectOne("SELECT state FROM drugsheets WHERE state = 'open'");
}

function getDrugSheetState($baseID, $week) {
    return selectOne("SELECT state FROM drugsheets WHERE base_id = '$baseID' AND week = '$week'");
}

function getStateFromDrugs($id){
    return selectOne("SELECT status.slug FROM status LEFT JOIN drugsheets ON drugsheets.status_id = status.id WHERE drugsheets.id =:sheetID", ["sheetID"=>$id]);
}

function getOpenDrugSheetNumber($baseID){
    return selectOne("SELECT COUNT(drugsheets.id) as number FROM  drugsheets inner join status on status.id = drugsheets.status_id where status.slug = 'open' and drugsheets.base_id =:base_id", ['base_id' => $baseID])['number'];
}
function removeDrugSheet($sheetID) {
	execute("DELETE FROM drugsheet_use_batch WHERE drugsheet_id =:sheet_id", ['sheet_id' => $sheetID]);
	execute("DELETE FROM drugsheet_use_nova WHERE drugsheet_id =:sheet_id", ['sheet_id' => $sheetID]);
	execute("DELETE FROM drugsheets WHERE id =:sheet_id", ['sheet_id' => $sheetID]);
}
function getStatusID($slug) {
	return(selectOne("SELECT id FROM status WHERE slug =:slug", ['slug' => $slug])['id']);
}

/** This function is used to get the list of drugs that have at least 1 usable batch (who have not the state "used") for a specific base
 * @param $baseID - The ID of the base
 * @return array|mixed|null
 */
function getDrugsWithUsableBatches($baseID){
    return(selectMany("SELECT drugs.id, drugs.name AS name FROM batches INNER JOIN drugs WHERE batches.drug_id = drugs.id AND batches.base_id = :base_id AND NOT batches.state = 'used' GROUP BY name;",['base_id' => $baseID]));
}

/** This function is used to get the list of the batches who are usable (That have not the state "used") for a specific base
 * @param $baseID - The ID of the base
 * @return array|mixed|null
 */
function getUsableBatches($baseID){
    return(selectMany("SELECT drugs.name as name,batches.drug_id as drug_id, batches.id, batches.number as number, batches.state AS state FROM batches INNER JOIN drugs WHERE batches.drug_id = drugs.id AND batches.base_id = :base_id AND NOT batches.state = 'used';",['base_id' => $baseID]));
}

/** This function is used to get the list of the signatures for a drugsheet
 * @param $sheetID - The ID of the drugsheet
 * @return array|mixed|null
 */
function getDrugSignaturesForDrugSheet($sheetID){
    return selectMany("select date, day ,drugsheet_id,users.firstname,users.lastname,bases.name as basename from drugsignatures inner join users on drugsignatures.user_id = users.id inner join bases on drugsignatures.base = bases.id where drugsheet_id = :sheet_id;", ['sheet_id' => $sheetID]);
}

/** This function is used to insert the signature of a day of a drugsheet
 * @param $drugSheetID - The ID of the drugsheet
 * @param $day - The day of the drugsheet
 * @param $userID - The ID of the user who sign the day
 * @param $baseID - The ID of the base from where the user sign the day
 * @return string|null
 */
function insertDrugSignatures($drugSheetID,$day,$userID,$baseID){
    return insert("INSERT INTO drugsignatures (day, drugsheet_id, user_id, base) values (:day,:drugSheetID,:userID,:baseID);",['drugSheetID' => $drugSheetID, 'day'=>$day,'userID'=>$userID,'baseID'=>$baseID]);
}

/** This function is used to insert new special out operation of drugs in the database
 * @param $date - The Date in the drug sheet
 * @param $batchId - The ID of the Batch
 * @param $drugsheetId - The ID of the drug sheet
 * @param $quantity - The amount
 * @param $comment - The comment
 * @param $adminId - The notified admin
 * @param $userId - The ID of the user that performed the action
 * @return string|null
 */
function insertSpecialDrugOut($date, $batchId, $drugsheetId, $quantity, $comment, $adminId, $userId){
    return insert("INSERT into specialdrugout(date, batch_id, drugsheet_id, quantity, comment, notified_admin_id,user_id) values (:date, :batch_id,:drugsheet_id,:quantity,:comment,:admin_id,:user_id)",["date" => $date,"batch_id"=>$batchId,"drugsheet_id"=>$drugsheetId,"quantity"=>$quantity,"comment"=>$comment,"admin_id"=>$adminId,"user_id"=>$userId]);
}

/** Get the sum of special out operation of drugs for a drug sheet
 * @param $sheetId
 * @return array|mixed|null
 */
function getSumOfSpecialDrugOutForSheet($sheetId){
    return selectMany("select specialdrugout.date,specialdrugout.batch_id,sum(specialdrugout.quantity) as sum from specialdrugout where drugsheet_id = :sheetId group by specialdrugout.date, specialdrugout.batch_id order by specialdrugout.date,specialdrugout.batch_id",["sheetId"=>$sheetId]);
}

/** Get the list of special out operation of drugs for a drug sheet
 * @param $sheetId
 * @return array|mixed|null
 */
function getSpecialDrugOutForSheet($sheetId){
    return selectMany("Select specialdrugout.date,specialdrugout.execution_date, specialdrugout.batch_id,specialdrugout.quantity,specialdrugout.comment, usersnotified.initials as notified_admin, users.initials as user from specialdrugout
join users usersnotified on usersnotified.id = specialdrugout.notified_admin_id
join users on users.id = specialdrugout.user_id
where specialdrugout.drugsheet_id = :sheetId",["sheetId"=>$sheetId]);
}
/* ---- API ----- */

/** This function is use to get the list of the drug sheets where a given user performed an action.
 *  This is for the API.
 * @param $userId - The ID of the user
 * @return array|mixed|null
 */
function getDrugSheetWhereUserAction($userId){
    return selectMany("(select drugsheets.id, drugsheets.week, bases.name base from drugsheets
    join bases on bases.id = drugsheets.base_id
    join drugsignatures on drugsheets.id = drugsignatures.drugsheet_id
    where drugsignatures.user_id = :userId)
    union
    (select drugsheets.id, drugsheets.week, bases.name base from drugsheets
    join bases on bases.id = drugsheets.base_id
    join novachecks on drugsheets.id = novachecks.drugsheet_id
    where novachecks.user_id = :userId)
    union
    (select drugsheets.id, drugsheets.week, bases.name base from drugsheets
    join bases on bases.id = drugsheets.base_id
    join pharmachecks on drugsheets.id = pharmachecks.drugsheet_id
    where pharmachecks.user_id = :userId)
    union
    (select drugsheets.id, drugsheets.week, bases.name base from drugsheets
    join bases on bases.id = drugsheets.base_id
    join restocks on drugsheets.id = restocks.drugsheet_id
    where restocks.user_id = :userId);", ["userId" => $userId]);
}
