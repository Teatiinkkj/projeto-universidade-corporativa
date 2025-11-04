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

  <section class="section-inc-1 mt-5">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center text-lg-start">

        <!-- Textos (agora com área maior) -->
        <div class="col-12 col-lg-6 mb-5 mb-lg-0 titulos">
          <h2 class="h2-inicio">Universidade Corporativa</h2>
          <h2 class="h2-inc-introducao">Transforme seu futuro. Evolua sua carreira.</h2>
          <h3 class="h3-inc-introducao">
            Desbloqueie seu potencial e alcance novos patamares de sucesso com a nossa
            <strong>Universidade Corporativa.</strong>
          </h3>

          <!-- Novo parágrafo motivacional -->
          <p class="p-inc-introducao">
            Nossos cursos são desenhados para profissionais que buscam crescimento real e aplicável no mercado. Aqui,
            você aprende na prática e com quem entende do assunto.
          </p>

          <!-- Frase de destaque curta -->
          <p class="p-inc-destaque">
            🚀 Prepare-se para decolar sua carreira com conhecimento de ponta!
          </p>

          <a href="../../html/sobre.html" class="link-sobre">
            <i class="fa fa-info-circle"></i> Clique aqui e saiba mais sobre a <strong>UNICORP!</strong>
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>

        <!-- Logo (diminuída um pouco para balancear) -->
        <div class="col-12 col-lg-2 mb-lg-0 g-4">
          <img class="logo-inicio" src="../../images/logo.png" alt="Logo UNICORP"
            style="margin-left: -200px; margin-right: 200px;">
        </div>

        <!-- CTA Criativa -->
        <div class="col-12 col-lg-4">
          <section class="cta">
            <h2>Pronto para dar o próximo passo?</h2>
            <p>Invista no seu futuro e conquiste novas oportunidades com nossos cursos exclusivos da
              <strong>UNICORP</strong>.
            </p>
            <div class="cta-beneficios">
              <div class="beneficio">
                <span>Aulas <strong>100%</strong> online e práticas</span>
              </div>
              <div class="beneficio">
                <span>Certificação reconhecida no <strong>mercado</strong></span>
              </div>
              <div class="beneficio">
                <span>Professores <strong>especialistas</strong> na área</span>
              </div>
            </div>
            <div class="cta-selo">
              Mais de <strong>10.000 alunos</strong> transformaram suas carreiras!
            </div>
            <button class="btn-curso" id="btnComeceAgora">Comece Agora</button>
          </section>
        </div>
      </div>
    </div>
  </section>

  <br><br><br><br>

  <br>

  <section class="ctb-texto">
    <h2 class="animado">Invista no seu futuro! Acesse nossos cursos agora!</h2>
  </section>

  <br>

  <section class="container cursos-section" style="margin-top: 80px; position: relative;">
    <div class="cursos-wrapper">
      <a href="cursos.php" class="btn btn-primary pull-left btn-cursos"
        style="margin-left: 3%; background-color: #1754a3; border: none;">Gerenciar cursos</a>
      <h3 class="titulo-cursos" style="margin-right: 180px;">Cursos Disponíveis</h3>
      <p class="subtitulo-cursos">Escolha um curso e comece a transformar seu futuro.</p>
      <div id="lista-cursos" class="row g-4 cursos-grid"></div>
    </div>
  </section>

  <section id="parceiros" class="parceiros container" aria-label="Parceiros da Universidade Corporativa">
    <h2>Desenvolvedores</h2>
    <div class="row text-center" style="margin-left: 70px;">
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Teatin</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Felipe</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Leonardo</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Luan</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Helena</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Ana Vitória</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
        <p>Dani</p>
      </div>
      <div class="col-md-3 parceiro" style="width: 250px;">
        <div class="icon-container">
          <i class="fa fa-user"></i>
        </div>
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

            // Verifica matrícula e progresso
            const matriculado = curso.matriculado == 1 || curso.matriculado === true;
            const progresso = parseInt(curso.progresso) || 0;

            // Define a borda condicional
            const borderStyle = matriculado
              ? '4px solid rgba(30, 81, 149, 0.6)'
              : 'none';

            card.style.cssText = `
                background: linear-gradient(145deg, #ffffff, #f0f0f5);
                border: ${borderStyle};
                border-radius: 15px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.08);
                overflow: hidden;
                width: 280px;
                transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
                display: flex;
                flex-direction: column;
              `;

            card.innerHTML = `
              <div style="height:180px; background-image:url('${curso.imagem || '../../images/imgsemfundo2.png'}'); 
                            background-size: cover; background-position: center;"></div>
              <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h4 style="margin-bottom: 10px;">${curso.titulo}</h4>
                  <p style="font-size: 14px; color: #555;">${curso.descricao}</p>

                  ${matriculado ? `
                    <div class="progress-container" style="background:#eee; border-radius:8px; height:12px; overflow:hidden;">
                      <div class="progress-bar" id="progress-${curso.id}" 
                          style="
                            width: ${progresso}%;
                            height:100%;
                            background:#1754a3;
                            border-radius: 8px;
                            transition: width 0.5s;
                          ">
                      </div>
                    </div>
                    <div class="progress-text" id="progress-text-${curso.id}">${progresso}% concluído</div>
                  ` : ''}
                </div>
                <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                  <a href="#" class="btn-acessar" data-id="${curso.id}"
                    style="padding:8px 25px; background:#28a745; color:white; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600;">
                    Acessar
                  </a>
                    ${matriculado ? `
                      <span style="color:#28a745; font-weight:600; font-size:14px;">Matriculado</span>
                    ` : `
                      <button class="btn-matricular" data-id="${curso.id}"
                        style="padding:8px 15px; background:#007bff; color:white; border:none; border-radius:8px; font-size:14px; font-weight:600;">
                        Matricular
                      </button>
                    `}
                </div>
              </div>
            `;

            // Efeito hover apenas se matriculado
            card.addEventListener('mouseenter', () => {
              card.style.transform = 'translateY(-5px)';
              card.style.boxShadow = '0 15px 25px rgba(0,0,0,0.15)';
              if (matriculado) card.style.borderColor = '#1754a3';
            });
            card.addEventListener('mouseleave', () => {
              card.style.transform = 'translateY(0)';
              card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.08)';
              if (matriculado) card.style.borderColor = 'rgb(29, 113, 222)';
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
                              texto: 'Acessar curso',
                              class: 'btn btn-success',
                              onClick: () => window.location.href = `../../api/admin/videoaula.php?id=${cursoId}`
                            }
                          ]);

                          // Substitui o botão "Matricular" pelo texto informativo
                          const cardFooter = target.parentElement;
                          target.remove(); // remove o botão "Matricular"

                          const textoMatriculado = document.createElement('span');
                          textoMatriculado.textContent = 'Matriculado';
                          textoMatriculado.style.cssText = `
                            color: #28a745;
                            font-weight: 600;
                            font-size: 14px;
                          `;

                          cardFooter.appendChild(textoMatriculado);

                          // Atualiza a barra de progresso
                          const progressBar = document.getElementById(`progress-${cursoId}`);
                          if (progressBar) {
                            progressBar.style.background = '#28a745';
                            progressBar.style.width = '0%';
                          }

                          // Se quiser mostrar também um texto de progresso inicial
                          const progressText = document.getElementById(`progress-text-${cursoId}`);
                          if (progressText) {
                            progressText.textContent = '0% concluído';
                          }
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

    // Scroll suave para a seção de cursos
    document.getElementById('btnComeceAgora').addEventListener('click', () => {
      const cursosSection = document.querySelector('.animado');
      if (cursosSection) {
        cursosSection.scrollIntoView({ behavior: 'smooth' });
      }
    });

    // Scroll Reveal manual
    const parceiros = document.querySelectorAll('.parceiro');

    function revelarCards() {
      const windowHeight = window.innerHeight;
      parceiros.forEach((parceiro, i) => {
        const top = parceiro.getBoundingClientRect().top;
        if (top < windowHeight - 50) {
          setTimeout(() => {
            parceiro.classList.add('show-on-scroll');
          }, i * 150);
        }
      });
    }

    window.addEventListener('scroll', revelarCards);
    window.addEventListener('load', revelarCards);
  </script>

  <script src="../../lib/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>