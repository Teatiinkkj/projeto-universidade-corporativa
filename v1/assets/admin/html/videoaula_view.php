<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($curso['titulo']); ?> | Video Aula</title>
<link rel="stylesheet" href="../../css/website.css">
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
        <!-- Player / Conteúdo -->
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
                <?php $total=0; foreach($topicos as $t) $total += count($t['conteudos']); echo $total;?> 
            </div>
        </div>

        <!-- Lista de aulas -->
        <div class="col-md-4">
            <h4>Aulas do Curso</h4>
            <?php foreach($topicos as $topico): ?>
            <div class="topico">
                <strong><?php echo htmlspecialchars($topico['titulo']); ?></strong>
                <ul class="list-unstyled">
                    <?php foreach($topico['conteudos'] as $conteudo): ?>
                        <li class="conteudo-item" 
                            data-tipo="<?php echo $conteudo['tipo']; ?>"
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
    contadorAulas.innerText = `Aulas assistidas: ${aulasAssistidas} / ${totalAulas}`;
});

// Marcar como concluído
btnConcluido.addEventListener('click', () => {
    if (aulaAtual && !aulaAtual.classList.contains('assistido')) {
        let conteudoId = aulaAtual.dataset.id;

        fetch('../../api/admin/marcar_assistido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'conteudo_id=' + encodeURIComponent(conteudoId),
            credentials: 'include'
        })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                aulaAtual.classList.add('assistido');
                aulasAssistidas++;
                contadorAulas.innerText = `Aulas assistidas: ${aulasAssistidas} / ${totalAulas}`;
            } else {
                alert('Erro ao marcar como assistido: ' + (data.erro || ''));
            }
        })
        .catch(err => console.error(err));
    }
});

// Clique nas aulas
document.querySelectorAll('.conteudo-item').forEach(item => {
    item.addEventListener('click', () => {
        const tipo = item.dataset.tipo;
        const arquivo = item.dataset.arquivo;
        aulaAtual = item;

        tituloAula.innerText = item.innerText;

        if(tipo==='video'){
            // se for YouTube
            if (arquivo.includes("youtube.com") || arquivo.includes("youtu.be")) {
                player.style.display='none';
                conteudoExtra.innerHTML = `<iframe width="100%" height="500" src="${arquivo.replace("watch?v=", "embed/")}" frameborder="0" allowfullscreen></iframe>`;
            } else {
                // vídeo direto MP4
                player.src = arquivo;
                player.style.display='block';
                conteudoExtra.innerHTML='';
            }
        } else if(tipo==='pdf'){
            player.style.display='none';
            conteudoExtra.innerHTML = `<iframe src="${arquivo}" width="100%" height="500px"></iframe>`;
        }
    });
});

// ABRIR PRIMEIRO VÍDEO AUTOMATICAMENTE
window.addEventListener('DOMContentLoaded', () => {
    const primeiroVideo = document.querySelector('.conteudo-item[data-tipo="video"]');
    if (primeiroVideo) {
        primeiroVideo.click();
    }
});
</script>

</body>
</html>
