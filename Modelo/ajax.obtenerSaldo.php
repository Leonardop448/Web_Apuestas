<?php

require_once "../modelos/Formularios.Modelo.php";

$id_usuario = $_SESSION['id'] ?? null;

if ($id_usuario) {
    $nuevoSaldo = ModeloFormularios::obtenerSaldo($id_usuario);
    $_SESSION['saldo'] = $nuevoSaldo;
    echo json_encode(['saldo' => number_format($nuevoSaldo, 0, ',', '.')]);
} else {
    echo json_encode(['error' => 'Usuario no autenticado']);
}
?>