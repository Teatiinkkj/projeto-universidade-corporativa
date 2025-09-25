<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT conteudo_id FROM progresso WHERE usuario_id=? AND concluido=1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$ids = [];
while ($row = $result->fetch_assoc()) {
    $ids[] = intval($row['conteudo_id']);
}

echo json_encode($ids);
