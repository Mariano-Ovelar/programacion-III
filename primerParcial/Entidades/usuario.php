<?php
require_once "./token.php";

class usuario //extends AnotherClass implements Interface
{
    public $email;
    public $password;
    public $tipo;

    function __construct($email, $password, $tipo)
    {
        $this->email = $email;
        $this->password = $password;
        $this->tipo = $tipo;
    }
    public function verificarUsuario($lista)
    {
        $retorno = null;
        foreach ($lista as $key => $value) {
            if ($this->email == $value->email && $this->password == $value->password) {
                $retorno = cookie::generarToken([$value->email, $value->tipo]);
                break;
            }
        }
        return  $retorno;
    }
    public static function verificarAdmin($token)
    {
        $retorno = false;
        $usuario = cookie::decodificarToken($token);
        if ($usuario[1] == "admin") {
            $retorno = true;
        }
        return  $retorno;
    }
    public static function verificarUsers($token)
    {
        $retorno = false;
        $usuario = cookie::decodificarToken($token);
        if ($usuario[1] == "users") {
            $retorno = true;
        }
        return  $retorno;
    }
    public static function getEmail($token)
    {
        $usuario = cookie::decodificarToken($token);
        $retorno = $usuario[0];
        return  $retorno;
    }
    public function ExisteUsuario($lista)
    {
        $retorno = false;
        if ($lista != null) {
            foreach ($lista as $key => $value) {
                if ($this->email == $value->email) {
                    $retorno = true;
                    break;
                }
            }
        }

        return  $retorno;
    }
}
