<title>Registro</title>
<div align="center">
  <!-- MENSAJE -->
  <?php
  $registroUsuario = FormularioControlador::registrarUsuario();

  if (isset($registroUsuario)) {
    if (isset($registroUsuario['id'])) {
      echo "<div class='alert alert-success alert-dismissible fade show col-lg-6 mx-auto mt-3' role='alert'>
      <strong>¡Éxito!</strong> Usuario creado. Revisa tu correo para activarlo.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Cerrar'></button>
    </div>";
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show col-lg-6 mx-auto mt-3' role='alert'>
      <strong>¡Cuidado!</strong> Este usuario ya existe.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Cerrar'></button>
    </div>";
    }
  }
  ?>

  <!-- FORMULARIO DE REGISTRO -->
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-6">
        <div class="card bg-dark border-warning text-white shadow-lg rounded-4">
          <div class="card-header bg-warning text-dark text-center">
            <h2 class="fw-bold m-0">¡Regístrate!</h2>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="mb-3">
                <label for="contrasena" class="form-label fw-bold">Contraseña:</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
              </div>
              <div class="mb-3">
                <label for="cedula" class="form-label fw-bold">Cédula:</label>
                <input type="number" class="form-control" id="cedula" name="cedula" required>
              </div>
              <div class="mb-3">
                <label for="telefono" class="form-label fw-bold">Teléfono:</label>
                <input type="number" class="form-control" id="telefono" name="telefono" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-warning fw-bold">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>