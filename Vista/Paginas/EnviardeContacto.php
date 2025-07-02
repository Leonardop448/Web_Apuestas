<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpMailer/Exception.php';
require_once __DIR__ . '/phpMailer/PHPMailer.php';
require_once __DIR__ . '/phpMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $asunto = htmlspecialchars($_POST["asunto"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'mail.pulcast.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@pulcast.com';           // ✅ Tu correo Gmail
        $mail->Password = 'Isabella1812';               // ✅ Contraseña de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Remitente (de tu parte) y destinatario (admin del sitio)
        $mail->setFrom('contacto@pulcast.com', 'Formulario Web de Carreras');
        $mail->addAddress('contacto@pulcast.com', 'Administrador del sitio'); // ✅ Correo del admin
        $mail->addReplyTo($email, $nombre); // Permite responderle al visitante

        // Contenido del mensaje
        $mail->isHTML(true);
        $mail->Subject = "Formulario de Contacto: $asunto";
        $mail->Body = "
            <h2>Nuevo mensaje desde tu sitio web</h2>
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Correo:</strong> $email</p>
            <p><strong>Asunto:</strong> $asunto</p>
            <p><strong>Mensaje:</strong><br>$mensaje</p>
        ";

        $mail->send();



        // ✅ Mensaje enviado: alerta y redirección
        echo "<script>
            alert('✅ Tu mensaje ha sido enviado correctamente.');
            window.location.href = '../../index.php?pagina=Inicio';  // 🔁 Cambia aquí a donde quieras redirigir
        </script>";
    } catch (Exception $e) {
        // ❌ Error al enviar: alerta con descripción y redirección
        echo "<script>
            alert('❌ Error al enviar el mensaje: " . addslashes($mail->ErrorInfo) . "');
            window.location.href = '../../index.php?pagina=Inicio';  // 🔁 Cambia aquí también si deseas otro destino
        </script>";
        exit;
    }
}
?>