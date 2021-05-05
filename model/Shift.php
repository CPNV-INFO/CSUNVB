<?php
/**
 * Shift.php : all funtion pertaining to database request -> for shift
 * Auteur: Gogniat Michael / Paola Costa
 * Date: Decembre 2020
 **/


function getshiftchecksForAction($action_id, $shiftsheet_id, $day)
{
    $checks = selectMany('SELECT shiftchecks.time, users.initials as initials FROM shiftchecks inner join users on users.id = shiftchecks.user_id where shiftaction_id =:action_id and shiftsheet_id =:shiftsheet_id and day=:day', ['action_id' => $action_id, 'shiftsheet_id' => $shiftsheet_id, 'day' => $day]);
    return $checks;
}

function getShiftCommentsForAction($action_id, $shiftsheet_id, $base_id)
{
    $comments = selectMany('SELECT shiftcomments.message, shiftcomments.carryOn, shiftcomments.id, shiftcomments.time, users.initials ,shiftsheets.date,shiftcomments.endOfCarryOn
FROM shiftcomments 
inner join users on users.id = shiftcomments.user_id
inner join shiftsheets on shiftsheets.id = shiftcomments.shiftsheet_id
WHERE shiftaction_id = :action_id AND (shiftsheets.id = :shiftsheet_id or ((carryOn = 1  AND ( (endOfCarryOn IS NULL AND :date > shiftsheets.date) OR :date BETWEEN shiftsheets.date AND endOfCarryOn)) and shiftsheets.base_id = :base_id))', ['action_id' => $action_id, 'shiftsheet_id' => $shiftsheet_id, 'base_id' => $base_id, 'date' => getshiftsheetByID($shiftsheet_id)["date"]]);
    return $comments;
}

function getSelectedActions($sectionID, $model_id)
{
    $actions = selectMany('SELECT shiftactions.* FROM shiftmodel_has_shiftaction
INNER JOIN shiftactions
ON shiftactions.id = shiftmodel_has_shiftaction.shiftaction_id
WHERE shiftmodel_id = :model_id AND shiftsection_id = :sectionID', ['sectionID' => $sectionID, 'model_id' => $model_id]);
    return $actions;
}

function getNotSelectedActions($sectionID, $model_id)
{
    $actions = selectMany('SELECT * FROM shiftactions WHERE id NOT IN
(SELECT shiftactions.id FROM shiftmodel_has_shiftaction
INNER JOIN shiftactions
ON shiftactions.id = shiftmodel_has_shiftaction.shiftaction_id
WHERE shiftmodel_id = :model_id)
AND shiftsection_id = :sectionID', ['sectionID' => $sectionID, 'model_id' => $model_id]);
    return $actions;
}

function getshiftsections($shiftSheetID, $baseID)
{
    $shiftsections = selectMany('SELECT * FROM shiftsections', []);
    foreach ($shiftsections as &$section) {
        $section["actions"] = getSelectedActions($section["id"], getshiftsheetByID($shiftSheetID)["model"]);
        $section["unusedActions"] = getNotSelectedActions($section["id"], getshiftsheetByID($shiftSheetID)["model"]);
        foreach ($section["actions"] as &$action) {
            $action['checksDay'] = getshiftchecksForAction($action["id"], $shiftSheetID, 1);
            $action['checksNight'] = getshiftchecksForAction($action["id"], $shiftSheetID, 0);
            $action["comments"] = getShiftCommentsForAction($action["id"], $shiftSheetID, $baseID);
        }
    }
    return $shiftsections;
}

function getAllShiftForBase($baseID)
{
    $slugs = selectMany("SELECT id,slug as name FROM status", []);
    foreach ($slugs as $slug) {
        $sheets[$slug["name"]] = getShiftWithStatus($baseID, $slug["id"]);
    }
    return $sheets;
}

function getShiftWithStatus($baseID, $slugID)
{
    return selectMany('SELECT shiftsheets.id, shiftsheets.date, shiftsheets.base_id, status.displayname AS status, status.slug AS statusslug, shiftmodels.name as model, shiftmodels.id as model_id 
FROM shiftsheets
INNER JOIN status ON status.id = shiftsheets.status_id
INNER JOIN shiftmodels ON shiftmodels.id = shiftsheets.shiftmodel_id
WHERE shiftsheets.base_id =:base_id and status.id =:slugID order by date DESC;', ["base_id" => $baseID, "slugID" => $slugID]);
}

function getshiftsheetByID($id)
{
    return selectOne('SELECT bases.name as baseName,bases.id as baseID, shiftsheets.id, shiftsheets.date, shiftsheets.base_id,shiftsheets.shiftmodel_id as model, status.slug AS status, status.displayname AS displayname, closeBy.initials AS closeBy
FROM shiftsheets
INNER JOIN bases ON bases.id = shiftsheets.base_id
INNER JOIN status ON status.id = shiftsheets.status_id
LEFT JOIN users closeBy ON closeBy.id = shiftsheets.closeBy
WHERE shiftsheets.id =:id;', ["id" => $id]);
}


function addNewShiftSheet($baseID, $modelID, $date)
{
    return intval (insert("INSERT INTO shiftsheets (date,shiftmodel_id,status_id,base_id) VALUES (:date,:modelID,1,:base)", ['date' => $date, 'base' => $baseID, 'modelID' => $modelID]));
}

function getDateOfLastSheet($baseID)
{
    $lastDate = selectOne("SELECT MAX(date) FROM shiftsheets where base_id = :baseID", ['baseID' => $baseID])["MAX(date)"];
    return $lastDate;
}

function getNextDateForShift($baseID)
{
    $newDate = selectOne("SELECT DATE_ADD( :lastDate, INTERVAL 1 DAY) as newDate", ['lastDate' => getDateOfLastSheet($baseID)])["newDate"];
    if($newDate == NULL){
        $now = selectOne("select NOW()",[])["NOW()"];
        $newDate = selectOne("SELECT DATE_FORMAT('".$now."', '%Y-%m-%d') as date",[])["date"];
    }
    return $newDate;
}

function getOpenShiftSheet($base_id){
    return selectOne("SELECT COUNT(shiftsheets.id) as number FROM  shiftsheets inner join status on status.id = shiftsheets.status_id where status.slug = 'open' and shiftsheets.base_id =:base_id", ['base_id' => $base_id])["number"];
}


function getNbshiftsheet($status,$base_id){
    return selectOne("SELECT COUNT(shiftsheets.id) as number FROM  shiftsheets inner join status on status.id = shiftsheets.status_id where status.slug = :status and shiftsheets.base_id =:base_id", ['status' => $status, 'base_id' => $base_id])["number"];
}

function checkActionForShift($action_id, $shiftSheet_id, $day)
{
    return execute("Insert into shiftchecks(day,shiftsheet_id,shiftaction_id,user_id)values(:day,:shiftSheet_id,:action_id,:user_id)", ["day" => $day, "user_id" => $_SESSION['user']['id'], "shiftSheet_id" => $shiftSheet_id, "action_id" => $action_id]);
}

function unCheckActionForShift($action_id, $shiftSheet_id, $day){
    return execute("Delete from shiftchecks where shiftsheet_id=:shiftSheet_id and day = :day and shiftaction_id =:action_id", ["day" => $day, "shiftSheet_id" => $shiftSheet_id, "action_id" => $action_id]);
}

function commentActionForShift($action_id, $shiftSheet_id, $message)
{
    return execute("Insert into shiftcomments(shiftsheet_id,shiftaction_id,user_id,message)values(:shiftSheet_id,:action_id,:user_id,:message)", ["user_id" => $_SESSION['user']['id'], "shiftSheet_id" => $shiftSheet_id, "action_id" => $action_id, "message" => $message]);
}

function getStateFromSheet($id)
{
    return selectOne("SELECT status.slug, status.displayname FROM status LEFT JOIN shiftsheets ON shiftsheets.status_id = status.id WHERE shiftsheets.id =:sheetID", ["sheetID" => $id]);
}


function getBaseIDForShift($id)
{
    return selectOne("SELECT base_id FROM shiftsheets where id =:id", ["id" => $id])["base_id"];
}

function addCarryOnComment($commentID)
{
    return execute("update shiftcomments set carryON = 1, endOfCarryOn = null where id=:commentID", ["commentID" => $commentID]);
}

function carryOffComment()
{
    return execute("update shiftcomments set endOfCarryOn = :carryOff where id= :commentID", ["commentID" => $_POST["commentID"], "carryOff" => $_POST["carryOff"]]);
}

function getModelByID($id)
{
    return selectOne("select * from shiftmodels where id=:id", ["id" => $id]);
}


function addShiftAction($modelID, $actionID)
{
    return execute("INSERT INTO `shiftmodel_has_shiftaction` (shiftaction_id,shiftmodel_id) VALUES (:actionID,:modelID)", ["modelID" => $modelID, "actionID" => $actionID]);
}

function creatShiftAction($action, $section)
{
    execute("INSERT INTO `shiftactions` (text,shiftsection_id) VALUES (:action,:section)", ["action" => $action, "section" => $section]);
    return selectOne("SELECT MAX(id) AS max FROM shiftactions", [])["max"];
}

function removeShiftAction($modelID, $actionID)
{
    return execute("DELETE FROM `shiftmodel_has_shiftaction` WHERE shiftaction_id=:actionID and shiftmodel_id=:modelID;", ["actionID" => $actionID, "modelID" => $modelID]);
}

function getShiftActionID($actionName, $sectionName)
{
    return selectOne("SELECT shiftactions.id from shiftactions 
INNER JOIN shiftsections
ON shiftsections.id = shiftactions.shiftsection_id
where TEXT= :actionName AND shiftsections.id = :sectionName", ["actionName" => $actionName, "sectionName" => $sectionName])["id"];
}

function getShiftActionName($actionID)
{
    return selectOne("SELECT text from shiftactions where id=:actionID", ["actionID" => $actionID])["text"];
}


/**
 * setSlugForShift : update the status for a shiftsheet
 * @param int $id : id of the shiftsheet
 * @param string $slug : status's slug, values possible values ("blank", "open" , "close" , "reopen", "archive")
 * @return bool : true = ok / false = fail
 */
function setSlugForShift($id, $slug)
{
    return execute("update shiftsheets set status_id= (select id from status where slug =:slug) WHERE id=:id", ["slug" => $slug, "id" => $id]);
}

/**
 * setSlugForShift : set the user who close de sheet
 * @param int $id : id of the shiftsheet
 * @param int $userID : id of the user
 * @return bool : true = ok / false = fail
 */
function closeBy($id,$userID){
    return execute("update shiftsheets set closeBy = :userID WHERE id=:id", ["userID" => $userID, "id" => $id]);
}


/**
 * shiftSheetDelete : delete a shiftsheet ( currently only used for deleting "blank", to delete "archive you need to add some "delete on cascade" in the database )
 * @param int $id : id of the shiftsheet
 * @return bool : true = ok / false = fail
 */
function shiftSheetDelete($id)
{
    return execute("DELETE FROM shiftsheets WHERE id=:id", ["id" => $id]);
}

function getShiftModels()
{
    $models = selectMany("SELECT id,name FROM shiftModels where name <> ''", []);
    return $models;
}


/**
 * getShiftModels : get the list of models where name si not null ( = not a hidden model ) and suggested = 1 ( suggested in the list for shiftsheet creation )
 * @return array : array of models with id and name
 */
function getSuggestedShiftModels(){
    $models = selectMany("SELECT id,name FROM shiftModels where name <> ''  and suggested = 1", []);
    return $models;
}

/**
 * getLastShiftModel : get id of most recent closed or reopened ( in correction ) shiftsheet for the selected base
 * @param int $baseID : id of the selected base
 * @return int : id of the model
 */
function getLastShiftModel($baseID)
{
    $modelID = selectOne("SELECT shiftmodel_id from shiftsheets where DATE = ( SELECT MAX(DATE) FROM shiftsheets WHERE base_id = :baseID and (status_id = (SELECT id FROM status WHERE slug = 'close') or status_id = (SELECT id FROM status WHERE slug = 'reopen'))) AND base_id = :baseID", ["baseID" => $baseID])["shiftmodel_id"];
    return $modelID;
}

/**
 * enableShiftModel : remove the model to the suggested list for the creation of sheet
 * @param int $modelID : id of the model
 * @return bool : true = ok / false = fail
 */
function disableShiftModel($modelID)
{
    return execute("UPDATE shiftmodels SET suggested = 0 WHERE id = :id", ["id" => $modelID]);
}

/**
 * enableShiftModel : add the model to the suggested list for the creation of sheet and give him a name
 * @param int $modelID : id of the model
 * @param int $modelName : name for the model to display
 * @return bool : true = ok / false = fail
 */
function enableShiftModel($modelID, $modelName)
{
    return execute("UPDATE shiftmodels SET suggested = 1, name =:name WHERE id = :id", ["id" => $modelID, "name" => $modelName]);
}

function reEnableShiftModel($modelID){
    return execute("UPDATE shiftmodels SET suggested = 1 WHERE id = :id", ["id" => $modelID]);
}

/**
 * updateModelID : change the model of the shiftsheet
 * @param int $shiftSheetID : id of the shiftsheet
 * @param int $newModelID : id for the new model to use
 * @return bool : true = ok / false = fail
 */
function updateModelID($shiftSheetID, $newModelID)
{
    return execute("update shiftsheets set shiftmodel_id = :newModelID where id= :shiftSheetID", ["shiftSheetID" => $shiftSheetID, "newModelID" => $newModelID]);
}

/**
 * copyModel : create a copy of the model
 * @param int $modelID : id of the model to copy
 * @return int : id of the copy
 */
function copyModel($modelID)
{
    $model = getModelByID($modelID);
    execute("INSERT INTO `shiftmodels` (NAME,nbTeamD,nbTeamN) VALUES (null,:nbTeamD,:nbTeamN)", ["nbTeamD" => $model["nbTeamD"], "nbTeamN" => $model["nbTeamN"]]);
    $newID = selectOne("SELECT MAX(id) AS max FROM shiftmodels", [])["max"];
    $actionToCopy = selectMany('SELECT shiftactions.id FROM shiftmodel_has_shiftaction
INNER JOIN shiftactions
ON shiftactions.id = shiftmodel_has_shiftaction.shiftaction_id
WHERE shiftmodel_id = :model_id ', ['model_id' => $modelID]);
    foreach ($actionToCopy as $action) {
        execute("INSERT INTO `shiftmodel_has_shiftaction` (shiftaction_id,shiftmodel_id) VALUES (:actionID,:modelID)", ["modelID" => $newID, "actionID" => $action["id"]]);
    }
    return $newID;
}

function updateShiftTeams()
{
    switch ($_POST["field"]) {
        case "nova":
            execute("UPDATE shiftteams SET nova_id = :novaID WHERE id = :id", [ "id" => $_POST["teamID"], "novaID" => $_POST["value"]]);
            echo "true";
            break;
        case "boss":
            execute("UPDATE shiftteams SET boss_id = :novaID WHERE id = :id", [ "id" => $_POST["teamID"], "novaID" => $_POST["value"]]);
            echo "true";
            break;
        case "teammate":
            execute("UPDATE shiftteams SET teammate_id = :novaID WHERE id = :id", [ "id" => $_POST["teamID"], "novaID" => $_POST["value"]]);
            echo "true";
            break;
        default:
            echo "false";
    }
}

function getUncheckActionForShift($sheetID){
    return count(selectMany("SELECT day, action_id FROM (
SELECT 0 as DAY, shiftmodel_has_shiftaction.shiftaction_id AS action_id, CONCAT(shiftmodel_has_shiftaction.shiftaction_id,'/',0) AS 'code' FROM shiftmodels
INNER JOIN shiftmodel_has_shiftaction
ON shiftmodels.id = shiftmodel_has_shiftaction.shiftmodel_id
INNER JOIN shiftsheets
ON shiftsheets.shiftmodel_id = shiftmodels.id
WHERE shiftsheets.id = :sheetID
union SELECT 1 as DAY, shiftmodel_has_shiftaction.shiftaction_id AS action_id,CONCAT(shiftmodel_has_shiftaction.shiftaction_id,'/',1) AS 'code'  FROM shiftmodels
INNER JOIN shiftmodel_has_shiftaction
ON shiftmodels.id = shiftmodel_has_shiftaction.shiftmodel_id
INNER JOIN shiftsheets
ON shiftsheets.shiftmodel_id = shiftmodels.id
WHERE shiftsheets.id = :sheetID ) AS test 
WHERE code not IN(
SELECT unique CONCAT(shiftactions.id,'/',shiftchecks.day) AS 'code' FROM shiftchecks
inner JOIN shiftactions
ON shiftactions.id = shiftchecks.shiftaction_id
WHERE shiftchecks.shiftsheet_id = :sheetID)",["sheetID" => $sheetID]));
}

function getShiftBySlugWithUser($slug,$userID){
    return selectMany("SELECT date, shiftsheets.id AS id FROM shiftsheets
JOIN status ON shiftsheets.status_id = status.id
WHERE status.slug = :slug
AND ( dayboss_id = :userID OR nightboss_id = :userID OR dayteammate_id= :userID OR nightteammate_id = :userID)",["slug" => $slug, "userID" => $userID]);
}

function getShiftRole($sheetID,$userID){
    return selectMany("SELECT 'Responsable Jour' AS name FROM shiftsheets WHERE shiftsheets.id = :sheetID AND shiftsheets.dayboss_id = :userID
UNION SELECT 'Responsable Nuit' AS name FROM shiftsheets WHERE shiftsheets.id = :sheetID AND shiftsheets.nightboss_id = :userID
UNION SELECT 'Equipier Jour' AS name FROM shiftsheets WHERE shiftsheets.id = :sheetID AND shiftsheets.dayteammate_id = :userID
UNION SELECT 'Equipier Nuit' AS name FROM shiftsheets WHERE shiftsheets.id = :sheetID AND shiftsheets.nightteammate_id = :userID",["sheetID" => $sheetID, "userID" => $userID]);
}

function getNbShiftTask($sheetID){
    return 2 * count(selectMany("SELECT shiftaction_id FROM shiftmodel_has_shiftaction WHERE shiftmodel_id = (SELECT shiftmodel_id FROM shiftsheets WHERE shiftsheets.id = :sheetID)",["sheetID" => $sheetID]));
}

function getShiftTeam($sheetID,$day){
    return selectMany("select shiftteams.id as team_id, novas.number as nova, novas.id as nova_id, boss.initials as boss , boss.id as boss_id, teammate.initials as teammate , teammate.id as teammate_id from shiftteams
LEFT join novas on nova_id = novas.id
LEFT JOIN users boss ON boss.id = shiftteams.boss_id
LEFT JOIN users teammate ON teammate.id = shiftteams.teammate_id
where shiftsheet_id = :sheetID and day = :day",["sheetID" => $sheetID, "day" => $day]);
}

function addShiftTeam($sheetID,$day){
    return insert("INSERT INTO `shiftteams` (shiftsheet_id,day) VALUES (:sheetID,:day)",["sheetID"=> $sheetID, "day" => $day]);
}


function addTeamToModel($modelID,$day){
    switch ($day) {
        case 0:
            return execute("UPDATE shiftmodels SET nbTeamN = nbTeamN + 1 where id = :modelID",[ "modelID" => $modelID]);
        case 1:
            return execute("UPDATE shiftmodels SET nbTeamD = nbTeamD + 1 where id = :modelID",[ "modelID" => $modelID]);
        default:
    }
}
