<?php
/**
 * file with the main action -> the one used on every branch and common to every groups, when it is an user action. The admin actions are on the adminController
 */


/** Display Home page */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function home()
{
    $openShifts = getShiftBySlugWithUser("open",$_SESSION["user"]["id"]);
    foreach ($openShifts as &$openShift){
        $openShift["roles"] = getShiftRole($openShift["id"],$_SESSION["user"]["id"]);
        $nbMissing = getUncheckActionForShift($openShift["id"]);
        $nbTot = getNbShiftTask($openShift["id"]);
        $openShift["nbDone"] = $nbTot - $nbMissing;
        $openShift["nbTasks"] = $nbTot;
    }
    $blankShifts = getShiftBySlugWithUser("blank",$_SESSION["user"]["id"]);
    foreach ($blankShifts as &$blankShift){
        $blankShift["roles"] = getShiftRole($blankShift["id"],$_SESSION["user"]["id"]);
    }
    $reOpenShifts = getShiftBySlugWithUser("reopen",$_SESSION["user"]["id"]);
    foreach ($reOpenShifts as &$reOpenShift){
        $reOpenShift["roles"] = getShiftRole($reOpenShift["id"],$_SESSION["user"]["id"]);
    }
    $todoSheets = getWeeksBySlugs($_SESSION['base']['id'],"open");
    $stupSheets = getDrugSheetsByState($_SESSION['base']['id'],"open");
    require VIEW . 'main/dashboard.php';
}

/**
 * disconnect the user
 */
function disconnect()
{
    $_SESSION['user'] =  null;
    $_SESSION['action'] = 'login';
    redirect("login");
}

/**
 * verify presence of every parameter for the connexion
 */
function login()
{
    if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['base']))
    {
        trylogin();
    }else{
        displayLoginPage();
    }
}

/**
 * show the login page
 */
function displayLoginPage(){
    $bases = getbases();
    require VIEW . 'main/login.php';
}

/**
 * attempt to connect the user
 */
function tryLogin()
{
    $initials = $_POST['username'];
    $password = $_POST['password'];
    $baseLogin = $_POST['base'];
    $user = getUserByInitials($initials);
    if($user['firstconnect'] == true){
        setFlashMessage("Ce compte semble inactif, vérifiez votre boite mail, vous avez peut-être reçu un lien d'activation pour le compte, si ce n'est pas le cas, contacter un administrateur");
        displayLoginPage();
    }else{
        if (password_verify($password, $user['password'])) {
            unset($user['password']); // don't store password in the session
            $_SESSION['user'] =  $user;
            $_SESSION['base'] = getbasebyid($baseLogin);//Met la base dans la session
            setFlashMessage('Bienvenue ' . $user['firstname'] . ' ' . $user['lastname'] . ' !');
            redirect("home");
        } else {
            setFlashMessage('Identifiants incorrects ...');
            displayLoginPage();
        }
    }
}

/**
 * send to the view of an unknown page
 */
function unknownPage(){
    require VIEW . 'main/unknownPage.php';
}


function resetPass(){
    require VIEW . 'main/resetPass.php';
}

function resetPassMail(){
    $mail = newMail();
    $user = getUserByMail($_POST["mail"]);
    if($user==false){
        setFlashMessage("Aucun compte n'est lié à ce mail");
    }else{
        $mail->addAddress($_POST["mail"], $user["initials"]);
        $mail->Subject = utf8_decode('Réinitialiser votre mot de passe');;
        $token = generateTokenNumber();
        if(newToken($token,$user["id"],1)){
            $url = "http://".$_SERVER[HTTP_HOST].'?action=newPass&id='.$token;
            $link = '<a href="'.$url.'">CSUNVB</a>';
            $mailContent = "<h2>Bonjour ".$user["initials"].",</h2>";
            $mailContent .= "<p>Veuillez cliquer sur le lien ci-dessous si vous souhaiter changer votre mot de passe<br>Si vous n'avez pas fait cette demande, vous pouvez simplement ignorer ce mail</p>";
            $mailContent .= $link;
            $mail->msgHTML($mailContent);
            if ($mail->send()) {
                setFlashMessage("Le lien vous a été envoyé à l'adresse : ".$_POST["mail"]);
            } else {
                setFlashMessage("Erreur lors de l'envoi du mail");
            }
        }else{
            setFlashMessage("Erreur lors de la création du token");
        }
    }
    redirect("resetPass");
}

function newMail(){
    $mail = new PHPMailer();
    $mail->isSMTP();
//Set the hostname of the mail server
    $mail->Host = MAILHOST;
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = MAILSENDER;
//Password to use for SMTP authentication
    $mail->Password = MAILPASS;
//Set who the message is to be sent from
    $mail->setFrom(MAILSENDER, 'CSUNVB');
    return $mail;
}

function generateTokenNumber($length = 24) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function newPass($token){
    $userID = checkToken($token);
    if($userID == null){
        setFlashMessage("Lien expiré ou invalide");
        redirect("login");
    }else{
        require VIEW . 'main/newPass.php';
    }
}

function setNewPass($userID){
    if($_POST["newPassword"]==$_POST["confirmPassword"]){
        setFlashMessage("Mot de passe modifié avec succès");
        $user = getUser($userID);
        $hash =  password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
        SaveUserPassword($hash, $userID);
        redirect("login");
    }else{
        setFlashMessage("Le mot de passe de confirmation n'est pas identique");
        redirect('newPass&id='.$_POST["token"]);
    }
}