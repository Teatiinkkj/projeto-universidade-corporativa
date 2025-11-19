<?php
session_start();
include __DIR__ . '/../../db/conexao.php';

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../../index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$curso_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($curso_id <= 0) {
    header("Location: ../../admin/html/inicio.php");
    exit;
}

// Busca informações do curso
$stmt = $conn->prepare("SELECT * FROM cursos WHERE id = ? AND status = 1");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$curso = $result->fetch_assoc();
if (!$curso) {
    die("Curso não encontrado.");
}

// Verifica se o usuário já está matriculado
$stmtMatricula = $conn->prepare("SELECT * FROM matriculas WHERE usuario_id = ? AND curso_id = ?");
$stmtMatricula->bind_param("ii", $usuario_id, $curso_id);
$stmtMatricula->execute();
$matriculado = $stmtMatricula->get_result()->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($curso['titulo']) ?> | UNICORP</title>
    <link rel="stylesheet" href="../../css/website.css">
    <link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 100px;">
        <div class="card shadow p-4">
            <img src="<?= htmlspecialchars($curso['imagem'] ?: '../../images/imgsemfundo2.png') ?>"
                 alt="Imagem do Curso" class="img-fluid mb-4 rounded">
            <h2><?= htmlspecialchars($curso['titulo']) ?></h2>
            <p class="text-muted"><?= htmlspecialchars($curso['descricao']) ?></p>

            <div class="mt-4">
                <?php if ($matriculado): ?>
                    <a href="videoaula.php?id=<?= $curso_id ?>" class="btn btn-success btn-lg">
                        Acessar Curso
                    </a>
                <?php else: ?>
                    <form method="POST" action="../../api/curso/matricular.php" style="display:inline;">
                        <input type="hidden" name="curso_id" value="<?= $curso_id ?>">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Matricular-se no Curso
                        </button>
                    </form>
                <?php endif; ?>
                <a href="../../admin/html/inicio.php" class="btn btn-secondary btn-lg">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</body>
</html>
