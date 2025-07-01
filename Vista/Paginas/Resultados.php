<title>Resultados de Carreras</title>


<body class="bg-light">
  <main class="container mt-5">
    <div class="container mt-5">
      <div class="card bg-dark text-white shadow-lg rounded-4">
        <div class="card-header bg-warning text-dark text-center">
          <h2 class="fw-bold">Resultados de Carreras</h2>
        </div>
        <div class="card-body">

          <?php
          $carreras = FormularioControlador::obtenerCarrerasConResultados();

          if (empty($carreras)) {
            echo '<div class="alert alert-info text-center">No hay resultados registrados aún.</div>';
          } else {
            foreach ($carreras as $carrera) {
              $formatter = new \IntlDateFormatter('es_ES', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, 'America/Bogota');
              $fecha = $formatter->format(new DateTime($carrera['fecha']));

              echo '<div class="card bg-secondary text-white mb-4">';
              echo '<div class="card-header text-center h4"><strong>' . htmlentities($carrera['nombre']) . '</strong> | ' . $fecha . '</div>';
              echo '<div class="card-body">';

              $resultados = FormularioControlador::obtenerResultadosPorCarreraYCategorias($carrera['id']);
              if (empty($resultados)) {
                echo '<p class="text-white">No se han registrado resultados aún.</p>';
              } else {
                $resultadosPorCategoria = [];

                foreach ($resultados as $r) {
                  $cat = $r['categoria'];
                  if (!isset($resultadosPorCategoria[$cat])) {
                    $resultadosPorCategoria[$cat] = [];
                  }
                  $resultadosPorCategoria[$cat][] = $r;
                }

                foreach ($resultadosPorCategoria as $categoria => $resultadosCat) {
                  echo '<div class="mb-3">';
                  echo '<h5 class="text-info text-center fw-bold">' . htmlentities($categoria) . '</h5>';
                  echo '<ul class="list-group list-group-flush">';
                  foreach ($resultadosCat as $r) {
                    $medalla = match ($r['posicion']) {
                      1 => '🥇',
                      2 => '🥈',
                      3 => '🥉',
                      default => ''
                    };
                    echo '<li class="list-group-item bg-dark text-white d-flex justify-content-center align-items-center">';
                    echo '<span class="text-center h5">' . $medalla . ' ' . htmlentities($r['nombre']) . '</span>';
                    echo '</li>';
                  }
                  echo '</ul>';
                  echo '</div>';
                }
              }

              echo '</div></div>';
            }
          }
          ?>

        </div>
      </div>
    </div>
  </main>
</body>

</html>