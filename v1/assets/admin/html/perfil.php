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
    SELECT c.titulo, cert.data_emissao
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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== Body e container ===== */
        body {
            font-family: 'Open Sans', sans-serif;
            background: #e8f0fe;
            margin: 0;
            overflow-x: hidden;
        }

        .perfil-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        /* ===== Header ===== */
        .perfil-header {
            display: flex;
            align-items: center;
            gap: 30px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .perfil-foto-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .perfil-foto-wrapper:hover {
            transform: scale(1.1);
        }

        .perfil-foto-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1754a3;
        }

        .alterar-foto-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #1754a3;
            color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            border: 2px solid #fff;
            transition: 0.3s;
        }

        .alterar-foto-btn:hover {
            background: #0f3f7a;
        }

        /* ===== Títulos ===== */
        .perfil-header h2 {
            margin: 0;
            color: #1754a3;
            font-size: 28px;
        }

        .perfil-header p {
            margin: 4px 0;
            color: #555;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== Seções ===== */
        .perfil-secao {
            margin-bottom: 30px;
        }

        .perfil-secao h3 {
            color: #1754a3;
            margin-bottom: 15px;
            border-bottom: 2px solid #1754a3;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* ===== Formulário ===== */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #1754a3;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group textarea:focus {
            border-color: #1754a3;
            outline: none;
            box-shadow: 0 0 10px rgba(23, 84, 163, 0.3);
        }

        /* ===== Botões ===== */
        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #1754a3;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn:hover {
            background: #0f3f7a;
            transform: scale(1.05);
        }

        /* ===== Cards Cursos e Certificados ===== */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            flex: 1 1 250px;
            background: #f8faff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* ===== Modal ===== */
        .modal-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal {
            background: #fff;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            padding: 25px;
            position: relative;
            animation: fadeIn 0.3s;
        }

        .modal h3 {
            margin-top: 0;
            color: #1754a3;
        }

        .modal .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===== Notificações ===== */
        #listaNotificacoes {
            max-height: 200px;
            overflow-y: auto;
            padding-left: 20px;
        }

        #listaNotificacoes li {
            margin-bottom: 10px;
            padding: 10px;
            background: #f0f6ff;
            border-radius: 8px;
            transition: transform 0.3s, background 0.3s;
        }

        #listaNotificacoes li:hover {
            transform: translateX(5px);
            background: #d6e4ff;
        }
    </style>
</head>

<body>

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

        <!-- Sobre mim -->
        <div class="perfil-secao">
            <h3>Sobre mim</h3>
            <form id="biografiaForm">
                <div class="form-group">
                    <textarea name="biografia" id="biografia" rows="4"
                        placeholder="Escreva algo sobre você..."><?= htmlspecialchars($biografia) ?></textarea>
                </div>
                <button type="submit" class="btn"><i class="fa fa-save"></i> Salvar Biografia</button>
            </form>
        </div>

        <!-- Cursos Matriculados -->
        <div class="perfil-secao">
            <h3>Cursos Matriculados</h3>
            <div class="cards-container">
                <?php while ($mat = $matriculas->fetch_assoc()): ?>
                    <div class="card">
                        <h4><?= htmlspecialchars($mat['titulo']) ?></h4>
                        <p>Status: <?= htmlspecialchars($mat['status']) ?></p>
                        <!-- Link direto para a tela de vídeo-aula -->
                        <a href="../../api/admin/videoaula.php?curso_id=<?= $mat['id'] ?>" class="btn"><i class="fa fa-play"></i> Ver
                            Curso</a>
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
                        <!-- Link para baixar certificado -->
                        <a href="../../api/admin/gerar_certificado.php?curso_id=<?= $cert['curso_id'] ?>" class="btn"><i
                                class="fa fa-download"></i> Baixar Certificado</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Notificações -->
        <div class="perfil-secao">
            <h3>Notificações Recentes</h3>
            <ul id="listaNotificacoes"></ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-bg" id="modalBg">
        <div class="modal" id="modalContent">
            <span class="close-btn" id="modalClose">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <form id="fotoForm" style="display:none;" enctype="multipart/form-data">
        <input type="file" name="foto" id="inputFoto" accept="image/*">
    </form>

    <script>
        // Modal
        const modalBg = document.getElementById('modalBg');
        const modalBody = document.getElementById('modalBody');
        const modalClose = document.getElementById('modalClose');

        document.querySelectorAll('.card .btn-ver').forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.card');
                const tipo = card.dataset.tipo;
                if (tipo === 'curso') {
                    const id = card.dataset.id;
                    modalBody.innerHTML = `<h3>Curso #${id}</h3><p>Conteúdo do curso pode ser exibido aqui...</p>
            <a href="curso.php?id=${id}" class="btn">Acessar Curso</a>`;
                } else if (tipo === 'certificado') {
                    const curso = card.dataset.curso;
                    modalBody.innerHTML = `<h3>Certificado: ${curso}</h3>
            <a href="certificado.php?curso=${curso}" class="btn"><i class="fa fa-download"></i> Baixar Certificado</a>`;
                }
                modalBg.style.display = 'flex';
            });
        });

        modalClose.addEventListener('click', () => modalBg.style.display = 'none');
        modalBg.addEventListener('click', e => { if (e.target === modalBg) modalBg.style.display = 'none'; });

        // Foto do perfil
        document.getElementById('fotoWrapper').addEventListener('click', () => document.getElementById('inputFoto').click());

        document.getElementById('inputFoto').addEventListener('change', async function () {
            const formData = new FormData();
            formData.append('foto', this.files[0]);

            const res = await fetch('../../api/usuario/alterar_foto.php', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.success) {
                document.getElementById('fotoPerfil').src = data.foto;
                alert('Foto atualizada com sucesso!');
            } else alert('Erro ao atualizar foto: ' + data.message);
        });

        // Biografia
        document.getElementById('biografiaForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const res = await fetch('../../api/usuario/alterar_biografia.php', { method: 'POST', body: formData });
            const data = await res.json();
            alert(data.message);
        });

        // Notificações
        async function carregarNotificacoes() {
            const res = await fetch('../../api/admin/get_notificacoes.php');
            const data = await res.json();
            const ul = document.getElementById('listaNotificacoes');
            ul.innerHTML = '';
            data.slice(0, 5).forEach(n => {
                const li = document.createElement('li');
                li.textContent = `${n.descricao} (${n.data_criacao})`;
                ul.appendChild(li);
            });
        }
        carregarNotificacoes();
    </script>

</body>

</html>