<?php
/**
 *
 */

function getUsers()     //Récupère tous les utilisateurs
{
    return selectMany("SELECT * FROM users order by  initials ASC", []);
}

function addNewUser($prenomUser, $nomUser, $initialesUser, $hash, $admin, $firstconnect)
{
    return intval(insert("INSERT INTO users (firstname, lastname, initials, password, admin, firstconnect) VALUES (:firstname, :lastname, :initials, :password, :admin, :firstconnect)", ['firstname' => $prenomUser, 'lastname' => $nomUser, 'initials' => $initialesUser, 'password' => $hash, 'admin' => $admin, 'firstconnect' => $firstconnect]));       //à optimiser/simplifier avec un tableau
}

function addNewUserT($lastname, $firstname, $initials, $email, $tel)
{
    return intval(insert("INSERT INTO users (firstname, lastname, initials,email,mobileNumber, admin, firstconnect) VALUES (:firstname, :lastname, :initials,:email,:mobileNumber, 0, 1)", ['firstname' => $firstname, 'lastname' => $lastname, 'initials' => $initials,"email" => $email,"mobileNumber" => $tel]));       //à optimiser/simplifier avec un tableau
}

function SaveUserPassword($hash, $id)       //Met à jour le mdp d'un utilisateur
{
    return execute("UPDATE users SET password= :password, firstconnect= :firstconnect where id = :id", ['password' => $hash, 'firstconnect' => 0, 'id' => $id]);
}

/** update the user
 * @return bool|null
 */
function SaveUser($user)
{
    unset($user['password']);
    unset($user['firstconnect']);
    unset($user['number']);
    return execute("UPDATE users SET firstname= :firstname, lastname= :lastname, initials = :initials, admin = :admin, email = :email, mobileNumber = :mobileNumber where id = :id", $user);
}

/** return the user from database
 * @param $id id of the user
 * @return array|mixed|null
 */
function getUser($id)
{
    return selectOne("SELECT * FROM users where id=:id", ['id' => $id]);
}

/** return the user from database
 * @param $initials initials of the user
 * @return array|mixed|null
 */
function getUserByInitials($initials)       //Récupère un utilisateur en fonction de ses initiales
{
    return selectOne("SELECT * FROM users where initials =:initials", ['initials' => $initials]);
}

/** return the user from database
 * @param string $email
 * @return array|mixed|null
 */
function getUserByMail($email)
{
    return selectOne("SELECT id,initials FROM users where email=:email", ['email' => $email]);
}

function newToken($token, $user_id, $validity)
{
    return execute("Insert into tokens (value,validity,user_id) values (:token,:validity,:user_id)", ['token' => $token, 'user_id' => $user_id, 'validity' => date('Y-m-d H:i:s', time() + ($validity * 3600))]);
}

function checkToken($token)
{
    return selectOne("SELECT user_id FROM tokens where value=:token and validity > :now", ['token' => $token, 'now' => date('Y-m-d H:i:s', time())])["user_id"];
}

function addUserNumber($userID, $userNumber)
{
    return execute("UPDATE users SET number = :userNumber WHERE id= :userID", ['userID' => $userID, 'userNumber' => $userNumber]);
}

function getWorkTimes()
{
    return selectMany("select * from worktimes", []);
}

function addWorkTime($code, $name, $day, $baseID)
{
    return intval(insert("INSERT INTO worktimes (code, type, day, base_id) VALUES (:code, :name, :day, :base_id)", ['code' => $code, 'name' => $name, 'day' => $day, 'base_id' => $baseID]));
}

function addWorkPlanning($selectedWorkTimeID, $selectedUserID, $date)
{
    return intval(insert("INSERT INTO workplannings (worktime_id,user_id,date) VALUES (:workID, :userID, :date)", ['workID' => $selectedWorkTimeID, 'userID' => $selectedUserID, 'date' => $date]));
}

function delPlanning($firstDate, $lastDate)
{
    return execute("Delete from workplannings where date BETWEEN :firstDate and :lastDate", ["firstDate" => $firstDate, "lastDate" => $lastDate]);
}

function getPlanningForUser($userID, $date)
{
    return selectMany("select worktimes.code,type,day,bases.name as base from workplannings 
inner join worktimes on worktimes.id = workplannings.worktime_id
left join bases on bases.id = worktimes.base_id where user_id = :userID and date = :date", ["userID" => $userID, "date" => $date]);
}