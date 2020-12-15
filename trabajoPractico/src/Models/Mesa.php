<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Models\Mesa as TABLA;
use App\MyClass\Token;

class Mesa extends Model
{
    public static function addOne($obj)
    {
        $mensaje = "Se a registrado una nueva mesa!!!!";
        try {
            TABLA::validacionDatos($obj);
            $datosObj = array(
                "codigo" => $obj->codigo
            );
            if (!$obj->save()) {
                $mensaje = "ERROR: No se pudo resgistrar";
            }
        } catch (\Throwable $th) {
            $mensaje = "ERROR: " . $th->getMessage();
        } finally {
            $respuesta = array(
                "mensaje" => $mensaje,
                "mesa" => $datosObj
            );
            return $respuesta;
        }
    }

    public static function validacionDatos($obj)
    {
        try {
            TABLA::validarCodigo($obj->codigo);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function validarCodigo($codigo)
    {
        if (TABLA::getObjCodigo($codigo) != null) {
            throw new Exception("Ya hay una mesa con este codigo");
        }
        if (strlen($codigo) != 5) {
            throw new Exception("El codigo tiene que tener 5 caracteres");
        }
    }

    public static function getObjCodigo($codigo)
    {
        return TABLA::where("codigo", "=", $codigo)->first();
    }

    public static function asignarMesaACliente($nombre, $foto)
    {
        $mensaje = "Se a asignado la mesa al cliente!!!!";
        $obj = TABLA::where("estado", "=", "Cerrada")->first();

        if ($obj != null) {
            $obj->nombre = ucwords(strtolower($nombre));
            $obj->foto = $foto;
            $obj->estado = "Esperando al mozo";
            $obj->save();
            $datosObj = array(
                "id de la mesa" => $obj->id,
                "cliente" => $obj->nombre,
                "foto" => $obj->foto,
                "codigo" => $obj->codigo
            );
        } else {
            $mensaje = "no hay mesas disponible";
        }

        $respuesta = array(
            "mensaje" => $mensaje,
            "mesa" => $datosObj
        );

        return $respuesta;
    }
    public static function getMesa($id)
    {
        return TABLA::where("id", "=", $id)->first();
    }
}
