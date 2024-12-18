<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\BlogController;
use Controllers\GaleriaController;
use Controllers\LoginController;
use Controllers\NavController;
use Controllers\NoticiaController;
use Controllers\UsuarioController;
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
    $router->get('/admin/usuarios', [UsuarioController::class, 'usuarios']);
    $router->get('/admin/buscausuario', [UsuarioController::class, 'buscausuario']);
    $router->get('/admin/usuarios/eliminar', [UsuarioController::class, 'eliminarUsuario']);
    $router->get('/admin/usuarios/actualizar', [UsuarioController::class, 'actualizarUsuario']);
    $router->post('/admin/usuarios/actualizar', [UsuarioController::class, 'actualizarUsuario']);

    //ADMINISTRACION DE NOTICIAS
    $router->get('/admin/noticias', [NoticiaController::class, 'noticias']);
    $router->get('/admin/noticias/crear', [NoticiaController::class, 'nuevaNoticia']);
    $router->post('/admin/noticias/crear', [NoticiaController::class, 'nuevaNoticia']);
    $router->get('/admin/noticias/eliminar', [NoticiaController::class, 'eliminarNoticia']);
    $router->get('/admin/noticias/actualizar', [NoticiaController::class, 'actualizarNoticia']);
    $router->post('/admin/noticias/actualizar', [NoticiaController::class, 'actualizarNoticia']);
    $router->get('/admin/noticias/foto', [NoticiaController::class, 'seleccionarFoto']);

    //ADMINISTRACION DE GALERIAS
    $router->get('/admin/galerias', [GaleriaController::class, 'galerias']);
    $router->get('/admin/galerias/crear', [GaleriaController::class, 'crearGaleria']);
    $router->post('/admin/galerias/nueva', [GaleriaController::class, 'nuevaGaleria']);
    $router->get('/admin/galerias/eliminar', [GaleriaController::class, 'eliminarGaleria']);
    $router->get('/admin/galerias/galeria', [GaleriaController::class, 'editarGaleria']);
    $router->post('/admin/galerias/galeria', [GaleriaController::class, 'editarGaleria']);
    $router->post('/admin/galerias/galeria/eliminar', [GaleriaController::class, 'eliminarFotografia']);
    $router->post('/admin/galerias/galeria/muestra', [GaleriaController::class, 'muestraFotografia']);
    $router->post('/admin/galerias/textoAlt', [GaleriaController::class, 'textoAlt']);


    $router->get('/admin/elenco', [AdminController::class, 'elenco']);
    $router->get('/admin/anteriores', [AdminController::class, 'anteriores']);

    //ADMINISTRACION DE BLOGS

    $router->get('/admin/blogs', [BlogController::class, 'admin']);
    $router->get('/admin/blogs/crear', [BlogController::class, 'crear']);
    $router->post('/admin/blogs/crear', [BlogController::class, 'crear']);
    $router->get('/admin/blogs/editar', [BlogController::class, 'editar']);
    $router->post('/admin/blogs/editar', [BlogController::class, 'editar']);
    $router->get('/admin/blogs/eliminar', [BlogController::class, 'eliminar']);


//API de USUARIOS

    $router->get('/admin/api/usuarios', [ApiController::class, 'getUsuarios']);
    $router->post('/admin/api/buscaUsuarios', [ApiController::class, 'findUsuarios']);
    $router->get('/admin/api/usuariosNoFoto', [ApiController::class, 'getUsuariosNoFoto']);
    $router->post('/admin/api/buscaUsuariosNoFoto', [ApiController::class, 'findUsuariosNoFoto']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();