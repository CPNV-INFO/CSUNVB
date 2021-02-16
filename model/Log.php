<?php
/**
 * Shift.php : all funtion pertaining to database request -> for logs
 * Auteur: Gogniat Michael
 * Date: Février 2021
 **/

function writeLog($type,$sheetID,$info) {
    return insert("INSERT INTO logs (user_id,report_type,report_id,info) VALUES (:userID,:type,:sheetID,:info)",["userID" => $_SESSION['user']["id"], "type" => $type, "sheetID" => $sheetID , "info" => $info]);
}

function getLogs($type,$sheetID){
    return selectMany("SELECT timestamp  as date, info, (select initials from users where id = logs.user_id) as initials FROM logs where report_type=:type and report_id=:sheetID order by date DESC", ["type" => $type, "sheetID" => $sheetID]);
}