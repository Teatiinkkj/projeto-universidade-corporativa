<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_POST['curso_id'], $_POST['titulo'], $_POST['ordem'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

$curso_id = intval($_POST['curso_id']);
$titulo = $conn->real_escape_string($_POST['titulo']);
$ordem = intval($_POST['ordem']);

$sql = "INSERT INTO topicos (curso_id, titulo, ordem) VALUES ($curso_id, '$titulo', $ordem)";
if ($conn->query($sql)) {
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Tópico adicionado com sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao adicionar tópico: ' . $conn->error]);
}
?>
