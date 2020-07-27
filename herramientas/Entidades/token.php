<?php

require_once "./vendor/autoload.php";

use \Firebase\JWT\JWT;

class cookie
{
    public static function generarToken($dato)
    {
        $jwt = null;
        try {
            $key = "pro3-parcial";
            $payload = array(
                "email" => $dato['email'],
                "clave" => $dato['clave'],
                "tipo" => $dato['tipo']
            );
            $jwt = JWT::encode($payload, $key);
            return $jwt;
        } catch (\Throwable $th) {
            //throw $th;
        } finally {
            return $jwt;
        }
    }
    public static function decodificarToken($jwt)
    {
        $decoded = null;
        try {
            $key = "pro3-parcial";
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (\Throwable $th) {
            //throw $th;
        } finally {
            return $decoded;
        }
    }
}
