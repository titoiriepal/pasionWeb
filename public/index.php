<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
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
    $router->get('/auth/logout', [LoginController::class, 'logout']);
    //Confirmar cuenta y recuperar password

    $router->get('/auth/confirmar-cuenta', [LoginController::class, 'confirmar']);
    $router->get('/auth/mensaje', [LoginController::class, 'mensaje']);
    $router->get('/auth/mensaje-password', [LoginController::class, 'mensajePassword']);
    $router->get('/auth/recuperar', [LoginController::class, 'recuperar']);
    $router->post('/auth/recuperar', [LoginController::class, 'recuperar']);


// SECCION ADMINISTRACIÓN

    $router->get('/admin', [AdminController::class, 'admin']);
    $router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
    $router->get('/admin/noticias', [AdminController::class, 'noticias']);
    $router->get('/admin/galerias', [AdminController::class, 'galerias']);
    $router->get('/admin/blogs', [AdminController::class, 'blogs']);
    $router->get('/admin/elenco', [AdminController::class, 'elenco']);
    $router->get('/admin/anteriores', [AdminController::class, 'anteriores']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();