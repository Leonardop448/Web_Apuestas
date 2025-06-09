<?php
$actualizarusuario = FormularioControlador::actualizarUsuario();
?>


<div class="form-outline mb-4" align="center">
<form method="POST">

<label class="form-label " for="documento">Documento: </label>
<?php echo $_SESSION[ 'cedula' ]?><br>
<label class="form-label " for="nombre">Nombre: </label>
<input type="text" id="nombre" name= "nombre" value="<?php echo $_SESSION[ 'nombre' ]?>" required><br>
<label class="form-label " for="email">Correo Electronico: </label>
<input type="email" id="email" name="email"value="<?php echo $_SESSION[ 'email' ]?>"><br>
<label class="form-label " for="number" >Telefono: </label>
<input type="number" id="telefono" name="telefono" value="<?php echo $_SESSION[ 'telefono' ]?>" required><br>
<input type="submit" value= "Actualizar">

<?php
if ($actualizarusuario>=1){
  ?><script>
  window.confirm("Se han actualizado los datos, Inicia sesion nuevamente");
  </script>
	<?php
  
  session_destroy();
  header("location: index.php");
  }
	

?>


</form>
</div>