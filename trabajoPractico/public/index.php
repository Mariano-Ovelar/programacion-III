<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Middlewares\JsonMiddleware;
use App\Controllers\EmpleadoController;
use App\Controllers\MenuController;
use App\Controllers\MesaController;
use App\Controllers\PedidoController;
use App\Controllers\FacturaController;

use App\Middlewares\AuthAdminMiddleware;
use App\Middlewares\AuthMozoMiddleware;
use App\Middlewares\AuthEmpleadoMiddleware;
use App\Middlewares\AuthSocioMiddleware;

/* 
use App\Middlewares\AuthMiddleware;
use App\Controllers\UsuarioController;
use App\Controllers\MateriaController;
use App\Controllers\Materias_usuarioController;
use App\Controllers\ClienteController; 
*/

require __DIR__ . '/../vendor/autoload.php';
$conn = new Database;
$app = AppFactory::create();
$app->setBasePath('/Prog3/segundoCuatri/trabajoPractico/public');

$app->group('', function (RouteCollectorProxy $group) {
    //empleados
    $group->post('/empleado', EmpleadoController::class . ":addOne"); //terminado
    $group->post('/login', EmpleadoController::class . ":login"); //terminado
    //menu
    $group->post('/menu', MenuController::class . ":addOne")->add(new AuthAdminMiddleware); //terminado
    //mesa
    $group->post('/mesa', MesaController::class . ":addOne")->add(new AuthAdminMiddleware); //terminado
    $group->post('/cliente', MesaController::class . ":asignar"); //terminado
    //pedido
    $group->post('/pedido', PedidoController::class . ":addOne")->add(new AuthMozoMiddleware); //terminado
    $group->post('/preparar', PedidoController::class . ":preparaPedido")->add(new AuthEmpleadoMiddleware); //terminado
    $group->post('/terminar', PedidoController::class . ":terminarPedido")->add(new AuthEmpleadoMiddleware); //terminado
    $group->post('/servir', PedidoController::class . ":entregarPedido")->add(new AuthMozoMiddleware); //terminado
    //factura
    $group->post('/cuenta', FacturaController::class . ":pedirLaCuenta"); //terminado
    $group->get('/listar', PedidoController::class . ":getAll")->add(new AuthSocioMiddleware); //terminado
    $group->post('/tiempo', PedidoController::class . ":mostrarPedido"); //terminado
    $group->post('/pagar', FacturaController::class . ":pagarfactura")->add(new AuthSocioMiddleware); //terminado
   // entregado a la mesa

    //
})->add(new JsonMiddleware);

$app->run();

























//$group->post('/traer', EmpleadoController::class . ":getall")->add(new AuthAdminMiddleware);



    //$group->post('/login', S::class . ":login");


    /* 
    $group->group('/empleados', function (RouteCollectorProxy $group) {
        $group->post('/registro', ClienteController::class . ":");
    }); 
    */
    /* 
    $group->post('/users', ClienteController::class . ":upDateOne");
    $group->post('/users', ClienteController::class . ":upDateOne");
    $group->post('/users', ClienteController::class . ":upDateOne");
    $group->post('/users', ClienteController::class . ":upDateOne");
    $group->post('/users', ClienteController::class . ":upDateOne");
 */














/* $group->post('/users', UsuarioController::class . ":addOne");
    $group->post('/login', UsuarioController::class . ":login");
    $group->group('', function (RouteCollectorProxy $group) {
        
        $group->post('/materia', MateriaController::class . ":addOne");
        $group->post('/inscripcion/{idMateria}', Materias_usuarioController::class . ":addOne");
        $group->put('/notas/{idMateria}', UsuarioController::class . ":getAll");
        $group->get('/inscripcion/{idMateria}', UsuarioController::class . ":getAll");
        $group->get('/materia', UsuarioController::class . ":getAll");
        $group->get('/notas/{idMateria}', UsuarioController::class . ":getAll");
    })->add(new AuthMiddleware); */