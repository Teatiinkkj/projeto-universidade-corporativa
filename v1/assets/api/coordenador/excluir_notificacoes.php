<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../../db/conexao.php';

// Verifica autenticação
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

try {
    $stmt = $conn->prepare("DELETE FROM notificacoes WHERE usuario_id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();

    if ($stmt->affected_rows >= 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma notificação encontrada.']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
exit;
?>
