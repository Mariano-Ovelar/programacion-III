<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Models\Usuario;
use App\Models\Pedido as TABLA;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Sectore;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;
use Symfony\Component\Console\Helper\Table;

class PedidoController
{
    public function addOne(Request $request, Response $response, $args)
    {
        $mesa = Mesa::getMesa($_POST["idMesa"]);
        $menu = Menu::getMenu($_POST["pedido"]);
        if ($mesa != null) {
            if ($menu != null) {
                if ($mesa->estado == "Esperando al mozo" || $mesa->estado != "Cerrada" && $mesa->estado != "con clientes pagando") {
                    $obj = new TABLA();
                    $obj->estado = "pendiente";
                    $obj->id_mesa = $mesa->id;
                    $obj->tiempo_preparacion = 20; //crear un ramdom mas tarde
                    $obj->id_menu = $menu->id;
                    $obj->sector = $menu->sector;

                    $respuesta = TABLA::addOne($obj);
                } else {
                    $respuesta = array("mensaje" => "Esta mesa ya no hacen mas pedidos");
                }
            } else {
                $respuesta = array("mensaje" => "lo que esta pidiendo el cliete no esta en el menu");
            }
        } else {
            $respuesta = array("mensaje" => "mesa no encontrada");
        }
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::get()));
        return $response;
    }


    public function preparaPedido(Request $request, Response $response, $args)
    {
        $mensaje = "Ya empezaron con la preparcacion del pedido";
        $empleado = Token::decodificarToken(getallheaders()['token']);
        $pedido = TABLA::where("sector", "=", $empleado->sector)->where("estado", "=", "pendiente")->first();

        if ($pedido != null) {
            $pedido->estado = "en preparación";
            $pedido->id_empleado = $empleado->id;
            if (!$pedido->save()) {
                $mensaje = "ERROR: No se pudo asignar empleado al pedido";
            }
        } else {
            $mensaje = "No se pudo encontrar un pedido para este sector";
        }
        $datospedido = array(
            "id del pedido" => $pedido->id,
            "estado" => $pedido->estado,
            "tiempo de preparacion" =>  $pedido->tiempo_preparacion
        );
        $respuesta = array(
            "mensaje" => $mensaje,
            "datos del pedido" => $datospedido,
            "empleado" => $empleado
        );
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function terminarPedido(Request $request, Response $response, $args)
    {
        $mensaje = "El pedido ya esta listo";
        $empleado = Token::decodificarToken(getallheaders()['token']);
        $pedido = TABLA::where("id_empleado", "=", $empleado->id)->where("estado", "=", "en preparación")->first();
        if ($pedido != null) {
            $pedido->estado = "listo para servir";
            $pedido->tiempo_preparacion = 0; //crear un ramdom mas tarde
            if (!$pedido->save()) {
                $mensaje = "ERROR: No se pudo guardar los datos que indica que el pedido esta listo";
            }
        } else {
            $mensaje = "Este empleado no tiene pedidos en preparacion";
        }
        $datospedido = array(
            "id del pedido" => $pedido->id,
            "estado" => $pedido->estado,
        );
        $respuesta = array(
            "mensaje" => $mensaje,
            "datos del pedido" => $datospedido,
            "empleado" => $empleado
        );
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function entregarPedido(Request $request, Response $response, $args)
    {
        $empleado = Token::decodificarToken(getallheaders()['token']);
        $mensaje = "Pedido entregado a la mesa";
        $pedido = TABLA::where("estado", "=", "listo para servir")->first();
        if ($pedido != null) {
            $mesa = Mesa::getMesa($pedido->id_mesa);
            if ($mesa != null) {
                $pedido->estado = "entregado a la mesa";
                if (!$pedido->save()) {
                    $mensaje = "ERROR: No se pudo guardar los datos que indica que el pedido esta listo";
                }
                $mesaPedidos = TABLA::where("estado", "=", "listo para servir")->where("id_mesa", "=", $mesa->id)->get();
                if (count($mesaPedidos) == 0) {
                    $mesa->estado = "con clientes comiendo";
                    if (!$mesa->save()) {
                        $mensaje = "ERROR: No se pudo guardar datos mesa";
                    }
                }
            } else {
                $mensaje = "Mesa no encontrada";
            }
        } else {
            $mensaje = "Este empleado no tiene pedidos en preparacion";
        }
        $datospedido = array(
            "id mesa" => $mesa->id,
            "cliente" => $mesa->nombre,
            "id del pedido" => $pedido->id,
            "estado" => $pedido->estado
        );
        $respuesta = array(
            "mensaje" => $mensaje,
            "datos del pedido" => $datospedido,
            "empleado" => $empleado
        );
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function mostrarPedido(Request $request, Response $response, $args)
    {
        $mesa = Mesa::getObjCodigo($_POST['codigo']);
        $menu = Menu::where("nombre", "=", $_POST['pedido'])->first();
        $respuesta = "pedido no encontrado";
        if ($mesa != null && $menu != null) {
            $pedido = TABLA::where("id_menu", "=", $menu->id)->where("id_mesa", "=", $mesa->id)->first();
            if ($pedido != null) {
                $respuesta = "El pedido va esta en " . $pedido->tiempo_preparacion . " minutos";
            }
        }
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}



/* $pedido = TABLA::where("estado", "=", "listo para servir")->first();
        $mesa = Mesa::getMesa($pedido->id_mesa);
        $mesaPedidos = TABLA::where("estado", "=", "l isto para servir")->where("id_mesa", "=", $mesa->id)->get();
        $respuesta = count($mesaPedidos); */

 /* public function getOne(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(TABLA::find($_POST['id'])));
        return $response;
    } */