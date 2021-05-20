<?php

/** Display admin page */
function adminHome()
{
    require VIEW . 'admin/adminHome.php';
}

/** Users Administration */
/** Display crew page */
function adminCrew()
{
    $users = getUsers();
    require_once VIEW . 'admin/adminCrew.php';
}

/** Display new user page */
function newUser()
{
    require_once VIEW . 'admin/newUser.php';
}

/**
 * save a new user
 * show a message if there's a problem
 */
function saveNewUser()
{
    $prenomUser = $_POST['prenomUser'];
    $nomUser = $_POST['nomUser'];
    $initialesUser = $_POST['initialesUser'];
    $startPassword = $_POST['startPassword'];
    $hash = password_hash($startPassword, PASSWORD_DEFAULT);

    if ($prenomUser == " " || $initialesUser == " " || $nomUser == " ") {
        setFlashMessage("Ni le prénom, ni le nom, ni les initiales ne peut être un champ vide.");
    } else {
        $result = addNewUser($prenomUser, $nomUser, $initialesUser, $hash, 0, 1);
        if ($result == 0) {
            setFlashMessage("Une erreur est survenue. Impossible d'ajouter l'utilisateur.");
        } else {
            setFlashMessage("L'utilisateur a bien été ajouté !");
        }
    }
    redirect("adminCrew");
}

/**
 * change an user to admin or an admin to user
 */
function changeUserAdmin()
{
    $changeUser = $_GET['idUser'];
    $user = getUser($changeUser);
    if ($user['admin']) {
        $user['admin'] = 0;
    } else {
        $user['admin'] = 1;
    }
    $res = SaveUser($user);
    if ($res == true) {
        if ($user['admin']) {
            setFlashMessage($user['initials'] . " est désormais administrateur.");
        } else {
            setFlashMessage($user['initials'] . " est désormais utilisateur.");
        }
    } else {
        setFlashMessage("Erreur de modification du rôle pour " . $user['initials']);
    }
    redirect("adminCrew");
}

/**
 * reset an user password
 * ! the new password is in the flashmessage, it must be copied to be sent further on.
 */
function resetUserPassword()
{
    $newpassword = changePwdState($_GET['idUser']);
    setFlashMessage("Le nouveau mot de passe est: $newpassword");
    redirect("adminCrew");
}

/** drugs Administration */

function adminDrugs()
{
    $drugs = getDrugs();
    require_once VIEW . 'admin/adminDrugs.php';
}

function newDrug()
{
    if (isset($_POST['nameDrug'])) {
        if ($_POST['nameDrug'] == " " || $_POST['nameDrug'] == "") {
            setFlashMessage("Le nom du médicament ne peut pas être vide.");
        } else {
            $res = addNewDrug($_POST['nameDrug']);
            if ($res == false) {
                setFlashMessage("Une erreur est survenue. Impossible d'ajouter le médicament.");
            } else {
                setFlashMessage("Le médicament " . $_POST['nameDrug'] . " a été correctement ajouté.");
            }
        }
        adminDrugs();
    } else {
        require_once VIEW . 'admin/newDrug.php';
    }
}

function updateDrug()
{
    $idDrug = $_GET['idDrug'];
    if (isset($_POST['updateNameDrug'])) {
        $res = updateDrugName($_POST['updateNameDrug'], $idDrug);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible de renommer le médicament.");
        } else {
            setFlashMessage("Le médicament a été correctement renommé.");
        }
        adminDrugs();
    } else {
        require_once VIEW . 'admin/updateDrug.php';
    }
}

/** Bases Administration */

function adminBases()
{
    $bases = getbases();
    require_once VIEW . 'admin/adminBases.php';
}

function newBase()
{
    if (isset($_POST['nameBase'])) {
        if ($_POST['nameBase'] == " " || $_POST['nameBase'] == "") {
            setFlashMessage("Le nom de la base ne peut pas être vide.");
        } else {
            $res = addNewBase($_POST['nameBase']);
            if ($res == false) {
                setFlashMessage("Une erreur est survenue. Impossible d'ajouter la base.");
            } else {
                setFlashMessage("La base a été correctement ajoutée.");
            }
        }
        adminBases();
    } else {
        require_once VIEW . 'admin/newBase.php';
    }
}

function editbase($id)
{
    $base = getbasebyid($id);
    require_once VIEW . 'admin/updateBase.php';
}

function updateBase()
{
    extract($_POST); // crée les variables $id et $updateNameBase qui sont les clés du POST
    $res = renameBase($id, $updateNameBase);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de renommer la base.");
    } else {
        setFlashMessage("La base a été correctement renommée.");
    }
    redirect('adminBases');
}

/** Nova Administration */

function adminNovas()
{
    $novas = getNovas();
    require_once VIEW . 'admin/adminNovas.php';
}

function newNova()
{
    if (isset($_POST['nameNova'])) {
        $res = addNewNova($_POST['nameNova']);
        if ($res == false) {
            setFlashMessage("Une erreur est survenue. Impossible d'ajouter la nova.");
        } else {
            setFlashMessage("La nova a été correctement ajoutée.");
        }
        adminNovas();
    } else {
        require_once VIEW . 'admin/newNova.php';
    }
}

function changeEmail()
{
    $changeUser = $_POST['userID'];
    $user = getUser($changeUser);
    $user['email'] = $_POST['mail'];
    SaveUser($user);
}

function changeTel()
{
    $changeUser = $_POST['userID'];
    $user = getUser($changeUser);
    $user['mobileNumber'] = $_POST['tel'];
    SaveUser($user);
}

function showNova($novaID)
{
    $nova = getANovaByID($novaID);
    $dayNames = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
    $monthNames = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    if (isset($_POST["month"]) and isset($_POST["year"])) {
        $date = $_POST["year"]."-".$_POST["month"];
    } else {
        $date = date("Y-n");
    }
    $calendar = newCalendar($date);

    foreach ($calendar as &$week){
        foreach ($week as &$day){
            $day["shifts"] = getShiftUsingNova($novaID,date_format($day["date"],"Y-m-d"));
            $day["unAvailableDay"] = getUnAvailableNova(date_format($day["date"],"Y-m-d"),1,$novaID);
            $day["unAvailableNight"] = getUnAvailableNova(date_format($day["date"],"Y-m-d"),0,$novaID);
            if(date_format($day["date"],"Y-m-d") == date("Y-m-d")){
                $day["color"] = "#FFD239";
            }
        }
        unset($day);
    }
    unset($week);
    $selectedMonth = date_format(date_create($date.'-01'), 'n');
    $selectedYear = date_format(date_create($date.'-01'), 'Y');

    require_once VIEW . 'admin/showNova.php';
}


function updateNova($novaID)
{
    $res = updateNumberNova($_POST['updateNumberNova'], $novaID);
    if ($res == false) {
        setFlashMessage("Une erreur est survenue. Impossible de renommer la nova.");
    } else {
        setFlashMessage("La nova a été correctement renommée.");
    }
    redirect("showNova",$novaID);
}

function updateNovaAvailable($novaID){
    delUnAvailableNova($_POST["date"],$novaID);
    if(isset($_POST["day"])and($_POST["day"] == "on")){
        addUnAvailableNova($_POST["comment"],$_POST["date"],1,$_SESSION["user"]["id"],$novaID);
    }
    if(isset($_POST["night"])and($_POST["night"] == "on")){
        addUnAvailableNova($_POST["comment"],$_POST["date"],0,$_SESSION["user"]["id"],$novaID);
    }
    redirect("showNova",$novaID);
}

function importPlanning(){
    $users = getUsers();
    $workTimes = getWorkTimes();
    $bases = getbases();
    $errors = array();
    $planningToImport = array();
    $firstDate = null;
    $lastDate = null;

    $selectedUserID = null;
    $date = null;
    $selectedWorkTimeID = null;

    if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
        $row = 1;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $ok = true;
            if(is_numeric($data[0])){
                $selectedUserID = checkUserNumber($users,$data[0]);
                if($selectedUserID == false){
                    $selectedUserID = checkUserName($users,utf8_encode($data[1]),$data[0]);
                    if($selectedUserID != false){
                        $users = getUsers();
                    }else{
                        $newError = $data[0] . "/". utf8_encode($data[1]) ." : mauvais nom de secouriste, matricule ou secouriste non enregistré sur le site, ";
                        if (!in_array($newError, $errors))
                        {
                            array_push($errors, $newError);
                        }
                        $ok = false;
                    }
                }

                $date = DateTime::createFromFormat("d.m.Y", $data[2]);
                if($date == false){
                    array_push($errors, "ligne " . $row . " format de date incorrect, ");
                    $ok = false;
                }

                $selectedWorkTimeID = checkWorkTime($workTimes,$data[5]);
                if($selectedWorkTimeID == false){
                    $selectedWorkTimeID = tryAddWorkTime($data[5],utf8_encode($data[6]),$bases);
                    $workTimes = getWorkTimes();
                }
            }else{
                $ok = false;
            }
            if($ok == true){
                $newPlanning['workID'] = $selectedWorkTimeID;
                $newPlanning['userID'] = $selectedUserID;
                $newPlanning['date'] = date_format($date,"Y-m-d");
                array_push($planningToImport,$newPlanning);
                if($firstDate > $date || $firstDate == null){
                    $firstDate = $date;
                }
                if($lastDate < $date || $lastDate == null){
                    $lastDate = $date;
                }
            }
            $row ++;
        }
        fclose($handle);
    }
    delPlanning(date_format($firstDate,"Y-m-d"),date_format($lastDate,"Y-m-d"));
    foreach ($planningToImport as $planning){
        addWorkPlanning($planning["workID"],$planning["userID"],$planning["date"]);
    }
    if(count($errors) == 0){
        setFlashMessage("Planning importé avec succès");
    }else{
        setFlashMessage("Certaines données n'ont pas pu être importée : ");
        foreach ($errors as $error){
            setFlashMessage($_SESSION['flashmessage'].$error);
        }
    }
    redirect("adminCrew");
}

function checkUserNumber($users,$userNumber){
    foreach ($users as $user){
        if($user["number"] == $userNumber){
            return $user["id"];
        }
    }
    return false;
}

function checkUserName($users,$userName,$userNumber){
    $bestCorrelation = null;
    $minPercent = 90;
    $percent = 0;
    foreach ($users as $user){
        similar_text(($user["lastname"]. " " .$user["firstname"]),$userName,$res);
        if($percent < $res){
            $percent = $res;
            $bestCorrelation = $user;
        }
        similar_text(($user["firstname"]. " " .$user["lastname"]),$userName,$res);
        if($percent < $res){
            $percent = $res;
            $bestCorrelation = $user;
        }
    }
    if($percent<$minPercent){
        return false;
    }else{
        $users = getUsers();
        return tryAddUserNumber($bestCorrelation,$userNumber);
    }
}

function checkWorkTime($workTimes,$code){
    foreach ($workTimes as $workTime){
        if($workTime["code"] == $code){
            return $workTime["id"];
        }
    }
    return false;
}

function tryAddUserNumber($user,$userNumber){
    if($user["number"] != null){
        return false;
    }else{
        if(addUserNumber($user["id"],$userNumber)){
            return $user["id"];
        }else{
            return false;
        }
    }
}

function tryAddWorkTime($code,$name,$bases){
    $special = false;
    $day = null;
    $bestBaseID = null;
    $minPercent = 25;

    $tolowerName = strtolower($name);
    $words = explode(" ", $tolowerName);

    if(strpos($tolowerName, "horaire") === false){
        $special = true;
    }else{
        $lookingForNumber = false;
        $name = null;
        foreach ($words as $key => $word){
            if($lookingForNumber === true){
                if(strlen($word) < 4){
                    $name = strtoupper($word);
                    unset($words[$key]);
                }
                $lookingForNumber = false;
            }else{
                switch ($word) {
                    case "horaire":
                        $lookingForNumber = true;
                        unset($words[$key]);
                        break;
                    case "-":
                        unset($words[$key]);
                        break;
                    case "jour":
                        $day = 1;
                        unset($words[$key]);
                        break;
                    case "nuit":
                        $day = 0;
                        unset($words[$key]);
                        break;
                    default:
                }
            }
        }
        $resultingString = implode(" ", $words);
        $percent = 0;
        foreach ($bases as $base){
            similar_text($base["name"],$tolowerName,$res);
            if($percent < $res and $res > $minPercent){
                $percent = $res;
                $bestBaseID = $base["id"];
            }
        }
    }
    return addWorkTime($code,$name,$day,$bestBaseID);
}

function showUser($id){
    $user = getUser($id);
    $dayNames = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
    $monthNames = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    if (isset($_POST["month"]) and isset($_POST["year"])) {
        $date = $_POST["year"]."-".$_POST["month"];
    } else {
        $date = date("Y-n");
    }
    $calendar = newCalendar($date);

    foreach ($calendar as &$week){
        foreach ($week as &$day){
            $day["works"] = getPlanningForUser($user["id"],date_format($day["date"],"Y-m-d"));
            if(date_format($day["date"],"Y-m-d") == date("Y-m-d")){
                $day["color"] = "#FFD239";
            }
        }
        unset($day);
    }
    unset($week);

    $selectedMonth = date_format(date_create($date.'-01'), 'n');
    $selectedYear = date_format(date_create($date.'-01'), 'Y');
    require_once VIEW . 'admin/showUser.php';
}