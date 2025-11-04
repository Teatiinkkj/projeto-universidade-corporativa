<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit();
}

$usuarioId = $_SESSION['usuario_id'];

// Marcar todas como lidas
if(isset($_GET['marcar_lidas'])) {
    $stmt = $conn->prepare("UPDATE notificacoes SET lida = 1 WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    exit();
}

// Buscar notificações recentes
$stmt = $conn->prepare("
    SELECT id, tipo, descricao, lida, data_criacao
    FROM notificacoes
    WHERE usuario_id = ?
    ORDER BY data_criacao DESC
    LIMIT 5
");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$notificacoes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Contar notificações não lidas
$stmt2 = $conn->prepare("SELECT COUNT(*) as total FROM notificacoes WHERE usuario_id = ? AND lida = 0");
$stmt2->bind_param("i", $usuarioId);
$stmt2->execute();
$totalNaoLidas = $stmt2->get_result()->fetch_assoc()['total'];

echo json_encode([
    'notificacoes' => $notificacoes,
    'totalNaoLidas' => $totalNaoLidas
]);
