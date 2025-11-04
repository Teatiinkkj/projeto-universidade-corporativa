<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

// Recebe dados do POST
$topico_id = intval($_POST['topico_id'] ?? 0);
$tipo = $_POST['tipo'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$ordem = intval($_POST['ordem'] ?? 0);

// Validação básica
if (!$topico_id || !$tipo || !$titulo) {
    echo json_encode(['status'=>'erro','mensagem'=>'Todos os campos são obrigatórios.']);
    exit;
}

// Upload de arquivo
$arquivo_path = '';
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
    $novo_nome = uniqid() . '.' . $ext;
    $destino = '../../uploads/' . $novo_nome;

    if (!is_dir('../../uploads')) {
        mkdir('../../uploads', 0755, true);
    }

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo_path = 'uploads/' . $novo_nome;
    } else {
        echo json_encode(['status'=>'erro','mensagem'=>'Erro ao enviar o arquivo.']);
        exit;
    }
}

// Inserir no banco
$stmt = $conn->prepare("INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao preparar query: '.$conn->error]);
    exit;
}

// bind_param: s/strings não aceitam null, então usamos ''
$stmt->bind_param("isssi", $topico_id, $tipo, $titulo, $arquivo_path, $ordem);

if ($stmt->execute()) {
    echo json_encode(['status'=>'sucesso','mensagem'=>'Conteúdo adicionado com sucesso.']);
} else {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro ao adicionar conteúdo: '.$stmt->error]);
}

$stmt->close();
$conn->close();
?>
