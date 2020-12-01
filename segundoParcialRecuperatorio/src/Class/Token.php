<?php

namespace App\MyClass;

//require_once "./../../vendor/autoload.php";
//require __DIR__ . './../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class Token
{
    public static function generarToken($dato)
    {
        $jwt = "";
        try {
            $key = "pro3-parcial";
            $payload = $dato;
            $jwt = JWT::encode($payload, $key);
        } catch (\Throwable $th) {
        } finally {
            return $jwt;
        }
    }
    public static function decodificarToken($jwt)
    {
        try {
            $key = "pro3-parcial";
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (\Throwable $th) {
            $decoded = null;
        } finally {
            return $decoded;
        }
    }
}
