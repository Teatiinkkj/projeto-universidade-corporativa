<?php
session_start();
header('Content-Type: application/json');
include __DIR__ . '/../../db/conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$conteudo_id = intval($_POST['conteudo_id'] ?? 0);
$desmarcar = intval($_POST['desmarcar'] ?? 0);

if (!$usuario_id || !$conteudo_id) {
    echo json_encode(["sucesso" => false, "erro" => "Acesso inválido!"]);
    exit;
}

// Se desmarcar = 1 → define concluido = 0, senão marca como 1
$concluido = $desmarcar == 1 ? 0 : 1;

$stmt = $conn->prepare("
    INSERT INTO progresso (usuario_id, conteudo_id, concluido)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE concluido = VALUES(concluido)
");
$stmt->bind_param("iii", $usuario_id, $conteudo_id, $concluido);
$stmt->execute();
$stmt->close();

// Se estiver desmarcando, não precisa criar certificado nem verificar curso
if ($desmarcar == 1) {
    echo json_encode(['sucesso' => true, 'certificado' => false]);
    exit;
}

// Obter o curso do conteúdo
$stmt = $conn->prepare("
    SELECT t.curso_id 
    FROM topicos t
    INNER JOIN conteudo c ON c.topico_id = t.id
    WHERE c.id = ?
");
$stmt->bind_param("i", $conteudo_id);
$stmt->execute();
$cursoRow = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cursoRow) {
    echo json_encode(['sucesso' => true, 'certificado' => false]);
    exit;
}

$curso_id = $cursoRow['curso_id'];

// Verificar total de aulas do curso
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM conteudo c
    INNER JOIN topicos t ON c.topico_id = t.id
    WHERE t.curso_id = ? AND c.tipo IN ('video','pdf')
");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$totalAulas = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Verificar aulas concluídas
$stmt = $conn->prepare("
    SELECT COUNT(*) AS concluido
    FROM progresso p
    INNER JOIN conteudo c ON p.conteudo_id = c.id
    INNER JOIN topicos t ON c.topico_id = t.id
    WHERE p.usuario_id = ? AND t.curso_id = ? AND p.concluido = 1 AND c.tipo IN ('video','pdf')
");
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$concluido = $stmt->get_result()->fetch_assoc()['concluido'];
$stmt->close();

$certificado = false;

if ($totalAulas > 0 && $totalAulas == $concluido) {
    // Gera certificado (se ainda não existir)
    $stmt = $conn->prepare("SELECT id FROM certificados WHERE usuario_id = ? AND curso_id = ?");
    $stmt->bind_param("ii", $usuario_id, $curso_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    if ($res->num_rows == 0) {
        $dataHoje = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO certificados (usuario_id, curso_id, data_emissao) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $usuario_id, $curso_id, $dataHoje);
        $stmt->execute();
        $stmt->close();
    }

    $certificado = true;

    // 🔥 Busca nome do curso
    $stmt = $conn->prepare("SELECT titulo FROM cursos WHERE id = ?");
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $cursoNome = $stmt->get_result()->fetch_assoc()['titulo'] ?? 'Curso';
    $stmt->close();

    // 🔥 Cria notificação de curso concluído (se ainda não existir)
    $stmt = $conn->prepare("
        SELECT id FROM notificacoes 
        WHERE usuario_id = ? AND tipo = 'curso_concluido' AND descricao LIKE CONCAT('%', ?, '%')
    ");
    $stmt->bind_param("is", $usuario_id, $cursoNome);
    $stmt->execute();
    $jaExiste = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    if (!$jaExiste) {
        $descricao = "Você concluiu o curso '$cursoNome' e seu certificado foi gerado!";
        $stmt = $conn->prepare("
            INSERT INTO notificacoes (usuario_id, tipo, descricao, lida) 
            VALUES (?, 'curso_concluido', ?, 0)
        ");
        $stmt->bind_param("is", $usuario_id, $descricao);
        $stmt->execute();
        $stmt->close();
    }
}

echo json_encode(['sucesso' => true, 'certificado' => $certificado]);
