<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="v1/assets/css/login.css" />
  <link rel="stylesheet" href="v1/assets/css/logo.css" />
  <link rel="icon" href="v1/assets/images/logo-dominio.png" type="image/png" class="logo-dominio">
</head>

<body>
  <div id="particles-js"></div>

  <div class="container">
    <div class="caixa-login">
      <div class="cabecalho">
        <i class="fas fa-user-circle"></i>
        <h1>Login</h1>
      </div>

      <div class="mensagem-erro" id="mensagemErro"></div>

      <form class="formulario-login" id="formLogin">
        <div class="grupo-input">
          <i class="fas fa-envelope"></i>
          <input class="campo-input" id="email" placeholder="Email" type="email" required />
        </div>
        <div class="grupo-input">
          <i class="fas fa-lock"></i>
          <input class="campo-input" id="senha" placeholder="Senha" type="password" required />
          <span class="icone-senha" onclick="mostrarSenha()">
            <i class="fas fa-eye"></i>
          </span>
        </div>
        <p class="cadastro">
          <a class="link-cadastro" href="v1/assets/html/recuperar-senha.php">Esqueceu a senha?</a>
        </p>
        <button class="botao-enviar" type="submit">Login</button>
      </form>

      <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
    </div>
    <div class="imagem-wrapper">
      <img class="imagem-fundo-bg" src="v1/assets/images/feixe-azul.png" alt="Imagem de fundo" />
      <img class="imagem-fundo" src="v1/assets/images/logo.png" alt="Imagem da frente" />
    </div>
  </div>

  <!-- MODAL DE SUCESSO -->
  <div class="modal-sucesso" id="modalSucesso">
    <div class="conteudo-modal">
      <i class="fas fa-check-circle"></i>
      <h2>Login realizado!</h2>
      <p>Você será redirecionado em instantes...</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

  <script>
    function mostrarSenha() {
      var senha = document.getElementById("senha");
      var icone = document.querySelector(".icone-senha i");
      if (senha.type === "password") {
        senha.type = "text";
        icone.classList.remove("fa-eye");
        icone.classList.add("fa-eye-slash");
      } else {
        senha.type = "password";
        icone.classList.remove("fa-eye-slash");
        icone.classList.add("fa-eye");
      }
    }

    document.getElementById('formLogin').addEventListener('submit', async function (event) {
      event.preventDefault();

      const email = document.getElementById('email').value.trim();
      const senha = document.getElementById('senha').value.trim();
      const mensagemErro = document.getElementById('mensagemErro');
      const modalSucesso = document.getElementById('modalSucesso');

      if (!email || !senha) {
        mensagemErro.textContent = 'Por favor, preencha todos os campos.';
        mensagemErro.style.display = 'block';
        return;
      }

      try {
        const response = await fetch('v1/assets/api/auth/login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, senha })
        });

        const data = await response.json();

        if (data.success) {
          localStorage.setItem('usuarioLogado', JSON.stringify(data.usuario));

          // Exibe o modal de sucesso
          modalSucesso.classList.add('ativo');

          // Redireciona após 2 segundos
          setTimeout(() => {
            window.location.href = data.redirecionamento || 'v1/assets/pages/inicio.html';
          }, 2000);

        } else {
          mensagemErro.textContent = data.message;
          mensagemErro.style.display = 'block';
        }
      } catch (error) {
        console.error('Erro:', error);
        mensagemErro.textContent = 'Erro ao conectar com o servidor. Tente novamente.';
        mensagemErro.style.display = 'block';
      }
    });

    // Fundo animado de partículas
    particlesJS("particles-js", {
      "particles": {
        "number": { "value": 70 },
        "color": { "value": "#ffffff" },
        "shape": { "type": "circle" },
        "opacity": { "value": 0.5 },
        "size": { "value": 3 },
        "move": { "enable": true, "speed": 1.5 }
      },
      "interactivity": {
        "events": { "onhover": { "enable": true, "mode": "repulse" } }
      }
    });
  </script>
</body>

</html>