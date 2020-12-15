<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materias_usuario;
use App\Models\Materia;
use App\Models\Usuario;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class Materias_usuarioController
{
    public function addOne(Request $request, Response $response, $args)
    {
        $token = getallheaders()['token'] ?? '';
        $respuesta = "";


        try {
            $payload = Token::decodificarToken($token);
            $materia = Materia::where("id", "=", $args['idMateria'])->first();
            if ($payload->tipo == "alumno") {

                $auxM_usuario = Materias_usuario::where("id_usuario", "=", $payload->id)->where("id_materia", "=", $materia->id)->first();

                if ($auxM_usuario == null) {
                    if ($materia->cupos >= 1) {
                        $Mat_usario = new Materias_usuario();
                        $Mat_usario->id_materia = $materia->id;
                        $Mat_usario->id_usuario = $payload->id;
                    } else {
                        throw new Exception("no hay cupos para esta materia!!!");
                    }
                } else {
                    throw new Exception("alumno ya esta anotado a esta materia!!!");
                }
            } else {
                throw new Exception("solo los alumnos pueden anotarse a las materias!!!");
            }

            if (!$Mat_usario->save()) {
                throw new Exception("No se pudo anotar a la materia materia");
            } else {
                $respuesta = "Se a anotado con exito!!!!";
                $materia->cupos--;
                $materia->save();
            }
        } catch (\Throwable $th) {
            $respuesta = "Error: " . $th->getMessage();
        } finally {
            $response->getBody()->write(json_encode($respuesta));
            return $response;
        }
    }
    public function getAllNotas(Request $request, Response $response, $args)
    {
        $respuesta = array();
        $materias_usuario = Materias_usuario::where("id_materia", "=", $args['idMateria'])->get();
        foreach ($materias_usuario as $key => $value) {
            $aux=array(
                "alumno" => Usuario::where("id", "=", $value->id_usuario)->first()->nombre,
                "nota" => $value->nota
            );
            
            array_push($respuesta,$aux);
        }
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}
