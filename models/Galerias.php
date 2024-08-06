<?php

namespace Model;


class Galerias extends ActiveRecord{

    protected static $tabla = 'galerias';
    protected static $columnasDB = ['id', 'idUsuario'];

    public $id;
    public $idUsuario;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        
    }


}