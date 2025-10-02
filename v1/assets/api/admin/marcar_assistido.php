<?php
session_start();
include __DIR__ . '/../../db/conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$conteudo_id = intval($_POST['conteudo_id'] ?? 0);

if (!$usuario_id || !$conteudo_id) {
    echo json_encode(["sucesso" => false, "erro" => "Acesso inválido!"]);
    exit;
}

// Marcar conteúdo como concluído
$stmt = $conn->prepare("INSERT INTO progresso (usuario_id, conteudo_id, concluido) 
                        VALUES (?, ?, 1) 
                        ON DUPLICATE KEY UPDATE concluido = 1");
$stmt->bind_param("ii", $usuario_id, $conteudo_id);
$stmt->execute();
$stmt->close();

// Obter o curso do conteúdo
$stmt = $conn->prepare("SELECT t.curso_id 
                        FROM topicos t
                        INNER JOIN conteudo c ON c.topico_id = t.id
                        WHERE c.id = ?");
$stmt->bind_param("i", $conteudo_id);
$stmt->execute();
$curso_id = $stmt->get_result()->fetch_assoc()['curso_id'];
$stmt->close();

// Verificar se todas as aulas do curso foram concluídas
$stmt = $conn->prepare("SELECT COUNT(*) AS total 
                        FROM conteudo c 
                        INNER JOIN topicos t ON c.topico_id = t.id 
                        WHERE t.curso_id = ? AND c.tipo IN ('video','pdf')");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$totalAulas = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS concluido 
                        FROM progresso p
                        INNER JOIN conteudo c ON p.conteudo_id = c.id
                        INNER JOIN topicos t ON c.topico_id = t.id
                        WHERE p.usuario_id = ? AND t.curso_id = ? AND p.concluido = 1 AND c.tipo IN ('video','pdf')");
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$concluido = $stmt->get_result()->fetch_assoc()['concluido'];
$stmt->close();

// Se todas concluídas, criar certificado (se ainda não existir)
$certificado = false;
if ($totalAulas > 0 && $totalAulas == $concluido) {
    $stmt = $conn->prepare("SELECT id FROM certificados WHERE usuario_id = ? AND curso_id = ?");
    $stmt->bind_param("ii", $usuario_id, $curso_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    if ($res->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO certificados (usuario_id, curso_id, data_emissao) VALUES (?, ?, ?)");
        $dataHoje = date('Y-m-d');
        $stmt->bind_param("iis", $usuario_id, $curso_id, $dataHoje);
        $stmt->execute();
        $stmt->close();
    }
    $certificado = true;
}

echo json_encode(['sucesso' => true, 'certificado' => $certificado]);
