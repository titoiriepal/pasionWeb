<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\GaleriaAutor;
use Model\Galerias;
use Model\Noticia;
use Model\NoticiaAutor;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController{

    public static function admin(Router $router) {

        //Comprobamos los permisos de los usuarios para acceder al panel de administración
        if($_SESSION['admin'] !=1  && $_SESSION['blog'] !=1 && $_SESSION['fotografo'] !=1){
            header('Location: /');
        }

        //Mostramos la vista. Dependiendo de los permisos apareceran unos botones u otros resaltados
        $router->render('admin/admin', [
            'title' => 'Iriépal es pasión || Administracion Web'
            
        ]);
    }


            //***GALERÍA FOTOGRÁFICA***//


    public static function galerias(Router $router){

        isAdminOrFoto();
        $alertas=[];

        if ($_SESSION['admin'] != 1){
            
            $galeria = Galerias::where('idUsuario', $_SESSION['id']);         
            header('Location:/admin/galerias/galeria?id=' . $galeria->id);

        }else{
            
            $pagina_actual = $_GET['page'];
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if(!$pagina_actual  || $pagina_actual < 1){
                header('Location: /admin/galerias?page=1');
                
                $pagina_actual = 1;
            }

            
            $total_registros = Galerias::total();
            

            if($total_registros == '0'){
                
                header('Location: /admin/galerias/crear');
                exit;
            }

            
            $registros_por_pagina = 5;
            $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros);

            if($paginacion->total_paginas() < $pagina_actual){
                header('Location: /admin/galerias?page=1');
                $pagina_actual = 1;
            }

            $galerias = Galerias::paginar($registros_por_pagina, $paginacion->offset()," ");

            //Incluimos los datos del usuario en cada registro
            foreach ($galerias as $galeria){
                $galeria->usuario = Usuario::find($galeria->idUsuario);
            }
            
            
        }

        $router->render('admin/galerias', [
            'title' => 'Iriépal es pasión || Administracion Galerias',
            'galerias' => $galerias,
            'alertas' => $alertas,
            'cabecera' => 'Administración de Galerías',
            'paginacion' => $paginacion->paginacion()
            
        ]);
        
    }

    public static function editarGaleria(Router $router){

        isAdminOrFoto();
        $alertas=[];

        $idGaleria = $_GET['id'];

        if(!(is_numeric($idGaleria))){
            header('Location: /admin/galerias');            
        }

        $galeria = Galerias::find($idGaleria);
        $usuario = Usuario::find($galeria->idUsuario);
        $fotografias = Fotografias::arraywhere('idUsuario',$galeria->idUsuario);
        

        $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
        $carpetaUsuario = CARPETA_IMAGENES . '/' . $nombreCarpeta . '/' ;

        

        

        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){


            foreach ($_FILES['foto']['tmp_name'] as $nombre){
            

                
                $numFotografias = count($fotografias);
                if($numFotografias >= 50){

                    $alertas['error'][]='Excedes el numero de Fotografias. Por favor borra alguna antes de continuar';
                    break;

                }else{

            

                    $fotografia = new Fotografias($_POST['fotografias']);
                    $fotografia->fecha = date('Y');

                    $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
                    

                    
                    if($nombre){

                        list($ancho, $alto, $tipo, $atributos) = getimagesize($nombre);
                        
                        if($alto >= $ancho){
                            $image = Image::make($nombre)->fit(600,800); 
                        }else{
                            $image = Image::make($nombre)->fit(800,600);
                        }
                        
                        $fotografia->setRuta($nombreImagen);
                        

                        


                        if(!is_dir(CARPETA_IMAGENES)){
                            mkdir(CARPETA_IMAGENES);
                        }

                        

                        if(!is_dir($carpetaUsuario)){
                            mkdir($carpetaUsuario);
                        }

                        $image->save($carpetaUsuario . $nombreImagen);

                        $fotografia->guardar();

                        $fotografias = Fotografias::arraywhere('idUsuario',$galeria->idUsuario);

                        

                    }   

                    
                }

            }

            $alertas['exito'][]='Fotografía(s) guardada correctamente';

                
        }


            //RESIZE IMAGEN Y MUESTRA


            //debuguear($image);
        

        $router->render('admin/galerias/galeria', [
            'title' => 'Iriépal es pasión || Editar Galería',
            'alertas' => $alertas,
            'cabecera' => 'Galería de '. $usuario->nombre . ' ' . $usuario->apellidos,
            'idGaleria' => $idGaleria,
            'idUsuario' => $usuario->id,
            'fotografias' => $fotografias,
            'nombreCarpeta' => $nombreCarpeta
            
        ]);
        
    }

    public static function eliminarFotografia(){
        isAdminOrFoto();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $fotografia = Fotografias::find($id);
                $usuario = Usuario::find($fotografia->idUsuario);
                $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
                $carpetaUsuario = CARPETA_IMAGENES . '/' . $nombreCarpeta . '/' ;
                

                
                $fotografia->eliminarFotografia($carpetaUsuario);

                header('Location:/admin/galerias/galeria?id=' . $fotografia->idGaleria);

                
            }
        }
    }

    public static function muestraFotografia(){
        isAdminOrFoto();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $fotografia = Fotografias::find($id);
                $fotografias = Fotografias::arraywhere('idUsuario',$fotografia->idUsuario);
                $numeroMuestras = 0;
                foreach ($fotografias as $foto){
                    if($foto->muestra === '1'){
                        $numeroMuestras += 1;
                    }
                }
                

                



                    if($fotografia->muestra === '0' && $numeroMuestras <6){
                        $fotografia->muestra = 1;

                        
                    }else{
                        $fotografia->muestra = '0';
                        
                    }



                    $fotografia->guardar();

                

                header('Location:/admin/galerias/galeria?id=' . $fotografia->idGaleria);

                
                


            }


        }

    }

    public static function crearGaleria(Router $router){
        
        isAdmin();

        
        $usuarios = Usuario::consultarSQL('SELECT * FROM pasion.usuarios WHERE fotografo != 1');

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            debuguear($_POST);
            return($_POST);
            
            //$noticia->sincronizar($_POST);
            // $alertas = $noticia->validarNuevaNoticia();

            // if(empty($alertas)){
            //     $noticia->fecha = date('Y-m-d');
            //     $noticia->idUsuario = $_SESSION['id'];
                
            //     //GUARDAR FOTO, SI LA HUBIERA
                

            //     //GUARDAR NOTICIA
                
            //     $resultado = $noticia->guardar();
            //     if($resultado){
            //         Noticia::setAlerta('exito','Nueva noticia generada');
            //         $noticia = new Noticia();
            //     }

            // }
        }

        

        $router->render('admin/galerias/crear', [
            'title' => 'Iriépal es pasión || Crear Galeria',
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);
        
    }

    public static function nuevaGaleria(){
        $galeria = new Galerias();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){      
            $id = s($_POST['id']);
            $usuario = Usuario::find($id);
            if($usuario){
                $galeria->idUsuario = $id;
                $resultado= $galeria->guardar();
                $usuario->fotografo = 1;
                $usuario->guardar();
            }
            
        }
        echo json_encode($usuario);

    }


    public static function eliminarGaleria(){
        isAdmin();

        $id = $_GET['id'];
        if(!(is_numeric($id))){
            GaleriaAutor::setAlerta('error', 'Error en los datos');
            header('Location: /admin/galerias');
            
        }
        $galeria = Galerias::find($id);
        if ($galeria === null){
            GaleriaAutor::setAlerta('error', 'Error en los datos');
            header('Location: /admin/galerias');

            
        }
        $idUser= $galeria->idUsuario;
        $usuario = Usuario::find($idUser);
        $usuario->fotografo = 0;
        $usuario->guardar();
        $galeria->eliminar();
        header('Location: /admin/galerias');
    }

    //***BLOGS ***//

    public static function blogs(Router $router){

        $router->render('admin/blogs', [
            'title' => 'Iriépal es pasión || Administracion Blogs'
            
        ]);
        
    }
    
    public static function elenco(Router $router){

        $router->render('admin/elenco', [
            'title' => 'Iriépal es pasión || Administracion Elenco'
            
        ]);
        
    }

    public static function anteriores(Router $router){

        $router->render('admin/anteriores', [
            'title' => 'Iriépal es pasión || Administracion Ediciones anteriores'
            
        ]);
        
    }
}

