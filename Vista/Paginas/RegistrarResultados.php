<?php
if (!isset($_SESSION['privilegios']) || $_SESSION['privilegios'] !== 'admin') {
    echo "<script>window.location.href = 'index.php?pagina=Login';</script>";
    exit();
}

require_once "Modelo/Conexion.php";
require_once "Modelo/Formularios.Modelo.php";

$mensaje = "";
$tipoMensaje = "success";
$categoriasCarrera = [];

if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'ok') {
    $mensaje = "Resultados registrados correctamente.";
}

$carreras = ModeloFormularios::carrerasPorEstado('pendiente');
$pilotos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_carrera = $_POST['id_carrera'] ?? null;
    $accion = $_POST['accion'] ?? '';
    $categoriaSeleccionada = $_POST['categoria'] ?? null;

    if ($accion === 'registrar_resultados') {
        $pilotosSeleccionados = $_POST['pilotos'] ?? [];

        if (count($pilotosSeleccionados) !== 3 || count(array_unique($pilotosSeleccionados)) !== 3) {
            $mensaje = "Error: Los 3 pilotos deben ser diferentes.";
            $tipoMensaje = "danger";
        } elseif (!$categoriaSeleccionada) {
            $mensaje = "Debe seleccionar una categoría.";
            $tipoMensaje = "danger";
        } else {
            ModeloFormularios::procesarResultados($id_carrera, $pilotosSeleccionados, $categoriaSeleccionada);
            echo "<script>window.location.href='index.php?pagina=RegistrarResultados&mensaje=ok';</script>";
            exit;
        }
    }

    if ($id_carrera) {
        $pilotos = ModeloFormularios::pilotosDeCarrera($id_carrera);
        $categoriasCarrera = ModeloFormularios::obtenerCategoriasConApuestas($id_carrera);
    }
}
?>

<title>Registrar Resultados</title>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card tarjeta-carreras shadow-lg rounded-4">
                <div class="card-header encabezado-carreras text-center">
                    <h2 class="fw-bold">Registrar Resultados de Carrera</h2>
                </div>
                <div class="card-body">
                    <?php if ($mensaje): ?>
                        <div class="alert alert-<?= $tipoMensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
                    <?php endif; ?>

                    <form method="post" id="formResultados">
                        <input type="hidden" name="accion" id="accion" value="">

                        <!-- Selección de carrera -->
                        <div class="mb-3">
                            <label for="id_carrera" class="form-label fw-bold">Selecciona Carrera</label>
                            <select name="id_carrera" id="id_carrera" class="form-select"
                                onchange="document.getElementById('accion').value='cambiar_carrera'; this.form.submit();"
                                required>
                                <option value="">-- Elige --</option>
                                <?php foreach ($carreras as $carrera): ?>
                                    <option value="<?= $carrera['id'] ?>" <?= isset($id_carrera) && $id_carrera == $carrera['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($carrera['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mostrar categorías como checkbox -->
                        <?php if (!empty($categoriasCarrera)): ?>
                            <div class="mb-3">
                                <label class="form-label">Selecciona una categoría para procesar:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($categoriasCarrera as $cat): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria"
                                                value="<?= htmlspecialchars($cat) ?>" id="cat_<?= md5($cat) ?>">
                                            <label class="form-check-label" for="cat_<?= md5($cat) ?>">
                                                <?= htmlspecialchars($cat) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Mostrar selectores de piloto -->
                        <?php if (!empty($pilotos)): ?>
                            <h4>Orden de llegada (solo los 3 primeros puestos)</h4>
                            <?php for ($i = 0; $i < 3; $i++): ?>
                                <div class="mb-2">
                                    <label class="form-label">Posición <?= $i + 1 ?></label>
                                    <select name="pilotos[]" class="form-select seleccion-piloto" required>
                                        <option value="">-- Selecciona piloto --</option>
                                        <?php foreach ($pilotos as $opcion): ?>
                                            <option value="<?= htmlspecialchars($opcion['id']) ?>">
                                                <?= htmlspecialchars($opcion['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endfor; ?>

                            <div class="text-center">
                                <button type="button" class="btn btn-apuesta fw-bold mt-3 px-5"
                                    onclick="enviarResultados()">
                                    Registrar Resultados
                                </button>
                                <script>
                                    function enviarResultados() {
                                        document.getElementById('accion').value = 'registrar_resultados';
                                        document.getElementById('formResultados').submit();
                                    }
                                </script>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const selects = document.querySelectorAll(".seleccion-piloto");

                        function actualizarOpciones() {
                            const seleccionados = Array.from(selects)
                                .map(sel => sel.value)
                                .filter(val => val !== "");

                            selects.forEach(select => {
                                Array.from(select.options).forEach(opt => {
                                    if (opt.value === "") return;
                                    opt.disabled = seleccionados.includes(opt.value) && select.value !== opt.value;
                                });
                            });
                        }

                        selects.forEach(select => {
                            select.addEventListener("change", actualizarOpciones);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>