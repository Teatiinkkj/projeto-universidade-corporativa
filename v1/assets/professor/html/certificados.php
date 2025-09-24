<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus cursos | U.C</title>
    <link rel="stylesheet" href="../css/website.css">
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/meus-cursos.css">
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
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
                                                    <img id="foto-perfil" src="../images/default-avatar.png"
                                                        alt="Foto de Perfil" class="foto-perfil"
                                                        style="width: 60px; height: 60px; border-radius: 50%; display: block;">
                                                    <i class="fa fa-pencil"
                                                        style="position: absolute; bottom: 0; right: 0; background: white; border-radius: 50%; padding: 4px; font-size: 14px; color: #333;"></i>
                                                </div>
                                                <input type="file" id="input-foto-perfil" accept="image/*"
                                                    style="display: none;">
                                            </div>
                                            <div style="margin-top: 10px;" class="col-md-8">
                                                <div style="display: flex; flex-direction: column;">
                                                    <p id="nome-usuario" style="margin: 0; font-weight: bold;">Nome</p>
                                                    <p id="email-usuario" style="margin: 0; font-size: 14px;">
                                                        email@email.com</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin-top: 20px;">
                                    <link rel="stylesheet"
                                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

                                    <a href="../login.html"><i class="fa-solid fa-right-from-bracket"></i> Trocar
                                        Conta</a>
                                    <a href="inicio.html"><i class="fa-solid fa-house"></i> Início</a>
                                    <a href="../sobre.html"><i class="fa-solid fa-circle-info"></i> Sobre</a>
                                    <a href="#" id="meus-cursos"><i class="fa-solid fa-book"></i> Meus Cursos</a>
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

    <a href="inicio.html" class="back-button">
        <i class="fa fa-arrow-left"></i> Início
    </a>

    <br>

    <section class="container section-inc-2">
        <div class="texto-curso">
            <h3 class="h3-inicio" style="font-size: 50px;">Meus Certificados</h3>
        </div>
    </section>

    <br>

    <section class="container section-inc-video">
        <div class="row">
            <div class="video-inicio col-md-12">
                <h2 class="h2-curso" style="margin-top: 20px;">Certificados obtidos:</h2>
                <div id="certificados-lista" class="row" style="margin-top: 40px; display: flex; flex-wrap: wrap;">
                    <div class="col-md-4" style="margin-bottom: 20px;">
                        <div class="curso">
                            <h3>Gestão Escolar Eficiente</h3>
                            <p>Concluído em: 10/02/2025</p>
                            <button class="btn btn-primary">Visualizar</button>
                            <button class="btn btn-success">Baixar</button>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-bottom: 20px;">
                        <div class="curso">
                            <h3>Metodologias Ativas em Sala de Aula</h3>
                            <p>Concluído em: 15/03/2025</p>
                            <button class="btn btn-primary">Visualizar</button>
                            <button class="btn btn-success">Baixar</button>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-bottom: 20px;">
                        <div class="curso">
                            <h3>Comunicação e Relacionamento com Famílias</h3>
                            <p>Concluído em: 20/04/2025</p>
                            <button class="btn btn-primary">Visualizar</button>
                            <button class="btn btn-success">Baixar</button>
                        </div>
                    </div>
                </div>
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

    <footer>
        <div class="footer-text">
            <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dadosUsuario = JSON.parse(localStorage.getItem("usuarioLogado"));
            const usuarioId = dadosUsuario?.usuario;

            if (dadosUsuario) {
                document.getElementById('nome-usuario').textContent = dadosUsuario.nome || dadosUsuario.usuario;
                document.getElementById('email-usuario').textContent = dadosUsuario.email;

                const fotoPerfil = document.getElementById("foto-perfil");
                if (dadosUsuario.foto) {
                    fotoPerfil.src = dadosUsuario.foto;
                }
            }

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
                const notificacoesLista = notificacaoBarra?.querySelector('ul');
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

                notificacoesAlteracao.slice().reverse().forEach((notificacao) => {
                    const li = document.createElement('li');
                    li.classList.add('notificacao-item');
                    li.style.opacity = notificacao.lido ? '0.6' : '1';

                    li.innerHTML = `
                    <div class="texto-notificacao">${notificacao.mensagem}</div>
                    <div class="senha-notificacao"><strong>Nova senha:</strong> ${notificacao.senhaNova}</div>
                    <small><em>${formatarData(notificacao.data)}</em></small>
                    <button class="marcar-lido" data-id="${notificacao.id}">Marcar como ${notificacao.lido ? 'não lido' : 'lido'}</button>
                    <button class="excluir-notificacao" data-id="${notificacao.id}">Excluir</button>
                `;

                    li.querySelector('.marcar-lido').addEventListener('click', () => {
                        marcarComoLido(notificacao.id);
                        carregarNotificacoes();
                    });

                    li.querySelector('.excluir-notificacao').addEventListener('click', () => {
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

            if (fotoPerfilContainer) {
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
                            dadosUsuario.foto = reader.result;
                            localStorage.setItem("usuarioLogado", JSON.stringify(dadosUsuario));
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            const inputSearch = document.getElementById('input-search');
            const buttonSearch = document.querySelector('.input-group-btn button');

            if (buttonSearch && inputSearch) {
                buttonSearch.addEventListener('click', () => {
                    const searchText = inputSearch.value.trim().toLowerCase();
                    const cursos = [
                        { nome: 'Gestão Escolar Eficiente', url: 'videoaula.html' },
                        { nome: 'Metodologias Ativas em Sala de Aula', url: 'videoaula.html' },
                        { nome: 'Comunicação e Relacionamento com Famílias', url: 'videoaula.html' },
                    ];

                    const cursoEncontrado = cursos.find(curso =>
                        curso.nome.toLowerCase().includes(searchText)
                    );

                    if (cursoEncontrado) {
                        window.location.href = cursoEncontrado.url;
                    } else {
                        alert('Curso não encontrado!');
                    }
                });
            }
        });

        const certificados = document.querySelectorAll('.curso');

        certificados.forEach((certificado, index) => {
            certificado.style.opacity = 0;
            certificado.style.transform = 'translateY(50px)';
            certificado.style.transition = 'all 0.5s ease-in-out';

            setTimeout(() => {
                certificado.style.opacity = 1;
                certificado.style.transform = 'translateY(0)';
            }, index * 200);
        });
    </script>

</body>

</html>