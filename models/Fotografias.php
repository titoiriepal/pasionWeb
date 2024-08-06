<?php

namespace Model;


class Fotografias extends ActiveRecord{


    protected static $tabla = 'fotografias';
    protected static $columnasDB = ['id', 'ruta', 'fecha', 'muestra', 'idGaleria', 'idUsuario'];

    public $id;
    public $ruta;
    public $fecha;
    public $muestra;
    public $idGaleria;
    public $idUsuario;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->ruta = $args['ruta'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->muestra = $args['muestra'] ?? '0';
        $this->idGaleria = $args['idGaleria'] ?? '';
        $this->idUsuario = $args['idUsuario'] ?? '';
        
    }

    public static function arrayMuestras($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE ${columna} = '${valor}' and muestra = 1";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    public static function findXFromToWhitId($columna, $principio, $cantidad, $idGaleria) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $columna . " > " . $principio . " AND idGaleria = " . $idGaleria ." LIMIT " . $cantidad; 
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}