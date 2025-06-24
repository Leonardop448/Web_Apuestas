<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajustes de Usuario</title>
	<?php
	$actualizarusuario = FormularioControlador::actualizarUsuario();
	?>
	<div class="container mt-5">
		<div class="card bg-dark text-white shadow-lg rounded-4">
			<div class="card-header bg-warning text-dark text-center">
				<h2 class="fw-bold">Ajustes de Usuario</h2>
			</div>
			<div class="form-outline mb-4" align="center">
				<form method="POST">

					<label class="form-label " for="documento">Documento: </label>
					<?php echo $_SESSION['cedula'] ?><br>
					<label class="form-label " for="nombre">Nombre: </label>
					<input type="text" id="nombre" name="nombre" value="<?php echo $_SESSION['nombre'] ?>" required><br>
					<label class="form-label " for="email">Correo Electronico: </label>
					<input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?>"><br>
					<label class="form-label " for="number">Telefono: </label>
					<input type="number" id="telefono" name="telefono" value="<?php echo $_SESSION['telefono'] ?>"
						required><br>
					<input type="submit" value="Actualizar">

					<?php
					if ($actualizarusuario >= 1) {
						echo "<script>
        if (window.confirm('Se han actualizado los datos, inicia sesión nuevamente')) {
            window.location.replace('index.php?pagina=Salir');
        }
    </script>";
					}

					?>


				</form>
			</div>
		</div>
	</div>
	</div>