<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<title>Asignar Pilotos a una Carrera</title>



<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Estrecho y centrado -->
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Asignar Pilotos a una Carrera</h2>
                </div>
                <div class="card-body">
                    <!-- Formulario -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="carrera" class="form-label">Selecciona la carrera</label>
                            <select class="form-select" name="id_carrera" required>
                                <option value="">-- Elige una carrera --</option>
                                <?php
                                $carreras = FormularioControlador::obtenerCarreras();
                                foreach ($carreras as $carrera) {
                                    echo '<option value="' . $carrera['id'] . '">' . htmlentities($carrera['nombre']) . ' - ' . $carrera['fecha'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Selecciona los pilotos</label>
                            <?php
                            $pilotos = FormularioControlador::obtenerPilotos();
                            foreach ($pilotos as $piloto) {
                                echo '<div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pilotos[]" value="' . $piloto['id'] . '" id="piloto_' . $piloto['id'] . '">
                                    <label class="form-check-label" for="piloto_' . $piloto['id'] . '">' . htmlentities($piloto['nombre']) . '</label>
                                </div>';
                            }
                            ?>
                        </div>

                        <!-- Botón centrado y estilizado -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary fw-bold px-5">Asignar Pilotos</button>
                        </div>
                    </form>

                    <!-- Respuesta -->
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pilotos'])) {
                        $respuesta = FormularioControlador::asignarPilotos($_POST['id_carrera'], $_POST['pilotos']);

                        if (isset($respuesta['exito']) && $respuesta['exito']) {
                            echo '<div class="alert alert-success mt-3">Pilotos asignados correctamente.</div>';
                        }

                        if (!empty($respuesta['yaAsignados'])) {
                            echo '<div class="alert alert-warning mt-3">';
                            echo 'Los siguientes pilotos ya estaban asignados: <strong>' . implode(', ', $respuesta['yaAsignados']) . '</strong>.';
                            echo '</div>';
                        }

                        if (!$respuesta['exito'] && empty($respuesta['yaAsignados'])) {
                            echo '<div class="alert alert-danger mt-3">No se pudo asignar ningún piloto.</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>