<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Models\Usuario;
use App\Models\Menu as TABLA;
use App\Models\Sectore;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class MenuController
{
    public function addOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $obj = new TABLA();
        $obj->nombre = $_POST['nombre'];
        $obj->tipo = $_POST['tipo'];
        $obj->precio = $_POST['precio'];
        $obj->sector = Sectore::getNumeroSectorMenu($_POST['tipo']);
        $respuesta = TABLA::addOne($obj);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::get()));
        return $response;
    }
}








/*  public function getOne(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::find($_POST['id'])));
        return $response;
    } */