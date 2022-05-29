<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarInstrucciones(){

        //Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7c9488e49c4f96';
        $mail->Password = '84f7f866fa2635';

        $mail->setFrom('cuentas@iriepalespasion.com');
        $mail->addAddress($this->email, 'IriepalEsPasion.com');
        $mail->Subject = 'Reestablece tu contraseña';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña en Pasion Viviente de Iriépal, solo debes hacerlo en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:33333/auth/recuperar?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si tú no solicitaste esta cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();


        }

    public function enviarConfirmacion(){

        //Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7c9488e49c4f96';
        $mail->Password = '84f7f866fa2635';

        $mail->setFrom('cuentas@iriepalespasion.com');
        $mail->addAddress($this->email, 'IriepalEsPasion.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Pasion Viviente de Iriépal, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:33333/auth/confirmar-cuenta?token=" . $this->token . "'>Confirmar tu cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();


    }
}