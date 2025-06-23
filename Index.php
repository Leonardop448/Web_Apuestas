<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['pagina']) && $_GET['pagina'] === 'Salir') {
    include 'Vista/Paginas/Salir.php';
    exit;
}

require("Controlador/Plantilla.Controlador.php");
require("Controlador/Formulario.Controlador.php");



$plantilla = new ControladorPlantilla();
$plantilla->cargarPlantilla();
