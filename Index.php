<?php
require ("Controlador/Plantilla.Controlador.php");
require ("Controlador/Formulario.Controlador.php");

//forma llamar funcion que es estatica
//$plantilla= ControladorPlantilla::cargarPlantilla();


//Forma de llamar funcion publica no estatica
$plantilla= new ControladorPlantilla();
$plantilla->cargarPlantilla();
