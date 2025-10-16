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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início | U.C</title>
  <link rel="stylesheet" href="../../css/perfil-container.css">
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>

  <?php include '../api/header.php'; ?>

  <section style="margin-top: 100px;" class="container section-inc-1">
    <div class="row introducao">
      <div class="col-md-12">
        <img class="logo-inicio pull-left" src="../../images/logo.png" alt="logo">
        <h2 class="h2-inicio text-center">Universidade Corporativa</h2>
        <h2 class="h2-inc-introducao text-center">Transforme seu futuro. Evolua sua carreira.</h2>
        <h3 style="width: 750px; margin-left: 400px;" class="h3-inc-introducao text-center">Desbloqueie seu potencial e
          alcance novos patamares de sucesso com a nossa
          <strong>Universidade Corporativa.</strong></h2>
          <a style="margin-left: 260px; text-decoration: none;" href="../../html/sobre.html"
            onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
            Clique aqui e aproveite mais informações sobre a <strong>UNICORP</strong>
          </a>
      </div>
    </div>
  </section>

  <br><br><br><br>

  <section class="container section-inc-2">
    <div class="texto-curso">
      <h3 class="h3-inicio">Gerenciar Cursos:</h3>
      <a href="cursos.php" class="btn btn-primary"
        style="margin-left: 0px; background-color: #1754a3; border: none;">Cursos</a>
    </div>
  </section>

  <br>

  <section class="container cursos-section" style="margin-top: 80px; position: relative;">
    <div class="cursos-wrapper">
      <a href="cursos.php" class="btn btn-primary pull-left btn-cursos"
        style="margin-left: 3%; background-color: #1754a3; border: none;">Gerenciar cursos</a>
      <h3 class="titulo-cursos">Cursos Disponíveis</h3>
      <p class="subtitulo-cursos">Escolha um curso e comece a transformar seu futuro.</p>
      <div id="lista-cursos" class="row g-4 cursos-grid"></div>
    </div>
  </section>

  <section style="margin-top: 300px;" id="indicadores" class="indicadores container" tabindex="0"
    aria-label="Indicadores da Universidade Corporativa">
    <div class="row text-center">
      <article class="col-md-3 indicador" aria-live="polite">
        <h3 id="num-alunos">0</h3>
        <p>Alunos</p>
      </article>
      <article class="col-md-3 indicador" aria-live="polite">
        <h3 id="num-cursos">0</h3>
        <p>Cursos</p>
      </article>
      <article class="col-md-3 indicador" aria-live="polite">
        <h3 id="num-horas">0</h3>
        <p>Horas</p>
      </article>
      <article class="col-md-3 indicador" aria-live="polite">
        <h3 id="num-certificados">0</h3>
        <p>Certificados</p>
      </article>
    </div>
  </section>

  <section id="depoimentos" class="depoimentos container" aria-label="Depoimentos de alunos">
    <h2>Depoimentos</h2>
    <article class="depoimento" tabindex="0">
      <blockquote>
        <p>"A UNICORP mudou minha vida! O conteúdo é excelente e a equipe muito atenciosa."</p>
        <footer>- João Silva</footer>
      </blockquote>
    </article>
    <article class="depoimento" tabindex="0">
      <blockquote>
        <p>"Aprendi muito e pude aplicar no meu trabalho imediatamente."</p>
        <footer>- Maria Oliveira</footer>
      </blockquote>
    </article>
  </section>

  <section id="parceiros" class="parceiros container" aria-label="Parceiros da Universidade Corporativa">
    <h2 style="margin-bottom: 50px;">Desenvolvedores</h2>
    <div class="row text-center">
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Teatin</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Felipe</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Leonardo</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Luan</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Helena</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Ana Vitória</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Dani</p>
      </div>
      <div class="col-md-3 parceiro">
        <i class="fas fa-users text-center"></i>
        <p>Larissa</p>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer-text">
      <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
    </div>
  </footer>

  <!-- Modal de Mensagem -->
  <div id="modalMensagem" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 15px;">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" id="modalCorpo"></div>
        <div class="modal-footer" id="modalBotoes"></div>
      </div>
    </div>
  </div>

  <script>
    // ---------------- MODAL PERSONALIZADO ----------------
    function mostrarModal(titulo, mensagem, botoes = []) {
      document.getElementById('modalTitulo').innerText = titulo;
      document.getElementById('modalCorpo').innerHTML = mensagem;

      const botoesContainer = document.getElementById('modalBotoes');
      botoesContainer.innerHTML = '';

      botoes.forEach(botao => {
        const btn = document.createElement('button');
        btn.className = botao.class || 'btn btn-secondary';
        btn.innerText = botao.texto;
        btn.onclick = () => {
          if (botao.onClick) botao.onClick();
          const modalEl = bootstrap.Modal.getInstance(document.getElementById('modalMensagem'));
          modalEl.hide();
        };
        botoesContainer.appendChild(btn);
      });

      const modal = new bootstrap.Modal(document.getElementById('modalMensagem'));
      modal.show();
    }

    document.addEventListener('DOMContentLoaded', () => {
      // ---------------- MENU ----------------
      const menuLink = document.querySelector('.menu-item .menu-link');
      const submenuFull = document.querySelector('.submenu-full');
      const closeSubmenu = document.querySelector('.close-submenu');

      if (menuLink && submenuFull && closeSubmenu) {
        menuLink.addEventListener('click', (e) => {
          e.preventDefault();
          submenuFull.classList.toggle('show');
        });

        closeSubmenu.addEventListener('click', (e) => {
          e.preventDefault();
          submenuFull.classList.remove('show');
        });
      }

      // ---------------- NOTIFICAÇÕES ----------------
      const ntfItem = document.querySelector('.ntf-item');
      const notificacaoBarra = document.querySelector('.notificacao-barra');

      if (ntfItem && notificacaoBarra) {
        const closeBtn = notificacaoBarra.querySelector('.close-submenu');
        const notificacoesLista = notificacaoBarra.querySelector('ul');

        ntfItem.addEventListener('click', (e) => {
          e.preventDefault();
          notificacaoBarra.classList.toggle('show');
          carregarNotificacoes();
        });

        if (closeBtn) {
          closeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificacaoBarra.classList.remove('show');
          });
        }

        function carregarNotificacoes() {
          const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
          const notificacoesFiltradas = notificacoes.filter(n => n.tipo === 'recuperacaoSenha');
          notificacoesLista.innerHTML = '';

          if (notificacoesFiltradas.length === 0) {
            const li = document.createElement('li');
            li.textContent = 'Nenhuma notificação.';
            notificacoesLista.appendChild(li);
            document.getElementById('badge-count').style.display = 'none';
            return;
          }

          notificacoesFiltradas.reverse().forEach(({ id, mensagem, data, lido, destino }) => {
            const li = document.createElement('li');
            li.innerHTML = `
            <a href="${destino || '#'}" class="link-notificacao" style="text-decoration: none; color: inherit;">
              <div class="texto-notificacao">${mensagem}</div>
              <small><em>${formatarData(data)}</em></small>
            </a>
            <button class="marcar-lido" data-id="${id}">${lido ? 'Marcar como não lido' : 'Marcar como lido'}</button>
            <button class="excluir-notificacao" data-id="${id}">Excluir</button>
          `;
            if (lido) li.style.opacity = '0.5';
            notificacoesLista.appendChild(li);

            li.querySelector('.marcar-lido').addEventListener('click', () => {
              marcarComoLido(id);
              carregarNotificacoes();
            });

            li.querySelector('.excluir-notificacao').addEventListener('click', () => {
              excluirNotificacao(id);
              carregarNotificacoes();
            });
          });

          const badge = document.getElementById('badge-count');
          const unreadCount = notificacoesFiltradas.filter(n => !n.lido).length;
          badge.textContent = unreadCount > 0 ? unreadCount : '';
          badge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
        }

        function formatarData(isoString) {
          const data = new Date(isoString);
          return data.toLocaleString('pt-BR', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit',
          });
        }

        function marcarComoLido(id) {
          const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
          const n = notificacoes.find(n => n.id === id);
          if (n) {
            n.lido = !n.lido;
            localStorage.setItem('notificacoes', JSON.stringify(notificacoes));
          }
        }

        function excluirNotificacao(id) {
          const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
          const index = notificacoes.findIndex(n => n.id === id);
          if (index !== -1) {
            notificacoes.splice(index, 1);
            localStorage.setItem('notificacoes', JSON.stringify(notificacoes));
          }
        }

        carregarNotificacoes();
      }

      // ---------------- BUSCA ----------------
      const inputSearch = document.getElementById('input-search');
      const buttonSearch = document.querySelector('.input-group-btn button');

      if (buttonSearch && inputSearch) {
        buttonSearch.addEventListener('click', () => {
          const searchText = inputSearch.value.trim().toLowerCase();
          const cursos = document.querySelectorAll('.curso');
          let encontrado = false;

          cursos.forEach(curso => {
            const nome = curso.querySelector('h3')?.textContent.toLowerCase();
            if (nome && nome.includes(searchText)) {
              curso.scrollIntoView({ behavior: 'smooth' });
              encontrado = true;
            }
          });

          if (!encontrado) {
            mostrarModal('Aviso', 'Curso não encontrado!', [
              { texto: 'OK', class: 'btn btn-secondary' }
            ]);
          }
        });
      }
    });

    // ---------------- CARREGAR CURSOS ----------------
    document.addEventListener('DOMContentLoaded', async () => {
      const listaCursos = document.getElementById('lista-cursos');

      try {
        const response = await fetch('../../api/admin/get_cursos.php');
        if (!response.ok) throw new Error('Erro na requisição: ' + response.status);

        const result = await response.json();

        if (result.success && result.data.length > 0) {
          result.data.forEach(curso => {
            const card = document.createElement('div');
            card.classList.add('curso-card');
            card.style.cssText = `
            background: linear-gradient(145deg, #ffffff, #f0f0f5);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 280px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
          `;

            // Verifica se o usuário já está matriculado
            const matriculado = curso.matriculado; // API deve retornar true/false

            card.innerHTML = `
            <div style="height:180px; background-image:url('${curso.imagem || '../../images/imgsemfundo2.png'}'); 
                              background-size: cover; background-position: center;"></div>
            <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <h4 style="margin-bottom: 10px;">${curso.titulo}</h4>
                <p style="font-size: 14px; color: #555;">${curso.descricao}</p>
              </div>
              <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <a href="#" class="btn-acessar" data-id="${curso.id}"
                  style="padding:8px 25px; background:#28a745; color:white; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600;">
                  Acessar
                </a>
                <button class="btn-matricular" data-id="${curso.id}"
                  style="padding:8px 15px; background:#007bff; color:white; border:none; border-radius:8px; font-size:14px; font-weight:600;"
                  ${matriculado ? 'disabled style="background:#ccc; cursor:not-allowed;"' : ''}>
                  Matricular
                </button>
              </div>
            </div>
          `;

            card.addEventListener('mouseenter', () => {
              card.style.transform = 'translateY(-5px)';
              card.style.boxShadow = '0 15px 25px rgba(0,0,0,0.15)';
            });
            card.addEventListener('mouseleave', () => {
              card.style.transform = 'translateY(0)';
              card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.08)';
            });

            listaCursos.appendChild(card);
          });

          // ---------------- BOTÕES DE CURSO ----------------
          listaCursos.addEventListener('click', async (e) => {
            const target = e.target;

            // ---------- MATRÍCULA ----------
            if (target.classList.contains('btn-matricular') && !target.disabled) {
              const cursoId = target.dataset.id;

              try {
                const resposta = await fetch('../../api/admin/verificar_matricula.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                  body: `curso_id=${cursoId}`,
                  credentials: 'include'
                });
                const data = await resposta.json();

                if (data.status === 'nao_logado') {
                  mostrarModal('Acesso negado', 'Você precisa estar logado para acessar este curso.', [
                    { texto: 'Fazer login', class: 'btn btn-primary', onClick: () => window.location.href = '../../html/login.php' }
                  ]);
                } else if (data.status === 'matriculado') {
                  mostrarModal('Aviso', 'Você já está matriculado neste curso!', [
                    { texto: 'OK', class: 'btn btn-secondary' }
                  ]);
                } else if (data.status === 'nao_matriculado') {
                  mostrarModal('Confirmar matrícula', 'Você ainda não está matriculado neste curso. Deseja se matricular agora?', [
                    {
                      texto: 'Sim', class: 'btn btn-success', onClick: async () => {
                        const matriculaRes = await fetch('../../api/admin/matricular.php', {
                          method: 'POST',
                          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                          body: `curso_id=${cursoId}`,
                          credentials: 'include'
                        });
                        const matriculaData = await matriculaRes.json();

                        if (matriculaData.status === 'sucesso') {
                          mostrarModal('Sucesso', 'Matrícula realizada com sucesso! Agora você pode acessar o curso.', [
                            {
                              texto: 'Acessar curso', class: 'btn btn-success', onClick: () => window.location.href =
                                `../../api/admin/videoaula.php?id=${cursoId}`
                            }
                          ]);
                          target.disabled = true;
                          target.style.background = '#ccc';
                          target.style.cursor = 'not-allowed';
                        } else {
                          mostrarModal('Erro', 'Erro ao matricular: ' + (matriculaData.mensagem || 'Tente novamente.'), [
                            { texto: 'OK', class: 'btn btn-danger' }
                          ]);
                        }
                      }
                    },
                    { texto: 'Cancelar', class: 'btn btn-secondary' }
                  ]);
                }
              } catch (err) {
                console.error('Erro:', err);
                mostrarModal('Erro', 'Erro ao verificar matrícula. Tente novamente.', [
                  { texto: 'OK', class: 'btn btn-danger' }
                ]);
              }
            }

            // ---------- ACESSAR CURSO ----------
            if (target.classList.contains('btn-acessar')) {
              e.preventDefault();
              const cursoId = target.dataset.id;

              try {
                const resposta = await fetch('../../api/admin/verificar_matricula.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                  body: `curso_id=${cursoId}`,
                  credentials: 'include'
                });

                const data = await resposta.json();

                if (data.status === 'nao_logado') {
                  mostrarModal('Acesso negado', 'Você precisa estar logado para acessar este curso.', [
                    { texto: 'Fazer login', class: 'btn btn-primary', onClick: () => window.location.href = '../../html/login.php' }
                  ]);
                } else if (data.status === 'nao_matriculado') {
                  mostrarModal('Acesso restrito', 'Você precisa se matricular neste curso antes de acessá-lo.', [
                    { texto: 'Matricular-se', class: 'btn btn-success' },
                    { texto: 'Fechar', class: 'btn btn-secondary' }
                  ]);
                } else if (data.status === 'matriculado') {
                  window.location.href = `../../api/admin/videoaula.php?id=${cursoId}`;
                }
              } catch (err) {
                console.error('Erro:', err);
                mostrarModal('Erro', 'Erro ao verificar matrícula. Tente novamente.', [
                  { texto: 'OK', class: 'btn btn-danger' }
                ]);
              }
            }
          });

        } else {
          listaCursos.innerHTML = `<p class="text-center">Nenhum curso disponível no momento.</p>`;
        }
      } catch (error) {
        console.error('Erro ao carregar cursos:', error);
        listaCursos.innerHTML = `<p class="text-center text-danger">Erro ao carregar os cursos.</p>`;
      }
    });
  </script>

  <script src="../../lib/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>