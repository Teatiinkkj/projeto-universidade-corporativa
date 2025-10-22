<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperar Senha | UNICORP</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/login.css" />
  <link rel="stylesheet" href="../css/back-button.css">
</head>

<body>
  <a onclick="history.back()" class="back-button">
    <i class="fa fa-arrow-left"></i> Voltar
  </a>

  <div class="container">
    <div class="caixa-login">
      <div class="cabecalho">
        <i class="fas fa-key"></i>
        <h1>Recuperar Senha</h1>
      </div>

      <!-- Formulário envia via POST para o PHP -->
      <form class="formulario-recuperar" action="../api/auth/processar_recuperacao.php" method="POST">
        <div class="grupo-input">
          <i class="fas fa-envelope"></i>
          <input class="campo-input" id="email" name="email" placeholder="Digite seu e-mail" type="email" required />
        </div>
        <button class="botao-enviar" type="submit">Verificar e Continuar</button>
      </form>

      <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
    </div>

    <div class="imagem-wrapper">
      <img class="imagem-fundo-bg" src="../images/feixe-azul.png" alt="Imagem de fundo" />
      <img class="imagem-fundo" src="../images/logo.png" alt="Imagem da frente" />
    </div>
  </div>
</body>

</html>
