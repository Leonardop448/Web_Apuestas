<title>Proximos Eventos</title>

<body>
  <div class="container mt-5">
    <div class="card bg-dark text-white shadow-lg rounded-4">
      <div class="card-header bg-warning text-dark text-center">
        <h2 class="fw-bold">Próximas Carreras Pendientes</h2>
      </div>
      <div class="card-body">
        <?php
        $carreras = FormularioControlador::obtenerCarrerasProgramadas();

        if (empty($carreras)) {
          echo '<div class="alert alert-info">No hay carreras pendientes actualmente.</div>';
        } else {
          $formatter = new \IntlDateFormatter(
            'es_ES',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::SHORT,
            'America/Bogota',
            \IntlDateFormatter::GREGORIAN,
            "EEEE, d 'de' MMMM 'de' yyyy - hh:mm a"
          );

          foreach ($carreras as $carrera) {
            $idCollapse = "collapseCarrera" . $carrera['id'];
            $fechaFormateada = $formatter->format(new DateTime($carrera['fecha']));
            ?>
            <div class="card mb-4 bg-secondary text-white">
              <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <span><?= htmlentities($carrera['nombre']) ?> | <?= $fechaFormateada ?></span>
                <button class="btn btn-sm btn-outline-light toggle-btn collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#<?= $idCollapse ?>" aria-expanded="false" aria-controls="<?= $idCollapse ?>">
                  👁️ Mostrar Pilotos
                </button>
              </div>
              <div class="collapse" id="<?= $idCollapse ?>">
                <div class="card-body">
                  <?php
                  $pilotos = FormularioControlador::obtenerPilotosPorCarrera($carrera['id']);
                  if (empty($pilotos)) {
                    echo '<p class="text-light">Aún no hay pilotos asignados.</p>';
                  } else {
                    echo '<ul class="list-group list-group-flush">';
                    foreach ($pilotos as $piloto) {
                      echo '<li class="list-group-item bg-dark text-white">' . htmlentities($piloto['nombre']) . '</li>';
                    }
                    echo '</ul>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>



  <!-- Script para cambiar el texto del botón -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const botones = document.querySelectorAll('.toggle-btn');

      botones.forEach(boton => {
        const targetId = boton.getAttribute('data-bs-target');
        const target = document.querySelector(targetId);

        const collapse = new bootstrap.Collapse(target, { toggle: false });

        boton.addEventListener('click', function () {
          if (target.classList.contains('show')) {
            collapse.hide();
            boton.innerHTML = '👁️ Mostrar Pilotos';
          } else {
            collapse.show();
            boton.innerHTML = '❌ Ocultar Pilotos';
          }
        });
      });
    });
  </script>
</body>

</html>