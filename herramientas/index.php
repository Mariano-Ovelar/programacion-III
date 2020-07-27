<?php

use function PHPSTORM_META\type;

include_once "./Entidades/archivo.php";
include_once "./Entidades/objetoGenerico.php";
include_once "./Entidades/peticiones.php";
include_once "./Entidades/fecha.php";
include_once "./Entidades/funcionesExtras.php";
include_once "./Entidades/imagenes.php";

/*
$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$PATH_INFO = $_SERVER["PATH_INFO"] ?? null;

$persona = new objGenerico(4);
$persona->nom="ss";

if (hayUnaPeticion($PATH_INFO)) {
    if ($REQUEST_METHOD == "GET") {
        tratarPeticionGet($PATH_INFO, $persona);
    } else if ($REQUEST_METHOD == "POST") {
        tratarPeticionPost($PATH_INFO, $persona);
    }
}
 */
