<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movimientos</title>
<?php
if (!isset($_SESSION['tokenUsuario'])) {
    echo "Debe iniciar sesión para ver los movimientos.";
    exit;
}

$token = $_SESSION['tokenUsuario'];

// Obtener la página actual de la URL o por defecto 1
$pagina = isset($_GET['paginas']) ? (int)$_GET['paginas'] : 1;

// Definir cuántos registros por página mostrar
$porPagina = 10;

// Pasar los parámetros al controlador que a su vez llamará al modelo
$movimientos = FormularioControlador::movimiento($token, $pagina, $porPagina);
$Contarmovimientos = FormularioControlador::contarMovimiento($token);


?>
<h2 align="center">Movimientos</h2>
<?php
if (isset($_SESSION['privilegios'])) {
    $balance = FormularioControlador::balance();
    $saldo = number_format($balance['saldo']);
?>
    <h2>
        <a class="nav-link text-white fw-bold" align="center" href="?pagina=ApuMovi">
            <strong class="text-warning">
                <i class="fa-solid fa-sack-dollar fa-bounce" style="color: #ffc107;"></i>
                <?php echo "&nbsp;$saldo&nbsp;"; ?>
            </strong>
        </a>
    </h2>
<?php } ?>

<div class="d-flex justify-content-center" align="center">
    <div class="alert alert-secondary">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($movimientos as $fila) {
                    $valor = $fila['ingresos'] > 0 ? $fila['ingresos'] : $fila['egresos'];
                    $tipo = $fila['ingresos'] > 0 ? 'Ingreso' : 'Egreso';
                    $fecha = $fila['fecha'];

                    if ($tipo == 'Ingreso') {
                        $color = "table-success";
                        $signo = "";
                    } else {
                        $color = "table-danger";
                        $signo = "-";
                    }
                ?>
                    <tr class="<?php echo $color; ?>">
                        <td><?php echo $fecha; ?></td>
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