<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;
use Exception;
use \Firebase\JWT\JWT;
use App\MyClass\Token;


class UsuarioController
{

    public function addOne(Request $request, Response $response, $args)
    {
        $respuesta = "";
        $usuario = new Usuario();
        $usuario->nombre = ucwords(strtolower($_POST['nombre'] ?? '')); // ucwords combierte la primera letra en mayuscula
        $usuario->clave = $_POST['clave'] ?? '';
        $usuario->tipo = strtolower($_POST['tipo'] ?? ''); // strtolower covierte en minuscula la cadena
        $usuario->email = $_POST['email'] ?? '';

        try {
            $this->validacionDatos($usuario);
            if (!$usuario->save()) {
                throw new Exception("No se pudo resgistrar");
            } else {
                $respuesta = "Se a registrado con exito!!!!";
            }
        } catch (\Throwable $th) {
            $respuesta = "Error: " . $th->getMessage();
        } finally {
            $response->getBody()->write(json_encode($respuesta));
            return $response;
        }
    }

    public function validacionDatos($usuario)
    {
        $this->validarEmail($usuario->email);
        $this->validarNombre($usuario->nombre);
        $this->validarClave($usuario->clave);
        $this->validarTipo($usuario->tipo);
    }
    public function validarNombre($nombre)
    {
        if (!strpos($nombre, " ") && $nombre[0] != " ") {
            if ($this->getUsuarioNombre($nombre) != null) {
                throw new Exception("El nombre ya existe");
            }
        } else {
            throw new Exception("El nombre no puede tener espacios en blancos");
        }
        return true;
    }
    public function validarClave($clave)
    {
        if (strlen($clave) < 4) {
            throw new Exception("La clave es muy corta minimo 4 caracteres");
        }
        return true;
    }
    public function validarTipo($tipo)
    {
        if ($tipo != "cliente" && $tipo != "admin") {
            throw new Exception("El tipo puede ser cliente o admin");
        }
        return true;
    }
    public function validarEmail($email)
    {
        if ($this->getUsuarioEmail($email) != null) {
            throw new Exception("El email ya existe");
        }
        return true;
    }

    public function getUsuarioNombre($nombre)
    {
        return Usuario::where("nombre", "=", $nombre)->first();
    }
    public function getUsuarioEmail($email)
    {
        return Usuario::where("email", "=", $email)->first();
    }
    public function getUsuarioId($id)
    {
        $respuesta = Usuario::where("id", "=", $id)->first();

        try {
            //$respuesta = Usuario::where("id", "=", $id)->first();
        } catch (\Throwable $th) {
            $respuesta = null;
        } finally {
            return $respuesta;
        }
    }

    public function login(Request $request, Response $response, $args)
    {
        $respuesta = "";
        // $usuario = new Usuario();
        $clave = $_POST['clave'] ?? '';
        $email = $_POST['email'] ?? '';

        $usuario = $this->getUsuarioEmail($email);

        if ($usuario !=  null && $usuario->clave == $clave) {
            $payload = array(
                "id" => $usuario->id,
                "nombre" => $usuario->nombre,
                "tipo" => $usuario->tipo,
                "email" => $usuario->email
            );

            $respuesta = Token::generarToken($payload);
        } else {
            $respuesta = "Email o Clave incorrecta!!!!!";
        }

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}
