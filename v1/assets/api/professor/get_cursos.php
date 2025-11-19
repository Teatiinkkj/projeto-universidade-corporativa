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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "universidade_corporativa";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta principal com progresso e matrícula
    $sql = "
        SELECT
            c.id,
            c.titulo,
            c.descricao,
            c.imagem,
            c.status,
            CASE WHEN m.id IS NOT NULL THEN 1 ELSE 0 END AS matriculado,
            COALESCE(v.progresso, 0) AS progresso
        FROM cursos c
        LEFT JOIN matriculas m
            ON m.curso_id = c.id AND m.usuario_id = :usuario_id
        LEFT JOIN (
            SELECT
                m.usuario_id,
                m.curso_id,
                ROUND(
                    (COUNT(DISTINCT CASE WHEN p.concluido = 1 THEN p.conteudo_id END) /
                     COUNT(DISTINCT c.id)) * 100, 0
                ) AS progresso
            FROM matriculas m
            JOIN cursos cu ON cu.id = m.curso_id
            JOIN topicos t ON t.curso_id = cu.id
            JOIN conteudo c ON c.topico_id = t.id
            LEFT JOIN progresso p
                ON p.conteudo_id = c.id AND p.usuario_id = m.usuario_id
            WHERE m.usuario_id = :usuario_id
            GROUP BY m.usuario_id, m.curso_id
        ) v ON v.curso_id = c.id AND v.usuario_id = :usuario_id
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
