<?php
require_once '../Conexion.php';

if (!isset($_GET['id_carrera']))
    exit;

$id = $_GET['id_carrera'];
$pdo = (new Conexion())->conectar();

$stmt = $pdo->prepare("
    SELECT pilotos.id, pilotos.nombre 
    FROM carrera_pilotos 
    JOIN pilotos ON pilotos.id = carrera_pilotos.id_piloto 
    WHERE id_carrera = ?
");
$stmt->execute([$id]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));