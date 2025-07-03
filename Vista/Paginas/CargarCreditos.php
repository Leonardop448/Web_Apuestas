<title>Cargar Creditos</title>
<?php
$ingreso = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['verificar'])) {
    $ingreso = FormularioControlador::verificarRecargar();
  }

  if (isset($_POST['recargar'])) {
    FormularioControlador::recargar(); // Puedes agregar feedback al usuario si deseas
  }
}
?>

<main class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card tarjeta-carreras shadow-lg rounded-4">
        <div class="card-header encabezado-carreras text-center">
          <h2 class="fw-bold">Cargar Créditos</h2>
        </div>

        <div class="card-body">
          <!-- Formulario de Verificación -->
          <form method="post">
            <div class="mb-3">
              <label for="cedula" class="form-label fw-bold">Cédula</label>
              <input type="number" id="cedula" name="cedula" class="form-control text-center"
                placeholder="Ingrese documento" required>
            </div>

            <div class="mb-4">
              <label for="cantidad" class="form-label fw-bold">Cantidad</label>
              <input type="number" id="cantidad" name="cantidad" class="form-control text-center"
                placeholder="Cantidad a Recargar" required>
            </div>

            <div class="text-center">
              <input type="submit" name="verificar" value="Verificar" class="btn btn-apuesta fw-bold btn-lg px-5">
            </div>
          </form>

          <!-- Mostrar datos verificados -->
          <?php if ($ingreso): ?>
            <hr class="my-5">
            <div class="text-center">
              <h3 class="fw-bold">Datos del Usuario</h3>
              <p class="mb-4">Verifique que los datos sean correctos antes de confirmar la recarga.</p>

              <table class="table table-bordered text-white">
                <tbody>
                  <tr>
                    <td class="bg-success fw-bold">Nombre</td>
                    <td><?= htmlentities($ingreso['nombre']) ?></td>
                  </tr>
                  <tr>
                    <td class="bg-success fw-bold">Teléfono</td>
                    <td><?= htmlentities($ingreso['telefono']) ?></td>
                  </tr>
                  <tr>
                    <td class="bg-success fw-bold">Correo</td>
                    <td><?= htmlentities($ingreso['email']) ?></td>
                  </tr>
                  <tr>
                    <td class="bg-success fw-bold">Cantidad</td>
                    <td>$<?= number_format($ingreso['cantidad']) ?></td>
                  </tr>
                </tbody>
              </table>

              <form method="post">
                <input type="hidden" name="valor" value="<?= $ingreso['cantidad'] ?>">
                <input type="hidden" name="token" value="<?= $ingreso['token'] ?>">
                <input type="submit" name="recargar" value="Confirmar Recarga"
                  class="btn btn-apuesta fw-bold btn-lg px-5">
              </form>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</main>