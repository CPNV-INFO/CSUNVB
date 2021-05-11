<?php

/**
 * Call database login details and functions
 *
 * relative path are from public/api/index.php
 */
require "../" . MODEL . ".const.php";
require "../" . MODEL . "db_crud.php";

/**
 * Call all model files
 *
 * relative path are from public/api/index.php
 */
require "../" . MODEL . "Base.php";
require "../" . MODEL . "User.php";
require "../" . MODEL . "Drugs.php";
require "../" . MODEL . "Nova.php";
require "../" . MODEL . "Shift.php";
require "../" . MODEL . "Todo.php";
require "../" . MODEL . "Log.php";
require "../" . MODEL . "api.php";

/**
 * This function is used to get the list of the bases, convert it in JSON and require the view
 */
function basesList()
{
    $outText = json_encode(getbases());
    require_once '../../view/api/show.php';
}

/**
 * This function is used to define the error code when an action is not found and call the view
 */
function notFound()
{
    $httpErrorCode = '404';
    require_once '../../view/api/show.php';
}

/** This function is used to check the credentials given by the user and if it's correct generating a token,
 * calling the model to store it in the database and converting it into a JSON and calling the view for it to send it.
 *
 * This function require a POST "initials" and a POST "password".
 *
 * This function can give an HTTP error code if there is a problem depending on the problem:
 *
 * HTTP error code 400 - Bad Request - user or password missing
 * HTTP error code 401 - Unauthorized - wrong user or password
 * HTTP error code 500 - Internal Server Error - There can be a problem with the database
 *
 * @throws Exception - An exception can be threw when there is a problem with the database
 */
function tokenManager()
{
    if (isset($_POST['initials']) && isset($_POST['password'])) {
        $initials = $_POST['initials'];
        $password = $_POST['password'];

        $user = getUserByInitials($initials);


        if (password_verify($password, $user['password'])) {

            //Generate a random string.
            $token = random_bytes(30);

            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);

            $res = insertOrUpdateApiToken($user['id'], $token);
            if ($res == null || $res === false) {
                $httpErrorCode = "500";
            } else {
                $token = array("token" => $token);
                $outText = json_encode($token);
            }

        } else {
            $httpErrorCode = '401';
        }
    } else {
        $httpErrorCode = '400';
    }

    require_once '../../view/api/show.php';


}

/** This function is used to get the list of sheets where the user that provided the token has made an action.
 *
 *  This function can give an HTTP error code if there is a problem depending on the problem:
 *
 *  HTTP error code 400 - Bad Request - no token provided or wrong token method
 *  HTTP error code 401 - Unauthorized - invalid token
 */
function SheetListForUser(){
    if(isset($_SERVER['HTTP_AUTHORIZATION'] )) {
        $httpAuthorization = $_SERVER['HTTP_AUTHORIZATION'];
        if (substr($httpAuthorization, 0, 6) == "Bearer") {
            $token = substr($httpAuthorization,7);

            $user = getUserInfosByToken($token);

            if($user != false){
                $shiftSheets = getShiftSheetWhereUserActionOrCrew($user['id']);
                $drugSheets = getDrugSheetWhereUserAction($user['id']);
                $sheets = array("shift" => $shiftSheets,"drug" => $drugSheets);

                $outText = json_encode($sheets);


            }else{
                $httpErrorCode = '401';
            }
            $test = "";

        } else {
            $httpErrorCode = '400';
        }
    }else{
        $httpErrorCode = '400';
    }

    require_once '../../view/api/show.php';
}