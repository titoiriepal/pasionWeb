<?php

namespace Controllers;

use MVC\Router;
use Model\Noticia;
use Model\Usuario;
use Model\Fotografias;
use Model\GaleriaAutor;
use Model\NoticiaAutor;

class NavController{
    
    public static function index (Router $router){
        $noticias = Noticia::all();
        $galeriasAutor = GaleriaAutor::all();
        $fotografias = Fotografias::all();
        
        $arrayMuestras = [];
        $arrayCarpetas = [];
        $i = 0;
        foreach ($galeriasAutor as $galeria){
            $muestras = Fotografias::arrayMuestras('idUsuario', $galeria->idUsuario);
            $usuario = Usuario::find($galeria->idUsuario);
            $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
            $carpetaUsuario = CARPETA_IMAGENES_INDEX . '/' . $nombreCarpeta . '/' ;
            $arrayMuestras[] = $muestras;
            $arrayCarpetas[] = $carpetaUsuario;
            $guia[$galeria->idUsuario] = $carpetaUsuario;

            $i += 1;

            
        }

        

        
        
        

        $router->render('nav/index', [
            'title' => 'Pasión Viviente de Iriépal',
            'noticias' => $noticias,
            'galeriasAutor' => $galeriasAutor,
            'arrayMuestras' => $arrayMuestras,
            'arrayCarpetas' => $arrayCarpetas,
            'fotografias' => $fotografias,
            'guia'=> $guia
        ]);

    }

    public static function noticias (Router $router){

        $noticiaAutor = NoticiaAutor::all();

        $router->render('nav/noticias', [
            'title' => 'Noticias Pasión Iriépal',
            'noticiaAutor' => $noticiaAutor
        ]);

    }

    public static function galerias (Router $router){

        $router->render('nav/galerias', [
            'title' => 'Galerías fotográficas'
        ]);

    }

    public static function galeriaFotografica (Router $router){

        $inicioConsultaFotografias = 0;

        $galeriaAutor = GaleriaAutor::find($_GET['galery']);
        $fotografias = Fotografias::findXFromToWhitId('id', $inicioConsultaFotografias, 6, $_GET['galery']);
        debuguear($fotografias);


        $router->render('nav/galeriaFotografica', [
            'title' => 'Galerías fotográficas',
            'autor' => $galeriaAutor->autor,
            'fotografias' => $fotografias
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