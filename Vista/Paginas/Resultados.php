<title>Resultados de Carreras</title>

<body class="bg-light">
  <main class="container mt-5">

    <div class="container mt-5">
      <div class="card bg-dark text-white shadow-lg rounded-4">
        <div class="card-header bg-warning text-dark text-center">
          <h2 class="fw-bold">Resultados de Carreras Finalizadas</h2>
        </div>
        <div class="card-body">

          <?php
          $carreras = FormularioControlador::obtenerCarrerasFinalizadas();

          if (empty($carreras)) {
            echo '<div class="alert alert-info text-center">No hay carreras finalizadas aún.</div>';
          } else {
            $formatter = new \IntlDateFormatter('es_ES', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, 'America/Bogota');

            foreach ($carreras as $carrera) {
              $fecha = $formatter->format(new DateTime($carrera['fecha']));
              echo '<div class="card bg-secondary text-white mb-3">';
              echo '<div class="card-header text-center h4 "><strong>' . htmlentities($carrera['nombre']) . '</strong> | ' . $fecha . '</div>';
              echo '<div class="card-body">';

              $ganadores = FormularioControlador::obtenerGanadoresCarrera($carrera['id']);
              if (empty($ganadores)) {
                echo '<p class="text-white">No se han registrado resultados aún.</p>';
              } else {
                echo '<ul class="list-group list-group-flush">';
                foreach ($ganadores as $g) {
                  $medalla = match ($g['posicion']) {
                    1 => '🥇',
                    2 => '🥈',
                    3 => '🥉',
                    default => ''

                  };
                  echo '<li class="list-group-item bg-dark text-white d-flex justify-content-center align-items-center">';
                  echo '<span class="text-center h5">' . $medalla . ' ' . htmlentities($g['nombre']) . '</span>';
                  echo '</li>';
                }
                echo '</ul>';

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