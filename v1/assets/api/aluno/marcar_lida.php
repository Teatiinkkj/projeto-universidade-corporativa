<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$notif_id = intval($_POST['id'] ?? 0);

if (!$notif_id) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $conn->prepare("UPDATE notificacoes SET lida=1 WHERE id=? AND usuario_id=?");
$stmt->bind_param("ii", $notif_id, $usuario_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
