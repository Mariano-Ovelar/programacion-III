<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class MateriaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $respuesta = Materia::get();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
    public function getOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $respuesta = Materia::find($_POST['id']);

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $materia = null;
        $token = getallheaders()['token'] ?? '';
        $payload = Token::decodificarToken($token);
        try {
            if ($payload->tipo == "admin") {
                $materia = new Materia();
                $materia->materia = $_POST['materia'] ?? '';
                $materia->cupos = $_POST['cupos'] ?? '';
                $materia->cuatrimestre = $_POST['cuatrimestre'] ?? '';
            } else {
                throw new Exception("solo los admi pueden agregar materias!!!");
            }

            if (!$materia->save()) {
                throw new Exception("No se pudo resgistrar materia");
            } else {
                $respuesta = "Se a registrado con exito!!!!";
            }
        } catch (\Throwable $th) {
            $respuesta = "Error: " . $th->getMessage();
        } finally {
            $response->getBody()->write(json_encode($respuesta));
            return $response;
        }
    }
    public function upDateOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $materia = Materia::find($_POST['id']); //trae el objeto
        $materia->apellido = $_POST['apellido'];
        $materia->nombre = $_POST['nombre'];
        $materia->id_localidad = $_POST['id_localidad'];
        $respuesta = $materia->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
    public function deleteOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $materia = Materia::find($args['id']); //trae el objeto
        $respuesta = $materia->delete(); //lo borra de la base de datos
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}
