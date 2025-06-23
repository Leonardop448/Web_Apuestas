<?php
// Asegúrate de que la sesión está activa
if (!isset($_SESSION['email'])) {
    header("Location: index.php?pagina=Login");
    exit;
}
?>

<div class="container mt-5">
    <div class="card bg-dark text-white shadow-lg rounded-4">
        <div class="card-header bg-warning text-dark text-center">
            <h2 class="fw-bold">Perfil del Usuario</h2>
        </div>
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Nombre:</div>
                <div class="col-sm-8"><?php echo $_SESSION['nombre']; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Cédula:</div>
                <div class="col-sm-8"><?php echo $_SESSION['cedula']; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Teléfono:</div>
                <div class="col-sm-8"><?php echo $_SESSION['telefono']; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Correo Electrónico:</div>
                <div class="col-sm-8"><?php echo $_SESSION['email']; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Fecha de Registro:</div>
                <div class="col-sm-8">
                    <?php
                    echo isset($_SESSION['fecha_registro']) ? $_SESSION['fecha_registro'] : "No disponible";
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold">Saldo Actual:</div>
                <div class="col-sm-8">
                    <strong class="text-success">
                        $<?php echo number_format($_SESSION['saldo'] ?? 0); ?>
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>