<?php

namespace App\MyClass;


class Archivos
{

    public static function escribir($obj, $path)
    {
        $retorno = false;
        $array = archivos::leer($path);
        array_push($array, $obj);
        //echo json_encode($obj);

        $archivo = fopen($path, "w");
        $cant = fwrite($archivo, json_encode($array));
        fclose($archivo);

        if ($cant > 0) {
            $retorno = true;
        }

        return $retorno;
    }
    public static function leer($path)
    {
        $contenido = array();

        if (file_exists($path)) {
            $archivo = fopen($path, "r");

            if (filesize($path) > 0) {
                //echo "El archivo tiene contenido";
                $contenido = json_decode(fread($archivo, filesize($path)));
            } else {
                //echo "El archivo esta vacio";
            }

            //echo json_encode($contenido);
            rewind($archivo);
            fclose($archivo);
        }
        return $contenido;
    }
}
