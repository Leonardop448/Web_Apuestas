<?php
if (!isset($_SESSION['privilegios']) || !in_array($_SESSION['privilegios'], ['usuario', 'admin'])) {
    echo "<script>window.location.href = 'index.php?pagina=Login';</script>";
    exit();
}

require_once 'Modelo/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();

$stmt = $db->prepare("SELECT a.*, c.nombre AS carrera_nombre, p.nombre AS piloto_nombre
                      FROM apuestas a
                      INNER JOIN carreras c ON a.id_carrera = c.id
                      INNER JOIN pilotos p ON a.id_piloto = p.id
                      WHERE a.id_usuario = :id_usuario
                      ORDER BY a.id DESC");
$stmt->bindParam(":id_usuario", $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$apuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<title>Historial de Apuestas</title>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card tarjeta-carreras shadow-lg rounded-4">
                <div class="card-header encabezado-carreras text-center">
                    <h2 class="fw-bold">Historial de Apuestas</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (empty($apuestas)): ?>
                        <div class="alert alert-info text-center">
                            No tienes apuestas registradas aún.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center align-middle">
                                <thead class="table-info">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Carrera</th>
                                        <th>Piloto</th>
                                        <th>Categoría</th>
                                        <th>Tipo de Apuesta</th>
                                        <th>Monto Apostado</th>
                                        <th>Ganancia Esperada</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($apuestas as $apuesta): ?>
                                        <?php
                                        $cat = $apuesta['categoria'];
                                        $badgeCategoria = match ($cat) {
                                            '50cc Racer' => 'bg-info text-dark',
                                            'Infantil' => 'bg-primary',
                                            'Novatos' => 'bg-success',
                                            'Élite' => 'bg-warning text-dark',
                                            '150 cc' => 'bg-danger',
                                            'Master' => 'bg-dark',
                                            '200cc 2T' => 'bg-secondary',
                                            'Supermoto' => 'bg-light text-dark',
                                            'Expertos' => 'bg-primary text-white',
                                            default => 'bg-secondary',
                                        };
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y h:i A', strtotime($apuesta['creada_en'])) ?></td>
                                            <td><?= htmlspecialchars($apuesta['carrera_nombre']) ?></td>
                                            <td><?= htmlspecialchars($apuesta['piloto_nombre']) ?></td>
                                            <td><span class="badge <?= $badgeCategoria ?>"><?= htmlspecialchars($cat) ?></span>
                                            </td>
                                            <td><span
                                                    class="badge bg-info text-dark"><?= ucfirst($apuesta['tipo_apuesta']) ?></span>
                                            </td>
                                            <td>$<?= number_format($apuesta['monto']) ?></td>
                                            <td>$<?= number_format($apuesta['ganancia_esperada']) ?></td>
                                            <td>
                                                <span class="badge 
                                                    <?php
                                                    switch ($apuesta['resultado']) {
                                                        case 'ganada':
                                                            echo 'bg-success';
                                                            break;
                                                        case 'perdida':
                                                            echo 'bg-danger';
                                                            break;
                                                        default:
                                                            echo 'bg-secondary';
                                                            break;
                                                    }
                                                    ?>">
                                                    <?= ucfirst($apuesta['resultado']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div> <!-- table-responsive -->
                    <?php endif; ?>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
</div> <!-- container -->