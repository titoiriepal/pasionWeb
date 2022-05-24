<?php

namespace Controllers;

use MVC\Router;

class NavController{
    
    public static function index (Router $router){

        $router->render('nav/index', [
            'title' => 'Pasión Viviente de Iriépal'
        ]);

    }

    public static function noticias (Router $router){

        $router->render('nav/noticias', [
            'title' => 'Noticias Pasión Iriépal'
        ]);

    }
}