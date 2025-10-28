<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Confirmação | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/confirmar-recuperacao.css" />
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/back-button.css">
</head>

<body>
  <div id="particles-js"></div>

  <div class="container-confirmacao" style="color: white;">
    <div class="caixa-confirmacao" id="caixa-login">
      <div class="cabecalho">
        <i class="fas fa-paper-plane"></i>
        <h1>Confirmação</h1>
      </div>

      <div id="dados-usuario" style="margin-bottom: 20px; text-align: center;"></div>

      <button class="botao-enviar" onclick="enviarSolicitacao()">Enviar ao superior</button>

      <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

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
          const caixa = document.getElementById("caixa-login");
          caixa.innerHTML = `
            <div class="mensagem-sucesso">
              <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
              <h2>Solicitação enviada com sucesso!</h2>
              <p>Os administradores e coordenadores foram notificados.</p>
              <p>Você será redirecionado para a tela de login em breve...</p>
            </div>
          `;

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
