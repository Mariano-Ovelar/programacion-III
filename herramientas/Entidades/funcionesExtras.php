<?php
//include_once "./Entidades/fecha.php";

function getNombreUnico($string)
{
    $aux=fecha::getStringData();
    return "$string$aux";
}
