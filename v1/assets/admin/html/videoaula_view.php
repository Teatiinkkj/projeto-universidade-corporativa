<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($curso['titulo']); ?> | Video Aula</title>
<link rel="stylesheet" href="../../css/website.css">
<link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style>
    .conteudo-item { cursor:pointer; margin-bottom:5px; }
    .conteudo-item.assistido { color: green; font-weight: bold; }
</style>
</head>
<body>

<header class="header-inicio">
    <h2 style="color:white; text-align:center; padding:20px;"><?php echo htmlspecialchars($curso['titulo']); ?></h2>
</header>

<section class="video container" style="margin-top:40px;">
    <div class="row">
        <!-- Player -->
        <div class="col-md-8">
            <h3 id="tituloAula">Selecione uma aula</h3>
            <video id="playerVideo" controls width="100%" style="border-radius:15px;">
                <source src="" type="video/mp4">
            </video>
            <div id="conteudoExtra" style="margin-top:15px;"></div>
            <button id="btnConcluido" class="btn btn-success mt-2">Marcar como assistido</button>
            <div id="contadorAulas" style="margin-top:10px;">Aulas assistidas: 0 / <?php 
                $total=0; foreach($topicos as $t) $total += count($t['conteudos']); echo $total;?> 
            </div>
        </div>

        <!-- Lista de aulas -->
        <div class="col-md-4">
            <h4>Aulas do Curso</h4>
            <?php foreach($topicos as $topico): ?>
            <div class="topico">
                <strong><?php echo htmlspecialchars($topico['titulo']); ?></strong>
                <ul>
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

<script>
let player = document.getElementById('playerVideo');
let tituloAula = document.getElementById('tituloAula');
let conteudoExtra = document.getElementById('conteudoExtra');
let btnConcluido = document.getElementById('btnConcluido');
let contadorAulas = document.getElementById('contadorAulas');

let aulasAssistidas = 0;
let totalAulas = <?php echo $total; ?>;
let aulaAtual = null;

document.querySelectorAll('.conteudo-item').forEach(item => {
    item.addEventListener('click', () => {
        const tipo = item.dataset.tipo;
        const arquivo = item.dataset.arquivo;
        aulaAtual = item;

        tituloAula.innerText = item.innerText;

        if(tipo==='video'){
            player.src = arquivo;
            player.style.display='block';
            conteudoExtra.innerHTML='';
        } else if(tipo==='pdf'){
            player.style.display='none';
            conteudoExtra.innerHTML = `<iframe src="${arquivo}" width="100%" height="500px"></iframe>`;
        } else if(tipo==='imagem'){
            player.style.display='none';
            conteudoExtra.innerHTML = `<img src="${arquivo}" width="100%" style="border-radius:15px;">`;
        }
    });
});

btnConcluido.addEventListener('click', () => {
    if(aulaAtual && !aulaAtual.classList.contains('assistido')){
        aulaAtual.classList.add('assistido');
        aulasAssistidas++;
        contadorAulas.innerText = `Aulas assistidas: ${aulasAssistidas} / ${totalAulas}`;
    }
});
</script>

<footer style="margin-top:50px;">
    <div class="footer-text">
        <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
    </div>
</footer>

</body>
</html>
