<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Confirmação | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/confirmar-recuperacao.css" />
  <link rel="stylesheet" href="../css/back-button.css">
</head>

<body>
  <a onclick="history.back()" class="back-button">
    <i class="fa fa-arrow-left"></i> Voltar
  </a>

  <div class="container">
    <div class="caixa-login">
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
    const usuario = JSON.parse(localStorage.getItem("usuarioRecuperacao"));

    if (usuario) {
      document.getElementById("dados-usuario").innerHTML = `
    <p><strong>${usuario.nome}</strong></p>
    <p><strong>${usuario.email}</strong></p>
  `;
    }

    function adicionarNotificacao(mensagem, tipo = 'geral', destino = '') {
      const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];

      notificacoes.push({
        id: Date.now(),
        mensagem,
        tipo,
        lido: false,
        data: new Date().toISOString(),
        destino
      });

      localStorage.setItem('notificacoes', JSON.stringify(notificacoes));
    }

    function enviarSolicitacao() {
      if (!usuario) {
        alert("Nenhum usuário encontrado para enviar.");
        return;
      }

      const solicitacoes = JSON.parse(localStorage.getItem("solicitacoesRecuperacao")) || [];
      solicitacoes.push(usuario);
      localStorage.setItem("solicitacoesRecuperacao", JSON.stringify(solicitacoes));

      adicionarNotificacao(
        `Solicitação de recuperação de senha para o usuário "${usuario.nome}" confirmada.`,
        'recuperacaoSenha',
        '../admin/inicio.html'
      );

      window.location.href = "confirmacao-enviada.html";
    }

  </script>

</body>

</html>