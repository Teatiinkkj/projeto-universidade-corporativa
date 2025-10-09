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
                <div id="contadorAulas">
                    Aulas assistidas: 0 /
                    <?php $total = 0;
                    foreach ($topicos as $t)
                        $total += count($t['conteudos']);
                    echo $total; ?>
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
                    window.open(`../../api/admin/gerar_certificado.php?curso_id=<?php echo $curso_id; ?>`, '_blank');
                });
                document.querySelector('.col-md-8').appendChild(btn);
                setTimeout(() => btn.classList.add('show'), 10); // animação
            } else {
                btn.classList.add('show');
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

            // Atualiza texto do botão conforme aula atual
            if (aulaAtual) {
                btnConcluido.innerText = aulaAtual.classList.contains('assistido') ? "Desmarcar aula" : "Marcar como assistido";
            }
        }

        // Buscar progresso salvo
        fetch('../../api/admin/buscar_progresso.php', { credentials: 'include' })
            .then(res => res.json())
            .then(data => {
                document.querySelectorAll('.conteudo-item').forEach(item => {
                    if (data.includes(parseInt(item.dataset.id))) {
                        item.classList.add('assistido');
                        aulasAssistidas++;
                    }
                });
                atualizarContador();
            });

        // Marcar ou desmarcar aula
        btnConcluido.addEventListener('click', () => {
            if (!aulaAtual) return;

            const conteudoId = aulaAtual.dataset.id;
            const desmarcar = aulaAtual.classList.contains('assistido') ? 1 : 0;

            fetch('../../api/admin/marcar_assistido.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'conteudo_id=' + encodeURIComponent(conteudoId) + '&desmarcar=' + desmarcar,
                credentials: 'include'
            })
                .then(res => res.json())
                .then(data => {
                    if (data.sucesso) {
                        if (desmarcar) {
                            aulaAtual.classList.remove('assistido');
                            aulasAssistidas--;
                        } else {
                            aulaAtual.classList.add('assistido');
                            aulasAssistidas++;
                        }
                        atualizarContador();
                    } else {
                        alert('Erro ao atualizar aula: ' + (data.erro || ''));
                    }
                })
                .catch(err => console.error(err));
        });

        // Seleção de aulas
        document.querySelectorAll('.conteudo-item').forEach(item => {
            item.addEventListener('click', () => {
                aulaAtual = item;
                tituloAula.innerText = item.innerText;
                atualizarContador();

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