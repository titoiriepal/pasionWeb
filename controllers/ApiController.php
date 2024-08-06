<?php

namespace Controllers;

use Model\Usuario;

class ApiController{

    public static function getUsuarios(){
        $usuarios = Usuario::all();
        echo json_encode($usuarios);

        
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

