<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Confirmação | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/confirmar-recuperacao.css" />
  <link rel="stylesheet" href="../css/back-button.css">
  <style>
    /* Estilo para a mensagem de sucesso */
    .mensagem-sucesso {
      text-align: center;
      padding: 30px 20px;
      background-color: #e0f7fa;
      border: 1px solid #00acc1;
      border-radius: 10px;
      color: #007c91;
      font-size: 1.2rem;
      margin-top: 20px;
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px);}
      to { opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="caixa-login" id="caixa-login">
      <div class="cabecalho">
        <i class="fas fa-paper-plane"></i>
        <h1>Confirmação</h1>
      </div>

      <div id="dados-usuario" style="margin-bottom: 20px; text-align: center;"></div>

      <button class="botao-enviar" onclick="enviarSolicitacao()">Enviar ao superior</button>

      <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
    </div>
  </div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get("email");

    async function carregarUsuario() {
      if (!email) {
        document.getElementById("dados-usuario").innerHTML = `
          <p style="color:red;">E-mail não encontrado. Volte e tente novamente.</p>
        `;
        return;
      }

      try {
        const response = await fetch(`../api/auth/obter_usuario.php?email=${encodeURIComponent(email)}`);
        const data = await response.json();

        if (data.erro) {
          document.getElementById("dados-usuario").innerHTML = `
            <p style="color:red;">${data.erro}</p>
          `;
        } else {
          document.getElementById("dados-usuario").innerHTML = `
            <p><strong>Nome:</strong> ${data.nome}</p>
            <p><strong>E-mail:</strong> ${data.email}</p>
          `;
        }
      } catch (err) {
        console.error(err);
        document.getElementById("dados-usuario").innerHTML = `
          <p style="color:red;">Erro ao carregar os dados do usuário.</p>
        `;
      }
    }

    async function enviarSolicitacao() {
      if (!email) {
        alert("Nenhum e-mail encontrado para enviar.");
        return;
      }

      try {
        const response = await fetch("../api/auth/enviar_solicitacao.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `email=${encodeURIComponent(email)}`
        });

        const result = await response.text();

        if (result.includes("sucesso")) {
          // Substitui o conteúdo da caixa por mensagem bonita
          const caixa = document.getElementById("caixa-login");
          caixa.innerHTML = `
            <div class="mensagem-sucesso">
              <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
              <h2>Solicitação enviada com sucesso!</h2>
              <p>Os administradores e coordenadores foram notificados.</p>
              <p>Você será redirecionado para a tela de login em breve...</p>
            </div>
          `;

          // Redireciona para login após 5 segundos
          setTimeout(() => {
            window.location.href = "../html/login.php";
          }, 5000);

        } else {
          alert("Erro ao enviar solicitação: " + result);
        }
      } catch (err) {
        console.error(err);
        alert("Erro ao processar a solicitação.");
      }
    }

    carregarUsuario();
  </script>
</body>
</html>
