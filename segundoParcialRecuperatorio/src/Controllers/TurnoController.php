<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Turno;
use App\Models\Mascota;
use App\Models\Usuario;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class TurnoController
{
    public function mostrarFactura(Request $request, Response $response, $args)
    {
        $respuesta = array();
        $token = getallheaders()['token'] ?? '';
        $payload = Token::decodificarToken($token);
        $turnos = Turno::where("id_usuario", "=", $payload->id)->get();
        $precioTotal = 0;
        foreach ($turnos as $key => $value) {
            if ($value->estado == "atendido") {
                $mascota = Mascota::where("id", "=", $value->id_mascota)->first();
                $precioTotal = $precioTotal + $mascota->precio;
            }
        }
        $cliente = Usuario::where("id", "=", $payload->id)->first();
        $turno = array(
            'cliente' => $cliente->nombre,
            'total a pagar' => $precioTotal,
        );

        $respuesta = $turno;

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function atendeTurno(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $turno = Turno::where("id", "=", $args['idTurno'])->first();
        if ($turno != null && $turno->estado != "atendido") {
            $turno->estado = "atendido";
            $turno->save();
            $respuesta = "fue atendido";
        } else {
            $respuesta = "el turno ya fue atendido o no esta regitrado";
        }

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }


    public function getAll(Request $request, Response $response, $args)
    {
        $respuesta = array();
        $turnos = Turno::get();
        foreach ($turnos as $key => $value) {
            $cliente = Usuario::where("id", "=", $value->id_usuario)->first();
            $mascota = Mascota::where("id", "=", $value->id_mascota)->first();
            $turno = array(
                'cliente' => $cliente->nombre,
                'macota' => $mascota->tipo,
                'precio' => $mascota->precio,
                'fecha' => $value->fecha
            );
            array_push($respuesta, $turno);
        }

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
    public function addOne(Request $request, Response $response, $args)
    {
        $token = getallheaders()['token'] ?? '';
        $respuesta = "";


        try {
            $payload = Token::decodificarToken($token);
            $mascota = Mascota::where("tipo", "=", $_POST['tipo'])->first();


            // $turno = Turno::where("id_usuario", "=", $payload->id)->where("id_materia", "=", $mascota->id)->first();
            //if ($turno == null) {
            if ($mascota) {
                $turno = new Turno();
                $turno->id_usuario = $payload->id;
                $turno->id_mascota = $mascota->id;
                $turno->fecha = $_POST['fecha'];
                $turno->estado = "sin atender";
            } else {
                throw new Exception("no atendemos esa mascota!!!");
            }

            /* } else {
                throw new Exception("ya tiene un purno!!!");
            } */


            if (!$turno->save()) {
                throw new Exception("No se pudo realizar el turno");
            } else {
                $respuesta = "Se a anotado con exito!!!!";
            }
        } catch (\Throwable $th) {
            $respuesta = "Error: " . $th->getMessage();
        } finally {
            $response->getBody()->write(json_encode($respuesta));
            return $response;
        }
    }
}
