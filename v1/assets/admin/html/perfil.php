<?php
session_start();
require_once '../../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

// Dados do usuário
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

// Cursos matriculados + progresso
$matriculasStmt = $conn->prepare("
    SELECT 
        c.id AS curso_id,
        c.titulo,
        c.imagem,
        m.status,
        IFNULL(p.progresso, 0) AS progresso
    FROM matriculas m
    JOIN cursos c ON c.id = m.curso_id
    LEFT JOIN view_progresso_curso p 
        ON p.usuario_id = m.usuario_id AND p.curso_id = m.curso_id
    WHERE m.usuario_id = ?
");
$matriculasStmt->bind_param("i", $_SESSION['usuario_id']);
$matriculasStmt->execute();
$matriculas = $matriculasStmt->get_result();

// Certificados
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/back-button.css">
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
                <div class="alterar-foto-btn">
                    <i class="fa fa-camera"></i>
                </div>
            </div>

            <div class="perfil-info">
                <h2><?= htmlspecialchars($nome) ?></h2>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fa fa-envelope"></i> <?= htmlspecialchars($email) ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-id-card"></i> <?= htmlspecialchars($cpf) ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-briefcase"></i> <?= htmlspecialchars($cargo) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="cards-container">
            <?php while ($mat = $matriculas->fetch_assoc()): ?>
                <div class="card card-curso" data-tipo="curso" data-id="<?= htmlspecialchars($mat['curso_id']) ?>">

                    <!-- Imagem do curso -->
                    <?php if (!empty($mat['imagem'])): ?>
                        <div class="card-img-wrapper">
                            <img src="<?= htmlspecialchars($mat['imagem']) ?>" alt="<?= htmlspecialchars($mat['titulo']) ?>" />
                        </div>
                    <?php endif; ?>

                    <div class="card-header">
                        <h4><?= htmlspecialchars($mat['titulo']) ?></h4>
                        <span class="status-badge <?= strtolower($mat['status']) ?>">
                            <?= htmlspecialchars($mat['status']) ?>
                        </span>
                    </div>

                    <!-- Barra de progresso moderna -->
                    <div class="progress-wrapper">
                        <div class="progress-bar" style="--progress: <?= $mat['progresso'] ?>%;">
                            <span><?= $mat['progresso'] ?>%</span>
                        </div>
                    </div>

                    <!-- Link do curso -->
                    <a href="../../api/admin/videoaula.php?id=<?= htmlspecialchars($mat['curso_id']) ?>"
                        class="btn btn-curso">
                        <i class="fa fa-play"></i> Acessar Curso
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Certificados -->
        <div class="perfil-secao">
            <h3>Certificados</h3>
            <div class="cards-container">
                <?php while ($cert = $certificados->fetch_assoc()): ?>
                    <div class="card card-certificado" data-tipo="certificado"
                        data-curso="<?= htmlspecialchars($cert['curso_id']) ?>">

                        <div class="card-header">
                            <h4><?= htmlspecialchars($cert['titulo']) ?></h4>
                            <span class="status-badge concluido">Emitido</span>
                        </div>

                        <p class="certificado-data">Emitido em: <?= htmlspecialchars($cert['data_emissao']) ?></p>

                        <a href="../../api/admin/gerar_certificado.php?curso_id=<?= htmlspecialchars($cert['curso_id']) ?>"
                            class="btn btn-certificado">
                            <i class="fa fa-download"></i> Baixar Certificado
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Modal (GENÉRICO) -->
        <div class="modal-bg" id="modalBg"
            style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:999;">
            <div class="modal" id="modalContent"
                style="background:#fff;border-radius:10px;padding:20px;max-width:500px;width:90%;position:relative;">
                <span class="close-btn" id="modalClose"
                    style="position:absolute;right:12px;top:8px;cursor:pointer;font-size:20px;">&times;</span>
                <div id="modalBody"></div>
            </div>
        </div>

        <form id="fotoForm" style="display:none;" enctype="multipart/form-data">
            <input type="file" name="foto" id="inputFoto" accept="image/*">
        </form>

        <script>
            // Modal genérico
            const modalBg = document.getElementById('modalBg');
            const modalBody = document.getElementById('modalBody');
            const modalClose = document.getElementById('modalClose');

            modalClose.addEventListener('click', () => modalBg.style.display = 'none');
            modalBg.addEventListener('click', e => { if (e.target === modalBg) modalBg.style.display = 'none'; });

            // Troca da foto de perfil
            const fotoWrapper = document.getElementById('fotoWrapper');
            const inputFoto = document.getElementById('inputFoto');
            const fotoPerfil = document.getElementById('fotoPerfil');

            fotoWrapper.addEventListener('click', () => inputFoto.click());

            inputFoto.addEventListener('change', async function () {
                if (!this.files || !this.files[0]) return;
                const formData = new FormData();
                formData.append('foto', this.files[0]);

                try {
                    const res = await fetch('../../api/admin/alterar_foto.php', { method: 'POST', body: formData });
                    const data = await res.json();
                    if (data.success) {
                        fotoPerfil.src = data.foto;
                        mostrarModalSucesso("Foto atualizada com sucesso!");
                    } else {
                        mostrarModalErro("Erro ao atualizar foto: " + (data.message || 'erro desconhecido'));
                    }
                } catch (err) {
                    mostrarModalErro("Erro ao enviar a imagem: " + err.message);
                }
            });

            // Feedback
            function mostrarModalSucesso(mensagem) {
                const modal = document.createElement('div');
                modal.className = 'modal-feedback sucesso';
                modal.innerHTML = `<i class="fa fa-check-circle"></i> ${mensagem}`;
                document.body.appendChild(modal);
                setTimeout(() => modal.classList.add('ativo'), 10);
                setTimeout(() => { modal.classList.remove('ativo'); setTimeout(() => modal.remove(), 300); }, 3000);
            }

            function mostrarModalErro(mensagem) {
                const modal = document.createElement('div');
                modal.className = 'modal-feedback erro';
                modal.innerHTML = `<i class="fa fa-times-circle"></i> ${mensagem}`;
                document.body.appendChild(modal);
                setTimeout(() => modal.classList.add('ativo'), 10);
                setTimeout(() => { modal.classList.remove('ativo'); setTimeout(() => modal.remove(), 300); }, 3000);
            }

            // Modal card duplo clique
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('dblclick', function () {
                    const tipo = this.dataset.tipo;
                    if (tipo === 'curso') {
                        const id = this.dataset.id;
                        modalBody.innerHTML = `<h3>Curso: ${this.querySelector('h4').innerText}</h3>
                <p>Deseja acessar o curso?</p>
                <a href="../../api/admin/videoaula.php?curso_id=${id}" class="btn" style="display:inline-block;margin-top:10px;">Acessar Curso</a>`;
                        modalBg.style.display = 'flex';
                    } else if (tipo === 'certificado') {
                        const curso = this.dataset.curso;
                        modalBody.innerHTML = `<h3>Certificado: ${this.querySelector('h4').innerText}</h3>
                <p>Deseja baixar o certificado?</p>
                <a href="../../api/admin/gerar_certificado.php?curso_id=${curso}" class="btn" style="display:inline-block;margin-top:10px;"><i class="fa fa-download"></i> Baixar Certificado</a>`;
                        modalBg.style.display = 'flex';
                    }
                });
            });
        </script>

</body>

</html>