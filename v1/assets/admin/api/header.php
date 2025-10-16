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

// Aqui pegamos as informações do usuário do banco
require_once '../../db/conexao.php';
$stmt = $conn->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$nomeUsuario = $result['nome'] ?? "Usuário";
$emailUsuario = $result['email'] ?? "email@exemplo.com";
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
        <div class="user-info">
            <div class="user-name-email">
                <span class="user-name"><?= htmlspecialchars($nomeUsuario) ?></span>
                <span class="user-email"><?= htmlspecialchars($emailUsuario) ?></span>
            </div>
        </div>
        <a href="../../api/auth/logout.php" class="logout-btn" title="Sair">
            <i class="fa fa-sign-out"></i>
        </a>
    </div>

    <!-- Submenu -->
    <div class="submenu" id="userSubmenu">
        <div class="submenu-header">
            <strong><?= htmlspecialchars($nomeUsuario) ?></strong>
            <span><?= htmlspecialchars($emailUsuario) ?></span>
            <button id="closeSubmenu">&times;</button>
        </div>
        <ul class="submenu-links">
            <li><a href="perfil.php"><i class="fa fa-user"></i> Perfil</a></li>
            <li><a href="cursos.php"><i class="fa fa-graduation-cap"></i> Cursos</a></li>
            <li><a href="configuracoes.php"><i class="fa fa-cogs"></i> Configurações</a></li>
            <li><a href="../../api/auth/logout.php"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </div>
</header>

<script>
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userSubmenu = document.getElementById('userSubmenu');
    const closeSubmenu = document.getElementById('closeSubmenu');

    userMenuBtn.addEventListener('click', () => {
        userSubmenu.classList.toggle('active');
    });

    closeSubmenu.addEventListener('click', () => {
        userSubmenu.classList.remove('active');
    });

    // Fecha o submenu ao clicar fora
    document.addEventListener('click', (e) => {
        if (!userSubmenu.contains(e.target) && !userMenuBtn.contains(e.target)) {
            userSubmenu.classList.remove('active');
        }
    });

    // Barra de pesquisa animada
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query) {
            window.location.href = `../../html/pesquisa.php?q=${encodeURIComponent(query)}`;
        }
    });
</script>