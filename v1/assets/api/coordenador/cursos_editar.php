<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

$id = $_POST['id'] ?? 0;
$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$status = $_POST['status'] ?? '';

if (!$id || !$titulo || !$descricao) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Preencha todos os campos obrigatórios'
    ]);
    exit;
}

// Usando prepared statement para segurança
$stmt = $conn->prepare("UPDATE cursos SET titulo = ?, descricao = ?, status = ? WHERE id = ?");
$stmt->bind_param("sssi", $titulo, $descricao, $status, $id);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Curso atualizado com sucesso'
    ]);
} else {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao atualizar curso'
    ]);
}

$stmt->close();
$conn->close();
