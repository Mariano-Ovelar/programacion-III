<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Encuesta as TABLA;
use Exception;

class Encuesta extends Model
{
    public static function genrarEncuesta()
    {
        $notaMozo = $_POST['mozo'];
        $notaMesa = $_POST['mesa'];
        $notaRestaurante = $_POST['restaurante'];
        $notaComentario = $_POST['comentario'];
        $notaCocinero = $_POST['cocinero'];

        $encuesta = new Encuesta();
        $encuesta->puntaje_mozo = $notaMozo;
        $encuesta->puntaje_mesa = $notaMesa;
        $encuesta->puntaje_restaurante = $notaRestaurante;
        $encuesta->comentario = $notaComentario;
        $encuesta->puntaje_cocinero = $notaCocinero;
        $respuesta = $encuesta;

        if (!$encuesta->save()) {
            $respuesta = "no se pudo guardar la encuesta";
        }
        return $encuesta;
    }
}
