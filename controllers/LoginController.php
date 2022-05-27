<?php

namespace Controllers;

use MVC\Router;

class LoginController{

    public static function login(Router $router) {
        $router->render('auth/login', [
            'title' => 'Iriépal es pasión || Iniciar Sesion'
        ]);
    }
    public static function crear(Router $router) {
        $router->render('auth/crear', [
            'title' => 'Iriépal es pasión || Crear cuenta'
        ]);
    }
    public static function olvide(Router $router) {
        $router->render('auth/olvide', [
            'title' => 'Iriépal es pasión || Olvide mi Password'
        ]);
    }
}