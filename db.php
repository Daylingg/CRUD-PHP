<?php

$servidor="localhost";
$baseDatos="app";
$usuario="root";
$contrasena="";

try {
    $conexion= new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contrasena);
} catch(Exception $ex){

    echo "Error: ".$ex->getMessage();

}


?>