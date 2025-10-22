<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado', 'conteudos' => []]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// =====================================
// Parte 1: Marca um conteúdo como concluído (se enviado via POST)
// =====================================
if (isset($_POST['conteudo_id'])) {
    $conteudo_id = intval($_POST['conteudo_id']);
    if ($conteudo_id > 0) {
        $stmt = $conn->prepare("
            INSERT INTO progresso (usuario_id, conteudo_id, concluido) 
            VALUES (?, ?, 1) 
            ON DUPLICATE KEY UPDATE concluido=1
        ");
        $stmt->bind_param("ii", $usuario_id, $conteudo_id);
        $stmt->execute();
        $stmt->close();

        // Buscar o título do curso relacionado
        $stmtCurso = $conn->prepare("
            SELECT c.titulo 
            FROM cursos c
            JOIN topicos t ON t.curso_id = c.id
            JOIN conteudo co ON co.topico_id = t.id
            WHERE co.id = ?
        ");
        $stmtCurso->bind_param("i", $conteudo_id);
        $stmtCurso->execute();
        $resultCurso = $stmtCurso->get_result()->fetch_assoc();
        $tituloCurso = $resultCurso['titulo'] ?? 'Curso';
        $stmtCurso->close();

        // Verifica se o usuário concluiu todas as aulas do curso
        $stmtCheck = $conn->prepare("
    SELECT 
        COUNT(DISTINCT co.id) AS total_aulas,
        SUM(IFNULL(p.concluido, 0)) AS aulas_concluidas
    FROM cursos c
    JOIN topicos t ON t.curso_id = c.id
    JOIN conteudo co ON co.topico_id = t.id
    LEFT JOIN progresso p ON p.conteudo_id = co.id AND p.usuario_id = ?
    WHERE c.titulo = ?
");
        $stmtCheck->bind_param("is", $usuario_id, $tituloCurso);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();

        $totalAulas = $resultCheck['total_aulas'] ?? 0;
        $aulasConcluidas = $resultCheck['aulas_concluidas'] ?? 0;

        // Se concluiu todas, cria a notificação
        if ($totalAulas > 0 && $totalAulas == $aulasConcluidas) {
            $stmtNotif = $conn->prepare("
        INSERT INTO notificacoes (usuario_id, tipo, descricao) 
        VALUES (?, 'curso_concluido', ?)
    ");
            $descricaoNotif = "🎓 Parabéns! Você concluiu o curso: $tituloCurso";
            $stmtNotif->bind_param("is", $usuario_id, $descricaoNotif);
            $stmtNotif->execute();
            $stmtNotif->close();
        }
    }
}

// =====================================
// Parte 2: Retorna todos os conteúdos com status de conclusão
// =====================================
$sql = "
    SELECT co.id, co.titulo, co.tipo, co.arquivo_path, 
           IFNULL(p.concluido, 0) AS concluido
    FROM conteudo co
    LEFT JOIN progresso p 
           ON p.conteudo_id = co.id AND p.usuario_id = ?
    ORDER BY co.topico_id, co.ordem
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$conteudos = [];
while ($row = $result->fetch_assoc()) {
    $row['concluido'] = (bool) $row['concluido']; // transforma em true/false
    $conteudos[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'conteudos' => $conteudos]);
