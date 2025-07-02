<?php
$mensaje = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validar que el token exista y no esté vencido
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token_recuperacion = :token AND token_expiracion > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva = $_POST['nueva_contrasena'];
            $confirmar = $_POST['confirmar_contrasena'];

            if ($nueva !== $confirmar) {
                $mensaje = "<div class='alert alert-danger text-center'>Las contraseñas no coinciden.</div>";
            } elseif (strlen($nueva) < 6) {
                $mensaje = "<div class='alert alert-warning text-center'>La contraseña debe tener al menos 6 caracteres.</div>";
            } else {
                $hashed = password_hash($nueva, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE usuarios SET contrasena = :contrasena, token_recuperacion = NULL, token_expiracion = NULL WHERE token_recuperacion = :token");
                $stmt->bindParam(":contrasena", $hashed);
                $stmt->bindParam(":token", $token);

                if ($stmt->execute()) {
                    $mensaje = "<div class='alert alert-success text-center'>Contraseña actualizada correctamente. <a href='index.php?pagina=Ingreso'>Inicia sesión</a>.</div>";
                } else {
                    $mensaje = "<div class='alert alert-danger text-center'>Error al actualizar la contraseña.</div>";
                }
            }
        }
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>El enlace no es válido o ha expirado.</div>";
    }
} else {
    $mensaje = "<div class='alert alert-danger text-center'>Token inválido.</div>";
}
?>

<!-- Diseño de formulario con confirmación -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Cambiar Contraseña</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($usuario) && $usuario): ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nueva Contraseña</label>
                                <input type="password" name="nueva_contrasena" class="form-control text-center" required
                                    minlength="6" placeholder="Mínimo 6 caracteres">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirmar Contraseña</label>
                                <input type="password" name="confirmar_contrasena" class="form-control text-center" required
                                    placeholder="Confirma la contraseña">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-warning fw-bold px-4" type="submit">Actualizar Contraseña</button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <?= $mensaje ?>
                </div>
            </div>
        </div>
    </div>
</div>