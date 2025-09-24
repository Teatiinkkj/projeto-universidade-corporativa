<nav class="submenu">
  <ul>
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="fa fa-bars menu-icon" style="color: white;"></i>
      </a>
      <div class="submenu-full">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          <h2>Menu</h2>
          <button class="close-submenu"
            style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
        </div>
        <hr>
        <section id="foto-perfil-container" class="perfil-container" aria-label="Informações do usuário">
          <img style="margin-left: 10px; padding: 5px;" src="../../images/crown.png"
            alt="Foto de perfil do usuário" id="foto-perfil" />
          <div class="perfil-info">
            <strong style="margin-left: 30px; margin-right: 30px;" id="nome-usuario">Administrador</strong>
          </div>

          <button style="color: gray;" class="admin-btn" onclick="window.location.href='admin.php'"
            title="Administrar usuários" aria-label="Administrar usuários">
            <i class="fa fa-cogs"></i>
          </button>

          <a href="../login.php" style="font-size: 20px; color: gray; margin-left: -10px;"
            title="Sair da Conta">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </section>

        <hr style="margin-top: 20px;">
        <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <a href="inicio.php"><i class="fa-solid fa-house"></i> Início</a>
        <a href="meus-cursos.php" id="meus-cursos"><i class="fa-solid fa-book"></i> Meus Cursos</a>
        <a href="certificados.php"><i class="fa-solid fa-certificate"></i> Certificados</a>
        <a href="../../html/sobre.html"><i class="fa-solid fa-circle-info"></i> Sobre</a>
        <a href="cursos.php"><i class="fa-solid fa-circle-info"></i> Gestão de Cursos</a>
      </div>
    </li>
  </ul>
</nav>
