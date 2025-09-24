<?php
// api/admin/topicos_listar.php
header('Content-Type: application/json');
include '../../db/conexao.php';

$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

if ($curso_id > 0) {
    $sql = "SELECT * FROM topicos WHERE curso_id = $curso_id ORDER BY id DESC";
} else {
    echo json_encode([]);
    exit;
}

$result = $conn->query($sql);

$topicos = [];
while ($row = $result->fetch_assoc()) {
    $topicos[] = $row;
}

echo json_encode($topicos);
