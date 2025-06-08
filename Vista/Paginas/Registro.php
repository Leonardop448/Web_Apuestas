<div align="center">
<?php
$registroUsuario= FormularioControlador::registrarUsuario();



if (isset($registroUsuario)){
  if (isset($registroUsuario['id'])){
    echo "<div class='alert alert-success alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>Success!</strong> Su Usuario ha sido creado exitosamente!! Active desde su correo electronico.
  </div>";
}
else {
  echo "<div class='alert alert-danger alert-dismissible col-sm-3' align='center'>
  <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
     <strong>Cuidado!  </strong>Este Usuario ya existe!!!</a>.
   </div>";	
}

}



?>

</div>

<div class="container col-sm-4" align="center">
<form method="post">
  <div class="mb-3 mt-3 fw-bold">
    <label for="nombre" class="form-label">Nombre:</label>
    <input type="text" class="form-control" id="nombre" placeholder="Juan Perez" name="nombre" required>
  </div>
	<div class="mb-3 mt-3 fw-bold">
    <label for="contrasena" class="form-label">Contraseña:</label>
    <input type="password" class="form-control" id="contrasena" placeholder="******" name="contrasena" required>
  </div>
	<div class="mb-3 mt-3 fw-bold">
    <label for="cedula" class="form-label">Cedula:</label>
    <input type="number" class="form-control" id="cedula" placeholder="123456" name="cedula" required>
  </div>
	<div class="mb-3 mt-3 fw-bold">
    <label for="telefono" class="form-label">Telefono:</label>
    <input type="number" class="form-control" id="telefono" placeholder="Telefono" name="telefono" required>
  </div>
  <div class="mb-3 mt-3 fw-bold">
    <label for="email" class="form-label">Correo Electronico:</label>
    <input type="email" class="form-control" id="email" placeholder="Ingrese su correo" name="email" required>
  </div>
  
  <button type="submit" class="btn btn-primary fw-bold">Registrar</button>
</form>
	
</div>
