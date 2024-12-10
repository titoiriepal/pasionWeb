<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiController;
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

// GALERIAS FOTOGRAFICAS
    $router->get('/galerias/galeria', [NavController::class, 'galeriaFotografica']);

// SECCION ADMINISTRACIÓN

    $router->get('/admin', [AdminController::class, 'admin']);

    //ADMINISTRACION de USUARIOS
    $router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
    $router->get('/admin/buscausuario', [AdminController::class, 'buscausuario']);
    $router->get('/admin/usuarios/eliminar', [AdminController::class, 'eliminarUsuario']);
    $router->get('/admin/usuarios/actualizar', [AdminController::class, 'actualizarUsuario']);
    $router->post('/admin/usuarios/actualizar', [AdminController::class, 'actualizarUsuario']);

    //ADMINISTRACION DE NOTICIAS
    $router->get('/admin/noticias', [AdminController::class, 'noticias']);
    $router->get('/admin/noticias/crear', [AdminController::class, 'nuevaNoticia']);
    $router->post('/admin/noticias/crear', [AdminController::class, 'nuevaNoticia']);
    $router->get('/admin/noticias/eliminar', [AdminController::class, 'eliminarNoticia']);
    $router->get('/admin/noticias/actualizar', [AdminController::class, 'actualizarNoticia']);
    $router->post('/admin/noticias/actualizar', [AdminController::class, 'actualizarNoticia']);
    $router->post('/admin/noticias/foto', [AdminController::class, 'seleccionarFoto']);

    //ADMINISTRACION DE GALERIAS
    $router->get('/admin/galerias', [AdminController::class, 'galerias']);
    $router->get('/admin/galerias/crear', [AdminController::class, 'crearGaleria']);
    $router->post('/admin/galerias/crear', [AdminController::class, 'nuevaGaleria']);
    $router->get('/admin/galerias/eliminar', [AdminController::class, 'eliminarGaleria']);
    $router->get('/admin/galerias/galeria', [AdminController::class, 'editarGaleria']);
    $router->post('/admin/galerias/galeria', [AdminController::class, 'editarGaleria']);
    $router->post('/admin/galerias/galeria/eliminar', [AdminController::class, 'eliminarFotografia']);
    $router->post('/admin/galerias/galeria/muestra', [AdminController::class, 'muestraFotografia']);



    $router->get('/admin/blogs', [AdminController::class, 'blogs']);
    $router->get('/admin/elenco', [AdminController::class, 'elenco']);
    $router->get('/admin/anteriores', [AdminController::class, 'anteriores']);


//API de USUARIOS

    $router->get('/admin/api/usuarios', [ApiController::class, 'getUsuarios']);
    $router->post('/admin/api/buscaUsuarios', [ApiController::class, 'findUsuarios']);
    $router->get('/admin/api/usuariosNoFoto', [ApiController::class, 'getUsuariosNoFoto']);
    $router->post('/admin/api/buscaUsuariosNoFoto', [ApiController::class, 'findUsuariosNoFoto']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();