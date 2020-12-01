<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;

use App\Middlewares\JsonMiddleware;

use App\Middlewares\AuthClienteMiddleware;
use App\Middlewares\AuthAdminMiddleware;

//
use App\Controllers\UsuarioController;
use App\Controllers\MascotaController;
use App\Controllers\TurnoController;


require __DIR__ . '/../vendor/autoload.php';
$conn = new Database;
$app = AppFactory::create();
$app->setBasePath('/Prog3/segundoCuatri/segundoParcialRecuperatorio/public');

$app->group('', function (RouteCollectorProxy $group) {
    $group->post('/users', UsuarioController::class . ":addOne"); //1
    $group->post('/login', UsuarioController::class . ":login"); //2
    $group->post('/mascota', MascotaController::class . ":addOne")->add(new AuthAdminMiddleware); //3
    $group->post('/turno', TurnoController::class . ":addOne")->add(new AuthClienteMiddleware); //4
    $group->get('/turnos', TurnoController::class . ":getAll")->add(new AuthAdminMiddleware); //5
    $group->put('/turno/{idTurno}', TurnoController::class . ":atendeTurno")->add(new AuthAdminMiddleware); //6
    $group->get('/factura', TurnoController::class . ":mostrarFactura")->add(new AuthClienteMiddleware); //7

})->add(new JsonMiddleware);

$app->run();
