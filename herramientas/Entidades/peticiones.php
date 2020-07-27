<?php

function hayUnaPeticion($PATH_INFO)
{
    $retorno = false;

    if (isset($PATH_INFO)) {
        $retorno = true;
    } else {
        echo "ERROR:PETICION NO VALIDA!!!";
    }

    return $retorno;
}

function tratarPeticionGet($PATH_INFO, $datos)
{
    switch ($PATH_INFO) {
        case '/mostrar':

            break;

        default:
            # code...
            break;
    }
}
function tratarPeticionPost($PATH_INFO, $dato)
{
    $archivo = "./ArchivosJson/personas.json";
    $datosLista = archivos::readFile($archivo);

    switch ($PATH_INFO) {
        case '/guardar':

            if (!objGenerico::buscarIgualdad($datosLista, $dato->id, "id")) {
                archivos::writeFile($archivo, [$dato], $datosLista);
            }

            break;

        default:
            # code...
            break;
    }
}
