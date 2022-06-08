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

        isAdmin();

        
 

        $router->render('admin/usuarios', [
            'title' => 'Iriépal es pasión || Administracion Usuarios'
            
            
            
        ]);
        
    }

    public static function actualizarUsuario(Router $router){

        isAdmin();

        

        if(!(empty($_GET))){
            $id = ($_GET['id']);
            $usuario = Usuario::find($id);
        }else{
            header('Location: /admin');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!(isset($_POST['fotografo']))){
                $_POST['fotografo'] = '0';
            }
            if(!(isset($_POST['blog']))){
                $_POST['blog'] = '0';
            }
            if(!(isset($_POST['restringido']))){
                $_POST['restringido'] = '0';
            }
            
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
        if($_SESSION['admin'] != 1){
            header('Location: /');
        }

        $id = $_GET['id'];
        $usuario = Usuario::find($id);
        if($usuario){
            $usuario->eliminar();
            echo json_encode($usuario);
        }else{
            header('Location: /admin/usuarios');
        }
        
            
        

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