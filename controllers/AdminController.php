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


    //***USUARIOS ***//

    public static function usuarios(Router $router){

        isAdmin();
        //Validamos los parametros del get
        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/usuarios?page=1');
            $pagina_actual = 1;
        }

        //Contamos todos los registros que existen de Usuarios y creamos la paginación
        $total_registros = Usuario::total();
        $registros_por_pagina = 5;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/usuarios?page=1');
            $pagina_actual = 1;
        }

        //Traemos los registros de los usuarios de la página establecida
        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset()," ", $orden);

        //Renderizar
        $router->render('admin/usuarios', [
            'title' => 'Iriépal es pasión || Administracion Usuarios',
            'usuarios' => $usuarios,
            'paginacion' => $paginacion->paginacion()
                    
        ]);
        
    }

    public static function buscaUsuario (Router $router){


        isAdmin(); //Solo para administradores
        $pagina_actual = $_GET['page'];//Número de pagina a mostrar
        $orden = $_GET['order'] ?? 'id';//Si hay que ordenar la busqueda por algún parmetro. Si no se ordenará por id
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT); //Comprobar si el número de página introducido es un número 

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/buscausuario?busqueda='. $_GET["busqueda"] .'&page=1');
            $pagina_actual = 1;
        }

        //Nos devuelve el total de usuarios que tenemos según la busqueda
        $total_registros = Usuario::totalQuery(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]);

        $registros_por_pagina = 10; //Número de elementos que muestra cada página

        //Creamos la paginación
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/buscausuario?busqueda='. $_GET["busqueda"] .'&page=1');
            $pagina_actual = 1;
        }

        //Obrtenemos de la BD los registros ordenados que cumplan el parámetro de busqueda
        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset(),Usuario::selectWhereArray(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]), $orden);

        //Si no hay resultados de busqueda redirigimos a la página de Usuarios
        if(!$usuarios)
        {
            header('Location: /admin/usuarios?page=1');
            exit;
        }

        //renderizamos
        $router->render('admin/usuarios', [
            'title' => 'Iriépal es pasión || Administracion Usuarios',
            'usuarios' => $usuarios,
            'paginacion' => $paginacion->paginacion()
                    
        ]);



    }

    public static function actualizarUsuario(Router $router){

        isAdmin();

        
        if(!(empty($_GET))){
            $id = ($_GET['id']);
            $usuario = Usuario::find($id);
        }else{
            header('Location: /admin');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!(isset($_POST['fotografo']))){
                $_POST['fotografo'] = '0';
            }
            if(!(isset($_POST['blog']))){
                $_POST['blog'] = '0';
            }
            if(!(isset($_POST['restringido']))){
                $_POST['restringido'] = '0';
            }
            
            $usuario->sincronizar($_POST);
            $usuario->guardar();
            header('Location: /admin/usuarios');
            
        }
 

        $router->render('admin/usuarios/actualizar', [
            'title' => 'Iriépal es pasión || Actualizacion Usuario',
            'usuario' => $usuario
            
        ]);
        
    }

    public static function eliminarUsuario(){
        isAdmin();

        $id = $_GET['id'];

        if(!(is_numeric($id))){
            header('Location: /admin/usuarios');
        }
        $usuario = Usuario::find($id);
        if($usuario){
            $usuario->eliminar();
            echo json_encode($usuario);
        }else{
            header('Location: /admin/usuarios');
        }
                    
    }


    //***NOTICIAS ***//

    public static function noticias(Router $router){

        isAdmin();
        $alertas=[];

        $noticiaAutor = NoticiaAutor::all();
        
        
        $router->render('admin/noticias', [
            'title' => 'Iriépal es pasión || Administracion Noticias',
            'noticiaAutor' => $noticiaAutor,
            'alertas' => $alertas
            
        ]);
        
    }

    public static function nuevaNoticia(Router $router){

        isAdmin();

        $noticia = new Noticia();
        

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $noticia->sincronizar($_POST);
            $alertas = $noticia->validarNuevaNoticia();

            if(empty($alertas)){
                
                $noticia->fecha = date('Y-m-d');
                $noticia->idUsuario = $_SESSION['id'];
                
                
                $noticia->id = null;
                $resultado = $noticia->guardar();
                
                if($resultado){
                    Noticia::setAlerta('exito','Nueva noticia generada');
                    $noticia = new Noticia();
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

        $id = $_GET['id'];
        if(!(is_numeric($id))){
            header('Location: /admin/noticias');
        }
        $noticia = Noticia::find($id);
        if ($noticia === null){
            header('Location: /admin/noticias');            
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $noticia->sincronizar($_POST);
            $alertas = $noticia->validarNuevaNoticia();
            

            if(empty($alertas)){
                
                //GUARDAR NOTICIA
                
                $resultado = $noticia->guardar();
                if($resultado){
                    Noticia::setAlerta('exito','Noticia actualizada');
                    
                }

            }
        }

        $alertas = Noticia::getAlertas();

        $router->render('admin/noticias/actualizar', [
            'title' => 'Iriépal es pasión || Crear Noticia',
            'noticia' =>$noticia,
            'alertas' =>$alertas
        ]);

    }

    public static function seleccionarFoto(Router $router){
        $pagina = 0;
        $paginaFin = 20;
        $arrayIdUsuarios = [];
        $roots = [];


        $fotografias = Fotografias::findXFromTo('id', $pagina, 20);
        foreach ($fotografias as $fotografia):
            
                if (in_array($fotografia->idUsuario,$arrayIdUsuarios)){

                }else{
                    $arrayIdUsuarios[] = $fotografia->idUsuario;
                    $usuario = Usuario::find($fotografia->idUsuario);
                    $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
                    $roots[] = [$fotografia->idUsuario, $nombreCarpeta];
                    
                }
            
            
        endforeach;
        
        

        

        $router->render('admin/noticias/fotografia', [
            'title' => 'Iriépal es pasión || Seleccionar fotografia',
            'fotografias' => $fotografias,
            'roots' => $roots
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
            header('Location: /admin/noticias');
            
        }

        $noticia->eliminar();
        header('Location: /admin/noticias');
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

