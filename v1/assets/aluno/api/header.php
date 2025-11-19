<?php
session_start();

// Evita cache da página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../../index.php");
    exit();
}

// Pegamos as informações do usuário do banco
require_once '../../db/conexao.php';
$stmt = $conn->prepare("SELECT nome, email, foto FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$nomeUsuario = $result['nome'] ?? "Usuário";
$emailUsuario = $result['email'] ?? "email@exemplo.com";
$foto = $result['foto'] ?? "";

// Caminho das imagens
$caminhoImagens = '../../images/usuarios/';
$fotoPadrao = '../../images/default-avatar.png';

// Define a foto que será exibida
$fotoExibida = (!empty($foto) && file_exists($caminhoImagens . $foto))
    ? $caminhoImagens . $foto
    : $fotoPadrao;
?>

<header class="header-container">
    <div class="header-left">
        <button id="userMenuBtn"><i class="fa fa-bars"></i></button>
    </div>

    <div class="header-center">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar cursos...">
            <button id="searchBtn">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    <div class="header-right">
        <!-- Botão de notificações -->
        <div class="notifications-container">
            <button id="notificationsBtn" class="notifications-btn" title="Notificações">
                <i class="fa fa-bell"></i>
                <span id="notificationCount" class="notification-count">0</span>
            </button>

            <!-- Submenu de notificações -->
            <div class="notifications-menu" id="notificationsMenu">
                <div class="notifications-header">
                    <h4>Notificações</h4>
                    <button id="closeNotifications" title="Fechar">&times;</button>
                </div>
                <ul class="notifications-list">
                    <!-- Notificações serão carregadas via JS -->
                </ul>
                <div class="notifications-footer" style="padding-bottom: 10px; padding-top: 10px;">
                    <button id="expandNotifications" class="expand-btn" style="margin-left: 10px;">Ver todas</button>
                    <button id="deleteNotifications" class="delete-btn" style="margin-right: 10px;">Excluir
                        todas</button>
                </div>
            </div>

        </div>

        <div class="user-info" id="userProfileBtn">
            <a href="../html/perfil.php">
                <img src="<?= htmlspecialchars($fotoExibida) ?>" alt="Foto de perfil" class="user-photo">
            </a>
            <div class="user-name-email">
                <span class="user-name">Olá! <?= htmlspecialchars($nomeUsuario) ?></span>
            </div>
        </div>

        <a href="../../api/auth/logout.php" class="logout-btn" title="Sair">
            <i class="fa fa-sign-out"></i>
        </a>
    </div>

    <!-- Submenu do usuário -->
    <div class="submenu" id="userSubmenu">
        <div class="submenu-header">
            <div class="submenu-user-info">
                <div class="submenu-name-email">
                    <span class="user-name"><?= htmlspecialchars($nomeUsuario) ?></span>
                    <span class="user-email"><?= htmlspecialchars($emailUsuario) ?></span>
                </div>
                <a href="../../api/auth/logout.php" class="logout-btn-2" title="Sair">
                    <i class="fa fa-sign-out"></i>
                </a>
            </div>
        </div>
        <ul class="submenu-links">
            <li><a href="../html/inicio.php"><i class="fa fa-home"></i> Início</a></li>
            <li><a href="perfil.php"><i class="fa fa-user"></i> Perfil</a></li>
            <li><a href="../../api/auth/logout.php"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </div>
</header>

<div class="modal-overlay" id="modalMatricula">
    <div class="modal-container">
        <span class="close-modal" id="closeModal">&times;</span>
        <h2>Acesso negado</h2>
        <p>Você precisa estar matriculado neste curso para acessá-lo.</p>
        <button class="modal-btn" id="modalOkBtn">OK</button>
    </div>
</div>

<!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
<div class="modal-overlay" id="modalExcluirNotificacoes">
    <div class="modal-container">
        <div class="modal-icon">
            <i class="fa fa-exclamation-circle"></i>
        </div>
        <h2>Excluir todas as notificações?</h2>
        <p>Essa ação é irreversível. Deseja realmente apagar todas as notificações da sua conta?</p>
        <div class="modal-buttons">
            <button id="btnConfirmarExclusao" class="btn-primario">Sim, excluir</button>
            <button id="btnCancelarExclusao" class="btn-secundario">Cancelar</button>
        </div>
    </div>
</div>

<script>
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userSubmenu = document.getElementById('userSubmenu');
    const notificationsBtn = document.getElementById('notificationsBtn');
    const notificationsMenu = document.getElementById('notificationsMenu');
    const closeNotifications = document.getElementById('closeNotifications');
    const notificationCount = document.getElementById('notificationCount');
    const notificationsList = document.querySelector('.notifications-list');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const searchContainer = document.querySelector('.search-container');

    let searchPreview;
    let historicoPesquisas = JSON.parse(localStorage.getItem('historico_pesquisas')) || [];

    // =========================
    // MENU DO USUÁRIO
    // =========================
    userMenuBtn.addEventListener('click', () => {
        userSubmenu.classList.toggle('active');
        notificationsMenu.classList.remove('active');
    });

    document.addEventListener('click', (e) => {
        if (!userSubmenu.contains(e.target) && !userMenuBtn.contains(e.target)) {
            userSubmenu.classList.remove('active');
        }
        if (!notificationsMenu.contains(e.target) && !notificationsBtn.contains(e.target)) {
            notificationsMenu.classList.remove('active');
        }
    });

    closeNotifications?.addEventListener('click', () => {
        notificationsMenu.classList.remove('active');
    });
    // =========================
    // PESQUISA
    // =========================
    function criarPreview() {
        if (!searchPreview) {
            searchPreview = document.createElement('div');
            searchPreview.className = 'search-preview';
            searchContainer.appendChild(searchPreview);
        }
    }

    searchInput.addEventListener('blur', () => {
        setTimeout(() => {
            if (searchPreview) searchPreview.style.display = 'none';
        }, 150);
    });

    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.trim();
        criarPreview();

        try {
            const res = await fetch(`../../api/admin/buscar_cursos.php?q=${encodeURIComponent(query)}`);
            const cursos = await res.json();

            if (cursos.length === 0) {
                searchPreview.innerHTML = '<p class="no-results">Nenhum curso encontrado.</p>';
                searchPreview.style.display = 'block';
                return;
            }

            searchPreview.innerHTML = cursos.map(curso => `
            <div class="curso-item" data-id="${curso.id}">
                <img src="${curso.imagem}" alt="${curso.titulo}">
                <div>
                    <strong>${curso.titulo}</strong>
                    <p>${curso.descricao.slice(0, 60)}...</p>
                </div>
            </div>
        `).join('');

            searchPreview.style.display = 'block';
        } catch (err) {
            console.error('Erro na busca:', err);
        }
    });

    // =========================
    // EXECUTAR BUSCA
    // =========================
    async function executarBusca(query) {
        query = query.trim();
        if (!query) return;

        try {
            const res = await fetch(`../../api/admin/buscar_cursos.php?q=${encodeURIComponent(query)}`);
            const cursos = await res.json();

            if (cursos.length === 0) {
                console.log("Nenhum curso encontrado.");
                return;
            }

            // Procura um curso que contenha a query digitada (parcial)
            const cursoEncontrado = cursos.find(curso =>
                curso.titulo.toLowerCase().includes(query.toLowerCase())
            );

            if (cursoEncontrado) {
                verificarMatricula(cursoEncontrado.id); // Redireciona para o curso encontrado
            } else {
                console.log("Nenhum curso correspondente encontrado. Nenhuma ação executada.");
            }

        } catch (err) {
            console.error('Erro na execução da busca:', err);
        }
    }

    // =========================
    // CLIQUE NO BOTÃO DE BUSCA + ENTER
    // =========================
    function handleBusca() {
        const query = searchInput.value.trim();
        if (query) executarBusca(query);
    }

    searchBtn.addEventListener('click', handleBusca);

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            handleBusca();
        }
    });

    // =========================
    // CLIQUE EM UM CURSO
    // =========================
    searchContainer.addEventListener('click', (e) => {
        const item = e.target.closest('.curso-item');
        if (item) {
            verificarMatricula(item.dataset.id);
        }
    });


    // =========================
    // CLICAR EM UM CURSO
    // =========================
    searchContainer.addEventListener('click', async (e) => {
        const item = e.target.closest('.curso-item');
        if (item) {
            verificarMatricula(item.dataset.id);
        }
    });

    // =========================
    // VERIFICAR MATRÍCULA
    // =========================
    async function verificarMatricula(cursoId) {
        try {
            const res = await fetch(`../../api/admin/matricula_pesquisa.php?curso_id=${cursoId}`);
            const data = await res.json();

            if (data.status === 'matriculado') {
                window.location.href = `../../api/admin/videoaula.php?id=${cursoId}`;
            } else {
                abrirModalMatricula();
            }
        } catch (err) {
            console.error('Erro ao verificar matrícula:', err);
        }
    }

    // =========================
    // FUNÇÃO PARA ABRIR MODAL
    // =========================
    function abrirModalMatricula() {
        const modal = document.getElementById('modalMatricula');
        modal.style.display = 'flex';

        const fechar = document.getElementById('closeModal');
        const okBtn = document.getElementById('modalOkBtn');

        // Fecha ao clicar no X
        fechar.onclick = () => modal.style.display = 'none';

        // Fecha ao clicar no botão OK
        okBtn.onclick = () => modal.style.display = 'none';

        // Fecha ao clicar fora do modal
        window.onclick = (e) => {
            if (e.target === modal) modal.style.display = 'none';
        };
    }

    // =========================
    // NOTIFICAÇÕES
    // =========================
    async function carregarNotificacoes() {
        try {
            const res = await fetch('../../api/admin/get_notificacoes.php');
            const data = await res.json();

            notificationsList.innerHTML = '';
            let countNaoLidas = 0;

            data.forEach(notif => {
                if (notif.lida == 0) countNaoLidas++;

                const li = document.createElement('li');
                li.innerHTML = `
                <i class="fa ${icone(notif.tipo)}"></i> 
                ${notif.descricao} 
                <span class="notif-date">${notif.data_criacao}</span>
            `;
                li.dataset.id = notif.id;
                notificationsList.appendChild(li);
            });

            notificationCount.textContent = countNaoLidas;
        } catch (err) {
            console.error('Erro ao carregar notificações:', err);
        }
    }

    function icone(tipo) {
        switch (tipo) {
            case 'novo_curso': return 'fa-book';
            case 'perfil_atualizado': return 'fa-user';
            case 'curso_concluido': return 'fa-check';
            default: return 'fa-info-circle';
        }
    }

    // Abrir/fechar submenu de notificações
    notificationsBtn.addEventListener('click', async () => {
        notificationsMenu.classList.toggle('active');
        userSubmenu.classList.remove('active');

        // Marca todas como lidas ao abrir
        const items = notificationsList.querySelectorAll('li');
        items.forEach(async li => {
            const id = li.dataset.id;
            await fetch('../../api/admin/marcar_lida.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            });
        });

        notificationCount.textContent = 0;
    });

    // =========================
    // EXPANDIR NOTIFICAÇÕES
    // =========================
    const expandBtn = document.getElementById('expandNotifications');
    expandBtn.addEventListener('click', () => {
        notificationsMenu.classList.toggle('expanded');

        if (notificationsMenu.classList.contains('expanded')) {
            expandBtn.textContent = 'Recolher';
            notificationsMenu.scrollTop = 0; // volta ao topo ao expandir
        } else {
            expandBtn.textContent = 'Ver todas';
        }
    });


    // =========================
    // EXCLUIR TODAS NOTIFICAÇÕES
    // =========================
    const deleteBtn = document.getElementById('deleteNotifications');
    const modalExcluir = document.getElementById('modalExcluirNotificacoes');
    const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');
    const btnCancelarExclusao = document.getElementById('btnCancelarExclusao');

    // Abre o modal de confirmação
    deleteBtn.addEventListener('click', () => {
        modalExcluir.style.display = 'flex';
    });

    // Cancela e fecha o modal
    btnCancelarExclusao.addEventListener('click', () => {
        modalExcluir.style.display = 'none';
    });

    // Confirma exclusão
    btnConfirmarExclusao.addEventListener('click', async () => {
        try {
            const res = await fetch('../../api/admin/excluir_notificacoes.php', { method: 'POST' });
            const data = await res.json();

            if (data.success) {
                notificationsList.innerHTML = '<p class="no-results">Nenhuma notificação.</p>';
                notificationCount.textContent = 0;
            } else {
                alert(data.message || 'Erro ao excluir notificações.');
            }
        } catch (err) {
            console.error('Erro ao excluir notificações:', err);
            alert('Erro na resposta do servidor.');
        } finally {
            modalExcluir.style.display = 'none';
        }
    });

    // Fecha ao clicar fora do modal
    window.addEventListener('click', (e) => {
        if (e.target === modalExcluir) modalExcluir.style.display = 'none';
    });

    // Atualiza automaticamente a cada 10 segundos
    setInterval(carregarNotificacoes, 10000);
    carregarNotificacoes();

</script>