<form class="container col-sm-4" align="center" method="post">
          
          <div class="" >
            <p class="mx-1 mb-0"><h4 class="text-center fw-bold">Cargar Creditos</h4></p>
          </div>

          <!-- Cedula input -->
          <div class="form-outline mb-4">
			  <label class="form-label " for="email"><h5 class=" fw-bold">Cedula</h5></label>
            <input type="number" id="cedula" name="cedula" class="form-control form-control-lg"
              placeholder="Ingrese documento" />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
			  <label class="form-label fw-bold" for="cantidad"><h5 class=" fw-bold">Cantidad</h5></label>
            <input type="number" id="cantidad" name="cantidad" class="form-control form-control-lg"
              placeholder="Cantidad a Recargar" />
          </div>

          

          <div class="">
            <input type="submit" class="btn btn-primary btn-lg" name="verificar" value="Verificar"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">
            
          </div>
        <?php      
          $ingreso = FormularioControlador::verificarRecargar();
          if(isset($ingreso)){
            $token=$ingreso['token'];
            $nombre=$ingreso['nombre'];
            $telefono=$ingreso['telefono'];
            $correo=$ingreso['correo'];
            $cantidad=$ingreso['cantidad'];

        ?>

</form>
        <div class="container col-sm-4" align="center">
  <h2>Datos de Usuarios</h2>
  <p>Verifique que los datos de los usuarios sean los correctos</p>
  <table class="table">
    
    <tbody >
    <tr class="table">
        <td class="table-success" ><strong>Nombre</strong></td>
        <td><?php echo $nombre?></td>
        
      </tr>  
    <tr class="table">
        <td class="table-success" ><strong>Telefono</strong></td>
        <td><?php echo $telefono;?></td>
        
      </tr>
      <tr>
        <td class="table-success"><strong>Correo</strong></td>
        <td><?php echo $correo;?></td>
        
      </tr>
      <tr>
        <td class="table-success"><strong>Cantidad</strong></td>
        <td><?php echo $cantidad;?></td>
        
      </tr>
    </tbody>
  </table>
</div>

<form method="post" action = "#">
          
          <div class="divider d-flex align-items-center my-4 ">
                    
            <input type="hidden" id="valor" name="valor" class="form-control form-control-lg" value="<?php echo $cantidad;?>"/>
                   
            <input type="hidden" id="token" name="token" class="form-control form-control-lg" value="<?php echo $token;?>"/>
          

          

          <div class="container col-sm-4" align="center">
            <input type="submit" class="btn btn-primary btn-lg" name="recargar" value="Recargar"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">
            
          </div>
          <?php      }   ?>
        <?php      
          $ingreso = FormularioControlador::recargar();
         
        
        ?>

</form>     


