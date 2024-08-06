<?php

namespace Model;


class GaleriaAutor extends ActiveRecord{

    protected static $tabla = 'galeriaautor';
    protected static $columnasDB = ['id', 'idUsuario', 'autor'];

    public $id;
    public $idUsuario;
    public $autor;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->autor = $args['autor'] ?? '';
        
    }


}