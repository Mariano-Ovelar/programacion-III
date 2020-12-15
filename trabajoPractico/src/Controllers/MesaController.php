<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Models\Usuario;
use App\Models\Mesa as TABLA;
use App\Models\Pedido;
use App\Models\Menu;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;

class MesaController
{
    public function addOne(Request $request, Response $response, $args)
    {
        $obj = new TABLA();
        $obj->codigo = $_POST['codigo'];
        $obj->estado = "Cerrada";
        $respuesta = TABLA::addOne($obj);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::get()));
        return $response;
    }

    public function asignar(Request $request, Response $response, $args)
    {
        $foto = "";
        if (isset($_POST['foto'])) {
            $foto = $_POST['foto'];
        }


        $respuesta = TABLA::asignarMesaACliente($_POST['nombre'], $foto);
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

   /*  public function pedirLaCuenta(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    } */
}










  /* public function getOne(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::find($_POST['id'])));
        return $response;
    } */
