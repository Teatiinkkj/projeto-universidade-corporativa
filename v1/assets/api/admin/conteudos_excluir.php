<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

$conteudo_id = intval($_POST['id'] ?? 0);

if (!$conteudo_id) {
    echo json_encode(['status'=>'erro','mensagem'=>'ID inválido.']);
    exit;
}

// Buscar arquivo para excluir
$stmt = $conn->prepare("SELECT arquivo_path FROM conteudo WHERE id=?");
if (!$stmt) {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao preparar query: '.$conn->error]);
    exit;
}

$stmt->bind_param("i", $conteudo_id);
$stmt->execute();
$result = $stmt->get_result();
$conteudo = $result->fetch_assoc();
$stmt->close();

$arquivo_path = $conteudo['arquivo_path'] ?? '';

if ($arquivo_path) {
    $caminho_completo = realpath('../../' . $arquivo_path);
    if ($caminho_completo && file_exists($caminho_completo)) {
        if (!unlink($caminho_completo)) {
            echo json_encode(['status'=>'erro','mensagem'=>'Não foi possível excluir o arquivo físico.']);
            exit;
        }
    }
}

// Excluir do banco
$stmt = $conn->prepare("DELETE FROM conteudo WHERE id=?");
if (!$stmt) {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao preparar exclusão: '.$conn->error]);
    exit;
}

$stmt->bind_param("i", $conteudo_id);

if ($stmt->execute()) {
    echo json_encode(['status'=>'sucesso','mensagem'=>'Conteúdo excluído com sucesso.']);
} else {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao excluir conteúdo: '.$stmt->error]);
}

$stmt->close();
$conn->close();
?>
