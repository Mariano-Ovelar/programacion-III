<?php

class precios //extends AnotherClass implements Interface
{
    public $precio_hora;
    public $precio_estadia;
    public $precio_mensual;

    function __construct($precio_hora, $precio_estadia, $precio_mensual)
    {
        $this->precio_hora = $precio_hora;
        $this->precio_estadia = $precio_estadia;
        $this->precio_mensual = $precio_mensual;
    }
    
}
