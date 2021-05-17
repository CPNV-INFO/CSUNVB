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

/** This function is used to get the list of of shift sheets where a given user performed an action
 * @param $userId - The ID of the user
 * @return array|mixed|null
 */
function getShiftSheetWhereUserActionOrCrew($userId){
    return selectMany("(select shiftsheets.id, shiftsheets.date, bases.name base from shiftsheets
join bases on bases.id = shiftsheets.base_id
where shiftsheets.dayboss_id = :userId or
         shiftsheets.nightboss_id = :userId or
         shiftsheets.dayteammate_id = :userId or
         shiftsheets.nightteammate_id = :userId)

    union

    (select shiftsheets.id, shiftsheets.date, bases.name base from shiftsheets
   join bases on bases.id = shiftsheets.base_id
   join shiftchecks ON shiftchecks.shiftsheet_id = shiftsheets.id
	where shiftchecks.user_id = :userId  )

    union

    (select shiftsheets.id, shiftsheets.date, bases.name base from shiftsheets
   join bases on bases.id = shiftsheets.base_id
   join shiftcomments ON shiftcomments.shiftsheet_id = shiftsheets.id
	where shiftcomments.user_id = :userId );", ["userId" => $userId]);
}

/** This function is use to get the list of the drug sheets where a given user performed an action
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