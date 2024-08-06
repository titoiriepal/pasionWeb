<?php

define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes');
define('CARPETA_IMAGENES_INDEX', 'imagenes' );



function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}


function isAdmin(){
    if($_SESSION['admin'] != 1){
        header('Location: /');
    }
}

function isAdminOrFoto(){
    if($_SESSION['admin'] != 1 && $_SESSION['fotografo'] != 1){
        header('Location: /');
    }
}


function msgAlert($mensaje){
    echo '<script>alert(' . $mensaje .')</script>';
}


function nameCarpet($nombre, $apellidos){
    $nombre = strtolower(str_replace(' ', '', $nombre));
    $apellidos = str_replace(' ', '',$apellidos);

    $resultado = $nombre . $apellidos;

    return $resultado;

}