<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\NavController;
use MVC\Router;


$router = new Router();

//Navegation

$router->get('/', [NavController::class, 'index']);
$router->get('/noticias', [NavController::class, 'noticias']);
$router->get('/galerias', [NavController::class, 'galerias']);
$router->get('/blogs', [NavController::class, 'blogs']);
$router->get('/elenco', [NavController::class, 'elenco']);
$router->get('/ediciones', [NavController::class, 'ediciones']);


//LOGIN

$router->get('/auth/login', [LoginController::class, 'login']);
$router->post('/auth/login', [LoginController::class, 'login']);
$router->get('/auth/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/auth/crear-cuenta', [LoginController::class, 'crear']);
$router->get('/auth/olvide', [LoginController::class, 'olvide']);
$router->post('/auth/olvide', [LoginController::class, 'olvide']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();