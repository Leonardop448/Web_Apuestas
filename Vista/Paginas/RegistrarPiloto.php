<title>Registrar Piloto</title>


<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Estrecho y centrado -->
            <div class="card bg-dark text-white shadow-lg rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h2 class="fw-bold">Registrar Nuevo Piloto</h2>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del piloto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Ejemplo: Juan Carlos Gomez # 745" required>
                        </div>
                        <!-- Centrado del botón -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-5">Registrar</button>
                        </div>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $respuesta = FormularioControlador::registrarPiloto($_POST["nombre"]);
                        if ($respuesta === "ok") {
                            echo '<div class="alert alert-success mt-3">Piloto registrado con éxito</div>';
                        } else {
                            echo '<div class="alert alert-danger mt-3">Error al registrar el piloto</div>';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>



</html>