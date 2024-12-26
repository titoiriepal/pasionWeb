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
        $this->estado = $args['estado'] ?? 1 ;
    }

    public function validarNuevoBlog(){
        
        if(!$this->titulo){
            self::$alertas['error'][] = 'Es obligatorio introducir el titulo';           
        }else if(strlen($this->titulo)>= 100){
            self::$alertas['error'][] = 'El título del blog es demasiado largo'; 
        }

        if(!$this->cuerpo){
            self::$alertas['error'][] = 'Es obligatorio introducir Un cuerpo del blog';
        }else if(strlen($this->cuerpo)>= 100000){
            self::$alertas['error'][] = 'El cuerpo de la noticia es demasiado largo'; 
        }
        if(!$this->idFoto){
            self::$alertas['error'][] = 'No has elegido una fotografía para la noticia';
        }


        return self::$alertas;
    }
}

