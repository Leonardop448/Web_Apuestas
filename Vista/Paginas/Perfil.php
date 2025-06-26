<?php
if (!isset($_SESSION['email'])) {
    header("Location: index.php?pagina=Login");
    exit;
}
?>

<title>Perfil</title>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Perfil del Usuario</h2>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Nombre:</div>
                        <div class="col-12 text-break"><?= $_SESSION['nombre']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Cédula:</div>
                        <div class="col-12 text-break"><?= $_SESSION['cedula']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Teléfono:</div>
                        <div class="col-12 text-break"><?= $_SESSION['telefono']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Correo Electrónico:</div>
                        <div class="col-12 text-break"><?= $_SESSION['email']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Fecha de Registro:</div>
                        <div class="col-12 text-break">
                            <?= $_SESSION['fecha_registro'] ?? "No disponible"; ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 fw-bold">Saldo Actual:</div>
                        <div class="col-12 text-success fw-bold">
                            <?= '$' . number_format(FormularioControlador::obtenerSaldoUsuario($_SESSION['id'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>