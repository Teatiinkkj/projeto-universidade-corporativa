<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-BOOK</title>
    <link rel="stylesheet" href="../css/website.css">
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>

    <header class="header-inicio">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
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
                                  <div style="margin-top: 10px;" class="col-md-8">
                                    <div style="display: flex; flex-direction: column;">
                                      <p id="nome-usuario" style="margin: 0; font-weight: bold;">Nome</p>
                                      <p id="email-usuario" style="margin: 0; font-size: 14px;">email@email.com</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <hr style="margin-top: 20px;">
                              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
            
                              <a href="../entrar.html"><i class="fa-solid fa-right-from-bracket"></i> Trocar Conta</a>
                              <a href="inicio.html"><i class="fa-solid fa-house"></i> Início</a>
                              <a href="sobre.html"><i class="fa-solid fa-circle-info"></i> Sobre</a>
                            </div>
                          </li>
                        </ul>
                      </nav>
                </div>
                <div class="col-md-6 text-center">
                    <h2 style="color: white;font-size: 60px;">E-BOOK</h1>
                </div>
            </div>
        </div>
    </header>
    <a onclick="history.back()" class="back-button">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>
    <section class="video">
        <div id="video" class="container">
            <br><br>
            <div class="row justify-content-center">
                <div class="player d-flex flex-column align-items-start" style="width: fit-content;">
                    <h1 style="color: rgb(6, 93, 199);" class="h1-videoaula">Titulo do Curso</h1>
                    <h2>PDF - 1</h2>
                    <a href="../pdf/gestao_escolar_eficiente.pdf" target="_blank" class="btn-pdf">
                        Clique aqui para abrir o PDF
                    </a>
                </div>
                <div class="button-video" style="margin-top: 100px;">
                    <div class="background-btn-aulas">
                        <div class="row">
                            <div class="ebook-list-container col-md-2">
                                <button id="toggleEbookList" class="btn btn-primary mb-2 button-ebook">
                                    E-book
                                </button>
                            </div>
                            <div class="col-md-7">
                                <p>Clique aqui para ter acesso aos outros PDF curso.</p>
                            </div>
                            <div class="col-md-3">
                                <i class="fa fa-arrow-left">E-BOOK</i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button id="toggleVideoList" class="btn btn-primary mb-2 button-aulas">
                                    Aulas - Curso 1
                                </button>
                            </div>
                            <div class="col-md-7">
                                <p>Clique aqui para acessar as Vídeoaulas deste curso.</p>
                            </div>
                            <div class="col-md-3">
                                <i class="fa fa-arrow-left">AULAS</i>
                            </div>
                        </div>
                    </div>

                    <div id="videoModal" class="video-modal">
                        <div class="video-modal-content">
                            <span class="close-modal" id="closeVideoModal">&times;</span>
                            <h3 style="margin-bottom: 20px;">Aulas Disponíveis</h3>
                            <ul id="videoList" style="list-style: none; padding-left: 0;">
                                <li class="video-item d-flex align-items-start gap-3 mb-4" data-src="video1.mp4"
                                    style="cursor: pointer;">
                                    <img src="../images/imgsemfundo.png" alt="Thumb Aula 1"
                                        style="width: 150px; border-radius: 10px;">
                                    <div class="descricao-aulas">
                                        <strong>Aula 1 - Introdução</strong><br>
                                        <span class="status" style="color: gray;">Não assistido</span><br>
                                        <small class="text-muted">Nesta aula você terá uma visão geral do curso e
                                            conhecerá os objetivos principais.</small><br>
                                            <button class="btn btn-sm btn-outline-primary acessar-aula-btn mt-2"
                                            style="color: white; border-color: white;"><a style="text-decoration: none; color: white;" href="videoaula.html">Acessar Aula</a></button>
                                    </div>
                                </li>

                                <li class="video-item d-flex align-items-start gap-3 mb-4" data-src="video2.mp4"
                                    style="cursor: pointer;">
                                    <img src="../images/imgsemfundo.png" alt="Thumb Aula 2"
                                        style="width: 150px; border-radius: 10px;">
                                    <div class="descricao-aulas">
                                        <strong>Aula 2 - Conceitos Básicos</strong><br>
                                        <span class="status" style="color: gray;">Não assistido</span><br>
                                        <small class="text-muted">Aprenda os fundamentos teóricos essenciais para
                                            entender o tema.</small><br>
                                            <button class="btn btn-sm btn-outline-primary acessar-aula-btn mt-2"
                                            style="color: white; border-color: white;"><a style="text-decoration: none; color: white;" href="videoaula.html">Acessar Aula</a></button>
                                    </div>
                                </li>

                                <li class="video-item d-flex align-items-start gap-3 mb-4" data-src="video3.mp4"
                                    style="cursor: pointer;">
                                    <img src="../images/imgsemfundo.png" alt="Thumb Aula 3"
                                        style="width: 150px; border-radius: 10px;">
                                    <div class="descricao-aulas">
                                        <strong>Aula 3 - Exercícios Práticos</strong><br>
                                        <span class="status" style="color: gray;">Não assistido</span><br>
                                        <small class="text-muted">Hora de colocar em prática! Realize exercícios
                                            baseados no conteúdo anterior.</small><br>
                                            <button class="btn btn-sm btn-outline-primary acessar-aula-btn mt-2"
                                            style="color: white; border-color: white;"><a style="text-decoration: none; color: white;" href="videoaula.html">Acessar Aula</a></button>
                                    </div>
                                </li>
                            </ul>
                            <div id="contador-aulas" style="margin-top: 10px; font-weight: bold; color: #333;">
                                Aulas Assistidas: 0 / 3
                            </div>
                            <button id="btn-certificado" class="btn btn-success" disabled
                                style="margin-top: 10px; width: 100%; font-weight: bold;">
                                Certificado
                            </button>
                        </div>
                    </div>
                    <div id="ebookModal" class="video-modal">
                        <div class="video-modal-content">
                            <span class="close-modal" id="closeEbookModal">&times;</span>
                            <h3 style="margin-bottom: 20px;">E-books do Curso</h3>

                            <ul style="list-style: none; padding-left: 0;">
                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <div class="descricao-ebook">
                                        <strong>PDF 1 - Gestão Escolar Eficiente</strong><br>
                                        <small class="text-muted">Técnicas e estratégias para tornar a gestão escolar
                                            mais eficaz e colaborativa.</small><br>
                                        <a href="../pdf/gestao_escolar_eficiente.pdf" target="_blank"
                                            class="btn btn-sm btn-primary mt-2" style="color: white;">
                                            Abrir PDF
                                        </a>
                                    </div>
                                </li>

                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <div class="descricao-ebook">
                                        <strong>PDF 2 - Gestão Escolar Eficiente</strong><br>
                                        <small class="text-muted">Técnicas e estratégias para tornar a gestão escolar
                                            mais eficaz e colaborativa.</small><br>
                                        <a href="../pdf/gestao_escolar_eficiente.pdf" target="_blank"
                                            class="btn btn-sm btn-primary mt-2" style="color: white;">
                                            Abrir PDF
                                        </a>
                                    </div>
                                </li>

                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <div class="descricao-ebook">
                                        <strong>PDF 3 - Gestão Escolar Eficiente</strong><br>
                                        <small class="text-muted">Técnicas e estratégias para tornar a gestão escolar
                                            mais eficaz e colaborativa.</small><br>
                                        <a href="../pdf/gestao_escolar_eficiente.pdf" target="_blank"
                                            class="btn btn-sm btn-primary mt-2" style="color: white;">
                                            Abrir PDF
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-text" style="position: relative;">
            <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
        </div>
    </footer>

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
        });
        const btnConfirmar = document.getElementById('confirmarAssistido');
        if (btnConfirmar) {
            btnConfirmar.addEventListener('click', () => {
                if (btnConfirmar.classList.contains('btn-success')) {
                    btnConfirmar.classList.remove('btn-success');
                    btnConfirmar.classList.add('btn-secondary');
                    btnConfirmar.textContent = 'Nao completo';
                } else {
                    btnConfirmar.classList.remove('btn-secondary');
                    btnConfirmar.classList.add('btn-success');
                    btnConfirmar.textContent = 'Aula Completa!';
                }
            });
        }

        const toggleVideoList = document.getElementById('toggleVideoList');
        const videoModal = document.getElementById('videoModal');
        const closeVideoModal = document.getElementById('closeVideoModal');

        toggleVideoList.addEventListener('click', () => {
            videoModal.style.display = 'block';
        });

        closeVideoModal.addEventListener('click', () => {
            videoModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === videoModal) {
                videoModal.style.display = 'none';
            }
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
        const toggleEbookList = document.getElementById('toggleEbookList');
        const ebookModal = document.getElementById('ebookModal');
        const closeEbookModal = document.getElementById('closeEbookModal');

        toggleEbookList.addEventListener('click', () => {
            ebookModal.style.display = 'block';
        });

        closeEbookModal.addEventListener('click', () => {
            ebookModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === ebookModal) {
                ebookModal.style.display = 'none';
            }
        });
        document.querySelectorAll('.acessar-aula-btn').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const item = btn.closest('.video-item');
                item.click();
                document.getElementById('videoModal').style.display = 'none';
            });
        });
    </script>
    <div id="modal-confirmacao" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); 
    justify-content:center; align-items:center; z-index:9999;">
        <div style="background:white; padding:20px; border-radius:8px; max-width:300px; text-align:center;">
            <p>Deseja realmente alterar a foto de perfil?</p>
            <button id="btn-confirmar" class="btn btn-primary" style="margin-right:10px; width: 100px;">Sim</button>
            <button id="btn-cancelar" class="btn btn-secondary" style="width: 100px;">Cancelar</button>
        </div>
    </div>
</body>

</html>