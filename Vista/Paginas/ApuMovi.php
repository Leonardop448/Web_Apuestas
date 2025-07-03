<?php
if (!isset($_SESSION['tokenUsuario'])) {
    echo "Debe iniciar sesión para ver los movimientos.";
    exit;
}

$token = $_SESSION['tokenUsuario'];
$pagina = isset($_GET['paginas']) ? (int) $_GET['paginas'] : 1;
$porPagina = 10;

$movimientos = FormularioControlador::movimiento($token, $pagina, $porPagina);
$Contarmovimientos = FormularioControlador::contarMovimiento($token);
?>

<title>Movimientos</title>

<div class="container py-5">
    <?php if (isset($_SESSION['privilegios'])): ?>
        <?php $balance = FormularioControlador::balance(); ?>

    <?php endif; ?>

    <div class="card tarjeta-carreras shadow-lg rounded-4">
        <div class="card-header encabezado-carreras text-center">
            <h2 class="fw-bold">Movimientos</h2>
        </div>
        <div class="card-body p-4">
            <?php if (empty($movimientos)): ?>
                <div class="alert alert-info text-center">No hay movimientos registrados.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-info">
                            <tr>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movimientos as $fila): ?>
                                <?php
                                $valor = $fila['ingresos'] > 0 ? $fila['ingresos'] : $fila['egresos'];
                                $tipo = $fila['ingresos'] > 0 ? 'Ingreso' : 'Egreso';
                                $color = $tipo === 'Ingreso' ? "table-success" : "table-danger";
                                $signo = $tipo === 'Ingreso' ? "" : "-";

                                $fechaObj = new DateTime($fila['fecha']);
                                $formatter = new IntlDateFormatter(
                                    'es_ES',
                                    IntlDateFormatter::LONG,
                                    IntlDateFormatter::SHORT,
                                    'America/Bogota',
                                    IntlDateFormatter::GREGORIAN,
                                    "d 'de' MMMM 'de' yyyy, h:mm a"
                                );
                                $fecha = $formatter->format($fechaObj);
                                ?>
                                <tr class="<?= $color ?>">
                                    <td><?= $fecha ?></td>
                                    <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                                    <td><?= $tipo ?></td>
                                    <td><?= $signo . number_format($valor) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center align-items-center mt-4">
        <nav aria-label="Paginación de movimientos">
            <ul class="pagination">
                <?php
                $totalPaginas = ceil($Contarmovimientos['Cantidad'] / $porPagina);
                for ($i = 1; $i <= $totalPaginas; $i++):
                    $activo = $pagina == $i ? 'active' : '';
                    ?>
                    <li class="page-item <?= $activo ?>">
                        <a class="page-link" href="?pagina=ApuMovi&paginas=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>