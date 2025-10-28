<?php
session_start();
require_once '../../db/conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit();
}

$q = trim($_GET['q'] ?? '');

if ($q === '') {
    echo json_encode([]);
    exit();
}

// Busca cursos com nome parecido
$stmt = $conn->prepare("SELECT id, titulo, descricao, imagem FROM cursos WHERE titulo LIKE CONCAT('%', ?, '%') LIMIT 5");
$stmt->bind_param('s', $q);
$stmt->execute();
$result = $stmt->get_result();

$cursos = [];
while ($row = $result->fetch_assoc()) {
    $cursos[] = $row;
}

echo json_encode($cursos);
