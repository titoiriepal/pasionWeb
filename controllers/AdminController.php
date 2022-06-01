<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class AdminController{

    public static function admin(Router $router) {

        if($_SESSION['admin'] != 1  && $_SESSION['blog'] != 1  && $_SESSION['fotografo'] != 1){
            header('Location: /');
        }


        $router->render('admin/admin', [
            'title' => 'Iriépal es pasión || Administracion Web'
            
        ]);
    }

    public static function usuarios(Router $router){

        $imprUsuarios = [];

        $type = $_GET['type'];
        $page = $_GET['page'];

        //Número de usuarios que se mostraran por cada página
        $usuariosPagina = 25;

        //Primer usuario a mostrar
        $usuarioInicial = (intval($page) - 1) * $usuariosPagina;

        
        //Control del tipo de usuarios a mostrar

        switch($type){
            case "all":
                $usuarios = Usuario::all();
                break;
            case "admin":
                $usuarios = Usuario::arrayWhere("admin", "1"); 
                break;
            case "blog":
                $usuarios = Usuario::arrayWhere("blog", "1");
                break;
            case "foto":
                $usuarios = Usuario::arrayWhere("fotografo", "1");
                break;
            case "rest":
                $usuarios = Usuario::arrayWhere("restringido", "1"); 
                break;
            default:
                header('Location:/admin');
        }

        //Número de páginas a mostrar. Si el número de página es mayor que el de páginas totales, redireccionamos a admin
        if(count($usuarios)%$usuariosPagina != 0){
            $paginasTotales = intval(count($usuarios)/$usuariosPagina) + 1;
        }else{
            $paginasTotales = intval(count($usuarios)/$usuariosPagina);
        }

        
    
        if (intval($page) > $paginasTotales || intval($page)=== 0)  {
            header('Location:/admin');
        }
        

        // creamos la lista de usuarios a imprimir según la página en la que nos encontremos 
        for ($i = $usuarioInicial; ;$i++){
            if($i === $usuarioInicial + $usuariosPagina || $i === count($usuarios)){
                break;
            }
            if($usuarios[$i]){
                $imprUsuarios[] = $usuarios[$i];
            }

        };


        

        
        

        $router->render('admin/usuarios', [
            'title' => 'Iriépal es pasión || Administracion Usuarios',
            'usuarios' => $imprUsuarios,
            'paginasTotales' => $paginasTotales,
            'type' => $type,
            'page' => intval($page)
            
            
        ]);
        
    }

    public static function noticias(Router $router){

        $router->render('admin/noticias', [
            'title' => 'Iriépal es pasión || Administracion Noticias'
            
        ]);
        
    }

    public static function galerias(Router $router){

        $router->render('admin/galerias', [
            'title' => 'Iriépal es pasión || Administracion Galerias'
            
        ]);
        
    }

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