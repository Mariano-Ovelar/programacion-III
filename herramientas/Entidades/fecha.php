<?php

class fecha
{
    public $fecha;
    public $hora;

    function __construct()
    {
        $this->fecha = date("d/m/y");
        $this->hora = date("h:i");
    }

    public static function getCurrentDate()
    {
        $fecha=new fecha();
        return "$fecha->fecha $fecha->hora";
    }
    public static function getStringData()
    {
        $fecha=new fecha();
        $fecha->fecha = date("dmy");
        $fecha->hora = date("his");
        return "$fecha->fecha$fecha->hora";
    }
}
