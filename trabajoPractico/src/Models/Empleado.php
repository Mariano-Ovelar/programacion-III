<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

use App\Models\Empleado as TABLA;
use App\MyClass\Token;

class Empleado extends Model
{
    /*  public $nombre;
    public $email;
    public $tipo;
    public $clave;
    public $stado;

    public function __construct($nombre, $email, $tipo, $clave)
    {
        $this->nombre = ucwords(strtolower($nombre));
        $this->email = $email;
        $this->tipo = strtolower($tipo);
        $this->clave = $clave;
        $this->stado = true;
    } */
    public static function addOne($usuario)
    {
        $mensaje = "Se a registrado con exito!!!!";
        try {
            TABLA::validacionDatos($usuario);
            $datosUsuario = array(
                "nombre" => $usuario->nombre,
                "email" => $usuario->email,
                "tipo" => $usuario->tipo
            );
            if (!$usuario->save()) {
                $mensaje = "ERROR: No se pudo resgistrar";
            }
        } catch (\Throwable $th) {
            $mensaje = "ERROR: " . $th->getMessage();
        } finally {
            $respuesta = array(
                "mensaje" => $mensaje,
                "empleado" => $datosUsuario
            );
            return $respuesta;
        }
    }
    public static function validacionDatos($usuario)
    {
        try {
            TABLA::validarEmail($usuario->email);
            TABLA::validarNombre($usuario->nombre);
            TABLA::validarClave($usuario->clave);
            TABLA::validarTipo($usuario->tipo);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function validarNombre($nombre)
    {
        if (!strpos($nombre, " ") && $nombre[0] != " ") {
            if (TABLA::getUsuarioNombre($nombre) != null) {
                throw new Exception("El nombre ya existe");
            }
        } else {
            throw new Exception("El nombre no puede tener espacios en blancos");
        }
        return true;
    }
    public static function validarClave($clave)
    {
        if (strlen($clave) < 4) {
            throw new Exception("La clave es muy corta minimo 4 caracteres");
        }
        return true;
    }
    public static function validarTipo($tipo)
    {
        if ($tipo != "bartender" && $tipo != "cocinero" && $tipo != "cervecero" && $tipo != "socio" && $tipo != "mozo" && $tipo != "admin") {
            throw new Exception("El tipo puede ser bartender, cocinero, cervecero, mozo, socio o admin");
        }
        return true;
    }
    public static function validarEmail($email)
    {
        if (TABLA::getUsuarioEmail($email) != null) {
            throw new Exception("El email ya existe");
        }
        return true;
    }

    public static function getUsuarioNombre($nombre)
    {
        return TABLA::where("nombre", "=", $nombre)->first();
    }
    public static function getUsuarioEmail($email)
    {
        return TABLA::where("email", "=", $email)->first();
    }

    public static function login($email, $clave)
    {
        $respuesta = array("mensaje" => "Email o Clave incorrecta!!!!!");
        $usuario = TABLA::getUsuarioEmail($email);
        if ($usuario !=  null && $usuario->clave == $clave) {
            $payload = array(
                "id" => $usuario->id,
                "nombre" => $usuario->nombre,
                "tipo" => $usuario->tipo,
                "sector" => $usuario->sector,
                "email" => $usuario->email
            );
            $respuesta = array("token" => Token::generarToken($payload));
        }
        return $respuesta;
    }
}
