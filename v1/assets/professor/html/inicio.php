<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início | U.C</title>
  <link rel="stylesheet" href="../../css/website.css">
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
                  <div class="perfil-submenu" style="display: flex; align-items: center; gap: 15px;">
                    <div class="row">
                      <div class="col-md-3">
                        <div id="foto-perfil-container"
                          style="position: relative; width: 60px; height: 60px; cursor: pointer;">
                          <img id="foto-perfil" src="../images/default-avatar.png" alt="Foto de Perfil"
                            class="foto-perfil" style="width: 60px; height: 60px; border-radius: 50%; display: block;">
                          <i class="fa fa-pencil"
                            style="position: absolute; bottom: 0; right: 0; background: white; border-radius: 50%; padding: 4px; font-size: 14px; color: #333;"></i>
                        </div>
                        <input type="file" id="input-foto-perfil" accept="image/*" style="display: none;">
                      </div>
                      <div style="margin-top: 10px; display: flex; align-items: center;" class="col-md-8">
                        <div style="display: flex; flex-direction: column; margin-right: 10px;">
                          <p id="nome-usuario" style="margin: 0; font-weight: bold;">Nome</p>
                          <p id="email-usuario" style="margin: 0; font-size: 14px;">email@email.com</p>
                        </div>
                        <a href="../login.html" style="font-size: 20px;" title="Sair da Conta">
                          <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <hr style="margin-top: 20px;">
                  <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

                  <a href="inicio.html"><i class="fa-solid fa-house"></i> Início</a>
                  <a href="meus-cursos.html" id="meus-cursos"><i class="fa-solid fa-book"></i> Meus Cursos</a>
                  <a href="certificados.html"><i class="fa-solid fa-certificate"></i> Certificados</a>
                  <a href="../sobre.html"><i class="fa-solid fa-circle-info"></i> Sobre</a>

                </div>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-4">
          <nav class="notificacao pull-right">
            <ul>
              <li class="ntf-item">
                <a href="#" class="menu-link">
                  <i class="fa fa-bell" style="color: white;"></i>
                  <span id="badge-count"
                    style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; display: none;">0</span>
                </a>
                <div class="notificacao-barra">
                  <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>Notificações</h2>
                    <button class="close-submenu"
                      style="background:none; border:none; font-size:24px; cursor:pointer; color: black;">&times;</button>
                  </div>
                  <hr>
                  <ul>
                    <li><a href="#">Notificação 1</a></li>
                    <li><a href="#">Notificação 2</a></li>
                    <li><a href="#">Notificação 3</a></li>
                  </ul>
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
        <img class="logo-inicio pull-left" src="../images/logo.png" alt="logo">
        <h2 class="h2-inicio text-center">Universidade Corporativa</h2>
        <h2 class="h2-inc-introducao text-center">Transforme seu futuro. Evolua sua carreira.</h2>
        <h3 style="width: 750px; margin-left: 400px;" class="h3-inc-introducao text-center">Desbloqueie seu potencial e
          alcance novos patamares de sucesso com a nossa
          <strong>Universidade Corporativa.</strong></h2>
          <a style="margin-left: 260px;" href="../sobre.html">Clique aqui e aproveite mais informações sobre a <strong
              style="text-decoration: underline;">UNICORP</strong>...</a>
      </div>
    </div>
  </section>

  <br><br><br><br>

  <section class="container section-inc-2">
    <div class="texto-curso">
      <h3 class="h3-inicio">Escolha seu curso:</h3>
      <a href="meus-cursos.html" class="btn btn-primary" style="margin-left: 0px;">Meus Cursos</a>
    </div>
  </section>

  <br>

  <section class="container section-inc-video">
    <div class="row">
      <div class="video-inicio col-md-12">
        <h2 class="h2-curso" style="margin-top: 20px;">Cursos Disponíveis</h2>
        <div class="cursos" style="margin-top: 40px;">
          <div class="curso">
            <img src="../images/imgsemfundo2.png" alt="Curso 1">
            <h3>Gestão Escolar Eficiente</h3>
            <p>Capacitação voltada para coordenadores e diretores escolares, com foco em liderança educacional, gestão
              de equipe, planejamento estratégico e uso de indicadores de desempenho.</p>
            <a href="#" class="btn btn-primary" data-nome="Gestão Escolar Eficiente">Cadastrar-se</a>
            <div class="btn-view-alunos">
              <a href="listar_usuarios.html" class="btn" style="width: 170px;">Alunos cadastrados</a>
            </div>
          </div>
          <div class="curso">
            <img src="../images/imgsemfundo2.png" alt="Curso 2">
            <h3>Metodologias Ativas em Sala de Aula</h3>
            <p>Explore práticas inovadoras como sala de aula invertida, ensino híbrido e aprendizagem baseada em
              projetos, promovendo o protagonismo do aluno no processo de aprendizagem.</p>
            <a href="videoaula.html" class="btn btn-primary"
              data-nome="Metodologias Ativas em Sala de Aula">Cadastrar-se</a>
            <div class="btn-view-alunos">
              <a href="listar_usuarios.html" class="btn" style="width: 170px;">Alunos cadastrados</a>
            </div>
          </div>
          <div class="curso">
            <img src="../images/imgsemfundo2.png" alt="Curso 3">
            <h3>Comunicação e Relacionamento com Famílias</h3>
            <p>Desenvolva habilidades de comunicação empática e estratégias para construir parcerias positivas entre
              escola e família, fortalecendo o vínculo com a comunidade escolar.</p>
            <a href="videoaula.html" class="btn btn-primary"
              data-nome="Comunicação e Relacionamento com Famílias">Cadastrar-se</a>
            <div class="btn-view-alunos">
              <a href="listar_usuarios.html" class="btn" style="width: 170px;">Alunos cadastrados</a>
            </div>
          </div>
        </div>
        <button class="btn-adicionar">
          <span class="plus">+</span>
        </button>
      </div>
    </div>
  </section>

  <section id="indicadores" class="indicadores container" tabindex="0"
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

  <section id="carrossel-destaques" class="carrossel container" aria-label="Carrossel de Destaques" tabindex="0">
    <button id="prev-slide" aria-label="Slide anterior" class="carrossel-btn">&#8592;</button>
    <button id="next-slide" aria-label="Próximo slide" class="carrossel-btn">&#8594;</button>
    <div class="slides">
      <article class="slide active" tabindex="-1">
        <img src="../images/professores-unicorp.png" alt="Destaque 1">
      </article>
      <article class="slide" tabindex="-1">
        <img src="../images/metodologias-inovadoras.png" alt="Destaque 2">
      </article>
      <article class="slide" tabindex="-1">
        <img src="../images/profissao.png" alt="Destaque 3">
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
    <h2 style="margin-bottom: 50px;">Parceiros</h2>
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

  <div id="modal-confirmacao" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); 
    justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; padding:20px; border-radius:8px; max-width:300px; text-align:center;">
      <p style="font-size: 20px;">Deseja realmente alterar a foto de perfil?</p>
      <button id="btn-confirmar" class="btn btn-primary" style="margin-right:10px; width: 100px;">Sim</button>
      <button id="btn-cancelar" class="btn btn-secondary" style="width: 100px;">Cancelar</button>
    </div>
  </div>
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

  <footer>
    <div class="footer-text">
      <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
    </div>
  </footer>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const menuLink = document.querySelector('.menu-item .menu-link');
      const submenuFull = document.querySelector('.submenu-full');
      const closeSubmenu = document.querySelector('.close-submenu');

      menuLink.addEventListener('click', (e) => {
        e.preventDefault();
        submenuFull.classList.toggle('show');
      });

      closeSubmenu.addEventListener('click', (e) => {
        e.preventDefault();
        submenuFull.classList.remove('show');
      });
      const ntfItem = document.querySelector('.ntf-item');
      const notificacaoBarra = document.querySelector('.notificacao-barra');
      const badge = document.getElementById('badge-count');

      if (ntfItem && notificacaoBarra && badge) {
        ntfItem.addEventListener('click', (e) => {
          e.preventDefault();
          notificacaoBarra.classList.toggle('show');
          carregarNotificacoes();
        });
      }

      function formatarData(isoString) {
        const data = new Date(isoString);
        return data.toLocaleString('pt-BR', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
        });
      }

      function carregarNotificacoes() {
        if (!notificacaoBarra) return;

        const notificacoesLista = notificacaoBarra.querySelector('ul');
        if (!notificacoesLista) return;

        let notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];

        const notificacoesAlteracao = notificacoes.filter(n => n.tipo === 'alteracaoSenha');

        notificacoesLista.innerHTML = '';

        if (notificacoesAlteracao.length === 0) {
          const li = document.createElement('li');
          li.textContent = 'Nenhuma notificação';
          notificacoesLista.appendChild(li);
          atualizarBadge();
          return;
        }

        const notificacoesInvertidas = notificacoesAlteracao.slice().reverse();

        notificacoesInvertidas.forEach((notificacao) => {
          const li = document.createElement('li');
          li.classList.add('notificacao-item');
          li.style.position = 'relative';
          if (notificacao.lido) {
            li.style.opacity = '0.6';
          }

          li.innerHTML = `
      <div class="texto-notificacao">${notificacao.mensagem}</div>
      <div class="senha-notificacao"><strong>Nova senha:</strong> ${notificacao.senhaNova}</div>
      <small><em>${formatarData(notificacao.data)}</em></small>
      <button class="marcar-lido" data-id="${notificacao.id}">Marcar como ${notificacao.lido ? 'não lido' : 'lido'}</button>
      <button class="excluir-notificacao" data-id="${notificacao.id}">Excluir</button>
    `;

          li.querySelector('.marcar-lido').addEventListener('click', (e) => {
            e.stopPropagation();
            marcarComoLido(notificacao.id);
            carregarNotificacoes();
          });

          li.querySelector('.excluir-notificacao').addEventListener('click', (e) => {
            e.stopPropagation();
            excluirNotificacao(notificacao.id);
            carregarNotificacoes();
          });

          notificacoesLista.appendChild(li);
        });

        atualizarBadge();
      }

      function marcarComoLido(id) {
        let notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
        notificacoes = notificacoes.map(n => n.id === id ? { ...n, lido: !n.lido } : n);
        localStorage.setItem('notificacoes', JSON.stringify(notificacoes));
      }

      function excluirNotificacao(id) {
        let notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
        notificacoes = notificacoes.filter(n => n.id !== id);
        localStorage.setItem('notificacoes', JSON.stringify(notificacoes));
      }

      function atualizarBadge() {
        const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];
        const naoLidas = notificacoes.filter(n => n.tipo === 'alteracaoSenha' && !n.lido).length;
        badge.textContent = naoLidas > 0 ? naoLidas : '';
        badge.style.display = naoLidas > 0 ? 'block' : 'none';
      }
      carregarNotificacoes();
    });

    document.addEventListener('DOMContentLoaded', () => {
      const dadosUsuario = JSON.parse(localStorage.getItem("usuarioLogado"));

      if (dadosUsuario) {
        document.getElementById('nome-usuario').textContent = dadosUsuario.usuario;
        document.getElementById('email-usuario').textContent = dadosUsuario.email;
      }
      const fotoPerfilContainer = document.getElementById("foto-perfil-container");
      const fotoPerfil = document.getElementById("foto-perfil");
      const modalConfirmacao = document.getElementById("modal-confirmacao");
      const btnConfirmar = document.getElementById("btn-confirmar");
      const btnCancelar = document.getElementById("btn-cancelar");

      const inputFotoPerfil = document.createElement("input");
      inputFotoPerfil.type = "file";
      inputFotoPerfil.accept = "image/*";
      inputFotoPerfil.style.display = "none";
      document.body.appendChild(inputFotoPerfil);

      fotoPerfilContainer.addEventListener("click", () => {
        modalConfirmacao.style.display = "flex";
      });

      btnCancelar.addEventListener("click", () => {
        modalConfirmacao.style.display = "none";
      });

      btnConfirmar.addEventListener("click", () => {
        modalConfirmacao.style.display = "none";
        inputFotoPerfil.click();
      });

      inputFotoPerfil.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file && file.type.startsWith("image/")) {
          const reader = new FileReader();
          reader.onload = () => {
            fotoPerfil.src = reader.result;
            const dadosUsuario = JSON.parse(localStorage.getItem("usuarioLogado")) || {};
            dadosUsuario.foto = reader.result;
            localStorage.setItem("usuarioLogado", JSON.stringify(dadosUsuario));
          };
          reader.readAsDataURL(file);
        }
      });
    });

    document.addEventListener('DOMContentLoaded', () => {
      const dadosUsuario = JSON.parse(localStorage.getItem("usuarioLogado"));

      if (dadosUsuario) {
        document.getElementById('nome-usuario').textContent = dadosUsuario.nome;
        document.getElementById('email-usuario').textContent = dadosUsuario.email;

        const fotoPerfil = document.getElementById("foto-perfil");
        if (dadosUsuario.foto) {
          fotoPerfil.src = dadosUsuario.foto;
        }
      }
    });
    const inputSearch = document.getElementById('input-search');
    const buttonSearch = document.querySelector('.input-group-btn button');

    buttonSearch.addEventListener('click', () => {
      const searchText = inputSearch.value.trim().toLowerCase();
      const cursos = [
        { nome: 'Gestão Escolar Eficiente', url: 'videoaula.html' },
        { nome: 'Metodologias Ativas em Sala de Aula', url: 'videoaula.html' },
        { nome: 'Comunicação e Relacionamento com Famílias', url: 'videoaula.html' },
      ];

      const cursoEncontrado = cursos.find((curso) => curso.nome.toLowerCase().includes(searchText));

      if (cursoEncontrado) {
        window.location.href = cursoEncontrado.url;
      } else {
        alert('Curso não encontrado!');
      }
    });

    const imagens = document.querySelectorAll('.curso img');

    imagens.forEach((imagem) => {
      const editarImagem = document.createElement('i');
      editarImagem.classList.add('fa', 'fa-ellipsis-v'); 
      editarImagem.style.position = 'absolute';
      editarImagem.style.top = '5px';
      editarImagem.style.right = '5px'; 
      editarImagem.style.textAlign = 'center';
      editarImagem.style.padding = '4px';
      editarImagem.style.fontSize = '20px';
      editarImagem.style.color = '#333';
      imagem.parentNode.style.position = 'relative';
      imagem.parentNode.appendChild(editarImagem);

      editarImagem.addEventListener('mouseover', () => {
        editarImagem.style.transform = 'scale(1.5)';
        editarImagem.style.transition = 'transform 0.2s';
      });

      editarImagem.addEventListener('mouseout', () => {
        editarImagem.style.transform = 'scale(1)';
      });

      editarImagem.addEventListener('click', (e) => {
        e.stopPropagation();
        const curso = imagem.parentNode;
        const nomeCurso = curso.querySelector('h3').textContent;
        const submenu = document.createElement('div');
        submenu.classList.add('submenu-curso');
        submenu.style.position = 'absolute';
        submenu.style.top = editarImagem.offsetTop + editarImagem.offsetHeight + 'px';
        submenu.style.left = editarImagem.offsetLeft + 'px';
        submenu.style.background = '#fff';
        submenu.style.border = '1px solid #ddd';
        submenu.style.padding = '10px';
        submenu.style.zIndex = '9999';

        const editar = document.createElement('button');
        editar.textContent = 'Editar';
        editar.addEventListener('click', () => {
          const modalEditarCurso = document.getElementById('modal-editar-curso');
          modalEditarCurso.style.display = 'flex';
          document.getElementById('input-nome-curso').value = nomeCurso;
          document.getElementById('input-descricao-curso').value = curso.querySelector('p').textContent;

          const cursos = JSON.parse(localStorage.getItem('cursos')) || [];
          const cursoEncontrado = cursos.find(c => c.nome === nomeCurso);
          if (cursoEncontrado && cursoEncontrado.imagem) {
            const imagemCurso = document.getElementById('imagem-curso');
            imagemCurso.src = cursoEncontrado.imagem;
          } else {
            const imagemCurso = document.getElementById('imagem-curso');
            imagemCurso.src = imagem.src;
          }

          const imagemCurso = document.getElementById('imagem-curso');
          imagemCurso.addEventListener('click', abrirPastaArquivos);

          function abrirPastaArquivos() {
            const inputFile = document.getElementById('input-file-imagem');
            inputFile.click();
          }

          const inputFile = document.getElementById('input-file-imagem');
          inputFile.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith("image/")) {
              const reader = new FileReader();
              reader.onload = () => {
                const imagemCurso = document.getElementById('imagem-curso');
                imagemCurso.src = reader.result;

                const cursos = JSON.parse(localStorage.getItem('cursos')) || [];
                const cursoEncontrado = cursos.find(c => c.nome === nomeCurso);
                if (cursoEncontrado) {
                  cursoEncontrado.imagem = reader.result;
                  localStorage.setItem('cursos', JSON.stringify(cursos));
                } else {
                  const novoCurso = { nome: nomeCurso, imagem: reader.result };
                  cursos.push(novoCurso);
                  localStorage.setItem('cursos', JSON.stringify(cursos));
                }
              };
              reader.readAsDataURL(file);
            }
          });

          document.getElementById('btn-salvar-edicao').addEventListener('click', () => {
            salvarEdicao(curso, imagem);
          });

          document.getElementById('btn-cancelar-edicao').addEventListener('click', () => {
            cancelarEdicao();
          });
          submenu.remove();
        });

        const excluir = document.createElement('button');
        excluir.textContent = 'Excluir';
        excluir.addEventListener('click', () => {
          curso.style.display = 'none';
          submenu.remove();
        });

        submenu.appendChild(editar);
        submenu.appendChild(excluir);
        imagem.parentNode.appendChild(submenu);

        document.addEventListener('click', (e) => {
          if (e.target !== editarImagem && e.target !== submenu && e.target !== editar && e.target !== excluir) {
            submenu.remove();
          }
        });
      });
    });

    function salvarEdicao(cursoAtual, imagemAtual) {
      const novoNomeCurso = document.getElementById('input-nome-curso').value;
      const novaDescricaoCurso = document.getElementById('input-descricao-curso').value;
      cursoAtual.querySelector('h3').textContent = novoNomeCurso;
      cursoAtual.querySelector('p').textContent = novaDescricaoCurso;
      const modalEditarCurso = document.getElementById('modal-editar-curso');
      modalEditarCurso.style.display = 'none';
      const cursos = JSON.parse(localStorage.getItem('cursos')) || [];
      const index = cursos.findIndex((c) => c.nome === cursoAtual.querySelector('h3').textContent);
      if (index !== -1) {
        cursos[index].nome = novoNomeCurso;
        cursos[index].descricao = novaDescricaoCurso;
        localStorage.setItem('cursos', JSON.stringify(cursos));
      }
      const imagemCurso = document.getElementById('imagem-curso');
      imagemAtual.src = imagemCurso.src;
    }

    function cancelarEdicao() {
      const modalEditarCurso = document.getElementById('modal-editar-curso');
      modalEditarCurso.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {

      function animarNumero(id, final, duracao) {
        const el = document.getElementById(id);
        let start = 0;
        const increment = final / (duracao / 20);
        const timer = setInterval(() => {
          start += increment;
          if (start >= final) {
            el.textContent = final.toLocaleString();
            clearInterval(timer);
          } else {
            el.textContent = Math.floor(start).toLocaleString();
          }
        }, 20);
      }
      animarNumero('num-alunos', 12450, 1500);
      animarNumero('num-cursos', 36, 1500);
      animarNumero('num-horas', 10800, 1500);
      animarNumero('num-certificados', 5000, 1500);

      const slides = document.querySelectorAll('#carrossel-destaques .slide');
      let indiceAtual = 0;

      function mostrarSlide(i) {
        slides.forEach((slide, idx) => {
          slide.classList.toggle('active', idx === i);
          if (idx === i) slide.setAttribute('tabindex', '0');
          else slide.setAttribute('tabindex', '-1');
        });
      }
      mostrarSlide(indiceAtual);

      document.getElementById('prev-slide').addEventListener('click', () => {
        indiceAtual = (indiceAtual - 1 + slides.length) % slides.length;
        mostrarSlide(indiceAtual);
      });
      document.getElementById('next-slide').addEventListener('click', () => {
        indiceAtual = (indiceAtual + 1) % slides.length;
        mostrarSlide(indiceAtual);
      });

      const btnTopo = document.getElementById('btn-voltar-topo');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
          btnTopo.style.display = 'block';
        } else {
          btnTopo.style.display = 'none';
        }
      });
      btnTopo.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      window.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === '1') {
          e.preventDefault();
          document.getElementById('indicadores').focus();
        } else if (e.altKey && e.key === '2') {
          e.preventDefault();
          document.getElementById('carrossel-destaques').focus();
        } else if (e.altKey && e.key === '3') {
          e.preventDefault();
          document.getElementById('depoimentos').focus();
        } else if (e.altKey && e.key === '4') {
          e.preventDefault();
          document.getElementById('parceiros').focus();
        } else if (e.altKey && e.key === '5') {
          e.preventDefault();
          document.getElementById('cta').focus();
        }
      });
    });

    document.addEventListener('DOMContentLoaded', () => {
      const botoesAcessarCurso = document.querySelectorAll('.curso .btn-primary');

      botoesAcessarCurso.forEach((botao) => {
        const nomeCurso = botao.getAttribute('data-nome');
        const cursoElement = botao.closest('.curso');
        const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};

        if (cursosDisponiveis[nomeCurso]) {
          cursoElement.style.display = 'none';
        }

        botao.addEventListener('click', (e) => {
          e.preventDefault();
          const modalCadastro = document.getElementById('modal-cadastro');
          modalCadastro.style.display = 'flex';
          const btnSim = document.getElementById('btn-sim');
          const btnNao = document.getElementById('btn-nao');

          btnSim.addEventListener('click', () => {
            cadastrarCurso(nomeCurso, cursoElement);
            modalCadastro.style.display = 'none';
            verificarCursos();
            window.location.href = 'meus-cursos.html';
          });

          btnNao.addEventListener('click', () => {
            modalCadastro.style.display = 'none';
          });
        });
      });

      const cursos = document.querySelectorAll('.curso');
      const cursosCadastrados = JSON.parse(localStorage.getItem('cursosCadastrados')) || [];
      const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};

      cursos.forEach((curso) => {
        const nomeCurso = curso.querySelector('h3').textContent;
        if (cursosDisponiveis[nomeCurso]) {
          curso.style.display = 'none';
        }
      });

      verificarCursos();
    });

    function verificarCursos() {
      const cursos = document.querySelectorAll('.curso');
      const cursosCadastrados = JSON.parse(localStorage.getItem('cursosCadastrados')) || [];
      const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};

      let todosCadastrados = true;

      cursos.forEach((curso) => {
        const nomeCurso = curso.querySelector('h3').textContent;
        if (!cursosDisponiveis[nomeCurso]) {
          todosCadastrados = false;
        }
      });

      if (todosCadastrados) {
        const cursosContainer = document.querySelector('.cursos');
        cursosContainer.innerHTML = '<p style="text-align: center; font-size: 18px;">Não há cursos disponíveis no momento. Aguarde novos cursos em breve!</p>';
      }
    }

    function cadastrarCurso(nomeCurso, cursoElement) {
      const cursosCadastrados = JSON.parse(localStorage.getItem('cursosCadastrados')) || [];
      const cursoExistente = cursosCadastrados.some(curso => curso.nome === nomeCurso);

      if (!cursoExistente) {
        const curso = { nome: nomeCurso };
        cursosCadastrados.push(curso);
        localStorage.setItem('cursosCadastrados', JSON.stringify(cursosCadastrados));

        const cursosDisponiveis = JSON.parse(localStorage.getItem('cursosDisponiveis')) || {};
        cursosDisponiveis[nomeCurso] = true;
        localStorage.setItem('cursosDisponiveis', JSON.stringify(cursosDisponiveis));

        cursoElement.style.display = 'none';
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const iconeTrocarConta = document.querySelector('.fa-right-from-bracket');
      const modalTrocarConta = document.getElementById('modal-trocar-conta');
      const btnSimTrocarConta = document.getElementById('btn-sim-trocar-conta');
      const btnNaoTrocarConta = document.getElementById('btn-nao-trocar-conta');

      iconeTrocarConta.addEventListener('click', (e) => {
        e.preventDefault();
        modalTrocarConta.style.display = 'flex';
      });

      btnNaoTrocarConta.addEventListener('click', () => {
        modalTrocarConta.style.display = 'none';
      });

      btnSimTrocarConta.addEventListener('click', () => {
        window.location.href = '../login.html';
      });
    });

  </script>

</body>

</html>