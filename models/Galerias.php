<?php

namespace Model;


class Galerias extends ActiveRecord{

    protected static $tabla = 'galerias';
    protected static $columnasDB = ['id', 'idUsuario', 'oculto','textAlt'];

    public $id;
    public $idUsuario;
    public $textAlt;
    public $oculto;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        $textAlt->$args['textAlt'] ?? '';
        $oculto->$args['oculto'] ?? 0;
        
    }


}