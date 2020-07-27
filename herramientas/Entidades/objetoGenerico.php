<?php

class objGenerico
{
    public $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public static function buscarIgualdad($array, $dato, $keyDato)
    {
        $respuesta = false;
        foreach ($array as $obj) {

            if (objGenerico::comparandoDatos($obj, $dato, $keyDato)) {
                $respuesta = true;
                break;
            }
        }

        return $respuesta;
    }

    public static function comparandoDatos($obj, $dato, $keyDato)
    {
        $respuesta = false;

        foreach ($obj as $key => $value) {
            if ($key == $keyDato && $value == $dato) {
                $respuesta = true;
            }
        }


        return $respuesta;
    }
    public static function getData($array, $dato, $keyDato)
    {
        $respuesta = null;
        foreach ($array as $obj) {

            if (objGenerico::comparandoDatos($obj, $dato, $keyDato)) {
                $respuesta = $obj;
                break;
            }
        }

        return $respuesta;
    }
    public static function getDataAll($array, $dato, $keyDato)
    {
        $respuesta = array();
        foreach ($array as $obj) {

            if (objGenerico::comparandoDatos($obj, $dato, $keyDato)) {
                array_push($respuesta, $obj);
            }
        }

        return $respuesta;
    }

    public static function getLocation($array, $id)
    {
        $respuesta = null;
        $i = 0;
        foreach ($array as $obj) {

            if (objGenerico::comparandoDatos($obj, $id, "id")) {
                $respuesta = $i;
                break;
            }
            $i++;
        }
        return $respuesta;
    }
}
