<?php
require 'vendor/autoload.php';
require_once 'Modelo/Formularios.Modelo.php';

use Dompdf\Dompdf;

$tipo = $_GET['tipo'] ?? '';
$contenido = '';

if ($tipo === 'carrera' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $ganancia = ModeloFormularios::calcularGananciaPorCarrera($id);

    $contenido = "
        <h2>Ganancias por Carrera</h2>
        <p><strong>Total Apostado:</strong> $" . number_format($ganancia['total_apostado']) . "</p>
        <p><strong>Total Pagado:</strong> $" . number_format($ganancia['total_pagado']) . "</p>
        <p><strong>Ganancia:</strong> $" . number_format($ganancia['ganancia']) . "</p>
    ";
} elseif ($tipo === 'mes' && isset($_GET['mes'])) {
    $mes = $_GET['mes'];
    $ganancia = ModeloFormularios::calcularGananciaPorMes($mes);

    $contenido = "
        <h2>Ganancias del Mes $mes</h2>
        <p><strong>Total Apostado:</strong> $" . number_format($ganancia['total_apostado']) . "</p>
        <p><strong>Total Pagado:</strong> $" . number_format($ganancia['total_pagado']) . "</p>
        <p><strong>Ganancia:</strong> $" . number_format($ganancia['ganancia']) . "</p>
    ";
} else {
    exit('Parámetros inválidos');
}

// Crear PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($contenido);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Forzar descarga directa
$filename = 'ganancias_' . date('Ymd_His') . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
exit;
