<?php
session_start();
require_once '../../db/conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit();
}

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado ou erro no upload']);
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$foto = $_FILES['foto'];

// Define pasta onde as imagens serão salvas
$pastaDestino = '../../images/usuarios/';
if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0755, true);

// Gera um nome único para a imagem
$extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
$novoNome = 'usuario_'.$usuarioId.'_'.time().'.'.$extensao;
$caminhoCompleto = $pastaDestino . $novoNome;

// Move a imagem enviada para a pasta
if (!move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
    echo json_encode(['success' => false, 'message' => 'Falha ao salvar a imagem']);
    exit();
}

// Atualiza o banco de dados
$stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
$stmt->bind_param("si", $novoNome, $usuarioId);
if ($stmt->execute()) {
    // Retorna caminho relativo para exibição
    $fotoUrl = '../../images/usuarios/' . $novoNome;
    echo json_encode(['success' => true, 'foto' => $fotoUrl]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar banco de dados']);
}
