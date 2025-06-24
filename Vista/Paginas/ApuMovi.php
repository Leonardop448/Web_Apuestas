<title>Movimientos</title>
<?php
if (!isset($_SESSION['tokenUsuario'])) {
    echo "Debe iniciar sesión para ver los movimientos.";
    exit;
}

$token = $_SESSION['tokenUsuario'];

// Obtener la página actual de la URL o por defecto 1
$pagina = isset($_GET['paginas']) ? (int) $_GET['paginas'] : 1;

// Definir cuántos registros por página mostrar
$porPagina = 10;

// Pasar los parámetros al controlador que a su vez llamará al modelo
$movimientos = FormularioControlador::movimiento($token, $pagina, $porPagina);
$Contarmovimientos = FormularioControlador::contarMovimiento($token);


?>
<?php
if (isset($_SESSION['privilegios'])) {
    $balance = FormularioControlador::balance();
    $saldo = number_format($balance['saldo']);
    ?>
    <h2>
        <a class="nav-link text-white fw-bold" align="center" href="?pagina=ApuMovi">
            <strong class="text-warning">
                <i class="fa-solid fa-sack-dollar fa-bounce" style="color: #ffc107;"></i>
                <?php echo "&nbsp;$saldo"; ?>
            </strong>
        </a>
    </h2>
<?php } ?>

<div class="container m-5">
    <div class="card bg-dark text-white shadow-lg rounded-4">
        <div class="card-header bg-warning text-dark text-center">
            <h2 class="fw-bold">Movimientos</h2>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($movimientos as $fila) {
                    $valor = $fila['ingresos'] > 0 ? $fila['ingresos'] : $fila['egresos'];
                    $tipo = $fila['ingresos'] > 0 ? 'Ingreso' : 'Egreso';

                    $fechaObj = new DateTime($fila['fecha']);
                    $formatter = new IntlDateFormatter(
                        'es_ES',
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE,
                        'America/Bogota',
                        IntlDateFormatter::GREGORIAN,
                        'd \'de\' MMMM \'de\' yyyy, h:mm a'
                    );
                    $fecha = $formatter->format($fechaObj);

                    $color = $tipo === 'Ingreso' ? "table-success" : "table-danger";
                    $signo = $tipo === 'Ingreso' ? "" : "-";
                    ?>
                    <tr class="<?php echo $color; ?>">
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $tipo; ?></td>
                        <td><?php echo $signo . number_format($valor); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>



    </div>
</div>



<div class="d-flex justify-content-center" align="center">
    Página
    <?php
    $totalPaginas = ceil($Contarmovimientos['Cantidad'] / $porPagina);
    for ($i = 1; $i <= $totalPaginas; $i++) {
        $negrita = ($pagina == $i) ? "<strong>$i</strong>" : $i;
        echo "&nbsp;<a class='nav-link text-black' href='?pagina=ApuMovi&paginas=$i'>$negrita</a>";
    }
    ?>
</div>