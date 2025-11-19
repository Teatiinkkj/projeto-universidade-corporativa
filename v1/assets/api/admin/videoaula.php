<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para login se não estiver logado
    header("Location: ../../../../index.php");
    exit;
}

include __DIR__ . '/../../db/conexao.php';

// Pegar o ID do curso via GET
$curso_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($curso_id <= 0) {
    header("Location: ../../admin/html/inicio.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// 🔒 Verificar se o usuário está matriculado neste curso
$sqlVerificaMatricula = "SELECT id FROM matriculas WHERE usuario_id = ? AND curso_id = ?";
$stmtVerifica = $conn->prepare($sqlVerificaMatricula);
$stmtVerifica->bind_param("ii", $usuario_id, $curso_id);
$stmtVerifica->execute();
$resultVerifica = $stmtVerifica->get_result();

if ($resultVerifica->num_rows === 0) {
    // ❌ Não matriculado → redireciona com mensagem
    header("Location: ../../admin/html/inicio.php?erro=sem_matricula");
    exit;
}

// Buscar dados do curso
$sqlCurso = "SELECT * FROM cursos WHERE id = ? AND status = 1";
$stmtCurso = $conn->prepare($sqlCurso);
$stmtCurso->bind_param("i", $curso_id);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();
$curso = $resultCurso->fetch_assoc();
if (!$curso) {
    die("Curso não encontrado!");
}

// Buscar tópicos e conteúdos
$sqlTopicos = "SELECT * FROM topicos WHERE curso_id = ? ORDER BY ordem ASC";
$stmtTopicos = $conn->prepare($sqlTopicos);
$stmtTopicos->bind_param("i", $curso_id);
$stmtTopicos->execute();
$resultTopicos = $stmtTopicos->get_result();
$topicos = $resultTopicos->fetch_all(MYSQLI_ASSOC);

foreach ($topicos as &$topico) {
    $sqlConteudo = "SELECT * FROM conteudo WHERE topico_id = ? AND tipo IN ('video', 'pdf') ORDER BY ordem ASC";
    $stmtConteudo = $conn->prepare($sqlConteudo);
    $stmtConteudo->bind_param("i", $topico['id']);
    $stmtConteudo->execute();
    $resultConteudo = $stmtConteudo->get_result();
    $topico['conteudos'] = $resultConteudo->fetch_all(MYSQLI_ASSOC);
}
unset($topico);

// Incluir a view
include __DIR__ . '/../../admin/html/videoaula_view.php';
?>
