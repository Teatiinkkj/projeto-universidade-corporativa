<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['sucesso' => false, 'erro' => 'Usuário não logado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$conteudo_id = isset($_POST['conteudo_id']) ? intval($_POST['conteudo_id']) : 0;

if ($conteudo_id <= 0) {
    echo json_encode(['sucesso' => false, 'erro' => 'Conteúdo inválido']);
    exit;
}

// Verifica se já existe progresso
$stmt = $conn->prepare("SELECT id FROM progresso WHERE usuario_id=? AND conteudo_id=?");
$stmt->bind_param("ii", $usuario_id, $conteudo_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // Insere novo registro
    $stmt = $conn->prepare("INSERT INTO progresso (usuario_id, conteudo_id, concluido) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $usuario_id, $conteudo_id);
    $stmt->execute();
} else {
    // Atualiza registro existente
    $stmt = $conn->prepare("UPDATE progresso SET concluido=1 WHERE usuario_id=? AND conteudo_id=?");
    $stmt->bind_param("ii", $usuario_id, $conteudo_id);
    $stmt->execute();
}

echo json_encode(['sucesso' => true]);
