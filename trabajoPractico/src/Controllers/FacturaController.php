<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Models\Usuario;
use App\Models\Factura as TABLA;
use App\Models\Encuesta;
use App\Models\Mesa;
use App\Models\Pedido;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class FacturaController
{
    public function pedirLaCuenta(Request $request, Response $response, $args)
    {
        $respuesta = array(
            "cuenta:" => TABLA::addOne(),
            "Encuesta:" => Encuesta::genrarEncuesta()
        );
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $respuesta = TABLA::get();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
    public function pagarfactura(Request $request, Response $response, $args)
    {

        $factura = TABLA::where("id_mesa", "=", $_POST['idMesa'])->first();
        $respuesta = "esta mesa todabia estan comiendo o esta mesa esta cerrada";

        if ($factura != null) {
            $respuesta = "Factura pagada";
            $factura->estado = "pagado";
            $listaPedidos = Pedido::where("id_mesa", "=", $_POST['idMesa'])->get();
            if ($listaPedidos != null) {
                foreach ($listaPedidos as $key => $value) {
                    $value->estado = "ya esta pagado";
                    if (!$value->save()) {
                        $respuesta = "No se pudo guardar datos";
                    }
                }
                $respuesta = $listaPedidos;
                if (!$factura->save()) {
                    $respuesta = "No se pudo guardar datos";
                }
                $mesa = Mesa::where("id", "=", $_POST['idMesa'])->first();
                if ($mesa != null) {
                    $mesa->estado = "Cerrada";
                    $mesa->nombre = "";
                    $mesa->foto = "";
                    if (!$mesa->save()) {
                        $respuesta = "No se pudo guardar datos";
                    }
                }
            }
        }

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}
