<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID do tópico não fornecido']);
    exit;
}

$id = intval($_POST['id']);

$sql = "DELETE FROM topicos WHERE id=$id";
if ($conn->query($sql)) {
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Tópico excluído com sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir tópico: ' . $conn->error]);
}
?>
