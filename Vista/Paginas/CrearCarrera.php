<title>Crear Carrera</title>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST["nombre"];
  $fechaFormateada = date('Y-m-d H:i:s', strtotime($_POST["fecha"]));
  $categoriasSeleccionadas = isset($_POST['categorias']) ? implode(',', $_POST['categorias']) : '';

  $respuesta = FormularioControlador::crearCarrera($nombre, $fechaFormateada, $categoriasSeleccionadas);

  if ($respuesta === "ok") {
    echo '<div class="alert alert-success mt-3">Carrera creada con éxito</div>';
  } else {
    echo '<div class="alert alert-danger mt-3">Error al crear la carrera</div>';
  }
}
?>
<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-6"> <!-- Cambia a col-md-5 o col-md-4 si la quieres aún más estrecha -->
      <div class="card tarjeta-carreras shadow-lg rounded-4">
        <div class="card-header encabezado-carreras text-center">
          <h2 class="fw-bold">Crear nueva carrera</h2>
        </div>
        <form method="post" class="p-4">
          <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre de la carrera</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>

          <div class="mb-3">
            <label for="fecha" class="form-label fw-bold">Fecha y hora</label>
            <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
          </div>

          <div class="mb-3">
            <label class="card-header encabezado-carreras text-center fw-bold">Categorías</label><br>
            <?php
            $categorias = [
              '50cc Racer',
              'Infantil',
              'Novatos',
              'Élite',
              '150 cc',
              'Master',
              '200cc 2T',
              'Supermoto',
              'Expertos'
            ];
            foreach ($categorias as $categoria) {
              echo '<div class="form-check form-check-inline justify-content-center ">';
              echo '<input class="form-check-input" type="checkbox" name="categorias[]" value="' . $categoria . '" id="' . $categoria . '">';
              echo '<label class="form-check-label" for="' . $categoria . '">' . $categoria . '</label>';
              echo '</div>';
            }
            ?>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-apuesta fw-bold px-5">Crear Carrera</button>
          </div>
        </form>



      </div>
    </div>
  </div>
</div>
</body>

</html>