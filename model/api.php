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