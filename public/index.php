<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\NavController;
use MVC\Router;


$router = new Router();

//Navegation

$router->get('/', [NavController::class, 'index']);
$router->get('/noticias', [NavController::class, 'noticias']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();