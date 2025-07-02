<?php
date_default_timezone_set('America/Bogota');
if (isset($_GET['pagina']) && $_GET['pagina'] === 'Salir') {
    include 'Vista/Paginas/Salir.php';
    exit;
}
if (isset($_GET['pagina']) && $_GET['pagina'] === 'exportar_ganancia_pdf') {
    include "Vista/Paginas/exportar_ganancia_pdf.php";
    exit;
}
if ($_GET["pagina"] == "RecuperarContrasena") {
    include "Vista/Paginas/RecuperarContrasena.php";
} else {

}

require("Controlador/Plantilla.Controlador.php");
require("Controlador/Formulario.Controlador.php");



$plantilla = new ControladorPlantilla();
$plantilla->cargarPlantilla();
