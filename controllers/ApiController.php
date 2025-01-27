<?php

namespace Controllers;

use Model\Fotografias;
use Model\Usuario;

class ApiController{

    public static function getUsuarios(){
        $usuarios = Usuario::all();
        echo json_encode($usuarios);

        
    }

    public static function getFotos(){
        $inicio = s($_POST['inicio']);
        $registros = s($_POST['registros']);

        $fotografias = Fotografias::paginar($registros,$inicio);
        foreach ($fotografias as $fotografia){
            $usuario = Usuario::find($fotografia->idUsuario);
            $nombreCarpeta = nameCarpet($usuario->nombre, $usuario->apellidos);
            $fotografia->carpeta = '/' . CARPETA_IMAGENES_INDEX . '/' . $nombreCarpeta.'/'.$fotografia->ruta;
        }

        echo json_encode(($fotografias));

    }

    public static function getTotalFotos(){
        $fotosTotales = Fotografias::total();
        echo json_encode($fotosTotales);
    }


    public static function findUsuarios(){
        $cadena = s($_POST['cadena']);

        $consulta = "SELECT * FROM pasion.usuarios";
        $consulta .= " WHERE nombre LIKE ('%${cadena}%')";
        $consulta .= " OR apellidos LIKE ('%${cadena}%')";
        $consulta.= " OR email LIKE ('%${cadena}%')";
        $consulta.= " OR CONCAT(nombre, ' ', apellidos) LIKE ('%${cadena}%')";

        $usuarios = Usuario::SQL($consulta);
        echo json_encode($usuarios);

        
    }

    public static function getUsuariosNoFoto(){
        $usuarios = Usuario::consultarSQL("SELECT id, concat(nombre,' ', apellidos) as nombre FROM pasion.usuarios WHERE fotografo != 1;");
        echo json_encode($usuarios);

        
    }

    public static function findUsuariosNoFoto(){
        
        $cadena = s($_POST['cadena']);

        $consulta = "SELECT * FROM pasion.usuarios";
        $consulta .= " WHERE fotografo != 1 AND";
        $consulta .= " (nombre LIKE ('%${cadena}%')";
        $consulta .= " OR apellidos LIKE ('%${cadena}%'))";
        // $consulta.= " OR email LIKE ('%${cadena}%')";
        // $consulta.= " OR CONCAT(nombre, ' ', apellidos) LIKE ('%${cadena}%')";

        $usuarios = Usuario::SQL($consulta);
        echo json_encode($usuarios);
        // debuguear($usuarios);

        
    }
    
}

