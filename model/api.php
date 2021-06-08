<?php

/** This function is used to insert or update a token in the database
 * @param $userId - The ID of the user
 * @param $token - The new token
 * @return string|null
 */
function insertOrUpdateApiToken($userId,$token){
    return insert("INSERT INTO apitokens (user_id,token) values (:userId,:token) ON DUPLICATE key update token = :token;",["userId" => $userId,"token" => $token]);
}

/** This function is used to get the data of a user with a token
 * @param $token - The token
 * @return array|mixed|null
 */
function getUserInfosByToken($token){
    return selectOne("select users.id, users.initials, users.firstname, users.lastname, users.email, users.mobileNumber, users.admin from users inner join apitokens on users.id = apitokens.user_id where token = :token;",["token"=>$token]);
}

function getMissingPharmaChecks($baseId){
    return selectMany("select  pharmachecks.date, drugs.name as drug, pharmachecks.batch_id,batches.number as batch_number, pharmachecks.drugsheet_id  from pharmachecks
join batches on pharmachecks.batch_id = batches.id
join drugs on drugs.id = batches.drug_id
join drugsheets on pharmachecks.drugsheet_id = drugsheets.id
where (pharmachecks.start = 0 or pharmachecks.end = 0) and CURRENT_TIMESTAMP - interval '1' day > pharmachecks.date and drugsheets.status_id = 2 and drugsheets.base_id = :base_id",["base_id" => $baseId]);
}

function getMissingNovaChecks($baseId){
    return selectMany("select  novachecks.date, novas.number as nova, novachecks.nova_id, drugs.name as drug, novachecks.drug_id, novachecks.drugsheet_id  from novachecks
join novas on novachecks.nova_id = novas.id
join drugs on drugs.id = novachecks.drug_id
join drugsheets on novachecks.drugsheet_id = drugsheets.id
where (novachecks.start = 0 or novachecks.end = 0) and CURRENT_TIMESTAMP - interval '1' day > novachecks.date and drugsheets.status_id = 2 and drugsheets.base_id = :base_id",["base_id" => $baseId]);
}