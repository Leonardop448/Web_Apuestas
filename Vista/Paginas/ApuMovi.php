<?php
$movimientos = FormularioControlador::movimiento();
$Contarmovimientos = FormularioControlador::contarMovimiento();
?>
  <h2 align="center">Movimientos</h2>
  <h2 class="text-body" align="center"><?php echo "&nbsp;Saldo: $$saldo &nbsp;"; ?></h2>
          </h2>
  <div class="d-flex justify-content-center" align="center">
	
		<div class="alert alert-secondary">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Tipo</th>
					<th>Valor</th>
					</tr>
			</thead>
			<tbody>
				
				<?php
				foreach ( $movimientos AS $filas ) {
        $valor= $filas['valor'];
        $fecha= $filas['fecha'];
        $tipo= $filas['tipo'];
					
        if ($tipo=='Ganancia' || $tipo=='Recarga'){
        $color= "table-success";
        $signo="";
        }
        else{
          $color= "table-danger";
          $signo="-";
        }

					?>
				<tr class="<?php echo $color;?>">

					<td>
					    
						<?php echo $fecha; ?>
					</td>
					<td>
						<?php echo $tipo; ?>
					</td>
					<td>
						<?php echo $signo .number_format($valor); ?>
					</td>
					

				</tr>
				<?php  } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="d-flex justify-content-center" align="center">Pagina 
<?php ///// Estos if son para la paginacion y que se pongan en negrita en la pagina que esta
	for ($i=1; $i<=ceil(($Contarmovimientos['Cantidad']/10));$i++){
		if (isset($_GET['paginas'])&& $_GET['paginas']==$i)  {
			$negrita= "<strong>$i </strong>";
		
		}
		elseif (!isset($_GET['paginas'])&& 1==$i)  {
			$negrita= "<strong>$i </strong>";
		
		}
		else {
			$negrita= $i;
		}
		

		echo "&nbsp;";
		echo "<a class='nav-link text-black' href='?pagina=ApuMovi&paginas=$i'>$negrita</a>";
	}
  

	?>

</div>


