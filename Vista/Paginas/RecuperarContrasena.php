<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $usuario = ModeloFormularios::verificarUsuarios([$email]);

    // Mensaje genérico para seguridad
    $mensaje = "<div class='alert alert-success text-center'>Si el correo está registrado, se enviará un enlace de recuperación.</div>";

    if ($usuario) {
        $token = bin2hex(random_bytes(32));
        $expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token y expiración en la base de datos
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        $stmt = $pdo->prepare("UPDATE usuarios SET token_recuperacion = :token, token_expiracion = :expira WHERE email = :email");
        $stmt->execute([
            ":token" => $token,
            ":expira" => $expiracion,
            ":email" => $email
        ]);

        $enlace = "https://pulcast.com/index.php?pagina=ReestablecerContrasena&token=" . urlencode($token);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'mail.pulcast.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contacto@pulcast.com';
            $mail->Password = 'Isabella1812';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('contacto@pulcast.com', 'RaceStake Pro');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = "Hola,<br><br>Haz clic en el siguiente enlace para cambiar tu contraseña:<br><a href='$enlace'>$enlace</a><br><br>Este enlace expirará en 1 hora.";

            $mail->send();
        } catch (Exception $e) {
            // Error silencioso para evitar pistas al atacante
        }
    }
}
?>

<!-- Estilo del formulario -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Recuperar Contraseña</h2>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control text-center" required
                                placeholder="Ingresa tu correo">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-warning fw-bold px-4" type="submit">Enviar enlace</button>
                        </div>
                    </form>

                    <!-- Mensaje de confirmación o error -->
                    <?= $mensaje ?>
                </div>
            </div>
        </div>
    </div>
</div>