<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início | U.C</title>
  <link rel="stylesheet" href="../../css/website.css">
  <link rel="stylesheet" href="../../css/perfil-container.css">
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>

  <header class="header-inicio">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <nav id="menu" class="menu">
            <ul>
              <div class="input-group search">
                <input id="input-search" type="search" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                  <button class="" type="button"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </ul>
          </nav>
        </div>
        <div class="col-md-4">
          <nav class="submenu">
            <ul>
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <i class="fa fa-bars menu-icon" style="color: white;"></i>
                </a>
                <div class="submenu-full">
                  <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>Menu</h2>
                    <button class="close-submenu"
                      style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
                  </div>
                  <hr>
                  <section id="foto-perfil-container" class="perfil-container" aria-label="Informações do usuário">
                    <img style="margin-left: 10px; padding: 5px;" src="../../images/crown.png"
                      alt="Foto de perfil do usuário" id="foto-perfil" />
                    <div class="perfil-info">
                      <strong style="margin-left: 30px; margin-right: 30px;" id="nome-usuario">Administrador</strong>
                    </div>

                    <button style="color: gray;" class="admin-btn" onclick="window.location.href='admin.php'"
                      title="Administrar usuários" aria-label="Administrar usuários">
                      <i class="fa fa-cogs"></i>
                    </button>

                    <a href="../login.php" style="font-size: 20px; color: gray; margin-left: -10px;"
                      title="Sair da Conta">
                      <i class="fa-solid fa-right-from-bracket"></i>
                    </a>

                  </section>

                  <hr style="margin-top: 20px;">
                  <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

                  <a href="inicio.php"><i class="fa-solid fa-house"></i> Início</a>
                  <a href="meus-cursos.php" id="meus-cursos"><i class="fa-solid fa-book"></i> Meus Cursos</a>
                  <a href="certificados.php"><i class="fa-solid fa-certificate"></i> Certificados</a>
                  <a href="../../html/sobre.html"><i class="fa-solid fa-circle-info"></i> Sobre</a>
                  <a href="admin.php"><i class="fa-solid fa-circle-info"></i> Gestão de Usuários</a>
                  <a href="cursos.php"><i class="fa-solid fa-circle-info"></i> Gestão de Cursos</a>
                </div>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-4">
          <nav class="notificacao pull-right">
            <ul>
              <li class="ntf-item" style="position: relative;">
                <a href="#" class="menu-link">
                  <i class="fa fa-bell" style="color: white;"></i>
                  <span id="badge-count"
                    style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; display: none;">0</span>
                </a>
                <div class="notificacao-barra">
                  <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>Notificações</h2>
                    <button class="close-submenu"
                      style="background:none; border:none; font-size:24px; cursor:pointer; color: black;"
                      onclick="this.parentNode.parentNode.parentNode.classList.remove('show');">&times;</button>
                  </div>
                  <hr />
                  <ul></ul>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <section style="margin-top: 100px;" class="container section-inc-1">
    <div class="row introducao">
      <div class="col-md-12">
        <img class="logo-inicio pull-left" src="../../images/logo.png" alt="logo">
        <h2 class="h2-inicio text-center">Universidade Corporativa</h2>
        <h2 class="h2-inc-introducao text-center">Transforme seu futuro. Evolua sua carreira.</h2>
        <h3 style="width: 750px; margin-left: 400px;" class="h3-inc-introducao text-center">Desbloqueie seu potencial e
          alcance novos patamares de sucesso com a nossa
          <strong>Universidade Corporativa.</strong></h2>
          <a 
            style="margin-left: 260px; text-decoration: none;" 
            href="../../html/sobre.html"
            onmouseover="this.style.textDecoration='underline';"
            onmouseout="this.style.textDecoration='none';"
          >
            Clique aqui e aproveite mais informações sobre a <strong>UNICORP</strong>
          </a>
      </div>
    </div>
  </section>

  <br><br><br><br>

  <section class="container section-inc-2">
    <div class="texto-curso">
      <h3 class="h3-inicio">Gerenciar Cursos:</h3>
      <a href="cursos.php" class="btn btn-primary" style="margin-left: 0px;">Cursos</a>
    </div>
  </section>

  <br>

<section class="container cursos-section" style="margin-top: 50px;">
  <h3 class="text-center mb-4">Cursos Disponíveis</h3>
  <div id="lista-cursos" class="row g-4" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
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

  <dialog id="dialogRemover" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-remover"
    aria-describedby="descricao-modal-remover">
    <form method="dialog">
      <h3 id="titulo-modal-remover">Confirmar remoção</h3>
      <p id="descricao-modal-remover">Deseja realmente remover esta despesa?</p>
      <div style="display: flex; justify-content: center; gap: 20px;">
        <button type="button" class="cancelar" onclick="document.getElementById('dialogRemover').close()"
          aria-label="Cancelar remoção">Cancelar</button>
        <button type="button" class="confirmar" onclick="confirmarRemover()"
          aria-label="Confirmar remoção">Confirmar</button>
      </div>
    </form>
  </dialog>

  <div id="modal-cadastro" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); 
  justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; padding:20px; border-radius:8px; max-width:300px; text-align:center;">
      <p style="font-size: 20px;">Deseja se cadastrar ao curso?</p>
      <p style="font-size: 15px; color: rgb(137, 137, 137); margin-top: -10px;">Após clicar você estará concordando com
        os termos de condição</p>
      <button id="btn-sim" class="btn btn-primary" style="margin-right:10px; width: 100px;">Sim</button>
      <button id="btn-nao" class="btn btn-secondary" style="width: 100px;">Não</button>
    </div>
  </div>
  <div id="modal-editar-curso" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); 
justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; padding:20px; border-radius:8px; max-width:300px; text-align:center;">
      <p style="font-size: 20px;">Editar Curso</p>
      <img id="imagem-curso" src="" style="width: 100px; height: 100px; border-radius: 50%; cursor: pointer;">
      <input type="file" id="input-file-imagem" style="display: none;">
      <input id="input-nome-curso" type="text" placeholder="Nome do curso"
        style="width: 100%; padding: 10px; margin-bottom: 10px;">
      <textarea id="input-descricao-curso" placeholder="Descrição do curso"
        style="width: 100%; padding: 10px; margin-bottom: 10px; height: 100px;"></textarea>
      <button id="btn-salvar-edicao" class="btn btn-primary" style="margin-right:10px; width: 100px;">Salvar</button>
      <button id="btn-cancelar-edicao" class="btn btn-secondary" style="width: 100px;">Cancelar</button>
    </div>
  </div>
  <div id="modal-trocar-conta" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); 
  justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; padding:20px; border-radius:8px; max-width:300px; text-align:center;">
      <p style="font-size: 20px;">Deseja realmente trocar de conta?</p>
      <button id="btn-sim-trocar-conta" class="btn btn-primary" style="margin-right:10px; width: 100px;">Sim</button>
      <button id="btn-nao-trocar-conta" class="btn btn-secondary" style="width: 100px;">Não</button>
    </div>
  </div>

  <button id="btn-voltar-topo" aria-label="Voltar ao topo" title="Voltar ao topo" tabindex="0">&#8679;</button>

  <script>
document.addEventListener('DOMContentLoaded', () => {
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
        const badge = document.getElementById('badge-count');
        if (badge) badge.style.display = 'none';
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
      if (badge) {
        const unreadCount = notificacoesFiltradas.filter(n => !n.lido).length;
        badge.textContent = unreadCount > 0 ? unreadCount : '';
        badge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
      }
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

  const inputSearch = document.getElementById('input-search');
  const buttonSearch = document.querySelector('.input-group-btn button');

  if (buttonSearch && inputSearch) {
    buttonSearch.addEventListener('click', () => {
      const searchText = inputSearch.value.trim().toLowerCase();
      const cursos = document.querySelectorAll('.curso');
      let encontrado = false;

      cursos.forEach(curso => {
        const nome = curso.querySelector('h3').textContent.toLowerCase();
        if (nome.includes(searchText)) {
          curso.scrollIntoView({ behavior: 'smooth' });
          encontrado = true;
        }
      });

      if (!encontrado) alert('Curso não encontrado!');
    });
  }

  const botoesAcessarCurso = document.querySelectorAll('.curso .btn-primary');
  botoesAcessarCurso.forEach(botao => {
    const nomeCurso = botao.getAttribute('data-nome');
    const cursoElement = botao.closest('.curso');
    const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};

    if (cursosDisponiveis[nomeCurso]) cursoElement.style.display = 'none';

    botao.addEventListener('click', e => {
      e.preventDefault();
      const modalCadastro = document.getElementById('modal-cadastro');
      modalCadastro.style.display = 'flex';

      const btnSim = document.getElementById('btn-sim');
      const btnNao = document.getElementById('btn-nao');

      btnSim.onclick = () => {
        cadastrarCurso(nomeCurso, cursoElement);
        modalCadastro.style.display = 'none';
        window.location.href = 'meus-cursos.html';
      };

      btnNao.onclick = () => {
        modalCadastro.style.display = 'none';
      };
    });
  });

  function cadastrarCurso(nomeCurso, cursoElement) {
    const cursosCadastrados = JSON.parse(localStorage.getItem('cursosCadastrados')) || [];
    if (!cursosCadastrados.some(c => c.nome === nomeCurso)) {
      cursosCadastrados.push({ nome: nomeCurso });
      localStorage.setItem('cursosCadastrados', JSON.stringify(cursosCadastrados));

      const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};
      cursosDisponiveis[nomeCurso] = true;
      localStorage.setItem('cursosDisponiveis', JSON.stringify(cursosDisponiveis));

      cursoElement.style.display = 'none';
    }
  }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  const listaCursos = document.getElementById('lista-cursos');

  try {
    const response = await fetch('../../api/admin/get_cursos.php');
    if (!response.ok) throw new Error('Erro na requisição: ' + response.status);

    const result = await response.json();

    if (result.success && result.data.length > 0) {
      result.data.forEach(curso => {
        // se quiser só os ativos, descomenta a linha abaixo
        // if (curso.status != 1) return;

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

        card.innerHTML = `
          <div style="height:180px; background-image:url('${curso.imagem ? '../../images/' + curso.imagem : '../../images/imgsemfundo2.png'}'); 
                      background-size: cover; background-position: center;"></div>
          <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
              <h4 style="margin-bottom: 10px;">${curso.titulo}</h4>
              <p style="font-size: 14px; color: #555;">${curso.descricao}</p>
            </div>
            <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <a href="../../api/admin/videoaula.php?id=${curso.id}" style="padding:8px 15px; background:#28a745; color:white; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600;">
                  Acessar
                </a>
              <div style="position: relative;">
                <button class="menu-btn" style="border:none; background:none; font-size:20px; cursor:pointer;">⋮</button>
                <ul class="menu-list" style="display:none; position:absolute; top:25px; right:0; background:white; border-radius:8px; box-shadow:0 5px 15px rgba(0,0,0,0.2); list-style:none; padding:10px 0; min-width:120px;">
                  <li style="padding:8px 15px; cursor:pointer;" onclick="window.location.href='editar_curso.php?id=${curso.id}'">Editar</li>
                  <li style="padding:8px 15px; cursor:pointer;" onclick="excluirCurso(${curso.id})">Excluir</li>
                </ul>
              </div>
            </div>
          </div>
        `;

        // Hover efeito
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

      // Menu toggle (apenas um listener global)
      document.addEventListener('click', (e) => {
        document.querySelectorAll('.menu-list').forEach(menu => menu.style.display = 'none');
        if (e.target.classList.contains('menu-btn')) {
          const menu = e.target.nextElementSibling;
          menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
          e.stopPropagation();
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

// Função de excluir
function excluirCurso(id) {
  if(confirm('Deseja realmente excluir este curso?')) {
    fetch(`../../api/admin/excluir_curso.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        alert('Curso excluído com sucesso!');
        location.reload();
      } else {
        alert('Erro ao excluir curso.');
      }
    })
    .catch(err => console.error('Erro:', err));
  }
}
</script>

</body>

</html>