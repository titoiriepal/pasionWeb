<?php

namespace Model;


class Usuario extends ActiveRecord{
    //Base de datos

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellidos', 'email', 'admin', 'blog', 'fotografo', 'restringido', 'fechaCreacion', 'confirmado', 'token', 'password'];


    public $id;
    public $nombre;
    public $apellidos;
    public $email;
    public $admin;
    public $blog;
    public $fotografo;
    public $restringido;
    public $fechaCreacion;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($args= []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->blog = $args['blog'] ?? '0';
        $this->fotografo = $args['fotografo'] ?? '0';
        $this->restringido = $args['restringido'] ?? '0';
        $this->fechaCreacion = $args['fechaCreacion'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }


    // Mensajes de validacion para la creación de una cuenta

    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'Es obligatorio introducir el nombre';
        }
        if(!$this->apellidos){
            self::$alertas['error'][] = 'Es obligatorio introducir los apellidos';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'Es obligatorio introducir el E-mail';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Es obligatorio introducir el password';
        }else{
            if(strlen($this->password) < 8){
                self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
            }else{
                if($this->password != $_POST['password2']){
                    self::$alertas['error'][] = 'Los passwords introducidos no coinciden';
                }
            }
        }
        return self::$alertas;
    }


    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'Debes introducir un email de usuario';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Es obligatorio introducir el password';
        }
        

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'Debes introducir un email de usuario';
        }
        

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'Debes introducir un password';
        }else{
            if(strlen($this->password) < 8){
                self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
            }
        }
        

        return self::$alertas;
    }

    //Revisa si el email ya está registrado en la BBDD
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query); 
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya está registrado';
        }

        return $resultado;
    }


    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function ponerFecha(){
        $this->fechaCreacion = date('Y-m-d');
    }
    
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Password incorrecto o cuenta no confirmada';
        }else{
            
            return true;
            
        }
    }
}