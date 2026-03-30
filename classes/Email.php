<?php

namespace Classes;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    private function configurarMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = (int) $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPAutoTLS = true;

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        $mail->setFrom('administracion@iriepalpasion.com', 'Pasión Viviente de Iriépal');


        return $mail;
    }

    public function enviarInstrucciones(): bool
    {
        try {
            $mail = $this->configurarMailer();

            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Reestablece tu contraseña';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8') . "</strong>, has solicitado reestablecer tu contraseña en Pasión Viviente de Iriépal.</p>";
            $contenido .= "<p>Pulsa aquí: <a href='" . $_ENV['HOST'] . "/auth/recuperar?token=" . urlencode($this->token) . "'>Reestablecer contraseña</a></p>";
            $contenido .= "<p>Si tú no solicitaste este cambio, puedes ignorar este mensaje.</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;


            return $mail->send();
        } catch (Exception $e) {
            error_log('Error enviando email de recuperación: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function enviarConfirmacion(): bool
    {
        try {
            $mail = $this->configurarMailer();

            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Confirma tu cuenta';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8') . "</strong>, has creado tu cuenta en Pasión Viviente de Iriépal.</p>";
            $contenido .= "<p>Pulsa aquí: <a href='" . $_ENV['HOST'] . "/auth/confirmar-cuenta?token=" . urlencode($this->token) . "'>Confirmar tu cuenta</a></p>";
            $contenido .= "<p>Si tú no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            return $mail->send();
        } catch (Exception $e) {
            error_log('Error enviando email de confirmación: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
