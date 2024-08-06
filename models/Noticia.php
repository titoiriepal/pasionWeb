<?php

namespace Model;


class Noticia extends ActiveRecord{


    protected static $tabla = 'noticias';
    protected static $columnasDB = ['id', 'titulo', 'resumen', 'cuerpo', 'fecha', 'idUsuario', 'idFoto'];

    public $id;
    public $titulo;
    public $resumen;
    public $cuerpo;
    public $fecha;
    public $idUsuario;
    public $idFoto;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->resumen = $args['resumen'] ?? '';
        $this->cuerpo = $args['cuerpo'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->idFoto = $args['idFoto'] ?? '41';
    }

    public function validarNuevaNoticia(){
        
        if(!$this->titulo){
            self::$alertas['error'][] = 'Es obligatorio introducir el titulo';
        }
        if(!$this->resumen){
            self::$alertas['error'][] = 'Es obligatorio introducir un resumen de la noticia';
        }else if(strlen($this->resumen)<50){
            self::$alertas['error'][] = 'El resumen de la noticia debe contener, al menos, 50 caracteres.';
        }
        if(!$this->cuerpo){
            self::$alertas['error'][] = 'Es obligatorio introducir Un cuerpo de la noticia';
        }

        return self::$alertas;
    }

}