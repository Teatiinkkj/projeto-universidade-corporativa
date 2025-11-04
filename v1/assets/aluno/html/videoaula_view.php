<?php
session_start();

// Evita cache da página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../html/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($curso['titulo']); ?> | Video Aula</title>
    <link rel="stylesheet" href="../../css/videoaula.css">
    <link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>

<body>

    <header class="header-inicio">
        <h2><?php echo htmlspecialchars($curso['titulo']); ?></h2>
    </header>

    <a href="javascript:void(0);" class="back-button" onclick="history.back()">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>

    <section class="video container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h3 id="tituloAula">Selecione uma aula</h3>
                <div id="conteudoArea">
                    <video id="playerVideo" controls width="100%" style="display:none;">
                        <source src="" type="video/mp4">
                    </video>
                    <div id="conteudoExtra"></div>
                </div>
                <button id="btnConcluido" class="btn mt-3">Marcar como assistido</button>
                <div class="btn-direita">
                    <div id="contadorAulas">
                        Aulas assistidas: 0 /
                        <?php $total = 0;
                        foreach ($topicos as $t)
                            $total += count($t['conteudos']);
                        echo $total; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h4>Aulas do Curso</h4>
                <?php foreach ($topicos as $topico): ?>
                    <div class="topico">
                        <strong><?php echo htmlspecialchars($topico['titulo']); ?></strong>
                        <ul class="list-unstyled">
                            <?php foreach ($topico['conteudos'] as $conteudo): ?>
                                <li class="conteudo-item" data-tipo="<?php echo $conteudo['tipo']; ?>"
                                    data-arquivo="<?php echo $conteudo['arquivo_path']; ?>"
                                    data-id="<?php echo $conteudo['id']; ?>">
                                    <?php echo htmlspecialchars($conteudo['titulo']); ?> (<?php echo $conteudo['tipo']; ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 - Todos os direitos reservados</p>
    </footer>

    <script>
        let player = document.getElementById('playerVideo');
        let tituloAula = document.getElementById('tituloAula');
        let conteudoExtra = document.getElementById('conteudoExtra');
        let btnConcluido = document.getElementById('btnConcluido');
        let contadorAulas = document.getElementById('contadorAulas');

        let aulasAssistidas = 0;
        let totalAulas = <?php echo $total; ?>;
        let aulaAtual = null;

        function mostrarBotaoCertificado() {
            let btn = document.getElementById('btnCertificado');
            if (!btn) {
                btn = document.createElement('button');
                btn.id = 'btnCertificado';
                btn.className = 'btn btn-success mt-3';
                btn.innerText = "Baixar Certificado";

                btn.addEventListener('click', () => {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner"></i> Baixando...';
                    btn.classList.add('loading');

                    window.open(`../../api/aluno/gerar_certificado.php?curso_id=<?php echo $curso_id; ?>`, '_blank');

                    setTimeout(() => {
                        btn.classList.remove('loading');
                        btn.classList.add('sucesso');
                        btn.innerHTML = '<i class="fa fa-check-circle"></i> Certificado Baixado!';
                    }, 2000);

                    setTimeout(() => {
                        btn.classList.remove('sucesso');
                        btn.innerHTML = 'Baixar Certificado';
                        btn.disabled = false;
                    }, 5000);
                });

                document.querySelector('.col-md-8').appendChild(btn);
                setTimeout(() => btn.classList.add('show'), 10);
            } else {
                btn.classList.add('show');
            }

            if (typeof carregarNotificacoes === 'function') {
                carregarNotificacoes();
            }
        }

        function atualizarContador() {
            contadorAulas.innerText = `Aulas assistidas: ${aulasAssistidas} / ${totalAulas}`;
            if (aulasAssistidas === totalAulas) {
                mostrarBotaoCertificado();
            } else {
                let btn = document.getElementById('btnCertificado');
                if (btn) btn.classList.remove('show');
            }

            if (aulaAtual) {
                const textoMarcado = document.getElementById('textoMarcado');
                if (aulaAtual.classList.contains('assistido')) {
                    btnConcluido.style.display = 'none';
                    if (!textoMarcado) {
                        const texto = document.createElement('p');
                        texto.id = 'textoMarcado';
                        texto.textContent = 'Aula concluída!';
                        texto.style.color = 'green';
                        texto.style.fontWeight = '600';
                        texto.style.marginTop = '10px';
                        btnConcluido.parentNode.insertBefore(texto, btnConcluido.nextSibling);
                    }
                } else {
                    btnConcluido.style.display = 'inline-block';
                    if (textoMarcado) textoMarcado.remove();
                }
            }
        }

        // Buscar progresso salvo
        fetch('../../api/aluno/buscar_progresso.php', { credentials: 'include' })
            .then(res => res.json())
            .then(data => {
                if (data.success && Array.isArray(data.conteudos)) {
                    const concluidos = data.conteudos
                        .filter(c => c.concluido)
                        .map(c => parseInt(c.id));

                    document.querySelectorAll('.conteudo-item').forEach(item => {
                        if (concluidos.includes(parseInt(item.dataset.id))) {
                            item.classList.add('assistido');
                            aulasAssistidas++;
                        }
                    });
                    atualizarContador();
                }
            })
            .catch(err => console.error(err));

        // Marcar ou desmarcar aula
        btnConcluido.addEventListener('click', () => {
            if (!aulaAtual) return;

            const conteudoId = aulaAtual.dataset.id;
            const desmarcar = aulaAtual.classList.contains('assistido') ? 1 : 0;

            fetch('../../api/aluno/marcar_assistido.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'conteudo_id=' + encodeURIComponent(conteudoId) + '&desmarcar=' + desmarcar,
                credentials: 'include'
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success || data.sucesso) {
                        if (desmarcar) {
                            aulaAtual.classList.remove('assistido');
                            aulasAssistidas--;
                        } else {
                            aulaAtual.classList.add('assistido');
                            aulasAssistidas++;
                        }
                        atualizarContador();
                    } else {
                        alert('Erro ao atualizar aula: ' + (data.erro || data.message || ''));
                    }
                })
                .catch(err => console.error(err));
        });

        // Seleção de aulas
        document.querySelectorAll('.conteudo-item').forEach(item => {
            item.addEventListener('click', () => {
                aulaAtual = item;
                tituloAula.innerText = item.innerText;

                const tipo = item.dataset.tipo;
                const arquivo = item.dataset.arquivo;

                if (tipo === 'video') {
                    if (arquivo.includes("youtube.com") || arquivo.includes("youtu.be")) {
                        player.style.display = 'none';
                        conteudoExtra.innerHTML = `<iframe width="100%" height="500" src="${arquivo.replace("watch?v=", "embed/")}" frameborder="0" allowfullscreen></iframe>`;
                    } else {
                        player.src = arquivo;
                        player.style.display = 'block';
                        conteudoExtra.innerHTML = '';
                    }
                } else if (tipo === 'pdf') {
                    player.style.display = 'none';
                    conteudoExtra.innerHTML = `<iframe src="${arquivo}" width="100%" height="500px"></iframe>`;
                }

                atualizarContador(); // garante que o texto/btn esteja certo
            });
        });

        // Abrir primeiro vídeo automaticamente
        window.addEventListener('DOMContentLoaded', () => {
            const primeiroVideo = document.querySelector('.conteudo-item[data-tipo="video"]');
            if (primeiroVideo) primeiroVideo.click();
        });
    </script>

</body>

</html>