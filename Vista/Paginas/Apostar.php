<title>Apostar</title>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Realiza tu apuesta</h2>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($mensajeApuesta)): ?>
                        <div id="alertaApuesta"
                            class="alert alert-<?= $tipoMensaje ?? 'info' ?> alert-dismissible fade show" role="alert">
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
                                foreach ($carreras as $carrera) {
                                    $selected = (isset($_POST['id_carrera']) && $_POST['id_carrera'] == $carrera['id']) ? "selected" : "";
                                    echo "<option value='{$carrera['id']}' $selected>" . htmlentities($carrera['nombre']) . " - {$carrera['fecha']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                    <?php if (isset($_POST['id_carrera'])): ?>
                        <!-- FORMULARIO DE APUESTA -->
                        <form method="post">
                            <input type="hidden" name="id_carrera" value="<?= $_POST['id_carrera'] ?>">

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

                            <div class="mb-3">
                                <label class="form-label">Monto a apostar:</label>
                                <input type="number" class="form-control" name="monto" min="100" required>
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

<!-- Script para quitar ?apuesta=ok de la URL y desaparecer alerta -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alerta = document.getElementById("alertaApuesta");

        if (alerta && window.location.search.includes("apuesta=ok")) {
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