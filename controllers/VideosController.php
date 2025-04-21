<?php

namespace Controllers;

use MVC\Router;

class VideosController {

    public static function index(Router $router) {

        // $pagina_actual = $_GET['page'];
        // $orden = $_GET['order'] ?? 'id';
        // $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        // //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        // if(!$pagina_actual  || $pagina_actual < 1){
        //     header('Location: /admin/blogs?page=1');
        //     $pagina_actual = 1;
        // }

        // $total_registros = Blog::total();
        // $registros_por_pagina = 10;
        // $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        // //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        // if($paginacion->total_paginas() < $pagina_actual){
        //     header('Location: /admin/blogs?page=1');
        //     $pagina_actual = 1;
        // }

        // $blogs = Blog::paginar($registros_por_pagina, $paginacion->offset()," ", $orden);
        // foreach ($blogs as $blog){
        //     $blog->usuario = Usuario::find($blog->idUsuario);
        // }

        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('videos/indexVideos', [
            'title' => 'Iriépal es pasión || Videos',
            //'paginacion' => $paginacion->paginacion()
            
        ]);
    }
}