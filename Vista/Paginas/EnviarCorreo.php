<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpMailer/Exception.php';
require_once __DIR__ . '/phpMailer/PHPMailer.php';
require_once __DIR__ . '/phpMailer/SMTP.php';

class EnviarCorreo
{
    static public function enviarActivacion($nombre, $email, $token)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'mail.pulcast.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contacto@pulcast.com';
            $mail->Password = 'Isabella1812';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('contacto@pulcast.com', 'RaceStake Pro');
            $mail->addAddress($email, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Activa tu cuenta en RaceStake Pro';
            $mail->Body = '
                <h3>Hola ' . htmlentities($nombre ?? '') . ',</h3>
                <p>Gracias por registrarte en <strong>RaceStake Pro</strong>.</p>
                <p>Haz clic en el siguiente enlace para activar tu cuenta:</p>
                <p><a href="http://www.pulcast.com/index.php?pagina=ActivarCuenta&token=' . $token . '">Activar cuenta</a></p>
                <br><p>Si no creaste esta cuenta, puedes ignorar este correo.</p>';

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
        }
    }
}