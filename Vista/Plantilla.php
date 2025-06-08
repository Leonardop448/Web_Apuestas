<?php
//avisamos al navegador que se utilizaran variables de session.
session_start();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Inicio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/b84470ec17.js" crossorigin="anonymous"></script>
  
</head>
<body>
<?php
	$listadoPaginasprivadas = array("CargarCreditos","Salir","Perfil","ApuMovi","Ajustes");
  $listadopaginaspublicas = array ("ProximosEventos","Resultados","Inicio","Registro","RecuperarContrasena","ActivarCuenta");
	if (isset($_GET['pagina'])){
		$pagina = $_GET['pagina'];
    $paginaVerificada=$pagina;
		
    
    if (in_array($pagina,$listadoPaginasprivadas)&& isset($_SESSION['privilegios'])) {
				$paginaVerificada=$pagina;
			
			}
    
    
      elseif(in_array($pagina,$listadopaginaspublicas)){
				$paginaVerificada=$pagina;
      if ($paginaVerificada== 'Inicio' && isset($_SESSION['privilegios']) == 'Cliente'){
          $paginaVerificada='Perfil';
        }
      }
      
		
    
      else{
				$paginaVerificada= "404";
			}
	
	}



  else {
    $paginaVerificada = "ProximosEventos";
  }
?>
	<div align="center">
		<img src="/Imagenes/pngwing.com (3).png" alt="" width="10%" height="auto">
		<img src="/Imagenes/nombreinicio.png" alt="" width="50%" height="auto">
	</div>
  <?php
  if (isset($_SESSION['privilegios'])){
     $balance = FormularioControlador::balance();
     $saldo = number_format($balance['ingresos']- $balance['egresos']);
  
     ?>
    
      <h2>
          <a  class = "nav-link text-white fw-bold"  align="right" href="?pagina=ApuMovi"> <strong class="text-warning"><i class="fa-solid fa-sack-dollar fa-bounce" style="color: #ffc107;"></i><?php echo "&nbsp;$saldo &nbsp;"; ?></strong></a>
          </h2>
  <?php } ?> 
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container col-sm-4" align="center">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=Inicio">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=ProximosEventos">Proximos Eventos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=Resultados">Resultados</a>
        </li>
        <?php
    // Esto es para oculta el menu de Cuenta solo para cuando ya inicio session
  if (isset($_SESSION['privilegios'])){
     
    ?>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=CargarCreditos">Cargar Creditos</a>
        </li>
        <?php
  }
  ?>    
      </ul>
		</div>
	  </div>
    
    <?php
    // Esto es para oculta el menu de Cuenta solo para cuando ya inicio session
  if (isset($_SESSION['privilegios'])){
     
    
    ?>
          <li class="nav-item dropdown col-sm-1.5" align="left">
          <a class="nav-link dropdown-toggle text-white fw-bold " href="" role="button" data-bs-toggle="dropdown"><?php echo $_SESSION['nombre']; ?> </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item" href="?pagina=Perfil">Perfil</a></li>
            <li><a class="dropdown-item" href="?pagina=ApuMovi">Apuestas y Movimientos</a></li>
            <li><a class="dropdown-item" href="?pagina=Ajustes">Ajustes</a></li>
            <li><a class="dropdown-item" href="?pagina=Salir">Salir</a></li>
		  </ul>
        </li>
    
  <?php
  }
  else {

  
  ?>
<li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=Registro">Registrarse &nbsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="?pagina=Inicio">Login &nbsp;</a>
        </li>
  <?php
  }
  ?>
</nav>

<div class="container-fluid mt-3">
  <?php
	include("Vista/Paginas/$paginaVerificada.php")
?>
</div>
	

</body>
</html>