<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Factura as TABLA;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Menu;
use Exception;

class Factura extends Model
{
    public static function addOne()
    {
        $mensaje = "";
        $obj = new TABLA();
        $mesa = Mesa::where("id", "=", $_POST['idMesa'])->first();
        $listaPedidos = array();
        if ($mesa != null && $mesa->estado == "con clientes comiendo") {
            $mesa->estado = "con clientes pagando";
            if (!$mesa->save()) {
                $mensaje = "ERROR: No se pudo guardar datos mesa";
            } else {
                $pedidos = Pedido::where("id_mesa", "=", $_POST['idMesa'])->get();
                $aPagar = 0;
                foreach ($pedidos as $key => $value) {
                    $menu = Menu::where("id", "=", $value->id_menu)->first();
                    if ($value->estado != "ya esta pagado") {
                        $aPagar += $menu->precio;
                        array_push($listaPedidos, array("pedido" => $menu->nombre, "precio" => $menu->precio));
                    }
                }
                $obj->id_mesa = $mesa->id;
                $obj->monto = $aPagar;
                $obj->estado = "sin pagar";
                $obj->hora = date("G:i:s");
                $obj->dia = date("d-n-Y");

                if (!$obj->save()) {
                    $mensaje = "ERROR: No se pudo guardar datos mesa";
                }
            }
        } else if ($mesa == null) {
            $mensaje = "Esta mesa no existe";
        } else if ($mesa->estado == "con clientes pagando") {
            $mensaje = "Esta mesa ya pidio la cuenta";
        } else if ($mesa->estado == "Cerrada") {
            $mensaje = "Esta mesa no tiene clientes";
        } else {
            $mensaje = "Esta mesa todabia espera sus pedidos";
        }

        $respuesta = array(
            "mensaje" => $mensaje,
            "id mesa" => $obj->id_mesa,
            "pedidos" => $listaPedidos,
            "total" => $obj->monto,
            "hora" => $obj->hora,
            "dia" => $obj->dia
        );
        return $respuesta;
    }
}
