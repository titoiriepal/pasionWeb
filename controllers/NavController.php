<?php

namespace Controllers;

use MVC\Router;

class NavController{
    
    public static function index (Router $router){

        $router->render('nav/index', [
            'title' => 'Pasión Viviente de Iriépal'
        ]);

    }
}