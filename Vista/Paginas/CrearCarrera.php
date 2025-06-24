<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<title>Crear Carrera</title>


<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-6"> <!-- Cambia a col-md-5 o col-md-4 si la quieres aún más estrecha -->
      <div class="card bg-dark text-white shadow-lg rounded-4">
        <div class="card-header bg-warning text-dark text-center">
          <h2 class="fw-bold">Crear nueva carrera</h2>
        </div>
        <form method="post" class="p-4">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la carrera</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha y hora</label>
            <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary fw-bold px-5">Crear Carrera</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fechaFormateada = date('Y-m-d H:i:s', strtotime($_POST["fecha"]));
  $respuesta = FormularioControlador::crearCarrera($_POST["nombre"], $fechaFormateada);
  if ($respuesta === "ok") {
    echo '<div class="alert alert-success mt-3">Carrera creada con éxito</div>';
  } else {
    echo '<div class="alert alert-danger mt-3">Error al crear la carrera</div>';
  }
}
?>
</div>
</body>

</html>