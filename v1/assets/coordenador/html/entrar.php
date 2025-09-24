<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Entrar | UNICORP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/entrar.css" />
</head>

<body>
    <div class="container">
        <div class="caixa-entrar">
            <div class="cabecalho-entrar">
                <h1>UNICORP</h1>
                <p>Aprimore suas habilidades com a melhor plataforma de desenvolvimento corporativo.</p>
                <h2>Selecione sua forma de conexão:</h2>
            </div>
            <form class="formulario-entrar" onsubmit="return false;">
                <button class="botao-login" type="button" onclick="window.location.href='../login.html'">Logar</button>
                <p>OU</p>
                <button class="botao-cadastrar" type="button" onclick="window.location.href='cadastro.html'">Criar
                    conta</button>
            </form>
            <p class="footer">© 2025 UNICORP. Todos os direitos reservados.</p>
        </div>
        <div class="container-imagem">
            <img class="imagem-fundo-bg" src="../images/feixe-azul.png" alt="Imagem de fundo" />
            <img class="imagem-fundo" src="../images/logo.png" alt="Imagem da frente" />
        </div>
    </div>

</body>

</html>