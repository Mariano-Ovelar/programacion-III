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
            $payload = $dato;
            $jwt = JWT::encode($payload, $key);
        } catch (\Throwable $th) {
            //throw $th;
        } finally {
            return $jwt;
        }
    }
    public static function decodificarToken($jwt)
    {
        $key = "pro3-parcial";
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        try {
            $key = "pro3-parcial";
            // $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (\Throwable $th) {
            //throw $th;
        } finally {
            return $decoded;
        }
    }
}
