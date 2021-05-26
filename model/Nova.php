<?php
function getNovas()
{
    $nova= selectMany('SELECT * FROM novas',[]);
    return $nova;
}

function addNewNova($nameNova)
{
    return intval (insert("INSERT INTO novas (number) values (:nameNovas) ",['nameNovas'=>$nameNova] ));
}

function updateNumberNova($updateNumberNova, $idNova)
{
    return execute("UPDATE novas SET number= :number WHERE id= :id", ['number' => $updateNumberNova, 'id' => $idNova]);
}

function getANovaByID($novaID){
    return selectOne("select * from novas where id = :novaID",["novaID" => $novaID]);
}

function addUnAvailableNova($comment,$date,$day,$userID,$novaID){
    return insert("INSERT INTO novaunavailabilites (comment,date,day,user_id,nova_id) values (:comment,:date,:day,:userID,:novaID)",["comment" => $comment, "date" => $date, "day" => $day, "userID" => $userID, "novaID" => $novaID]);
}

function delUnAvailableNova($date,$novaID){
    return insert("delete from novaunavailabilites where nova_id = :novaID and date = :date",["date" => $date, "novaID" => $novaID]);
}

function getUnAvailableNova($date,$day,$novaID){
    return selectOne("select comment,initials from novaunavailabilites inner join users on novaUnavailabilites.user_id = users.id where nova_id=:novaID and date=:date and day=:day",["date" => $date, "day" => $day, "novaID" => $novaID]);
}


