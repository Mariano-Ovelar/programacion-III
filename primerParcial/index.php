<?php
include_once './Entidades/archivo.php';
include_once './Entidades/usuario.php';
include_once './Entidades/precios.php';
include_once './Entidades/auto.php';
include_once './token.php';

define("PATH_USUARIOS",     "./ArchivosJson/usuarios.json");
define("PATH_PRECIOS",     "./ArchivosJson/precios.json");
define("PATH_AUTOS",     "./ArchivosJson/autos.json");

$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'] ?? "";

/* $materia = new materia("prog", "segundo");
$materia2 = new materia("lab", "segundo");
var_dump(json_encode([$materia, $materia2])); */
//clase::mostrarListaDeClases(archivos::leer("./materias-profesores.json"));
/* $clase = new clase(1, 1, "noche");
$clase2 = new clase(2, 1, "noche");
var_dump($clase->laClaseYaEstaAsignadaAlProfesor([$clase2, $clase2, $clase2, $clase2]));  */

switch ($request_method) {
    case 'POST':
        switch ($path_info) {
            case '/registro':
                $email = $_POST['email'];
                $password = $_POST['password'];
                $tipo = $_POST['tipo'];
                if ($email != "" && $password != "" && $tipo != "") {
                    $usuario = new usuario($email, $password, $tipo);
                    //$listaUsuario = archivos::leer(PATH_USUARIOS);
                    if (!$usuario->ExisteUsuario(archivos::leer(PATH_USUARIOS))) {
                        archivos::escribir($usuario, PATH_USUARIOS);
                        echo "registro exitoso";
                    } else {
                        echo "El email ya existe!!";
                    }
                }

                break;

            case '/login':
                $email = $_POST['email'];
                $password = $_POST['password'];

                if ($email != "" && $password != "") {
                    $usuario = new usuario($email, $password, "");
                    $token = $usuario->verificarUsuario(archivos::leer(PATH_USUARIOS));
                    if ($token != null) {
                        echo "token:  $token";
                    } else {
                        echo "El email o contraseña no son validos!!";
                    }
                }

                break;

            case '/precio':
                $header = getallheaders();
                $token = $header['token'];

                $hora = $_POST['precio_hora'];
                $estadia = $_POST['precio_estadia'];
                $mensual = $_POST['precio_mensual'];
                if ($hora != "" && $estadia != "" && $mensual != "") {
                    $precios = new precios($hora, $estadia, $mensual);
                    if (usuario::verificarAdmin($token)) {
                        archivos::escribirYPisar($precios, PATH_PRECIOS);
                        echo "todo OK!!!";
                    } else {
                        echo "tenes que ser admin para modificar los precios!!!";
                    }
                } else {
                    echo "completar todos los datos!!!";
                }


                break;
            case '/ingreso':
                $header = getallheaders();
                $token = $header['token'];

                $email = usuario::getEmail($token);
                $patente = $_POST['patente'];
                //$fecha_ingreso = $_POST['fecha_ingreso'];
                $tipo = $_POST['tipo'];
                if ($email != "" && $patente != "" && $tipo != "") {
                    $auto = new auto($patente, date("d-m-Y H:i:s"), $tipo, $email);
                    if (usuario::verificarUsers($token)) {
                        archivos::escribir($auto, PATH_AUTOS);
                        echo "registro exitoso";
                    } else {
                        echo "tenes que ser users!!!";
                    }
                }
                break;


            default:

                break;
        }
        break;
    case 'GET':

        switch ($path_info) {
            case '/retiro':
                $header = getallheaders();
                $token = $header['token'];
                $patente = $_GET['patente'];
                $hora=date("d-m-Y H:i:s");
                if ($patente != "") {
                    $auto = new auto($patente, date("d-m-Y H:i:s"), $tipo, $email);
                    if (usuario::verificarUsers($token)) {
                       
                    } else {
                        echo "tenes que ser users!!!";
                    }
                }
                break;
            case '/ingreso':

                break;
            case '/importe/:tipo':

                break;
            case '/importe':

                break;
            default:

                break;
        }
        break;

    default:
        echo "405 method not allowed";
        break;
}
