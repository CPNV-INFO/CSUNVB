<?php
/** Author: Théo Gautier
 *  Date: 06.05.2021
 *  Description: Index of API
 */


header("Cache-Control: private, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // A date in the past
setlocale(LC_TIME, "fr_FR", "French");

/**
 * Call definition file pour paths
 */

date_default_timezone_set('Europe/Paris');

require "../../path.php";
require "../../globalhelpers.php";

/**
 * Calls the controller of the API
 */
require "../".CONTROLLER . "apiController.php";




/**
 * Check if user logged in and perform requested action when true
 */

header('Access-Control-Allow-Origin: *');


switch ($_GET['action']) {
    case "bases":
        basesList();
        break;
    case "gettoken":
        tokenManager();
        break;
    case "reports":
        sheetListForUser();
        break;
    case "myactionsinshift":
        sheetUserAction();
        break;
    case "novacheck":
        insertNovaCheck();
        break;
    case "pharmacheck":
        insertPharmaCheck();
        break;
    case "missingchecks":
        missingchecks();
        break;
    default:
        notFound();
}
