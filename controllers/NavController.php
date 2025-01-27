<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Blog;
use MVC\Router;
use Model\Noticia;
use Model\Usuario;
use Model\Fotografias;
use Model\Galerias;


class NavController{
    
    public static function index (Router $router){
        $noticias = Noticia::get(5);
        $galerias = Galerias::all();
        $fotografias = Fotografias::all();
        $blogs = Blog::get(3);

        foreach($noticias as $noticia){
            $usuario = Usuario::find($noticia->idUsuario); 
            $noticia->usuario = New Usuario();
            $noticia->usuario->nombre = $usuario->nombre;
            $noticia->usuario->apellidos = $usuario->apellidos;
            $noticia->fecha = date("d/m/Y", strtotime($noticia->fecha));

            $fotografia = Fotografias::find($noticia->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por '. $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $noticia->foto = $fotografia;
        }

        
        
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

        foreach ($blogs as $blog){
            $blog->usuario = Usuario::find($blog->idUsuario);
        }
   

        $router->render('nav/index', [
            'title' => 'Pasión Viviente de Iriépal',
            'noticias' => $noticias,
            'galerias' => $galerias,
            'arrayMuestras' => $arrayMuestras,
            'arrayCarpetas' => $arrayCarpetas,
            'fotografias' => $fotografias,
            'blogs' => $blogs,
            'guia'=> $guia
        ]);

    }

    public static function noticias (Router $router){

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /noticias?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Noticia::total();
        $registros_por_pagina = 5;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /noticias?page=1');
            $pagina_actual = 1;
        }

        $noticias = Noticia::paginar($registros_por_pagina, $paginacion->offset());
        foreach($noticias as $noticia){
            $usuario = Usuario::find($noticia->idUsuario); 
            $noticia->usuario = New Usuario();
            $noticia->usuario->nombre = $usuario->nombre;
            $noticia->usuario->apellidos = $usuario->apellidos;
            $noticia->fecha = date("d/m/Y", strtotime($noticia->fecha));

            $fotografia = Fotografias::find($noticia->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por '. $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $noticia->foto = $fotografia;
        }

        $router->render('nav/noticias', [
            'title' => 'Noticias Pasión Iriépal',
            'noticias' => $noticias,
            'paginacion' => $paginacion->paginacion()

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

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /blogs?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Blog::total();
        $registros_por_pagina = 6;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /blogs?page=1');
            $pagina_actual = 1;
        }

        $blogs = Blog::paginar($registros_por_pagina, $paginacion->offset());

        foreach($blogs as $blog){
            $usuario = Usuario::find($blog->idUsuario); 
            $blog->usuario = New Usuario();
            $blog->usuario->nombre = $usuario->nombre;
            $blog->usuario->apellidos = $usuario->apellidos;
            $blog->fecha = date("d/m/Y", strtotime($blog->fecha));

            $fotografia = Fotografias::find($blog->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = 'Fotografía del blog ' . $blog->titulo . ' realizada por '. $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $blog->foto = $fotografia;
        }

        

        $router->render('nav/blogs', [
            'title' => 'Blogs Pasión',
            'blogs'=>$blogs,
            'paginacion' => $paginacion->paginacion()
        ]);

    }

    public static function blog (Router $router){

        $blogId = $_GET['id'];
        $blogId = filter_var($blogId, FILTER_VALIDATE_INT);

        if(!$blogId){
        header('Location:/');
        }

        $blog = Blog::find($blogId);
        if(!$blog){
            header('Location:/');
        }
    
        $blog->usuario = Usuario::find($blog->idUsuario);
        $blog->fecha = date('d/m/Y', strtotime($blog->fecha));

        $fotografia = Fotografias::find($blog->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = 'Fotografía de la noticia ' . $blog->titulo . ' realizada por '. $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $blog->foto = $fotografia;
        $blog->formatText = explode("\n", $blog->cuerpo);
        // $blog->formatText = array_map('trim', $blog->formatText);
        //debuguear($blog->formatText);

        $router->render('nav/blog', [
            'title' => 'Blog Pasión',
            'blog' => $blog,
        ]);
    }

    public static function noticia (Router $router){

        $noticiaId = $_GET['id'];
        $noticiaId = filter_var($noticiaId, FILTER_VALIDATE_INT);

        if(!$noticiaId){
        header('Location:/');
        }

        $noticia = Noticia::find($noticiaId);
        if(!$noticia){
            header('Location:/');
        }
    
        $noticia->usuario = Usuario::find($noticia->idUsuario);
        $noticia->fecha = date('d/m/Y', strtotime($noticia->fecha));

        $fotografia = Fotografias::find($noticia->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if($fotografia->textAlt === ''){
                $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por '. $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $noticia->foto = $fotografia;
        $noticia->formatResumen =explode("\n", $noticia->resumen);
        $noticia->formatText = explode("\n", $noticia->cuerpo);
        // $blog->formatText = array_map('trim', $blog->formatText);
        //debuguear($blog->formatText);

        $router->render('nav/noticia', [
            'title' => 'Blog Pasión',
            'noticia' => $noticia,
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

    public static function error(Router $router){

        // Render a la vista 
        $router->render('nav/error', [
            'titulo' => 'Página no encontrada',
            
        ]);
    }
}