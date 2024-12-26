<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\Galerias;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Blog;

class BlogController{

    public static function admin(Router $router) {

        //Comprobamos los permisos de los usuarios para acceder al panel de administración
        if($_SESSION['admin'] !=1  && $_SESSION['blog'] !=1){
            header('Location: /');
        }

        if($_GET['noticia']){
            $alert=$_GET['noticia'];
            switch ($alert){
                case 1:
                    $alertas['exito'][]='Blog creado con éxito';
                    break;
                case 2:
                    $alertas['exito'][]='Blog actualizad0 con éxito';
                    break;
                case 3:
                    $alertas['exito'][]='Blog eliminado con éxito';
                    break;
                case 4:
                    $alertas['exito'][]='No se pudo realizar la accion';
                    break;
            }
        }

        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/blogs?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Blog::total();
        $registros_por_pagina = 10;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/blogs?page=1');
            $pagina_actual = 1;
        }

        $blogs = Blog::paginar($registros_por_pagina, $paginacion->offset()," ", $orden);
        foreach ($blogs as $blog){
            $blog->usuario = Usuario::find($blog->idUsuario);
        }

        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/blogs', [
            'title' => 'Iriépal es pasión || Administracion Blogs',
            'blogs' => $blogs,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
            
        ]);
    }

    public static function crear(Router $router) {

        //Comprobamos los permisos de los usuarios para acceder al panel de administración
        if($_SESSION['admin'] !=1  && $_SESSION['blog'] !=1){
            header('Location: /');
        }

        $blog = new Blog();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $blog->sincronizar($_POST);
            //debuguear($noticia);
            $alertas = $blog->validarNuevoBlog();

            if(empty($alertas)){
                
                $blog->fecha = date('Y-m-d');
                $blog->idUsuario = $_SESSION['id'];
                $blog->id = null;
                $resultado = $blog->guardar();
                
                if($resultado){
                    header( 'Location:/admin/blogs?noticia=1&page=1');
                    
                }else{
                    header( 'Location:/admin/blogs?noticia=4&page=1');
                }

            }
        }

        $alertas = Blog::getAlertas();


        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/blogs/crear', [
            'title' => 'Iriépal es pasión || Administracion Blogs',
            'blog' => $blog,
            'alertas' => $alertas,
            
            
        ]);
    }

    public static function editar(Router $router) {

        //Comprobamos los permisos de los usuarios para acceder al panel de administración
        if($_SESSION['admin'] !=1  && $_SESSION['blog'] !=1){
            header('Location: /');
        }


        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/blogs/editar', [
            'title' => 'Iriépal es pasión || Administracion Blogs',
            
            
        ]);
    }
}