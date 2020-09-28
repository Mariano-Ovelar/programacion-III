<?php

class auto //extends AnotherClass implements Interface
{
    public $patente;
    public $fecha_ingreso;
    public $tipo;
    public $emailUsurio;

    function __construct($patente, $fecha_ingreso, $tipo,$emailUsurio)
    {
        $this->patente = $patente;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->tipo = $tipo;
        $this->emailUsurio = $emailUsurio;
    }
    
}