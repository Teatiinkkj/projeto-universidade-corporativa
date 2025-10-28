<?php
session_start();
require_once('../../db/conexao.php');

// Impede erros, notices e HTML indesejado
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'nao_logado']);
    exit;
}

$usuario_id = intval($_SESSION['usuario_id']);

// Aceita tanto GET quanto POST
$curso_id = intval($_POST['curso_id'] ?? $_GET['curso_id'] ?? 0);

if ($curso_id <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Curso inválido.']);
    exit;
}

// Verifica se o usuário já está matriculado
$stmt = $conn->prepare("SELECT 1 FROM matriculas WHERE usuario_id = ? AND curso_id = ?");
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'matriculado']);
} else {
    echo json_encode(['status' => 'nao_matriculado']);
}

exit;
