<?php
session_start();
require_once '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$foto = $user['foto'] ?? '';
$nome = $user['nome'] ?? '';
$email = $user['email'] ?? '';
$cpf = $user['cpf'] ?? '';
$cargo = $user['cargo'] ?? '';
$biografia = $user['biografia'] ?? '';

$caminhoImagens = '../../images/usuarios/';
$fotoPadrao = '../../images/default-avatar.png';
$fotoExibida = (!empty($foto) && file_exists($caminhoImagens . $foto)) ? $caminhoImagens . $foto : $fotoPadrao;

$matriculasStmt = $conn->prepare("
    SELECT c.titulo, m.status, c.id
    FROM matriculas m
    JOIN cursos c ON c.id = m.curso_id
    WHERE m.usuario_id = ?
");
$matriculasStmt->bind_param("i", $_SESSION['usuario_id']);
$matriculasStmt->execute();
$matriculas = $matriculasStmt->get_result();

$certificadosStmt = $conn->prepare("
    SELECT c.titulo, cert.data_emissao, cert.curso_id
    FROM certificados cert
    JOIN cursos c ON c.id = cert.curso_id
    WHERE cert.usuario_id = ?
");
$certificadosStmt->bind_param("i", $_SESSION['usuario_id']);
$certificadosStmt->execute();
$certificados = $certificadosStmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil - Universidade Corporativa</title>
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../../css/back-button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modal de confirmação automático */
        #confirmModalBg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        #confirmModalBg.show {
            opacity: 1;
            pointer-events: all;
        }

        #confirmModalContent {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 12px;
            max-width: 350px;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            text-align: center;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>

<body>

    <a href="javascript:void(0);" class="back-button" onclick="history.back()">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>

    <div class="perfil-container">
        <!-- Header -->
        <div class="perfil-header">
            <div class="perfil-foto-wrapper" id="fotoWrapper">
                <img id="fotoPerfil" src="<?= htmlspecialchars($fotoExibida) ?>" alt="Foto de perfil">
                <div class="alterar-foto-btn"><i class="fa fa-camera"></i></div>
            </div>
            <div>
                <h2><?= htmlspecialchars($nome) ?></h2>
                <p><i class="fa fa-envelope"></i> <?= htmlspecialchars($email) ?></p>
                <p><i class="fa fa-id-card"></i> <?= htmlspecialchars($cpf) ?></p>
                <p><i class="fa fa-briefcase"></i> <?= htmlspecialchars($cargo) ?></p>
            </div>
        </div>

        <!-- Cursos Matriculados -->
        <div class="perfil-secao">
            <h3>Cursos Matriculados</h3>
            <div class="cards-container">
                <?php while ($mat = $matriculas->fetch_assoc()): ?>
                    <div class="card">
                        <h4><?= htmlspecialchars($mat['titulo']) ?></h4>
                        <p>Status: <?= htmlspecialchars($mat['status']) ?></p>
                        <a href="../../api/admin/videoaula.php?curso_id=<?= $mat['id'] ?>" class="btn"><i class="fa fa-play"></i> Ver Curso</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Certificados -->
        <div class="perfil-secao">
            <h3>Certificados</h3>
            <div class="cards-container">
                <?php while ($cert = $certificados->fetch_assoc()): ?>
                    <div class="card">
                        <h4><?= htmlspecialchars($cert['titulo']) ?></h4>
                        <p>Emitido em: <?= htmlspecialchars($cert['data_emissao']) ?></p>
                        <a href="../../api/admin/gerar_certificado.php?curso_id=<?= $cert['curso_id'] ?>" class="btn"><i class="fa fa-download"></i> Baixar Certificado</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Modal cursos/certificados -->
    <div class="modal-bg" id="modalBg">
        <div class="modal" id="modalContent">
            <span class="close-btn" id="modalClose">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <form id="fotoForm" style="display:none;" enctype="multipart/form-data">
        <input type="file" name="foto" id="inputFoto" accept="image/*">
    </form>

    <!-- Modal de confirmação -->
    <div id="confirmModalBg">
        <div id="confirmModalContent">
            <div id="confirmModalBody"></div>
        </div>
    </div>

    <script>
        // =========================
        // Modal cursos/certificados
        // =========================
        const modalBg = document.getElementById('modalBg');
        const modalBody = document.getElementById('modalBody');
        const modalClose = document.getElementById('modalClose');

        document.querySelectorAll('.card .btn-ver').forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.card');
                const tipo = card.dataset.tipo;

                if (tipo === 'curso') {
                    const id = card.dataset.id;
                    modalBody.innerHTML = `
                        <h3>Curso #${id}</h3>
                        <p>Conteúdo do curso pode ser exibido aqui...</p>
                        <a href="curso.php?id=${id}" class="btn"><i class="fa fa-play"></i> Acessar Curso</a>
                    `;
                } else if (tipo === 'certificado') {
                    const curso = card.dataset.curso;
                    modalBody.innerHTML = `
                        <h3>Certificado: ${curso}</h3>
                        <a href="certificado.php?curso=${curso}" class="btn"><i class="fa fa-download"></i> Baixar Certificado</a>
                    `;
                }

                modalBg.style.display = 'flex';
            });
        });

        modalClose.addEventListener('click', () => modalBg.style.display = 'none');
        modalBg.addEventListener('click', e => { if (e.target === modalBg) modalBg.style.display = 'none'; });

        // =========================
        // Modal de confirmação automático
        // =========================
        const confirmModalBg = document.getElementById('confirmModalBg');
        const confirmModalBody = document.getElementById('confirmModalBody');

        function mostrarConfirmacao(msg) {
            confirmModalBody.innerHTML = `<p>${msg}</p>`;
            confirmModalBg.classList.add('show');

            // Sumiço automático em 2,5 segundos
            setTimeout(() => {
                confirmModalBg.classList.remove('show');
            }, 1000);
        }

        // =========================
        // Alterar foto de perfil
        // =========================
        const fotoWrapper = document.getElementById('fotoWrapper');
        const inputFoto = document.getElementById('inputFoto');
        const fotoPerfil = document.getElementById('fotoPerfil');

        fotoWrapper.addEventListener('click', () => inputFoto.click());

        inputFoto.addEventListener('change', async function () {
            if (this.files.length === 0) return;

            const formData = new FormData();
            formData.append('foto', this.files[0]);

            try {
                const res = await fetch('../../api/admin/alterar_foto.php', { method: 'POST', body: formData });
                const data = await res.json();

                if (data.success) {
                    fotoPerfil.src = data.foto + '?t=' + new Date().getTime();
                    mostrarConfirmacao('Foto atualizada com sucesso!');
                } else {
                    mostrarConfirmacao('Erro ao atualizar foto: ' + data.message);
                }
            } catch (err) {
                console.error('Erro no envio da imagem:', err);
                mostrarConfirmacao('Ocorreu um erro ao enviar a imagem.');
            }
        });
    </script>

</body>
</html>
