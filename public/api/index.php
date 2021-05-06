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
 * Call database login details and functions
 */
require "../".MODEL . ".const.php";
require "../".MODEL . "db_crud.php";

/**
 * Call all model files
 */
require "../".MODEL . "Base.php";
require "../".MODEL . "User.php";
require "../".MODEL . "Drugs.php";
require "../".MODEL . "Nova.php";
require "../".MODEL . "Shift.php";
require "../".MODEL . "Todo.php";
require "../".MODEL . "Log.php";

/**
 * Check if user logged in and perform requested action when true
 */


switch ($_GET['action']) {
    case "bases":
        basesList();
        break;
    default:
        notFound();
}
