<?php
if (!isset($_SESSION['privilegios']) || !in_array($_SESSION['privilegios'], ['usuario', 'admin'])) {
    header("Location: index.php?pagina=Login");
    exit();
}

if (isset($_GET['apuesta']) && $_GET['apuesta'] === 'ok') {
    $mensajeApuesta = '¡Apuesta registrada exitosamente!';
    $tipoMensaje = 'success';
}
?>
<?php
if (isset($_POST['monto'], $_POST['tipo_apuesta'], $_POST['id_piloto'], $_POST['id_carrera'])) {
    $id_usuario = $_SESSION['id'];
    $monto = intval($_POST['monto']);
    $tipo = $_POST['tipo_apuesta'];

    $saldoActual = FormularioControlador::obtenerSaldoUsuario($id_usuario);

    if ($monto > $saldoActual) {
        echo '<div class="alert alert-danger mt-3">No tienes suficiente saldo para realizar esta apuesta. Tu saldo es de $' . number_format($saldoActual, 0, ',', '.') . '.</div>';
    } else {
        $ganancia = ($tipo == 'ganador') ? $monto * 2 : $monto * 1.4;

        $resp = FormularioControlador::registrarApuesta($id_usuario, $_POST['id_carrera'], $_POST['id_piloto'], $tipo, $monto, intval($ganancia));

        if ($resp === "ok") {
            // Descontar saldo
            $nuevoSaldo = $saldoActual - $monto;
            $resultadoSaldo = FormularioControlador::actualizarSaldoUsuario($id_usuario, $nuevoSaldo);




            if ($resultadoSaldo === "ok") {
                echo '<script>window.location.href = "index.php?pagina=Apostar&apuesta=ok";</script>';
                exit();
            } else {
                echo '<div class="alert alert-warning mt-3">Apuesta registrada, pero no se pudo actualizar el saldo.</div>';
            }
        } else {
            echo '<div class="alert alert-danger mt-3">Error al registrar la apuesta.</div>';
        }
    }
}
?>
</div>

<title>Apostar</title>
<div class="container m-5">
    <div class="row justify-content-center">
        <div class="col-8 col-md-8 col-lg-8"> <!-- Limita el ancho en pantallas grandes -->

            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Realiza tu apuesta</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($mensajeApuesta)): ?>
                        <div class="alert alert-<?php echo $tipoMensaje ?? 'info'; ?> mt-3"><?php echo $mensajeApuesta; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="id_carrera" class="form-label">Selecciona una carrera:</label>
                            <select name="id_carrera" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Elige una carrera --</option>
                                <?php
                                $carreras = FormularioControlador::obtenerCarrerasProgramadas();
                                foreach ($carreras as $carrera) {
                                    $selected = (isset($_POST['id_carrera']) && $_POST['id_carrera'] == $carrera['id']) ? "selected" : "";
                                    echo "<option value='{$carrera['id']}' $selected>" . htmlentities($carrera['nombre']) . " - {$carrera['fecha']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                    <?php if (isset($_POST['id_carrera'])): ?>
                        <form method="post">
                            <input type="hidden" name="id_carrera" value="<?php echo $_POST['id_carrera']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Selecciona piloto:</label>
                                <select name="id_piloto" class="form-select" required>
                                    <option value="">-- Selecciona piloto --</option>
                                    <?php
                                    $pilotos = FormularioControlador::obtenerPilotosPorCarrera($_POST['id_carrera']);
                                    foreach ($pilotos as $piloto) {
                                        echo "<option value='{$piloto['id']}'>" . htmlentities($piloto['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipo de apuesta:</label>
                                <select name="tipo_apuesta" class="form-select" required>
                                    <option value="">-- Selecciona apuesta --</option>
                                    <option value="ganador">Gana (100% ganancia)</option>
                                    <option value="podio">Podio (40% ganancia)</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Monto a apostar:</label>
                                <input type="number" class="form-control" name="monto" min="100" required>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary fw-bold mb-3">Realizar Apuesta</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>


</body>

</html>