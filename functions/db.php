<?php 
session_start();
function connect()
{

    $database = new \PDO('mysql:host=localhost; dbname=blog; charset=utf8', 'root', '' );

    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // mode de fetch par défaut : FETCH_ASSOC / FETCH_OBJ / FETCH_BOTH
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 
    return $database;
}

?>