<?php

namespace Model;


class Blog extends ActiveRecord{


    protected static $tabla = 'blogs';
    protected static $columnasDB = ['id', 'titulo', 'cuerpo', 'fecha', 'idUsuario', 'idFoto','estado'];

    public $id;
    public $titulo;
    public $cuerpo;
    public $fecha;
    public $idUsuario;
    public $idFoto;
    public $estado;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->resumen = $args['resumen'] ?? '';
        $this->cuerpo = $args['cuerpo'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->idFoto = $args['idFoto'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

}

