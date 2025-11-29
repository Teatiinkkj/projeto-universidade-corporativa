<?php
header('Content-Type: application/json');
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        "success" => false,
        "error" => "Usuário não logado"
    ]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

include '../../db/conexao.php';

try {

    // Consulta principal com progresso e matrícula
    $sql = "
        SELECT
            c.id,
            c.titulo,
            c.descricao,
            c.imagem,
            c.status,
            CASE WHEN m.id IS NOT NULL THEN 1 ELSE 0 END AS matriculado,
            COALESCE(
                (SELECT ROUND((COUNT(p.conteudo_id) / NULLIF((SELECT COUNT(*) FROM conteudo WHERE topico_id IN (SELECT id FROM topicos WHERE curso_id = c.id)), 0)) * 100)
                 FROM progresso p
                 WHERE p.usuario_id = :usuario_id AND p.conteudo_id IN (SELECT id FROM conteudo WHERE topico_id IN (SELECT id FROM topicos WHERE curso_id = c.id)) AND p.concluido = 1
                ), 0
            ) AS progresso
        FROM cursos c
        LEFT JOIN matriculas m
            ON m.curso_id = c.id AND m.usuario_id = :usuario_id
        ORDER BY c.titulo
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $cursos
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Erro ao acessar o banco de dados: " . $e->getMessage()
    ]);
}
