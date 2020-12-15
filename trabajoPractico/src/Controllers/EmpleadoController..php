<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Models\Usuario;
use App\Models\Empleado as TABLA;
use App\Models\Sectore;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class EmpleadoController
{
    public function addOne(Request $request, Response $response, $args)
    {
        $usuario = new TABLA();
        $usuario->nombre = ucwords(strtolower($_POST['nombre']));
        $usuario->email = $_POST['email'];
        $usuario->tipo = strtolower($_POST['tipo']);
        $usuario->clave = $_POST['clave'];
        $usuario->sector = Sectore::getNumeroSectorEmpleado($_POST['tipo']);
        $respuesta = TABLA::addOne($usuario);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function login(Request $request, Response $response, $args)
    {
        $respuesta = TABLA::login($_POST['email'], $_POST['clave']);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $respuesta = TABLA::get();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}























































/* public function getOne(Request $request, Response $response, $args)
    {
        $respuesta = TABLA::find($_POST['id']);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    } */


/* 
        public function upDateOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $usuario = TABLA::find($_POST['id']); //trae el objeto



        $respuesta = $usuario->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
    public function deleteOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $usuario = TABLA::find($args['id']); //trae el objeto
        $respuesta = $usuario->delete(); //lo borra de la base de datos
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
   
     */
