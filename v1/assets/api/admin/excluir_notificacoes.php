<?php
session_start();
require_once '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$stmt = $conn->prepare("DELETE FROM notificacoes WHERE usuario_id = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();

echo json_encode(['status' => 'sucesso']);
?>
