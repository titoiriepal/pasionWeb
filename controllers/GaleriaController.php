<?php

namespace Controllers;

use Classes\Paginacion;
use GuzzleHttp\Psr7\Request;
use Model\Fotografias;
use Model\Galerias;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class GaleriaController{

    public static function galerias(Router $router){

        
        isAdminOrFoto();//Solo pueden acceder administradores o fotografos
        $alertas=[];

        if ($_SESSION['admin'] != 1){ //Si el que accede no es un administrador el usuario es redirigido a su galería
            
            $galeria = Galerias::where('idUsuario', $_SESSION['id']);         
            header('Location:/admin/galerias/galeria?id=' . $galeria->id);

        }else{
            //Paginacion
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
 
            $registros_por_pagina = 10;
            $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros);

            if($paginacion->total_paginas() < $pagina_actual){
                header('Location: /admin/galerias?page=1');
                $pagina_actual = 1;
            }

            $galerias = Galerias::paginar($registros_por_pagina, $paginacion->offset()," ");

            //Incluimos los datos del usuario en cada registro
            foreach ($galerias as $galeria){
                $galeria->usuario = Usuario::find($galeria->idUsuario);//Añadimos a cada galería los datos de su usuario
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

        if ($_SESSION['admin'] != 1 && $galeria->idUsuario != $_SESSION['id'] ){ //Si el que accede no es un administrador o el dueño de la galeria el usuario es redirigido a su galería
            
            $galeria = Galerias::where('idUsuario', $_SESSION['id']);         
            header('Location:/admin');

       }
        $usuario = Usuario::find($galeria->idUsuario);
        $fotografias = Fotografias::arraywhere('idUsuario',$galeria->idUsuario);//Creamos un array con las fotografías del usuario en cuestion
        
        //formamos el nombre de la carpeta donde se alojan las fotografías de dicho Usuario
        $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
        $carpetaUsuario = CARPETA_IMAGENES . '/' . $nombreCarpeta . '/' ;
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            foreach ($_FILES['foto']['tmp_name'] as $fotoFile){//Para cada fotografía que subamos desde la web
                
                $numFotografias = count($fotografias);
                if($numFotografias >= 50){//Si el usuario ya tiene 50 fotografías en su galería, debe borrar alguna para continuarl

                    $alertas['error'][]='Excedes el numero de Fotografias. Por favor borra alguna antes de continuar';
                    break;

                }else{

                    $fotografia = new Fotografias($_POST['fotografias']);
                    $fotografia->fecha = date('Y');//Guardamos el año de la fotografía

                    $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";//Generamos un nombre único para la foto
                    
                    if($fotoFile){

                        list($ancho, $alto, $tipo, $atributos) = getimagesize($fotoFile); //Conseguimos los atributos de la fotografía de su archivo
                        
                        if($alto >= $ancho){ //Comprobamos si la fotografía es más alta que ancha y ajustamos sus valores a unos predeterminados
                            $image = Image::make($fotoFile)->fit(600,800); 
                        }else{
                            $image = Image::make($fotoFile)->fit(800,600);
                        }
                        
                        $fotografia->setRuta($nombreImagen);//Establecemos la ruta donde se va a guardar la fotografía

                        if(!is_dir(CARPETA_IMAGENES)){//Comprobamos que exista el directorio de imagenes. La primera vez lo creará automáticamente
                            mkdir(CARPETA_IMAGENES);
                        }

                        if(!is_dir($carpetaUsuario)){//Comprobamos que exista la carpeta de las imagenes del usuario. Si no existe,m la creamos
                            mkdir($carpetaUsuario);
                        }

                        $image->save($carpetaUsuario . $nombreImagen);//Guardamos el archivo fotográfico en su carpeta

                        $fotografia->guardar();//Guardamos el registro en la BD

                        $fotografias = Fotografias::arraywhere('idUsuario',$galeria->idUsuario);//Obtenemos las fotografías del usuario, ya actualizadas para mostrarlas en pantalla

                        $alertas['exito'][]='Fotografía(s) guardada correctamente';//Mandamos el mensaje de exito
                    }   
                }
            }
             
        }

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
        isAdminOrFoto(); //Solo administradores o fotografos pueden eliminar la fotografia
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

    public static function muestraFotografia(){ //Establece una fotografía como muestra para la galería fotográfica de la página principal. Solo se pueden establecer 6 fotografías como muestras
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

    public static function crearGaleria(Router $router){ //Muestra la pagina para crear nuevas galerías
        
        isAdmin();
        // debuguear($_POST);
        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/galerias/crear?page=1');
            $pagina_actual = 1;
        }

        //Contamos todos los registros que existen de Usuarios y creamos la paginación
        $total_registros = Usuario::totalQuery(['fotografo' => 0]);
        $registros_por_pagina = 20;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/galerias/crear?page=1');
            $pagina_actual = 1;
        }

        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset(),Usuario::selectWhereArray(['fotografo' => 0]), $orden);
        

        if(!$usuarios)
        {
            header('Location: /admin');
            exit;
        }
 
        // $usuarios = Usuario::consultarSQL('SELECT * FROM pasion.usuarios WHERE fotografo = 0');

        $alertas = [];
 

        $router->render('admin/galerias/crear', [
            'title' => 'Iriépal es pasión || Crear Galeria',
            'usuarios' => $usuarios,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
        ]);
        
    }

    public static function buscaCrearGaleria(Router $router){
        isAdmin();
        // debuguear($_POST);
        $pagina_actual = $_GET['page'];
        $orden = $_GET['order'] ?? 'id';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Comprobamos que exista la página enviada o que no sea menor que uno. Redirigimos a la primera página
        if(!$pagina_actual  || $pagina_actual < 1){
            header('Location: /admin/galerias/busquedaCrear?busqueda='. $_GET["busqueda"] .'&page=1');
            $pagina_actual = 1;
        }

        $total_registros = Usuario::totalQuery(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]);

        $registros_por_pagina = 20;
        $paginacion = new Paginacion($pagina_actual,$registros_por_pagina,$total_registros, $orden);

        //Si la página actual es mayor al número de páginas totales, redirigimos a la primera página
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/galerias/busquedaCrear?busqueda='. $_GET["busqueda"] .'&page=1');
            $pagina_actual = 1;
        }

        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset(),Usuario::selectWhereArray(['nombre' => $_GET["busqueda"],'apellidos' => $_GET["busqueda"],'email' => $_GET["busqueda"],'CONCAT(nombre, " ", apellidos)' => $_GET["busqueda"]]), $orden);

        //Si no hay resultados de busqueda redirigimos a la página de Crear
        if(!$usuarios)
        {
            header('Location: /admin/galerias/crear?page=1');
            exit;
        }

        $alertas = [];
 

        $router->render('admin/galerias/crear', [
            'title' => 'Iriépal es pasión || Crear Galeria',
            'usuarios' => $usuarios,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
        ]);



    }

    public static function nuevaGaleria(){ //Crea una nueva galería y devuelve el usuario para el que se creo la galería
        isAdmin();
        $galeria = new Galerias();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){     
            $id = s($_POST['id']);
            $usuario = Usuario::find($id);
            if($usuario){
                $galeria->idUsuario = $id;
                $galeria->textAlt = 'Fotografia de ' . $usuario->nombre . ' ' . $usuario->apellidos;
                $galeria->oculto = 0;
                $resultado= $galeria->guardar();
                $usuario->fotografo = 1;
                $usuario->guardar();
            }
            
        }
        echo json_encode($usuario);

    }

    public static function textoAlt(){ //Crea una nueva galería y devuelve el usuario para el que se creo la galería
        isAdminOrFoto();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){     
            $id = s($_POST['id']);
            $texto = s($_POST['texto']);
            $foto = Fotografias::find($id);
            if($foto){
                $foto->textAlt = $texto;
                $foto->guardar();
            }
            
        }
        echo json_encode($foto);

    }


    public static function eliminarGaleria(){
        isAdmin();

        $id = $_GET['id'];
        if(!(is_numeric($id))){
            Galerias::setAlerta('error', 'Error en los datos');
            header('Location: /admin/galerias');
            
        }
        $galeria = Galerias::find($id);
        if ($galeria === null){
            Galerias::setAlerta('error', 'Error en los datos');
            header('Location: /admin/galerias');

            
        }
        $idUser= $galeria->idUsuario;
        $usuario = Usuario::find($idUser);
        $usuario->fotografo = 0;
        $usuario->guardar();
        $galeria->eliminar();
        header('Location: /admin/galerias');
    }

}