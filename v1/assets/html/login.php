<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/login.css" />
  <style>
    .mensagem-erro {
      color: #ff4757;
      text-align: center;
      margin-bottom: 15px;
      padding: 10px;
      background: rgba(255, 71, 87, 0.1);
      border-radius: 5px;
      display: none;
    }

    /* ===== MODAL DE SUCESSO ===== */
    .modal-sucesso {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 1000;
    }

    .modal-sucesso.ativo {
      opacity: 1;
      pointer-events: auto;
    }

    .conteudo-modal {
      background: #fff;
      border-radius: 12px;
      padding: 30px 40px;
      text-align: center;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      animation: surgir 0.4s ease forwards;
    }

    .conteudo-modal i {
      color: #2ecc71;
      font-size: 50px;
      margin-bottom: 15px;
    }

    .conteudo-modal h2 {
      color: #333;
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .conteudo-modal p {
      color: #555;
      margin-bottom: 20px;
    }

    @keyframes surgir {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  </style>
</head>

<body>
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
          <a class="link-cadastro" href="recuperar-senha.php">Esqueceu a senha?</a>
        </p>
        <button class="botao-enviar" type="submit">Login</button>
      </form>

      <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
    </div>
    <div class="imagem-wrapper">
      <img class="imagem-fundo-bg" src="../images/feixe-azul.png" alt="Imagem de fundo" />
      <img class="imagem-fundo" src="../images/logo.png" alt="Imagem da frente" />
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
        const response = await fetch('../api/auth/login.php', {
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
            window.location.href = data.redirecionamento || '../pages/inicio.html';
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
  </script>
</body>

</html>
