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
    $httpErrorCode = null;

    sendJson($httpErrorCode, $outText);
}

/**
 * This function is used to define the error code when an action is not found and call the view
 */
function notFound()
{
    $httpErrorCode = '404';
    $outText = null;
    sendJson($httpErrorCode, $outText);
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
    $outText = null;
    $httpErrorCode = null;

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

    sendJson($httpErrorCode, $outText);


}

function checkApiToken()
{

    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $httpAuthorization = $_SERVER['HTTP_AUTHORIZATION'];
        if (substr($httpAuthorization, 0, 6) == "Bearer") {
            $token = substr($httpAuthorization, 7);

            $return = getUserInfosByToken($token);


        } else {
            $return = "error400";
        }
    } else {
        $return = "error400";
    }
    return $return;
}

/** This function is used to get the list of sheets where the user that provided the token has made an action.
 *
 *  This function can give an HTTP error code if there is a problem depending on the problem:
 *
 *  HTTP error code 400 - Bad Request - no token provided or wrong token method
 *  HTTP error code 401 - Unauthorized - invalid token
 */
function SheetListForUser()
{

    $user = checkApiToken();
    $outText = null;
    $httpErrorCode = null;

    if (isset($user['id'])) {
        $shiftSheets = getShiftSheetWhereUserActionOrCrew($user['id']);
        $drugSheets = getDrugSheetWhereUserAction($user['id']);
        $sheets = array("shift" => $shiftSheets, "drug" => $drugSheets);

        $outText = json_encode($sheets);
    } elseif ($user == "error400") {
        $httpErrorCode = '400';
    } else {
        $httpErrorCode = '401';
    }


    sendJson($httpErrorCode, $outText);
}

/**
 * This function is used to get the list of shift sheets where a given user has checked a task
 */
function sheetUserAction()
{

    $outText = null;
    $httpErrorCode = null;

    if (isset($_GET['id'])) {
        $sheetId = $_GET['id'];

        $user = checkApiToken();


        if (isset($user['id'])) {
            $checks = array("data" => getShiftChecks($user['id'], $sheetId));
            $outText = json_encode($checks);
        } elseif ($user == "error400") {
            $httpErrorCode = '400';
        } else {
            $httpErrorCode = '401';
        }

    }else{
        $httpErrorCode = '400';
    }

    sendJson($httpErrorCode, $outText);
}

/** This function is used to output the data from the API
 * @param $httpErrorCode - The HTTP error code or null
 * @param $outText - The Text (mostly JSON) or null
 */
function sendJson($httpErrorCode, $outText)
{
    if (!is_null($httpErrorCode)) {
        http_response_code($httpErrorCode);
    }

    if (!is_null($outText)) {
        echo $outText;
    }
}

/**
 * This function is used to insert a novacheck.
 *
 * it require in POST:
 * - 'nova_id' - The is of the nova
 * - 'drugsheet_id' - The id of the drugsheet
 * - 'start' - The value at the begining of the day
 * - 'end' - he value at the end of the day
 * - 'date' - The date
 * - 'drug_id' - The drug ID
 */
function insertNovaCheck()
{
    $outText = null;
    $httpErrorCode = null;

    $user = checkApiToken();

    if (isset($user['id'])) {
        if (isset($_POST['nova_id']) && isset($_POST['drugsheet_id']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['date']) && isset($_POST['drug_id'])) {
            $novaId = $_POST['nova_id'];
            $drugsheetId = $_POST['drugsheet_id'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $date = $_POST['date'];
            $drugId = $_POST['drug_id'];
            $drug = array("start" => $start, "end" => $end);

            $res = insertOrUpdateNovaChecks($date, $drug, $drugId, $novaId, $drugsheetId, $user['id']);
            if ($res == null || $res === false) {
                $httpErrorCode = '500';
            } else {
                $outText = "Ok";
            }
        } else {
            $httpErrorCode = '400';
        }
    } elseif ($user == "error400") {
        $httpErrorCode = '400';
    } else {
        $httpErrorCode = '401';
    }

    sendJson($httpErrorCode, $outText);
}

/**
 * This function is used to insert PharmaCheck.
 * Check documentation for more informations.
 */
function insertPharmaCheck()
{
    $outText = null;
    $httpErrorCode = null;

    $user = checkApiToken();

    if (isset($user['id'])) {
        if (isset($_POST['batch_id']) && isset($_POST['drugsheet_id']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['date'])) {
            $batchId = $_POST['batch_id'];
            $drugsheetId = $_POST['drugsheet_id'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $date = $_POST['date'];
            $batch = array("start" => $start, "end" => $end);

            $res = insertOrUpdatePharmaChecks($date, $batch, $batchId, $drugsheetId, $user['id']);
            if ($res == null || $res === false) {
                $httpErrorCode = '500';
            } else {
                $outText = "Ok";
            }
        } else {
            $httpErrorCode = '400';
        }
    } elseif ($user == "error400") {
        $httpErrorCode = '400';
    } else {
        $httpErrorCode = '401';
    }

    sendJson($httpErrorCode, $outText);

}

/**
 * This function is used to get novachecks or pharmachecks that have no value and are for a specific base and for yesterday.
 * Check documentation for more informations.
 */
function missingchecks(){
    $outText = null;
    $httpErrorCode = null;

    if (isset($_GET['id'])) {
        $baseId = $_GET['id'];

        $user = checkApiToken();

        if (isset($user['id'])) {
            $pharmaChecks = getMissingPharmaChecks($baseId);
            $novaChecks = getMissingNovaChecks($baseId);
            $checks = array("pharma" => $pharmaChecks,"nova"=>$novaChecks);
            $outText = json_encode($checks);
        } elseif ($user == "error400") {
            $httpErrorCode = '400';
        } else {
            $httpErrorCode = '401';
        }

    }else{
        $httpErrorCode = '400';
    }

    sendJson($httpErrorCode, $outText);
}