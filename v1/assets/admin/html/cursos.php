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
  <title>Admin - Gestão de Cursos</title>
  <link rel="stylesheet" href="../../css/cursos.css">
  <link rel="stylesheet" href="../../css/back-button.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<header>
<a href="inicio.php" class="back-button">
    <i class="fa fa-arrow-left"></i> Início
</a>
</header>

<div class="container-fluid">
  <main class="col-lg-10 offset-lg-1 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
      <h1 class="h2">Gestão de <strong>Cursos</strong></h1>
      <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#cursoModal">
        <i class="bi bi-plus-circle"></i> Criar novo curso
      </button>
    </div>

    <!-- Barra de Filtro -->
    <div class="input-group mb-4 shadow-sm">
      <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
      <input type="text" id="filtroCurso" class="form-control" placeholder="Pesquisar curso por título ou descrição...">
    </div>

    <div id="mensagem"></div>

    <div class="table-responsive">
      <table id="tabelaCursos" class="table table-striped table-hover align-middle shadow-sm">
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Status</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal Criar/Editar Curso -->
<div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="cursoModalLabel">Criar novo curso</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formCursos">
          <input type="hidden" id="curso-id">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" placeholder="Digite o título do curso" required>
          </div>
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" rows="3" placeholder="Digite a descrição" required></textarea>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" class="form-select">
              <option value="1">Ativo</option>
              <option value="0">Inativo</option>
            </select>
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
  const apiBase = baseURL + "v1/assets/api/admin/";

  let cursosCache = [];

  function carregarCursos() {
    $.get(apiBase + "cursos_listar.php", function(lista){
      cursosCache = lista;
      renderizarTabela(lista);
    }, 'json')
    .fail(function(jqXHR){
      console.error('Erro ao carregar cursos:', jqXHR.responseText);
      mostrarMensagem('Erro ao carregar cursos (ver console).', 'danger');
    });
  }

  function renderizarTabela(lista) {
    const tbody = $('#tabelaCursos tbody');
    tbody.empty();
    lista.forEach(curso => {
      const badge = curso.status == 1
        ? '<span class="badge bg-success badge-status">Ativo</span>'
        : '<span class="badge bg-secondary badge-status">Inativo</span>';

      tbody.append(`
        <tr>
          <td>${curso.id}</td>
          <td>${curso.titulo}</td>
          <td>${curso.descricao}</td>
          <td>${badge}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-primary btn-editar" 
                    data-id="${curso.id}" 
                    data-titulo="${curso.titulo}" 
                    data-descricao="${curso.descricao}" 
                    data-status="${curso.status}">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger btn-excluir" data-id="${curso.id}">
              <i class="bi bi-trash"></i>
            </button>
            <a href="topicos.php?id=${curso.id}" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-list-ul"></i>
            </a>
          </td>
        </tr>
      `);
    });
  }

  function mostrarMensagem(texto, tipo){
    $('#mensagem').html(`<div class="alert alert-${tipo}">${texto}</div>`);
    setTimeout(() => { $('#mensagem').fadeOut(400, () => $(this).empty().show()); }, 3000);
  }

  // 🔍 Filtro em tempo real
  $('#filtroCurso').on('input', function() {
    const termo = $(this).val().toLowerCase();
    const filtrados = cursosCache.filter(curso =>
      curso.titulo.toLowerCase().includes(termo) ||
      curso.descricao.toLowerCase().includes(termo)
    );
    renderizarTabela(filtrados);
  });

  $(document).on("click", ".btn-editar", function () {
    $('#cursoModalLabel').text("Editar curso");
    $('#curso-id').val($(this).data("id"));
    $('#titulo').val($(this).data("titulo"));
    $('#descricao').val($(this).data("descricao"));
    $('#status').val($(this).data("status"));
    $('#cursoModal').modal("show");
  });

  $(document).on('click', '.btn-excluir', function(){
    const id = $(this).data('id');
    if (!confirm("Deseja excluir este curso?")) return;

    $.post(apiBase + "cursos_excluir.php", { id }, function(res){
      mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
      carregarCursos();
    }, 'json');
  });

  $('#formCursos').on('submit', function(e){
    e.preventDefault();
    const id = $('#curso-id').val();
    const url = id ? "cursos_editar.php" : "cursos_adicionar.php";

    $.post(apiBase + url, {
      id,
      titulo: $('#titulo').val(),
      descricao: $('#descricao').val(),
      status: $('#status').val()
    }, function(res) {
      mostrarMensagem(res.mensagem, res.status === 'sucesso' ? 'success' : 'danger');
      $('#cursoModal').modal("hide");
      $('#formCursos')[0].reset();
      carregarCursos();
      $('#cursoModalLabel').text("Criar novo curso");
      $('#curso-id').val('');
    }, 'json');
  });

  $(document).ready(() => carregarCursos());
</script>

</body>
</html>
