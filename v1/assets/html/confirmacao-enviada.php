<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirmação Enviada | UNICORP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/confirmar-recuperacao.css" />
    <link rel="stylesheet" href="../assets/css/back-button.css">
</head>

<body>

    <div class="container">
        <div class="caixa-login">
            <div class="cabecalho">
                <i class="fas fa-check-circle"></i>
                <h1>Solicitação Enviada</h1>
            </div>

            <p style="color: white;">Sua solicitação foi enviada a um superior. Aguarde o email com a <strong>nova
                    senha</strong>.</p>

            <button class="botao-enviar" onclick="window.location.href='../assets/login.html'">Retornar ao
                Login</button>
            <button id="reenviar-notificacao" class="botao-enviar">Reenviar notificação</button>

            <p class="footer"> 2025 UNICORP. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        let tempoRestante = localStorage.getItem('tempoRestante') || 0;
        const botaoReenviar = document.getElementById('reenviar-notificacao');
        let intervalo;

        if (tempoRestante > 0) {
            botaoReenviar.disabled = true;
            botaoReenviar.style.background = 'rgba(0, 0, 0, 0.267)';
            botaoReenviar.textContent = `Reenviar notificação (${tempoRestante}s)`;
            intervalo = setInterval(atualizarContagem, 1000);
        } else {
            botaoReenviar.disabled = false;
            botaoReenviar.style.background = '';
            botaoReenviar.textContent = 'Reenviar notificação';
        }

        function atualizarContagem() {
            tempoRestante--;
            localStorage.setItem('tempoRestante', tempoRestante);
            botaoReenviar.textContent = `Reenviar notificação (${tempoRestante}s)`;
            if (tempoRestante <= 0) {
                clearInterval(intervalo);
                botaoReenviar.disabled = false;
                botaoReenviar.style.background = '';
                botaoReenviar.textContent = 'Reenviar notificação';
            }
        }

        botaoReenviar.addEventListener('click', () => {
            const usuario = JSON.parse(localStorage.getItem("usuarioRecuperacao"));

            if (!usuario) {
                alert("Nenhum usuário encontrado para reenviar.");
                return;
            }

            const solicitacoes = JSON.parse(localStorage.getItem("solicitacoesRecuperacao")) || [];
            solicitacoes.push(usuario);
            localStorage.setItem("solicitacoesRecuperacao", JSON.stringify(solicitacoes));

            adicionarNotificacao(
                `Solicitação de recuperação de senha para o usuário "${usuario.nome}" reenviada.`,
                'recuperacaoSenha',
                '../admin/inicio.html'
            );

            tempoRestante = 60;
            localStorage.setItem('tempoRestante', tempoRestante);
            botaoReenviar.disabled = true;
            botaoReenviar.style.background = 'rgba(0, 0, 0, 0.267)';
            botaoReenviar.textContent = `Reenviar notificação (${tempoRestante}s)`;
            intervalo = setInterval(atualizarContagem, 1000);
        });

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
    </script>

</body>

</html>