<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');
if (isset($_GET['pagina']) && $_GET['pagina'] === 'Salir') {
    include 'Vista/Paginas/Salir.php';
    exit;
}
if (isset($_GET['pagina']) && $_GET['pagina'] === 'exportar_ganancia_pdf') {
    include "Vista/Paginas/exportar_ganancia_pdf.php";
    exit;
} else {

}

require("Controlador/Plantilla.Controlador.php");
require("Controlador/Formulario.Controlador.php");



$plantilla = new ControladorPlantilla();
$plantilla->cargarPlantilla();
