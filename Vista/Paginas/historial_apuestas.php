<?php

if (!isset($_SESSION['privilegios']) || !in_array($_SESSION['privilegios'], ['usuario', 'admin'])) {
    header('Location: index.php?pagina=Login');
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
<div class="container m-5">
    <div class="row justify-content-center">
        <div class="col-8 col-md-8 col-lg-8"> <!-- Limita el ancho en pantallas grandes -->

            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Historial de Apuestas</h2>
                </div>
                <div class="card-body p-4">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Carrera</th>
                                <th>Piloto</th>
                                <th>Tipo de Apuesta</th>
                                <th>Monto Apostado</th>
                                <th>Ganancia Esperada</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                            <?php foreach ($apuestas as $apuesta): ?>
                                <tr>
                                    <td><?= htmlspecialchars($apuesta['carrera_nombre']) ?></td>
                                    <td><?= htmlspecialchars($apuesta['piloto_nombre']) ?></td>
                                    <td><?= ucfirst($apuesta['tipo_apuesta']) ?></td>
                                    <td>$<?= number_format($apuesta['monto']) ?></td>
                                    <td>$<?= number_format($apuesta['ganancia_esperada']) ?></td>
                                    <td><span class="badge 
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
                        ?>
                    "><?= ucfirst($apuesta['resultado']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>