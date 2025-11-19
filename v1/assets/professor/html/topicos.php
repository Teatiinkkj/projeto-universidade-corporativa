<?php
if (!isset($_GET['id'])) {
  die("Curso não especificado.");
}
$curso_id = intval($_GET['id']);
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>professor - Tópicos</title>
  <link rel="stylesheet" href="../../css/topicos.css" />
  <link rel="stylesheet" href="../../css/back-button.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<header>
  <a onclick="history.back()" class="back-button" role="button" tabindex="0">
      <i class="fa fa-arrow-left"></i> Voltar
  </a>
</header>

<div class="container-fluid">
  <main class="col-lg-10 offset-lg-1 px-md-4" style="padding: 30px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
      <h1 class="h2">Tópicos do Curso <strong><?= $curso_id ?></strong></h1>
      <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#topicoModal">
        <i class="bi bi-plus-circle"></i> Criar novo tópico
      </button>
    </div>

    <div id="mensagem"></div>

    <div class="table-responsive">
      <table id="tabelaTopicos" class="table table-striped table-hover align-middle shadow-sm">
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ordem</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal Criar/Editar Tópico -->
<div class="modal fade" id="topicoModal" tabindex="-1" aria-labelledby="topicoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="topicoModalLabel">Criar novo tópico</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formTopicos">
          <input type="hidden" id="topico-id">
          <input type="hidden" id="curso_id_modal" value="<?= $curso_id ?>">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" placeholder="Digite o título do tópico" required>
          </div>
          <div class="mb-3">
            <label for="ordem" class="form-label">Ordem</label>
            <input type="number" class="form-control" id="ordem" placeholder="Digite a ordem" required>
          </div>
          <button type="submit" class="btn btn-dark w-100">
            <i class="bi bi-save"></i> Salvar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  const baseURL = "/2IDS/projeto-universidade-corporativa/";
  const apiBase = baseURL + "v1/assets/api/professor/";

  function carregarTopicos() {
    const cursoId = $('#curso_id_modal').val();
    $.get(apiBase + "topicos_listar.php", { curso_id: cursoId }, function(lista) {
      const tbody = $('#tabelaTopicos tbody');
      tbody.empty();
      lista.forEach(t => {
        tbody.append(`
          <tr>
            <td>${t.id}</td>
            <td>${t.titulo}</td>
            <td>${t.ordem}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-primary btn-editar"
                      data-id="${t.id}"
                      data-titulo="${t.titulo}"
                      data-ordem="${t.ordem}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger btn-excluir" data-id="${t.id}">
                <i class="bi bi-trash"></i>
              </button>
              <a href="conteudo.php?topico_id=${t.id}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-journal-text"></i>
              </a>
            </td>
          </tr>
        `);
      });
    }, 'json')
    .fail(err => {
      console.error('Erro ao carregar tópicos:', err.responseText);
      mostrarMensagem('Erro ao carregar tópicos (ver console).', 'danger');
    });
  }

  function mostrarMensagem(texto, tipo) {
    $('#mensagem').html(`<div class="alert alert-${tipo}">${texto}</div>`);
    setTimeout(() => {
      $('#mensagem').fadeOut(400, function () {
        $(this).empty().show();
      });
    }, 3000);
  }

  $(document).on("click", ".btn-editar", function () {
    $('#topicoModalLabel').text("Editar tópico");
    $('#topico-id').val($(this).data("id"));
    $('#titulo').val($(this).data("titulo"));
    $('#ordem').val($(this).data("ordem"));
    $('#topicoModal').modal("show");
  });

  $(document).on("click", ".btn-excluir", function () {
    const id = $(this).data("id");
    if (!confirm("Deseja excluir este tópico?")) return;

    $.post(apiBase + "topicos_excluir.php", { id }, function (res) {
      mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
      carregarTopicos();
    }, 'json')
    .fail(err => {
      console.error('Erro ao excluir tópico:', err.responseText);
      mostrarMensagem('Erro ao excluir tópico.', 'danger');
    });
  });

  $('#formTopicos').on('submit', function(e){
    e.preventDefault();
    const id = $('#topico-id').val();
    const url = id ? "topicos_editar.php" : "topicos_adicionar.php";

    $.post(apiBase + url, {
      id,
      curso_id: $('#curso_id_modal').val(),
      titulo: $('#titulo').val(),
      ordem: $('#ordem').val()
    }, function(res) {
      mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
      $('#topicoModal').modal("hide");
      $('#formTopicos')[0].reset();
      $('#topico-id').val('');
      $('#topicoModalLabel').text("Criar novo tópico");
      carregarTopicos();
    }, 'json')
    .fail(err => {
      console.error('Erro ao salvar tópico:', err.responseText);
      mostrarMensagem('Erro ao salvar tópico.', 'danger');
    });
  });

  $(document).ready(() => carregarTopicos());
</script>

</body>
</html>