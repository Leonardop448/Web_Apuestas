<?php
$mensajeApuesta = null;
$tipoMensaje = null;

// Mostrar mensaje si viene desde una redirección exitosa
if (isset($_GET['apuesta']) && $_GET['apuesta'] === 'ok') {
    $mensajeApuesta = "✅ Apuesta registrada correctamente el ";
    $tipoMensaje = "success";
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_piloto'])) {
    $id_usuario = $_SESSION['id'] ?? null;

    if (!$id_usuario) {
        $mensajeApuesta = "Error: Usuario no autenticado.";
        $tipoMensaje = "danger";
    } else {
        $id_carrera = $_POST['id_carrera'];
        $id_piloto = $_POST['id_piloto'];
        $tipo_apuesta = $_POST['tipo_apuesta'];
        $monto = $_POST['monto'];
        $categoria = $_POST['categoria'];

        // ✅ Calcular ganancia esperada
        if ($tipo_apuesta === 'ganador') {
            $ganancia_esperada = $monto * 2;
        } elseif ($tipo_apuesta === 'podio') {
            $ganancia_esperada = $monto * 1.4;
        } else {
            $ganancia_esperada = 0;
        }

        // ✅ Registrar la apuesta
        $respuesta = FormularioControlador::registrarApuesta(
            $id_usuario,
            $id_carrera,
            $id_piloto,
            $tipo_apuesta,
            $monto,
            $categoria,
            $ganancia_esperada
        );

        if ($respuesta === "ok") {
            echo "<script>window.location.href = '?pagina=Apostar&apuesta=ok';</script>";
            exit();
        } else {
            $mensajeApuesta = $respuesta;
            $tipoMensaje = "danger";
        }
    }
}
?>

<title>Apostar</title>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Realiza tu apuesta</h2>
                </div>
                <div class="card-body p-4">

                    <?php if ($mensajeApuesta): ?>
                        <div id="alertaApuesta" class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show"
                            role="alert">
                            <?= $mensajeApuesta ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    <?php endif; ?>

                    <!-- FORMULARIO DE CARRERAS -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="id_carrera" class="form-label">Selecciona una carrera:</label>
                            <select name="id_carrera" class="form-select" onchange="this.form.submit()" required>
                                <option value="">-- Elige una carrera --</option>
                                <?php
                                $carreras = FormularioControlador::obtenerCarrerasProgramadas();

                                $fmt = new IntlDateFormatter(
                                    'es_ES',
                                    IntlDateFormatter::FULL,
                                    IntlDateFormatter::SHORT,
                                    'America/Bogota'
                                );

                                foreach ($carreras as $carrera) {
                                    $selected = (isset($_POST['id_carrera']) && $_POST['id_carrera'] == $carrera['id']) ? "selected" : "";

                                    $fechaCarrera = new DateTime($carrera['fecha']);
                                    $fmt->setPattern("d 'de' MMMM 'de' Y");
                                    $fechaFormateada = $fmt->format($fechaCarrera);
                                    $horaFormateada = $fechaCarrera->format('h:i A');

                                    echo "<option value='{$carrera['id']}' $selected>" . htmlentities($carrera['nombre']) . " - {$fechaFormateada} {$horaFormateada}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                    <?php if (isset($_POST['id_carrera'])): ?>
                        <?php
                        $idCarrera = $_POST['id_carrera'];
                        $pilotos = FormularioControlador::obtenerPilotosPorCarrera($idCarrera);
                        $datosCarrera = FormularioControlador::obtenerCarreraPorId($idCarrera);
                        $categorias = explode(',', $datosCarrera['categorias'] ?? '');
                        ?>

                        <!-- Formulario principal de apuesta -->
                        <form method="post">
                            <input type="hidden" name="id_carrera" value="<?= $idCarrera ?>">

                            <div class="mb-3">
                                <label class="form-label">Categoría: "Una por apuesta"</label><br>
                                <?php foreach ($categorias as $cat): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="categoria" id="cat_<?= $cat ?>"
                                            value="<?= $cat ?>" required>
                                        <label class="form-check-label" for="cat_<?= $cat ?>"><?= $cat ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Selecciona piloto:</label>
                                <select name="id_piloto" class="form-select" required>
                                    <option value="">-- Selecciona piloto --</option>
                                    <?php foreach ($pilotos as $piloto): ?>
                                        <option value="<?= $piloto['id'] ?>"><?= htmlentities($piloto['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="text-center small fw-bold mt-3 mb-0">
                                    ¿No encuentras tu piloto?
                                    <a href="?pagina=RegistrarPiloto" class="link-danger">Agregalo Aquí</a>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipo de apuesta:</label>
                                <select name="tipo_apuesta" class="form-select" required>
                                    <option value="">-- Selecciona apuesta --</option>
                                    <option value="ganador">Gana (100% ganancia)</option>
                                    <option value="podio">Podio (40% ganancia)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Monto a apostar:</label>
                                <input type="number" class="form-control" name="monto" placeholder="Mínimo $1000" min="1000"
                                    required>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary fw-bold">Realizar Apuesta</button>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS para limpiar mensaje y quitar ?apuesta=ok de la URL -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alerta = document.getElementById("alertaApuesta");

        if (alerta) {
            setTimeout(() => {
                alerta.classList.remove("show");
                alerta.classList.add("fade");
                alerta.style.opacity = "0";

                setTimeout(() => {
                    alerta.remove();
                }, 500);

                const url = new URL(window.location.href);
                url.searchParams.delete("apuesta");
                window.history.replaceState({}, document.title, url.toString());
            }, 3000);
        }
    });
</script>