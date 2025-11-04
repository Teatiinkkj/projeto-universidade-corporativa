<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar notificações recentes (inclui curso_concluido)
$sql = "
    SELECT id, tipo, descricao, lida, 
           DATE_FORMAT(data_criacao, '%d/%m/%Y %H:%i') AS data_criacao
    FROM notificacoes
    WHERE usuario_id = ?
    ORDER BY data_criacao DESC
    LIMIT 20
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$notificacoes = [];
while ($row = $result->fetch_assoc()) {
    $notificacoes[] = $row;
}

echo json_encode($notificacoes);
$stmt->close();
$conn->close();
?>
