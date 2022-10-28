<?php

$host="localhost";
$bd="justcoffee";
$usuario="root";
$contraseÃ±a="";

try {
        $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contraseÃ±a);



} catch ( Exception $ex) {

    echo $ex->getMessage();

}

?>