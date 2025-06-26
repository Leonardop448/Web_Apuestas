<title>Ajustes de Usuario</title>
<?php
$actualizarusuario = FormularioControlador::actualizarUsuario();
?>

<div class="container mt-5">
	<div class="card bg-dark text-white shadow-lg rounded-4">
		<div class="card-header bg-warning text-dark text-center">
			<h2 class="fw-bold">Ajustes de Usuario</h2>
		</div>

		<div class="card-body p-4">
			<form method="POST" class="text-center">
				<div class="mb-3">
					<label class="form-label fw-bold" for="documento">Documento:</label>
					<input type="text" id="documento" name="documento" class="form-control text-center"
						value="<?php echo $_SESSION['cedula'] ?>" readonly>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold" for="nombre">Nombre:</label>
					<input type="text" id="nombre" name="nombre" class="form-control text-center"
						value="<?= $_SESSION['nombre'] ?>" required>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold" for="email">Correo Electrónico:</label>
					<input type="email" id="email" name="email" class="form-control text-center"
						value="<?= $_SESSION['email'] ?>">
				</div>

				<div class="mb-4">
					<label class="form-label fw-bold" for="telefono">Teléfono:</label>
					<input type="number" id="telefono" name="telefono" class="form-control text-center"
						value="<?= $_SESSION['telefono'] ?>" required>
				</div>
				<label class="form-label" for="">* Documento o cedula no esta permitido
					cambiarse</label>
				<button type="submit" class="btn btn-warning fw-bold px-4">Actualizar</button>

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