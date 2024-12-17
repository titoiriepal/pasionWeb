<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Noticia;
use Model\Usuario;
use Model\Fotografias;
use Model\Galerias;
use Model\GaleriaAutor;
use Model\NoticiaAutor;

class NavController{
    
    public static function index (Router $router){
        $noticias = Noticia::all();
        $galerias = Galerias::all();
        $fotografias = Fotografias::all();
        
        $arrayMuestras = [];
        $arrayCarpetas = [];
        $i = 0;
        foreach ($galerias as $galeria){
            $galeria->usuario = Usuario::find($galeria->idUsuario);
            $muestras = Fotografias::arrayMuestras('idUsuario', $galeria->idUsuario);
            $nombreCarpeta = nameCarpet($galeria->usuario->nombre, $galeria->usuario->apellidos);
            $carpetaUsuario = CARPETA_IMAGENES_INDEX . '/' . $nombreCarpeta . '/' ;
            $arrayMuestras[] = $muestras;
            $arrayCarpetas[] = $carpetaUsuario;
            $guia[$galeria->idUsuario] = $carpetaUsuario;

            $i += 1;
          
        }
   

        $router->render('nav/index', [
            'title' => 'Pasión Viviente de Iriépal',
            'noticias' => $noticias,
            'galerias' => $galerias,
            'arrayMuestras' => $arrayMuestras,
            'arrayCarpetas' => $arrayCarpetas,
            'fotografias' => $fotografias,
            'guia'=> $guia
        ]);

    }

    public static function noticias (Router $router){

        $noticias = Noticia::all();

        $router->render('nav/noticias', [
            'title' => 'Noticias Pasión Iriépal',
            'noticias' => $noticias
        ]);

    }

    public static function galerias (Router $router){

        $router->render('nav/galerias', [
            'title' => 'Galerías fotográficas'
        ]);

    }

    public static function galeriaFotografica (Router $router){

        $galeriaNumero = $_GET['galery'];
        $galeriaNumero = filter_var($galeriaNumero, FILTER_VALIDATE_INT);

        if(!$galeriaNumero){
        header('Location:/');
        }

        $galeria = Galerias::find($galeriaNumero);
        if(!$galeria){
            header('Location:/');
        }
    
        $galeria->usuario = Usuario::find($galeria->idUsuario);

        //Validamos los parametros del get
        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /galerias/galeria?page=1&galery='. $galeriaNumero);
            $pagina_actual = 1;
        }

        //Nos devuelve el total de usuarios que tenemos según la busqueda
        $total_registros = Fotografias::totalQuery(['idUsuario' => $galeriaNumero]);
        if($total_registros === "0"){
            header('Location:/');
            exit;
        }
        $registros_por_pagina = 12; //Número de elementos que muestra cada página
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /galerias/galeria?page=1&galery='. $galeriaNumero);
            $pagina_actual = 1;
        }



        $fotografias = Fotografias::paginar($registros_por_pagina, $paginacion->offset(),Fotografias::selectWhereArray(['idUsuario' => $galeriaNumero]), $orden);
        //$fotografias = Fotografias::findXFromToWhitId('id', $inicioConsultaFotografias, 12, $_GET['galery']);
        foreach ($fotografias as $fotografia){
            $fotografia->url = nameCarpet($galeria->usuario->nombre, $galeria->usuario->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = $galeria->textAlt;
            }
        }
        
        $router->render('nav/galeriaFotografica', [
            'title' => 'Galerías fotográficas',
            'galeria' => $galeria,
            'fotografias' => $fotografias,
            'paginacion' => $paginacion->paginacion()
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