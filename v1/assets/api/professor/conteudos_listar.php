<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

$topico_id = intval($_GET['topico_id'] ?? 0);

if (!$topico_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, topico_id, tipo, titulo, arquivo_path, ordem FROM conteudo WHERE topico_id = ? ORDER BY ordem ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$result = $stmt->get_result();

$lista = [];
while ($row = $result->fetch_assoc()) {
    $lista[] = $row; // agora pega todas as colunas corretas
}

echo json_encode($lista);

$stmt->close();
$conn->close();
