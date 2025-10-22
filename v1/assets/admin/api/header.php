<?php
session_start();

// Evita cache da página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../html/login.php");
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
                <div class="notifications-footer">
                    <a href="todas_notificacoes.php">Ver todas</a>
                </div>
            </div>
        </div>

        <div class="user-info" id="userProfileBtn">
            <div class="user-name-email">
                <span class="user-name"><?= htmlspecialchars($nomeUsuario) ?></span>
                <span class="user-email"><?= htmlspecialchars($emailUsuario) ?></span>
            </div>
            <img src="<?= htmlspecialchars($fotoExibida) ?>" alt="Foto de perfil" class="user-photo">
        </div>

        <a href="../../api/auth/logout.php" class="logout-btn" title="Sair">
            <i class="fa fa-sign-out"></i>
        </a>
    </div>

    <!-- Submenu do usuário -->
    <div class="submenu" id="userSubmenu">
        <div class="submenu-header">
            <div class="submenu-user-info">
                <img src="<?= htmlspecialchars($fotoExibida) ?>" alt="Foto de perfil" class="user-photo">
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
            <li><a href="perfil.php"><i class="fa fa-user"></i> Perfil</a></li>
            <li><a href="../html/admin.php"><i class="fa fa-users"></i> Usuários</a></li>
            <li><a href="cursos.php"><i class="fa fa-graduation-cap"></i> Cursos</a></li>
            <li><a href="configuracoes.php"><i class="fa fa-cogs"></i> Configurações</a></li>
        </ul>
    </div>
</header>

<script>
const userMenuBtn = document.getElementById('userMenuBtn');
const userSubmenu = document.getElementById('userSubmenu');
const notificationsBtn = document.getElementById('notificationsBtn');
const notificationsMenu = document.getElementById('notificationsMenu');
const closeNotifications = document.getElementById('closeNotifications');
const notificationCount = document.getElementById('notificationCount');
const notificationsList = document.querySelector('.notifications-list');

// Menu do usuário
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

// Fechar notificações
closeNotifications?.addEventListener('click', () => {
    notificationsMenu.classList.remove('active');
});

// Busca
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
searchBtn.addEventListener('click', () => {
    const query = searchInput.value.trim();
    if (query) {
        window.location.href = `../../html/pesquisa.php?q=${encodeURIComponent(query)}`;
    }
});

// Função para carregar notificações
async function carregarNotificacoes() {
    try {
        const res = await fetch('../../api/admin/get_notificacoes.php');
        const data = await res.json();

        notificationsList.innerHTML = '';
        let countNaoLidas = 0;

        data.forEach(notif => {
            if (notif.lida == 0) countNaoLidas++;

            const li = document.createElement('li');
            li.innerHTML = `<i class="fa ${icone(notif.tipo)}"></i> ${notif.descricao} <span class="notif-date">${notif.data_criacao}</span>`;
            li.dataset.id = notif.id;
            notificationsList.appendChild(li);
        });

        notificationCount.textContent = countNaoLidas;
    } catch (err) {
        console.error('Erro ao carregar notificações:', err);
    }
}

// Função para escolher ícone
function icone(tipo) {
    switch(tipo) {
        case 'novo_curso': return 'fa-book';
        case 'perfil_atualizado': return 'fa-user';
        case 'curso_concluido': return 'fa-check';
        default: return 'fa-info-circle';
    }
}

// Marcar todas como lidas ao abrir menu
notificationsBtn.addEventListener('click', async () => {
    notificationsMenu.classList.toggle('active');
    userSubmenu.classList.remove('active');

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

// Atualiza notificações a cada 10 segundos
setInterval(carregarNotificacoes, 10000);
carregarNotificacoes();
</script>
