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
    
}

