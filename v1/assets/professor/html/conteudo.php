<?php
if (!isset($_GET['topico_id'])) {
    die("Tópico não especificado.");
}

$topico_id = intval($_GET['topico_id']);
include '../../db/conexao.php';

// Buscar informações do tópico
$sql = "SELECT curso_id, titulo FROM topicos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$result = $stmt->get_result();
$topico = $result->fetch_assoc();

if (!$topico) {
    die("Tópico não encontrado.");
}

$curso_id = $topico['curso_id'];
$topico_titulo = $topico['titulo'];
?>

<?php
session_start();

// Evita cache da página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>professor - Conteúdos</title>
  <link rel="stylesheet" href="../../css/conteudo.css">
  <link rel="stylesheet" href="../../css/back-button.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<header>
  <a onclick="history.back()" class="back-button" role="button" tabindex="0">
      <i class="fa fa-arrow-left"></i> Voltar
  </a>
</header>

<div class="container-fluid">
  <main class="col-lg-10 offset-lg-1 px-md-4">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-3 mb-4 border-bottom">
      <h1 class="h2">Conteúdos do Tópico: <strong><?= htmlspecialchars($topico_titulo) ?></strong></h1>
      <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#conteudoModal">
        <i class="bi bi-plus-circle"></i> Criar novo conteúdo
      </button>
    </div>

    <div id="mensagem"></div>

    <div class="table-responsive shadow-sm">
      <table id="tabelaConteudos" class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Arquivo/Prévia</th>
            <th>Ordem</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal Criar/Editar Conteúdo -->
<div class="modal fade" id="conteudoModal" tabindex="-1" aria-labelledby="conteudoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="conteudoModalLabel">Criar novo conteúdo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formConteudos" enctype="multipart/form-data">
          <input type="hidden" id="conteudo-id">
          <input type="hidden" id="topico_id_modal" value="<?= $topico_id ?>">

          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" required>
              <option value="texto">Texto</option>
              <option value="video">Vídeo</option>
              <option value="pdf">PDF</option>
              <option value="imagem">Imagem</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" placeholder="Digite o título do conteúdo" required>
          </div>

          <div class="mb-3">
            <label for="arquivo_path" class="form-label">Arquivo</label>
            <input type="file" class="form-control" id="arquivo_path">
            <div id="arquivo-preview" class="mt-2 text-center"></div>
          </div>

          <div class="mb-3">
            <label for="ordem" class="form-label">Ordem</label>
            <input type="number" class="form-control" id="ordem" value="0" required>
          </div>

          <button type="submit" class="btn btn-dark w-100">
            <i class="bi bi-save"></i> Salvar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const baseURL = "/2IDS/projeto-universidade-corporativa/";

function mostrarMensagem(texto, tipo){
  $('#mensagem').html(`<div class="alert alert-${tipo}">${texto}</div>`);
  setTimeout(() => { $('#mensagem').fadeOut(400, () => $(this).empty().show()); }, 3000);
}

function previewArquivo(file, tipo) {
  const preview = $('#arquivo-preview');
  preview.empty();
  if(tipo === 'imagem') {
    preview.append($('<img>').attr('src', URL.createObjectURL(file)).addClass('img-preview'));
  } else if(tipo === 'video') {
    preview.append($('<video controls>').attr('src', URL.createObjectURL(file)).addClass('video-preview'));
  } else if(tipo === 'pdf') {
    preview.append($('<embed>').attr('src', URL.createObjectURL(file)).addClass('embed-preview').attr('type', 'application/pdf'));
  }
}

$('#arquivo_path').on('change', function() {
  const file = this.files[0];
  const tipo = $('#tipo').val();
  if(file) previewArquivo(file, tipo);
});

function iconeTipo(tipo) {
  switch(tipo) {
    case 'texto': return '<i class="bi bi-file-text"></i> Texto';
    case 'video': return '<i class="bi bi-camera-video"></i> Vídeo';
    case 'pdf': return '<i class="bi bi-file-earmark-pdf"></i> PDF';
    case 'imagem': return '<i class="bi bi-image"></i> Imagem';
    default: return tipo;
  }
}

function carregarConteudos() {
  $.get(baseURL + "v1/assets/api/professor/conteudos_listar.php", { topico_id: $('#topico_id_modal').val() }, function(lista) {
    const tbody = $('#tabelaConteudos tbody');
    tbody.empty();
    lista.forEach(c => {
      let preview = c.arquivo_path;
      if(c.tipo === 'imagem') preview = `<img src="${c.arquivo_path}" class="img-preview">`;
      if(c.tipo === 'video') preview = `<video src="${c.arquivo_path}" class="video-preview" controls></video>`;
      if(c.tipo === 'pdf') preview = `<embed src="${c.arquivo_path}" class="embed-preview" type="application/pdf">`;

      tbody.append(`
        <tr>
          <td>${c.id}</td>
          <td>${iconeTipo(c.tipo)}</td>
          <td>${c.titulo}</td>
          <td>${preview}</td>
          <td>${c.ordem}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-primary btn-editar" 
              data-id="${c.id}" 
              data-tipo="${c.tipo}" 
              data-titulo="${c.titulo}" 
              data-arquivo_path="${c.arquivo_path}" 
              data-ordem="${c.ordem}">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger btn-excluir" data-id="${c.id}">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      `);
    });
  }, 'json')
  .fail(function(jqXHR){
    console.error('Erro ao carregar conteúdos:', jqXHR.responseText);
    mostrarMensagem('Erro ao carregar conteúdos (ver console).', 'danger');
  });
}

$(document).on("click", ".btn-editar", function () {
  $('#conteudoModalLabel').text("Editar conteúdo");
  $('#conteudo-id').val($(this).data("id"));
  $('#tipo').val($(this).data("tipo"));
  $('#titulo').val($(this).data("titulo"));
  $('#ordem').val($(this).data("ordem"));

  const arquivo = $(this).data("arquivo_path");
  let previewHTML = '';
  if(arquivo) previewHTML = `<a href="${arquivo}" target="_blank">Arquivo atual</a>`;
  $('#arquivo-preview').html(previewHTML);

  $('#conteudoModal').modal("show");
});

$(document).on('click', '.btn-excluir', function(){
  const id = $(this).data('id');
  if (!confirm("Deseja excluir este conteúdo?")) return;

  $.post(baseURL + "v1/assets/api/professor/conteudos_excluir.php", { id }, function(res){
    mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
    carregarConteudos();
  }, 'json');
});

$('#formConteudos').on('submit', function(e){
  e.preventDefault();
  const id = $('#conteudo-id').val();
  const url = id ? "conteudos_editar.php" : "conteudos_adicionar.php";

  const formData = new FormData();
  formData.append('id', id);
  formData.append('topico_id', $('#topico_id_modal').val());
  formData.append('tipo', $('#tipo').val());
  formData.append('titulo', $('#titulo').val());
  formData.append('ordem', $('#ordem').val());
  if($('#arquivo_path')[0].files[0]) formData.append('arquivo', $('#arquivo_path')[0].files[0]);

  $.ajax({
    url: baseURL + "v1/assets/api/professor/" + url,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function(res){
      mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
      $('#conteudoModal').modal("hide");
      $('#formConteudos')[0].reset();
      $('#arquivo-preview').empty();
      $('#conteudo-id').val('');
      $('#conteudoModalLabel').text("Criar novo conteúdo");
      carregarConteudos();
    }
  });
});

$(document).ready(() => carregarConteudos());
</script>
</body>
</html>