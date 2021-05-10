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


