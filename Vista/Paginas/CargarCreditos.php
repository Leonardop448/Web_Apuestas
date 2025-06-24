<?php
// Procesamiento de formularios
$ingreso = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['verificar'])) {
    $ingreso = FormularioControlador::verificarRecargar();
  }

  if (isset($_POST['recargar'])) {
    FormularioControlador::recargar(); // Puedes manejar respuesta o redirección aquí
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cargar Créditos</title>



<body>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-6"> <!-- Estrecho y centrado -->
        <div class="card bg-dark text-white shadow-lg rounded-4">
          <div class="card-header bg-warning text-dark text-center">
            <h2 class="fw-bold">Cargar Créditos</h2>
          </div>
          <div class="card-body">

            <!-- Formulario de Verificación -->
            <form method="post">
              <div class="form-outline mb-4">
                <label class="form-label fw-bold" for="cedula">Cédula</label>
                <input type="number" id="cedula" name="cedula" class="form-control form-control-lg"
                  placeholder="Ingrese documento" required />
              </div>

              <div class="form-outline mb-3">
                <label class="form-label fw-bold" for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control form-control-lg"
                  placeholder="Cantidad a Recargar" required />
              </div>

              <div class="text-center">
                <input type="submit" class="btn btn-primary btn-lg px-5" name="verificar" value="Verificar">
              </div>
            </form>

            <?php if ($ingreso): ?>
              <!-- Datos del usuario verificados -->
              <div class="mt-5 text-center">
                <h2>Datos del Usuario</h2>
                <p>Verifique que los datos sean correctos</p>
                <table class="table table-bordered text-white">
                  <tbody>
                    <tr>
                      <td class="bg-success"><strong>Nombre</strong></td>
                      <td><?= $ingreso['nombre'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-success"><strong>Teléfono</strong></td>
                      <td><?= $ingreso['telefono'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-success"><strong>Correo</strong></td>
                      <td><?= $ingreso['email'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-success"><strong>Cantidad</strong></td>
                      <td><?= number_format($ingreso['cantidad']) ?></td>
                    </tr>
                  </tbody>
                </table>

                <!-- Formulario de Recarga -->
                <form method="post">
                  <input type="hidden" name="valor" value="<?= $ingreso['cantidad'] ?>">
                  <input type="hidden" name="token" value="<?= $ingreso['token'] ?>">
                  <input type="submit" name="recargar" value="Recargar" class="btn btn-success btn-lg px-5">
                </form>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>