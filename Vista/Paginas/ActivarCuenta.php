<?php
require_once(__DIR__ . '/../../Modelo/Formularios.Modelo.php');
?>

<title>Activar Cuenta</title>


<body style="background: linear-gradient(135deg, #1a1a1a, #1658A3); color: white; font-family: Arial, sans-serif;">

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
      <?php
      if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $estado = ModeloFormularios::activarCuenta($token);

        if ($estado === 'activado') {
          echo '
                    <div class="alert alert-success shadow-lg" role="alert">
                        <h4 class="alert-heading">¡Cuenta activada con éxito!</h4>
                        <p>Ahora puedes iniciar sesión con tu cuenta. 🎉</p>
                        <hr>
                        <a href="?pagina=Login" class="btn btn-success fw-bold">Iniciar sesión</a>
                    </div>';
        } elseif ($estado === 'ya_activado') {
          echo '
                    <div class="alert alert-info shadow-lg" role="alert">
                        <h4 class="alert-heading">Cuenta ya activada</h4>
                        <p>Tu cuenta ya fue activada anteriormente.</p>
                        <hr>
                        <a href="?pagina=Login" class="btn btn-secondary fw-bold">Ir al Login</a>
                    </div>';
        } elseif ($estado === 'invalido') {
          echo '
                    <div class="alert alert-danger shadow-lg" role="alert">
                        <h4 class="alert-heading">Token inválido</h4>
                        <p>Este enlace no es válido o no existe.</p>
                        <hr>
                        <a href="?pagina=Registro" class="btn btn-warning fw-bold">Registrarse</a>
                    </div>';
        } else {
          echo '
                    <div class="alert alert-danger shadow-lg" role="alert">
                        <h4 class="alert-heading">Error inesperado</h4>
                        <p>No se pudo activar la cuenta. Inténtalo más tarde.</p>
                        <hr>
                        <a href="?pagina=Inicio" class="btn btn-light fw-bold">Volver al inicio</a>
                    </div>';
        }
      } else {
        echo '
                <div class="alert alert-warning shadow-lg" role="alert">
                    <h4 class="alert-heading">Token no proporcionado</h4>
                    <p>No se ha proporcionado un token de activación.</p>
                    <hr>
                    <a href="?pagina=Inicio" class="btn btn-light fw-bold">Volver al inicio</a>
                </div>';
      }
      ?>
    </div>
  </div>

</body>

</html>