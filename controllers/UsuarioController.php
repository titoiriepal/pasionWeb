<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\GaleriaAutor;
use Model\Galerias;
use Model\Noticia;
use Model\NoticiaAutor;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class UsuarioController{


public static function usuarios(Router $router){

isAdmin();
//Validamos los parametros del get
$pagina_actual = $_GET['page'];
$orden = $_GET['order'] ?? 'id';
$pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

//Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
if(!$pagina_actual  || $pagina_actual < 1){
    header('Location: /admin/usuarios?page=1');
    $pagina_actual = 1;
}

//Contamos todos los registros que existen de Usuarios y creamos la paginación
$total_registros = Usuario::total();
$registros_por_pagina = 5;
$paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

//Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
if($paginacion->total_paginas() < $pagina_actual){
    header('Location: /admin/usuarios?page=1');
    $pagina_actual = 1;
}

//Traemos los registros de los usuarios de la página establecida
$usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset()," ", $orden);

//Renderizar
$router->render('admin/usuarios', [
    'title' => 'Iriépal es pasión || Administracion Usuarios',
    'usuarios' => $usuarios,
    'paginacion' => $paginacion->paginacion()
            
]);

}

public static function buscaUsuario (Router $router){


isAdmin(); //Solo para administradores
$pagina_actual = $_GET['page'];//Número de pagina a mostrar
$orden = $_GET['order'] ?? 'id';//Si hay que ordenar la busqueda por algún parmetro. Si no se ordenará por id
$pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT); //Comprobar si el número de página introducido es un número 

//Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
if(!$pagina_actual  || $pagina_actual < 1){
    header('Location: /admin/buscausuario?busqueda='. $_GET["busqueda"] .'&page=1');
    $pagina_actual = 1;
}

//Nos devuelve el total de usuarios que tenemos según la busqueda
$total_registros = Usuario::totalQuery(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]);

$registros_por_pagina = 10; //Número de elementos que muestra cada página

//Creamos la paginación
$paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

//Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
if($paginacion->total_paginas() < $pagina_actual){
    header('Location: /admin/buscausuario?busqueda='. $_GET["busqueda"] .'&page=1');
    $pagina_actual = 1;
}

//Obrtenemos de la BD los registros ordenados que cumplan el parámetro de busqueda
$usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset(),Usuario::selectWhereArray(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]), $orden);

//Si no hay resultados de busqueda redirigimos a la página de Usuarios
if(!$usuarios)
{
    header('Location: /admin/usuarios?page=1');
    exit;
}

//renderizamos
$router->render('admin/usuarios', [
    'title' => 'Iriépal es pasión || Administracion Usuarios',
    'usuarios' => $usuarios,
    'paginacion' => $paginacion->paginacion()
            
]);



}

public static function actualizarUsuario(Router $router){

isAdmin();

//Validamos el parametro para buscar el usuario
if(!(empty($_GET))){
    $id = ($_GET['id']);
    $usuario = Usuario::find($id);
}else{
    header('Location: /admin');
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){//Comprobamos los parametros a actualizar. Todos los que no estén enviados en el post, los inicializamos a 0
    if(!(isset($_POST['fotografo']))){
        $_POST['fotografo'] = '0';
    }
    if(!(isset($_POST['blog']))){
        $_POST['blog'] = '0';
    }
    if(!(isset($_POST['restringido']))){
        $_POST['restringido'] = '0';
    }
    
    //Sincronizamos el usuario de memoria con los datos del post y guardamos
    $usuario->sincronizar($_POST);
    $usuario->guardar();
    header('Location: /admin/usuarios');
    
}


$router->render('admin/usuarios/actualizar', [
    'title' => 'Iriépal es pasión || Actualizacion Usuario',
    'usuario' => $usuario
    
]);

}

public static function eliminarUsuario(){
isAdmin();

$id = $_GET['id'];

if(!(is_numeric($id))){
    header('Location: /admin/usuarios');
}
$usuario = Usuario::find($id);
if($usuario){
    $usuario->eliminar();
    echo json_encode($usuario);
}else{
    header('Location: /admin/usuarios');
}
            
}

}