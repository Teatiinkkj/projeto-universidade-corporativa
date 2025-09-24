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
          <a class="link-cadastro" href="recuperar-senha.html">Esqueceu a senha?</a>
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

      if (!email || !senha) {
        alert('Por favor, preencha todos os campos.');
        return;
      }

      try {
        const response = await fetch('../api/auth/login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ email, senha })
        });

        const data = await response.json();

        if (data.success) {
          alert('Login realizado com sucesso! Redirecionando para: ' + data.redirecionamento);
          
          localStorage.setItem('usuarioLogado', JSON.stringify(data.usuario));
          
          if (data.redirecionamento) {
            window.location.href = data.redirecionamento;
          }
          
        } else {
          document.getElementById('mensagemErro').textContent = data.message;
          document.getElementById('mensagemErro').style.display = 'block';
        }
      } catch (error) {
        console.error('Erro:', error);
        document.getElementById('mensagemErro').textContent = 'Erro ao conectar com o servidor. Tente novamente.';
        document.getElementById('mensagemErro').style.display = 'block';
      }
    });
  </script>
</body>

</html>
