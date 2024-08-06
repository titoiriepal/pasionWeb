<?php

namespace Model;


class NoticiaAutor extends ActiveRecord{


    protected static $tabla = 'noticiaautor';
    protected static $columnasDB = ['id', 'titulo', 'resumen', 'fecha', 'idUsuario', 'autor'];

    public $id;
    public $titulo;
    public $resumen;
    public $fecha;
    public $idUsuario;
    public $autor;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->resumen = $args['resumen'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->autor = $args['autor'] ?? '';
    }

}