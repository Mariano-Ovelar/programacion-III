<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido as TABLA;
use Exception;
use App\MyClass\Token;


class Pedido extends Model
{
    public static function addOne($obj)
    {
        $mensaje = "Se a guardado datos del pedido con exito!!!!";
        $menu = Menu::getMenu($_POST["pedido"]);
        try {
            $mesa = Mesa::getMesa($obj->id_mesa);
            $mesa->estado = "con cliente esperando pedido";

            if ($mesa->save()) {
                if (!$obj->save()) {
                    $mensaje = "ERROR: No se pudo guardar datos del pedido";
                }
            } else {
                $mensaje = "ERROR: No se pudo cambiar el estado de la mesa";
            }
            $datosMesa = array(
                "id de la mesa" => $mesa->id,
                "cliente" => $mesa->nombre,
                "codigo" => $mesa->codigo
            );
            $datosPedido = array(
                "pedido" => $menu->nombre,
                "precio" => $menu->precio,
            );
        } catch (\Throwable $th) {
            $mensaje = "ERROR: " . $th->getMessage();
        } finally {
            $respuesta = array(
                "mensaje" => $mensaje,
                "mesa" => $datosMesa,
                "pedido" => $datosPedido
            );
            return $respuesta;
        }
    }
}
