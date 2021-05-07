<?php

/** This function is used to insert or update a token in the database
 * @param $userId - The ID of the user
 * @param $token - The new token
 * @return string|null
 */
function insertOrUpdateApiToken($userId,$token){
    return insert("INSERT INTO apitokens (user_id,token) values (:userId,:token) ON DUPLICATE key update token = :token;",["userId" => $userId,"token" => $token]);
}