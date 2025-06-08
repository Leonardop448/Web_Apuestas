<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$fecha_actual = date("d-m-Y h:i:s");
 
$mail = new PHPMailer(true);                              
try {
   // $mail->SMTPDebug = 4;                               // Habilitar el debug
 
    $mail->isSMTP();                                      // Usar SMTP
    $mail->Host = 'mail.bealri.com';  // Especificar el servidor SMTP reemplazando por el nombre del servidor donde esta alojada su cuenta
    $mail->SMTPAuth = true;                               // Habilitar autenticacion SMTP
    $mail->Username = 'correoenvio@correo.com';                 // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
    $mail->Password = 'contraseña';                           // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
    $mail->SMTPSecure = 'ssl';                            // Habilitar encriptacion
    $mail->Port = 465;                                    // Puerto SMTP                     
    $mail->Timeout       =   30;
    $mail->AuthType = 'LOGIN';
 
    //Recipients   
 
    $mail->setFrom('contacto@bealri.com','Beimar Alarcon');     //Direccion de correo remitente (DEBE SER EL MISMO "Username")
    $mail->addAddress('alarconbeimar@gmail.com');     // Agregar el destinatario
    $mail->addReplyTo('contacto@bealri.com');     //Direccion de correo para respuestas     
 
    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'hola '.$nombre." ". $fecha_actual;
    $mail->Body    = 'Mensaje enviado con el pdf '.$fecha_actual;
	
	// Adjuntar el archivo PDF
   
    $mail->addAttachment($pdfFile); // Adjunta el PDF
	
	
     
    $mail->send();
    echo 'El mensaje ha sido enviado'.'<br>';
	// eliminar el archivo del servidor pdf 
	if (file_exists($pdfFile)) {
    unlink($pdfFile);
    echo "El archivo PDF se ha eliminado del servidor.";
}
 
} catch (Exception $e) {
    echo 'El mensaje no pudo ser enviado. Mailer Error: ', $mail->ErrorInfo;
}