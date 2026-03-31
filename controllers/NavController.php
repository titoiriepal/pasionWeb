<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Blog;
use MVC\Router;
use Model\Noticia;
use Model\Usuario;
use Model\Fotografias;
use Model\Galerias;


class NavController
{

    public static function index(Router $router)
    {
        $galerias = Galerias::get(4, ['oculto', 0]);
        $noticias = Noticia::get(5);
        $fotografias = Fotografias::all();
        $blogs = Blog::get(3);

        foreach ($noticias as $noticia) {
            $usuario = Usuario::find($noticia->idUsuario);
            $noticia->usuario = new Usuario();
            $noticia->usuario->nombre = $usuario->nombre;
            $noticia->usuario->apellidos = $usuario->apellidos;
            $noticia->fecha = date("d/m/Y", strtotime($noticia->fecha));

            $fotografia = Fotografias::find($noticia->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if ($fotografia->textAlt === '' || $fotografia->textAlt === ' ') {
                $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por ' . $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $noticia->foto = $fotografia;
        }



        $arrayMuestras = [];
        $arrayCarpetas = [];
        $i = 0;
        foreach ($galerias as $galeria) {
            $galeria->usuario = Usuario::find($galeria->idUsuario);
            $muestras = Fotografias::arrayMuestras('idUsuario', $galeria->idUsuario);
            $nombreCarpeta = nameCarpet($galeria->usuario->nombre, $galeria->usuario->apellidos);
            $carpetaUsuario = CARPETA_IMAGENES_INDEX . '/' . $nombreCarpeta . '/';
            $arrayMuestras[] = $muestras;
            $arrayCarpetas[] = $carpetaUsuario;
            $guia[$galeria->idUsuario] = $carpetaUsuario;

            $i += 1;
        }

        foreach ($blogs as $blog) {
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
            'guia' => $guia,
            'keywords' => 'pasiones vivientes, Iriépal, Bubillos, Iriépal pasión, pasión viviente Guadalajara, pasión viviente Hiendelaencina, Semana santa, pasion viviente teatro',
        ]);
    }

    public static function noticias(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual  || $pagina_actual < 1) {
            header('Location: /noticias?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Noticia::total();
        $registros_por_pagina = 10;
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /noticias?page=1');
            $pagina_actual = 1;
        }

        $noticias = Noticia::paginar($registros_por_pagina, $paginacion->offset());
        foreach ($noticias as $noticia) {
            $usuario = Usuario::find($noticia->idUsuario);
            $noticia->usuario = new Usuario();
            $noticia->usuario->nombre = $usuario->nombre;
            $noticia->usuario->apellidos = $usuario->apellidos;
            $noticia->fecha = date("d/m/Y", strtotime($noticia->fecha));

            $fotografia = Fotografias::find($noticia->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if ($fotografia->textAlt === '') {
                $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por ' . $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $noticia->foto = $fotografia;
        }

        $router->render('nav/noticias', [
            'title' => 'Noticias Pasión Iriépal',
            'noticias' => $noticias,
            'keywords' => 'noticias pasión viviente, noticias pasión viviente de Iriépal, noticias pasiones vivientes, noticias Iriépal, noticias Iriépal pasión, noticias pasión viviente Guadalajara, noticias pasión viviente Hiendelaencina, noticias Semana santa, noticias pasion viviente teatro',
            'paginacion' => $paginacion->paginacion()

        ]);
    }

    public static function galerias(Router $router)
    {

        $galerias = Galerias::whereBool('oculto', 0);

        $arrayMuestras = [];
        $arrayCarpetas = [];
        $i = 0;
        foreach ($galerias as $galeria) {
            $galeria->usuario = Usuario::find($galeria->idUsuario);
            $muestras = Fotografias::arrayMuestras('idUsuario', $galeria->idUsuario);
            $nombreCarpeta = nameCarpet($galeria->usuario->nombre, $galeria->usuario->apellidos);
            $carpetaUsuario = CARPETA_IMAGENES_INDEX . '/' . $nombreCarpeta . '/';
            $arrayMuestras[] = $muestras;
            $arrayCarpetas[] = $carpetaUsuario;
            $guia[$galeria->idUsuario] = $carpetaUsuario;

            $i += 1;
        }

        $router->render('nav/galerias', [
            'title' => 'Galerías fotográficas',
            'galerias' => $galerias,
            'arrayMuestras' => $arrayMuestras,
            'arrayCarpetas' => $arrayCarpetas,
            'keywords' => 'galerías fotográficas pasión viviente, galerías fotográficas pasión viviente de Iriépal, galerías fotográficas pasiones vivientes, galerías fotográficas Iriépal, galerías fotográficas Iriépal pasión, galerías fotográficas pasión viviente Guadalajara, galerías fotográficas pasión viviente Hiendelaencina, galerías fotográficas Semana santa, galerías fotográficas pasion viviente teatro',
            'guia' => $guia
        ]);
    }

    public static function galeriaFotografica(Router $router)
    {

        $galeriaNumero = $_GET['galery'];
        $galeriaNumero = filter_var($galeriaNumero, FILTER_VALIDATE_INT);

        if (!$galeriaNumero) {
            header('Location:/');
        }

        $galeria = Galerias::find($galeriaNumero);
        if (!$galeria) {
            header('Location:/');
        }

        $galeria->usuario = Usuario::find($galeria->idUsuario);

        //Validamos los parametros del get
        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if (!$pagina_actual  || $pagina_actual < 1) {
            header('Location: /galerias/galeria?page=1&galery=' . $galeriaNumero);
            $pagina_actual = 1;
        }

        //Nos devuelve el total de usuarios que tenemos según la busqueda
        $total_registros = Fotografias::totalQuery(['idUsuario' => $galeria->idUsuario]);
        if ($total_registros === "0") {
            header('Location:/');
            exit;
        }
        $registros_por_pagina = 12; //Número de elementos que muestra cada página
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros, $orden);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /galerias/galeria?page=1&galery=' . $galeriaNumero);
            $pagina_actual = 1;
        }

        $fotografias = Fotografias::paginar($registros_por_pagina, $paginacion->offset(), Fotografias::selectWhereArray(['idUsuario' => $galeria->idUsuario]), $orden);
        //$fotografias = Fotografias::findXFromToWhitId('id', $inicioConsultaFotografias, 12, $_GET['galery']);
        foreach ($fotografias as $fotografia) {
            $fotografia->url = nameCarpet($galeria->usuario->nombre, $galeria->usuario->apellidos) . '/' . trim($fotografia->ruta);
            if ($fotografia->textAlt === '' || $fotografia->textAlt === ' ') {

                $fotografia->textAlt = $galeria->textAlt;
            }
        }



        $router->render('nav/galeriaFotografica', [
            'title' => 'Galerías fotográficas',
            'galeria' => $galeria,
            'fotografias' => $fotografias,
            'keywords' => 'galería fotográfica pasión viviente, galería fotográfica pasión viviente de Iriépal, galería fotográfica pasiones vivientes, galería fotográfica Iriépal, galería fotográfica Iriépal pasión, galería fotográfica pasión viviente Guadalajara, galería fotográfica pasión viviente Hiendelaencina, galería fotográfica Semana santa, galería fotográfica pasion viviente teatro',
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function blogs(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual  || $pagina_actual < 1) {
            header('Location: /blogs?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Blog::total();
        $registros_por_pagina = 6;
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /blogs?page=1');
            $pagina_actual = 1;
        }

        $blogs = Blog::paginar($registros_por_pagina, $paginacion->offset());

        foreach ($blogs as $blog) {
            $usuario = Usuario::find($blog->idUsuario);
            $blog->usuario = new Usuario();
            $blog->usuario->nombre = $usuario->nombre;
            $blog->usuario->apellidos = $usuario->apellidos;
            $blog->fecha = date("d/m/Y", strtotime($blog->fecha));

            $fotografia = Fotografias::find($blog->idFoto);
            $usuarioFoto = Usuario::find($fotografia->idUsuario);
            $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
            if ($fotografia->textAlt === '') {
                $fotografia->textAlt = 'Fotografía del blog ' . $blog->titulo . ' realizada por ' . $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
            }
            $blog->foto = $fotografia;
        }



        $router->render('nav/blogs', [
            'title' => 'Blogs Pasión',
            'blogs' => $blogs,
            'keywords' => 'blogs pasión viviente, blogs pasión viviente de Iriépal, blogs pasiones vivientes, blogs Iriépal, blogs Iriépal pasión, blogs pasión viviente Guadalajara, blogs pasión viviente Hiendelaencina, blogs Semana santa, blogs pasion viviente teatro',
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function blog(Router $router)
    {

        $blogId = $_GET['id'];
        $blogId = filter_var($blogId, FILTER_VALIDATE_INT);

        if (!$blogId) {
            header('Location:/');
        }

        $blog = Blog::find($blogId);
        if (!$blog) {
            header('Location:/');
        }

        $blog->usuario = Usuario::find($blog->idUsuario);
        $blog->fecha = date('d/m/Y', strtotime($blog->fecha));

        $fotografia = Fotografias::find($blog->idFoto);
        $usuarioFoto = Usuario::find($fotografia->idUsuario);
        $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
        if ($fotografia->textAlt === '') {
            $fotografia->textAlt = 'Fotografía de la noticia ' . $blog->titulo . ' realizada por ' . $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
        }
        $blog->foto = $fotografia;
        $blog->formatText = explode("\n", $blog->cuerpo);
        // $blog->formatText = array_map('trim', $blog->formatText);
        //debuguear($blog->formatText);

        $router->render('nav/blog', [
            'title' => 'Blog Pasión',
            'keywords' => 'blog pasión viviente, blog pasión viviente de Iriépal, blog pasiones vivientes, blog Iriépal, blog Iriépal pasión, blog pasión viviente Guadalajara, blog pasión viviente Hiendelaencina, blog Semana santa, blog pasion viviente teatro',
            'blog' => $blog,
        ]);
    }

    public static function noticia(Router $router)
    {

        $noticiaId = $_GET['id'];
        $noticiaId = filter_var($noticiaId, FILTER_VALIDATE_INT);

        if (!$noticiaId) {
            header('Location:/');
        }

        $noticia = Noticia::find($noticiaId);
        if (!$noticia) {
            header('Location:/');
        }

        $noticia->usuario = Usuario::find($noticia->idUsuario);
        $noticia->fecha = date('d/m/Y', strtotime($noticia->fecha));

        $fotografia = Fotografias::find($noticia->idFoto);
        $usuarioFoto = Usuario::find($fotografia->idUsuario);
        $fotografia->url = nameCarpet($usuarioFoto->nombre, $usuarioFoto->apellidos) . '/' . trim($fotografia->ruta);
        if ($fotografia->textAlt === '') {
            $fotografia->textAlt = 'Fotografía de la noticia ' . $noticia->titulo . ' realizada por ' . $usuarioFoto->nombre . ' ' . $usuarioFoto->apellidos;
        }
        $noticia->foto = $fotografia;
        $noticia->formatResumen = explode("\n", $noticia->resumen);
        $noticia->formatText = explode("\n", $noticia->cuerpo);
        // $blog->formatText = array_map('trim', $blog->formatText);

        $router->render('nav/noticia', [
            'title' => 'Noticia Pasión',
            'keywords' => 'noticia pasión viviente, noticia pasión viviente de Iriépal, noticia pasiones vivientes, noticia Iriépal, noticia Iriépal pasión, noticia pasión viviente Guadalajara, noticia pasión viviente Hiendelaencina, noticia Semana santa, noticia pasion viviente teatro',
            'noticia' => $noticia,
        ]);
    }

    public static function elenco(Router $router)
    {

        $router->render('nav/elenco', [
            'title' => 'Elenco Pasión',
            'keywords' => 'elenco pasión viviente, elenco pasión viviente de Iriépal, elenco pasiones vivientes, elenco Iriépal, elenco Iriépal pasión, elenco pasión viviente Guadalajara, elenco pasión viviente Hiendelaencina, elenco Semana santa, elenco pasion viviente teatro',
        ]);
    }

    public static function ediciones(Router $router)
    {

        $router->render('nav/ediciones', [
            'title' => 'Elenco Pasión',
            'keywords' => 'ediciones pasión viviente, ediciones pasión viviente de Iriépal, ediciones pasiones vivientes, ediciones Iriépal, ediciones Iriépal pasión, ediciones pasión viviente Guadalajara, ediciones pasión viviente Hiendelaencina, ediciones Semana santa, ediciones pasion viviente teatro',
        ]);
    }

    public static function error(Router $router)
    {

        // Render a la vista 
        $router->render('nav/error', [
            'titulo' => 'Página no encontrada',

        ]);
    }
}
