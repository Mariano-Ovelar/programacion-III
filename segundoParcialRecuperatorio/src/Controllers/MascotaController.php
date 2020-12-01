<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class MascotaController
{


    public function addOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $mascota = null;
        $token = getallheaders()['token'] ?? '';
        $payload = Token::decodificarToken($token);
        try {
            if ($payload->tipo == "admin") {
                if (Mascota::where("tipo", "=", $_POST['tipo'])->first() == null) {
                    $mascota = new Mascota();
                    $mascota->tipo = $_POST['tipo'] ?? '';
                    $mascota->precio = $_POST['precio'] ?? null;
                } else {
                    throw new Exception("la mascota " . $_POST['tipo'] . " ya esta en la lista");
                }
            } else {
                throw new Exception("solo los admi pueden agregar mascotas!!!");
            }

            if (!$mascota->save()) {
                throw new Exception("No se pudo resgistrar la mascota");
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
}
