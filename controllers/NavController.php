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

    public static function galerias (Router $router){

        $router->render('nav/galerias', [
            'title' => 'Galerías fotográficas'
        ]);

    }

    public static function blogs (Router $router){

        $router->render('nav/blogs', [
            'title' => 'Blogs Pasión'
        ]);

    }

    public static function elenco (Router $router){

        $router->render('nav/elenco', [
            'title' => 'Elenco Pasión'
        ]);

    }

    public static function ediciones (Router $router){

        $router->render('nav/ediciones', [
            'title' => 'Elenco Pasión'
        ]);

    }
}