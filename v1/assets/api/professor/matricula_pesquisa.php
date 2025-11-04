<?php
session_start();
require_once('../../db/conexao.php');

// Impede erros e HTML indevido
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'nao_logado']);
    exit;
}

$usuario_id = intval($_SESSION['usuario_id']);
$curso_id = intval($_GET['curso_id'] ?? $_POST['curso_id'] ?? 0);

// Valida curso
if ($curso_id <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Curso inválido.']);
    exit;
}

try {
    // Verifica matrícula
    $stmt = $conn->prepare("SELECT 1 FROM matriculas WHERE usuario_id = ? AND curso_id = ?");
    $stmt->bind_param("ii", $usuario_id, $curso_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo json_encode(['status' => 'matriculado']);
    } else {
        echo json_encode(['status' => 'nao_matriculado']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao verificar matrícula.']);
}
exit;
