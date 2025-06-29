<title>Ganancias</title>
<?php
if (!isset($_SESSION['privilegios']) || $_SESSION['privilegios'] !== 'admin') {
    echo "<script>window.location.href = 'index.php?pagina=Login';</script>";
    exit();
}

require_once "Modelo/Formularios.Modelo.php";

$carreras = ModeloFormularios::obtenerCarrerasFinalizadas();
$gananciaPorCarrera = null;
$gananciaMensual = null;
$tabActiva = 'carrera';

// Procesar selección por carrera
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && $_POST['tipo'] === 'carrera') {
    $tabActiva = 'carrera';
    $idCarrera = $_POST['id_carrera'];
    $estado = ModeloFormularios::obtenerEstadoCarrera($idCarrera);

    if ($estado === 'finalizada') {
        $gananciaPorCarrera = ModeloFormularios::calcularGananciaPorCarrera($idCarrera);
    } else {
        $mensajeCarrera = "La carrera aún no ha finalizado.";
    }
}

// Procesar selección por mes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo']) && $_POST['tipo'] === 'mes') {
    $tabActiva = 'mes';
    $mesSeleccionado = $_POST['mes']; // Formato YYYY-MM
    $gananciaMensual = ModeloFormularios::calcularGananciaPorMes($mesSeleccionado);
}
?>

<div class="container mt-4">
    <ul class="nav nav-tabs mb-3" id="gananciasTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link <?= $tabActiva === 'carrera' ? 'active' : '' ?>" id="porCarrera-tab"
                data-bs-toggle="tab" data-bs-target="#porCarrera" type="button" role="tab">Por Carrera</button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?= $tabActiva === 'mes' ? 'active' : '' ?>" id="porMes-tab" data-bs-toggle="tab"
                data-bs-target="#porMes" type="button" role="tab">Por Mes</button>
        </li>
    </ul>

    <div class="tab-content" id="gananciasTabContent">
        <!-- Vista 1: Por Carrera -->
        <div class="tab-pane fade <?= $tabActiva === 'carrera' ? 'show active' : '' ?>" id="porCarrera" role="tabpanel">
            <form method="post" class="mb-4">
                <input type="hidden" name="tipo" value="carrera">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Seleccionar Carrera</label>
                        <select name="id_carrera" class="form-select" required>
                            <option value="">-- Elige una carrera --</option>
                            <?php foreach ($carreras as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= isset($_POST['id_carrera']) && $_POST['id_carrera'] == $c['id'] ? 'selected' : '' ?>>
                                    <?= htmlentities($c['nombre']) ?> (<?= $c['fecha'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning fw-bold">Consultar</button>
                    </div>
                </div>
            </form>

            <?php if (isset($mensajeCarrera)): ?>
                <div class="alert alert-warning"><?= $mensajeCarrera ?></div>
            <?php elseif ($gananciaPorCarrera !== null): ?>
                <div class="card bg-dark text-white shadow-sm p-3 mb-3">
                    <h5>Ganancias para la carrera seleccionada:</h5>
                    <ul>
                        <li>Total apostado: <strong>$<?= number_format($gananciaPorCarrera['total_apostado']) ?></strong>
                        </li>
                        <li>Total pagado a ganadores:
                            <strong>$<?= number_format($gananciaPorCarrera['total_pagado']) ?></strong>
                        </li>
                        <li>
                            <?php if ($gananciaPorCarrera['ganancia'] >= 0): ?>
                                <span class="text-success">Ganancia neta:
                                    <strong>$<?= number_format($gananciaPorCarrera['ganancia']) ?></strong>
                                </span>
                            <?php else: ?>
                                <span class="text-danger">Pérdida neta:
                                    <strong>$<?= number_format($gananciaPorCarrera['ganancia']) ?></strong>
                                </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <a href="index.php?pagina=exportar_ganancia_pdf&tipo=carrera&id=<?= $_POST['id_carrera'] ?>"
                        class="btn btn-outline-light mt-2">Exportar a PDF</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Vista 2: Por Mes -->
        <div class="tab-pane fade <?= $tabActiva === 'mes' ? 'show active' : '' ?>" id="porMes" role="tabpanel">
            <form method="post" class="mb-4">
                <input type="hidden" name="tipo" value="mes">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Seleccionar Mes</label>
                        <input type="month" name="mes" class="form-control"
                            value="<?= isset($_POST['mes']) ? $_POST['mes'] : date('Y-m') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning fw-bold">Consultar</button>
                    </div>
                </div>
            </form>

            <?php if ($gananciaMensual !== null): ?>
                <div class="card bg-dark text-white shadow-sm p-3 mb-3">
                    <h5>Ganancias del mes <?= htmlentities($_POST['mes']) ?>:</h5>
                    <ul>
                        <li>Total apostado: <strong>$<?= number_format($gananciaMensual['total_apostado']) ?></strong></li>
                        <li>Total pagado a ganadores:
                            <strong>$<?= number_format($gananciaMensual['total_pagado']) ?></strong>
                        </li>
                        <li>
                            <?php if ($gananciaMensual['ganancia'] >= 0): ?>
                                <span class="text-success">Ganancia neta:
                                    <strong>$<?= number_format($gananciaMensual['ganancia']) ?></strong>
                                </span>
                            <?php else: ?>
                                <span class="text-danger">Pérdida neta:
                                    <strong>$<?= number_format($gananciaMensual['ganancia']) ?></strong>
                                </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <a href="index.php?pagina=exportar_ganancia_pdf&tipo=mes&mes=<?= $_POST['mes'] ?>"
                        class="btn btn-outline-light mt-2">Exportar a PDF</a>


                </div>
            <?php endif; ?>
        </div>
    </div>
</div>