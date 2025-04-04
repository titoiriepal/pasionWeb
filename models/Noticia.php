<?php

namespace Model;


class Noticia extends ActiveRecord{


    protected static $tabla = 'noticias';
    protected static $columnasDB = ['id', 'titulo', 'resumen', 'cuerpo', 'fecha', 'idUsuario', 'idFoto','link'];

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
        $this->idFoto = $args['idFoto'] ?? '';
        $this->link = $args['link'] ?? '';

    }

    public function validarNuevaNoticia(){
        
        if(!$this->titulo){
            self::$alertas['error'][] = 'Es obligatorio introducir el titulo';           
        }else if(strlen($this->titulo)>= 60){
            self::$alertas['error'][] = 'El título de la noticia es demasiado largo'; 
        }
        if(!$this->resumen){
            self::$alertas['error'][] = 'Es obligatorio introducir un resumen de la noticia';
        }else if(strlen($this->resumen)<50){
            self::$alertas['error'][] = 'El resumen de la noticia debe contener, al menos, 50 caracteres.';
        }else if(strlen($this->resumen)>= 300){
            self::$alertas['error'][] = 'El resumen de la noticia es demasiado largo'; 
        }
        if(!$this->cuerpo){
            self::$alertas['error'][] = 'Es obligatorio introducir Un cuerpo de la noticia';
        }else if(strlen($this->cuerpo)>= 10000){
            self::$alertas['error'][] = 'El cuerpo de la noticia es demasiado largo'; 
        }
        if(!$this->idFoto){
            self::$alertas['error'][] = 'No has elegido una fotografía para la noticia';
        }

        if(strlen($this->link)>= 500){
            self::$alertas['error'][] = 'El enlace proporcionado es demasiado largo'; 
        }


        return self::$alertas;
    }

}

