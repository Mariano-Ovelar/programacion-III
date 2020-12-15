<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Models\Menu as TABLA;
use App\MyClass\Token;

class Menu extends Model
{
    public static function addOne($obj)
    {
        $mensaje = "Se a guardado datos en menu con exito!!!!";
        try {
            TABLA::validacionDatos($obj);
            $datosObj = array(
                "nombre" => $obj->nombre,
                "tipo" => $obj->tipo,
                "precio" => $obj->precio
            );
            if (!$obj->save()) {
                $mensaje = "ERROR: No se pudo guardar datos al menu";
            }
        } catch (\Throwable $th) {
            $mensaje = "ERROR: " . $th->getMessage();
        } finally {
            $respuesta = array(
                "mensaje" => $mensaje,
                "menu" => $datosObj
            );

            return $respuesta;
        }
    }
    public static function validacionDatos($obj)
    {
        TABLA::validarNombre($obj->nombre);
        TABLA::validarTipo($obj->tipo);
    }
    public static function validarNombre($nombre)
    {
        if (TABLA::getObjNombre($nombre) != null) {
            throw new Exception("El nombre ya existe");
        }
        return true;
    }
    public static function validarTipo($tipo)
    {
        if ($tipo != "comida" && $tipo != "bebida" && $tipo != "cerveza" && $tipo != "postre") {
            throw new Exception("El tipo puede ser comida, bebida, cerveza o postre");
        }
        return true;
    }

    public static function getObjNombre($nombre)
    {
        return TABLA::where("nombre", "=", $nombre)->first();
    }

    public static function getMenu($nombre)
    {
        return TABLA::getObjNombre($nombre);
    }
}
