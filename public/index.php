<?php
/**
 * Created by PhpStorm.
 * User: Pascal.BENZONANA
 * Date: 08.05.2017
 * Time: 08:54
 * Update : 11-NOV-2020 - michael.gogniat
 * Simplify index. Remove all pages references.
 */
session_start();

header("Cache-Control: private, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // A date in the past
setlocale(LC_TIME, "fr_FR", "French");

/**
 * Call definition file pour paths
 */

date_default_timezone_set('Europe/Paris');
require "../path.php";

/**
 * Call common functions used in different parts of the code
 */
require VIEW . "helpers.php";
require "../globalhelpers.php";

/**
 * Call the controller files for the different pages of the site:
 * adminController: Administration
 * drugsController: Drug use tracking
 * mainController: Home page and login
 * shiftController: Shift reports
 * todoController: Daily tasks
 */
require CONTROLLER . "adminController.php";
require CONTROLLER . "drugsController.php";
require CONTROLLER . "mainController.php";
require CONTROLLER . "shiftController.php";
require CONTROLLER . "todoController.php";
require CONTROLLER . "smsController.php";

/**
 * Call database login details and functions
 */
require MODEL . ".const.php";
require MODEL . "db_crud.php";

/**
 * Use for PHPMailer
 */
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/.mailconf.php';


/**
 * Call all model files
 */
require MODEL . "Base.php";
require MODEL . "User.php";
require MODEL . "Drugs.php";
require MODEL . "Nova.php";
require MODEL . "Shift.php";
require MODEL . "Todo.php";
require MODEL . "Log.php";

/**
 * Check if user logged in and perform requested action when true
 */
if (!isset($_SESSION['user'])) {
    switch ($_GET['action']) {
        case "resetPass":
            resetPass();
            break;
        case "resetPassMail":
            resetPassMail();
            break;
        case "newPass":
            newPass($_GET['id']);
            break;
        case "setNewPass":
            setNewPass($_GET['id']);
            break;
        default:
            login();
    }

} else {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'home';
    }

    if (function_exists($action)) { // action parameter matches a known function name
        if(ican($action)){
            if (isset($_GET['id'])) {
                $action($_GET['id']); // call it with a value
            } else {
                $action();             // or not
            }
        }else{
            setFlashMessage("Action non-autorisée");
            home();
        }
    } else {
        home();
    }
}

