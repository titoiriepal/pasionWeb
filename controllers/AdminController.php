<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\Galerias;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController{

    public static function admin(Router $router) {

        //Comprobamos los permisos de los usuarios para acceder al panel de administración
        if($_SESSION['admin'] !=1  && $_SESSION['blog'] !=1 && $_SESSION['fotografo'] !=1){
            header('Location: /');
        }

        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/admin', [
            'title' => 'Iriépal es pasión || Administracion Web'
            
        ]);
    }



    //***BLOGS ***//

    public static function blogs(Router $router){

        $router->render('admin/blogs', [
            'title' => 'Iriépal es pasión || Administracion Blogs'
            
        ]);
        
    }
    
    public static function elenco(Router $router){

        $router->render('admin/elenco', [
            'title' => 'Iriépal es pasión || Administracion Elenco'
            
        ]);
        
    }

    public static function anteriores(Router $router){

        $router->render('admin/anteriores', [
            'title' => 'Iriépal es pasión || Administracion Ediciones anteriores'
            
        ]);
        
    }
}

