<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\Noticia;
use Model\NoticiaAutor;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class NoticiaController{

    //***NOTICIAS ***//

    public static function noticias(Router $router){

        isAdmin();
        $alertas=[];

        //Validamos los parametros del get

        if($_GET['noticia']){
            $alert=$_GET['noticia'];
            switch ($alert){
                case 1:
                    $alertas['exito'][]='Noticia creada con éxito';
                    break;
                case 2:
                    $alertas['exito'][]='Noticia actualizada con éxito';
                    break;
                case 3:
                    $alertas['exito'][]='Noticia eliminada con éxito';
                    break;
                case 4:
                    $alertas['exito'][]='No se pudo realizar la accion';
                    break;
            }
        }

        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/noticias?page=1');
            $pagina_actual = 1;
        }

        $total_registros = Noticia::total();
        $registros_por_pagina = 10;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/noticias?page=1');
            $pagina_actual = 1;
        }

        $noticias = Noticia::paginar($registros_por_pagina, $paginacion->offset()," ", $orden);
        foreach ($noticias as $noticia){
            $noticia->usuario = Usuario::find($noticia->idUsuario);
        }
        //debuguear($noticias);
        
        $router->render('admin/noticias', [
            'title' => 'Iriépal es pasión || Administracion Noticias',
            'noticias' => $noticias,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
            
        ]);
        
    }

    public static function nuevaNoticia(Router $router){

        isAdmin();

        $noticia = new Noticia();
        

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $noticia->sincronizar($_POST);
            //debuguear($noticia);
            if($_GET['idFoto']){
                $noticia->idFoto = $_GET['idFoto'];
            }
            $alertas = $noticia->validarNuevaNoticia();

            if(empty($alertas)){
                
                $noticia->fecha = date('Y-m-d');
                $noticia->idUsuario = $_SESSION['id'];
                
                
                $noticia->id = null;
                $resultado = $noticia->guardar();
                
                if($resultado){
                    header( 'Location:/admin/noticias?noticia=1&page=1');
                    
                }else{
                    header( 'Location:/admin/noticias?noticia=4&page=1');
                }

            }
        }

        $alertas = Noticia::getAlertas();

        $router->render('admin/noticias/crear', [
            'title' => 'Iriépal es pasión || Crear Noticia',
            'noticia' =>$noticia,
            'alertas' => $alertas
        ]);
        
    }

    public static function actualizarNoticia(Router $router){
        isAdmin();

        $alertas=[];
        $idFoto = '';

        $id = $_GET['id'];
        if(!(is_numeric($id))){
            header('Location: /admin/noticias');
        }
        if($_GET['idFoto']){
            if(!(is_numeric($_GET['idFoto']))){
                header('Location: /admin/noticias');
            }else{
                $foto = Fotografias::find($_GET['idFoto']);
                if(!$foto){
                    header('Location: /admin/noticias');
                }
                $idFoto = $foto->id;
            }
        }
        $noticia = Noticia::find($id);
        if ($noticia === null){
            header('Location: /admin/noticias');            
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){



            $noticia->sincronizar($_POST);
            if($idFoto){
                $noticia->idFoto = $idFoto;
            }
            $alertas = $noticia->validarNuevaNoticia();
            

            if(empty($alertas)){
                
                //GUARDAR NOTICIA
                
                $resultado = $noticia->guardar();
                if($resultado){
                    //Noticia::setAlerta('exito','Noticia actualizada');
                    header( 'Location:/admin/noticias?noticia=2&page=1');
                    
                }else{
                    header( 'Location:/admin/noticias?noticia=4&page=1');
                }

            }
        }

        $alertas = Noticia::getAlertas();

        $router->render('admin/noticias/actualizar', [
            'title' => 'Iriépal es pasión || Crear Noticia',
            'noticia' =>$noticia,
            'idFoto' => $idFoto,
            'alertas' =>$alertas
        ]);

    }

    public static function seleccionarFoto(Router $router){

        isAdmin();

        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        $idNoticia = $_GET['idNoticia'] ?? '';
        $idFoto = $_GET['idFoto'];
        $registros_por_pagina = 12;

        if((!$pagina_actual  || $pagina_actual < 1) && !$idFoto){
            $root = 'Location: /admin/noticias/foto?page=1';
            
            header($root);
            $pagina_actual = 1;
        }
        if((!$pagina_actual  || $pagina_actual < 1) && $idFoto)
        {
            $pagina_actual = ceil(intval(Fotografias::registerPosition('id', $idFoto))/$registros_por_pagina);
            //debuguear($pagina_actual);
            $root = 'Location: /admin/noticias/foto?page=' . $pagina_actual;
            if($idNoticia){
                $root .= '&idNoticia=' . $idNoticia;
            }
            $root .= '&idFoto=' . $idFoto;
            
            header($root);
            
        }


        $total_registros = Fotografias::total();
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        if($paginacion->total_paginas() < $pagina_actual){
            $root = 'Location: /admin/noticias/foto?page=1';
            if($idNoticia){
                $root .= '&idNoticia=' . $idNoticia;
            }
            if($idFoto){
                $root .= '&idFoto=' . $idFoto;
            }

            $pagina_actual = 1;
        }


        $fotografias = Fotografias::paginarAsc($registros_por_pagina, $paginacion->offset()," ", $orden);


        foreach ($fotografias as $fotografia):

            $usuario = Usuario::find($fotografia->idUsuario);
            $fotografia->carpeta = nameCarpet($usuario->nombre, $usuario->apellidos);    
            
        endforeach;

        //debuguear($fotografias);

        $router->render('admin/noticias/fotografia', [
            'title' => 'Iriépal es pasión || Seleccionar fotografia',
            'fotografias' => $fotografias,
            'idFoto' => $idFoto,
            'idNoticia' => $idNoticia,
            'paginacion' => $paginacion->paginacion()
        ]);


    }

    public static function eliminarNoticia(){

        isAdmin();

        $id = $_GET['id'];
        if(!(is_numeric($id))){
            NoticiaAutor::setAlerta('error', 'Error en los datos');
            header('Location: /admin/noticias');
        }
        $noticia = Noticia::find($id);
        if ($noticia === null){
            NoticiaAutor::setAlerta('error', 'Error en los datos');
            header('Location:/admin/noticias?noticia=4&page=1');
            
        }

        $noticia->eliminar();
        header('Location:/admin/noticias?noticia=3&page=1');
    }
}