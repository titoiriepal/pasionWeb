<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{

    public static function login(Router $router) {

        $auth = new Usuario();

        $alertas=[];

        if($_SERVER ['REQUEST_METHOD'] === 'POST'){
            
            //Validar campos del login
            $auth->sincronizar($_POST);
            $alertas = $auth->validarLogin();

            //Si los campos están rellenos
            if(empty($alertas)){

                //Verificamos que existe el usuario
                
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){
                    //Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //Autenticar el usuario
                        session_destroy();
                        session_start();
                        if($usuario->restringido === '1'){
                            Usuario::setAlerta('error', 'Usuario restringido temporalmente');
                            $_SESSION = [];
                            session_destroy();
                            
                        }else{
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellidos;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['admin'] = $usuario->admin;
                            $_SESSION['blog'] = $usuario->blog;
                            $_SESSION['fotografo'] = $usuario->fotografo;
                            $_SESSION['login'] = true;
                            header('Location: /');
                        }
                        
                    
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');

                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'title' => 'Iriépal es pasión || Iniciar Sesion',
            'alertas' => $alertas,
            'auth' => $auth
        ]);


    }



    public static function crear(Router $router) {

        $usuario = New Usuario();
        

        //Alertas vacias

        $alertas = [];

        if($_SERVER ['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            //Revisamos que no haya alertas

            if(empty($alertas)){
                
                //Verificar que el mail no esté ya registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();

                }else{
                    // El usuario no está registrado

                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un token único
                    $usuario->crearToken();
                    $usuario->ponerFecha();

                    //Enviar el Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado =$usuario->guardar();
                    if($resultado) {
                        header('Location: /auth/mensaje');
                    }


                    
                }
            }


            
            
            //debuguear($_POST);



        }
        $router->render('auth/crear', [

            'title' => 'Iriépal es pasión || Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }



    public static function olvide(Router $router) {
        $alertas=[];

        if($_SERVER ['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas= $auth->validarEmail();

            if(empty($alertas)){
                //Verificar que el email existe y que el usuario está confirmado
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario && $usuario->confirmado === "1"){
                    
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar el mail
                                        
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

        
                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Hemos enviado un correo con el enlace para resetear la contraseña');

                }else{

                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                }

            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'title' => 'Iriépal es pasión || Olvide mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router) {
        $_SESSION = [];

        

        header('Location: /');
    }
    
    
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'title' => 'Iriépal es pasión || Usuario Creado'
        ]);
    }

    public static function mensajePassword(Router $router) {
        $router->render('auth/mensaje-password', [
            'title' => 'Iriépal es pasión || Contraseña cambiada'
        ]);
    }


    public static function confirmar(Router $router) {
        $alertas = [];

        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no valido');
        }else{
            //Modificar a usuario confirmado
            $usuario->confirmado = "1"; 
            $usuario->token = null; 
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta activada correctamente');

        }
        
        //Obtener alertas
        $alertas = Usuario::getAlertas();


        $router->render('auth/confirmar', [
            'title' => 'Iriépal es pasión || Confirmar Usuario',
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no valido');
            $error = true;
        }

        if($_SERVER ['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)){
                if($password->password != $_POST['password2']){
                    Usuario::setAlerta('error', 'Los passwords no coinciden');
                }else{
                    $usuario->password = $password->password;
                    $usuario->hashPassword();
                    $usuario->token = null;
                    $resultado =$usuario->guardar();
                    if($resultado) {
                        header('Location: /auth/mensaje-password');
                    }
                }
            }

        }
        
        //Obtener alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'title' => 'Iriépal es pasión || Reestablecer contraseña',
            'alertas' => $alertas,
            'error' => $error
        ]);


    }
}