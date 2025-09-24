<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$status = $_POST['status'] ?? '';

if (!$titulo || !$descricao || !$status) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Preencha todos os campos obrigatórios!'
    ]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO cursos (titulo, descricao, status) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $titulo, $descricao, $status);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Curso cadastrado com sucesso!'
    ]);
} else {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao adicionar curso: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
