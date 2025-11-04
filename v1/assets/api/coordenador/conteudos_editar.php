<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

$conteudo_id = intval($_POST['id'] ?? 0);
$tipo = $_POST['tipo'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$ordem = intval($_POST['ordem'] ?? 0);

if (!$conteudo_id || !$tipo || !$titulo) {
    echo json_encode(['status'=>'erro','mensagem'=>'Todos os campos são obrigatórios.']);
    exit;
}

// Buscar arquivo antigo
$stmt = $conn->prepare("SELECT arquivo_path FROM conteudo WHERE id=?");
$stmt->bind_param("i", $conteudo_id);
$stmt->execute();
$result = $stmt->get_result();
$conteudo = $result->fetch_assoc();
$arquivo_path = $conteudo['arquivo_path'] ?? null;

// Substituir arquivo se enviado novo
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    if ($arquivo_path && file_exists('../../'.$arquivo_path)) unlink('../../'.$arquivo_path);

    $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
    $novo_nome = uniqid().'.'.$ext;
    $destino = '../../uploads/'.$novo_nome;
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo_path = 'uploads/'.$novo_nome;
    }
}

$stmt = $conn->prepare("UPDATE conteudo SET tipo=?, titulo=?, arquivo_path=?, ordem=? WHERE id=?");
$stmt->bind_param("sssii", $tipo, $titulo, $arquivo_path, $ordem, $conteudo_id);

if ($stmt->execute()) {
    echo json_encode(['status'=>'sucesso','mensagem'=>'Conteúdo atualizado com sucesso.']);
} else {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao atualizar conteúdo: '.$conn->error]);
}

$stmt->close();
$conn->close();
