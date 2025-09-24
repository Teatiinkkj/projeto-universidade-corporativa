<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método inválido, use POST']);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM cursos WHERE id = ?");
if (!$stmt) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no prepare: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Curso excluído com sucesso.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Nenhum curso foi deletado (ID não existe).']);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
