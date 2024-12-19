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

        $blogs = Blog::all();
        foreach($blogs as $blog){
            $usuario = Usuario::find($blog->idUsuario);
            $blog->usuario = $usuario;
        }

        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/blogs', [
            'title' => 'Iriépal es pasión || Administracion Blogs',
            'blogs' => $blogs
            
        ]);
    }

}