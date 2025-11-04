<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_POST['id'], $_POST['titulo'], $_POST['ordem'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

$id = intval($_POST['id']);
$titulo = $conn->real_escape_string($_POST['titulo']);
$ordem = intval($_POST['ordem']);

$sql = "UPDATE topicos SET titulo='$titulo', ordem=$ordem WHERE id=$id";
if ($conn->query($sql)) {
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Tópico atualizado com sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar tópico: ' . $conn->error]);
}
?>
