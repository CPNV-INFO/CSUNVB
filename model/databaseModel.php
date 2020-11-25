<?php

/**
 * Open a connection to the database
 * @return PDO
 */
function getPDO()
{
    require_once ".const.php";
    $dbh = null;
    try{
        $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    }catch(Exception $e){
        echo $e->getMessage();
    }


        $dbh->exec("set names utf8");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}


function select($query, $params, $multirecord)      //Fontion permettant de selectionner des données
{

    $dbh = getPDO();
    try
    {
        $statement = $dbh->prepare($query);     //Préparer la requête
        $statement->execute($params);       //Exécuter la requête
        if ($multirecord)       //Si on veut récuperer plusieurs données
        {
            $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);  //Alors on fait un fetchAll
        } else
        {
            $queryResult = $statement->fetch(PDO::FETCH_ASSOC);     //Sinon on fait un fetch simple
        }
        $dbh = null;
        return $queryResult;
    } catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

function selectMany($query, $params)        //Fonction permettant de récuperer plusieurs données
{
    return select($query, $params, true);
}

function selectOne($query, $params)         //Fontion permettant de récuperer une donnée
{
    return select($query, $params, false);
}

function insert($query, $params)            //Fontion permettant d'insérer des données
{

    $dbh = getPDO();
    try
    {
        $statement = $dbh->prepare($query);     //Préparer la requête
        $statement->execute($params);       //Exécuter la requête
        return $dbh->lastInsertId();
    } catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

function execute($query, $params)       //Fonction permettant de mettre à jour et d'effacer des données
{
    $dbh = getPDO();
    try
    {
        $statement = $dbh->prepare($query);     //Préparer la requête
        $statement->execute($params);       //Exécuter la requête
        $dbh = null;
        return true;
    } catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}
?>
