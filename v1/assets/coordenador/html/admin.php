<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel ADM - Gerenciar Usuários</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/back-button.css">
</head>

<body>

    <a href="inicio.html" class="back-button">
        <i class="fa fa-arrow-left"></i> Início
    </a>

    <h1><i class="fas fa-users" style="margin-right: 8px;"></i> Painel ADM - Gerenciar Usuários</h1>

    <div class="top-controls">
        <input type="search" id="filtroUsuarios" placeholder="Filtrar usuários pelo nome ou email..."
            oninput="filtrarUsuarios()" />

        <button id="btnNovoUsuario">
            <i class="fas fa-user-plus"></i> Cadastrar Novo Usuário
        </button>
    </div>

    <table id="tabelaUsuarios">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Cargo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="form-edicao" id="formEdicao" style="display:none;">
        <h2>Editar Usuário</h2>
        <label for="editNome">Nome:</label>
        <input type="text" id="editNome" />

        <label for="editEmail">Email:</label>
        <input type="email" id="editEmail" />

        <label for="editSenha">Senha:</label>
        <div style="position: relative; display: inline-block; width: 100%;">
            <input type="password" id="editSenha" style="padding-right: 30px; width: 100%;" />
            <button type="button" id="toggleSenha" style="position: absolute; right: 5px; top: 55%; 
            transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; color: #333;" 
            title="Mostrar/Esconder senha">
            <i class="fas fa-eye"></i>
        </button>
        </div>

        <button class="salvar" id="btnSalvar">Salvar</button>
        <button class="cancelar" id="btnCancelar">Cancelar</button>
    </div>

    <div id="modalConfirmacao" class="modal">
        <div class="modal-conteudo">
            <p>Tem certeza de que deseja cadastrar um novo usuário?</p>
            <div class="modal-botoes">
                <button id="confirmarCadastro" class="confirmar">Sim</button>
                <button id="cancelarCadastro" class="cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <div id="modalSucesso" class="modal">
        <div class="modal-conteudo">
            <p>Usuário atualizado com sucesso!</p>
            <div class="modal-botoes">
                <button id="fecharModalSucesso" class="confirmar">OK</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let usuarios = [];
            let indiceEditando = null;
            let filtroAtual = '';

            const tabelaBody = document.querySelector('#tabelaUsuarios tbody');
            const formEdicao = document.getElementById('formEdicao');
            const inputNome = document.getElementById('editNome');
            const inputEmail = document.getElementById('editEmail');
            const inputSenha = document.getElementById('editSenha');
            const btnSalvar = document.getElementById('btnSalvar');
            const btnCancelar = document.getElementById('btnCancelar');
            const filtroInput = document.getElementById('filtroUsuarios');

            function carregarUsuarios() {
                const dados = localStorage.getItem('usuarios');
                usuarios = dados ? JSON.parse(dados) : [];
            }

            function salvarUsuarios() {
                localStorage.setItem('usuarios', JSON.stringify(usuarios));
            }

            function renderizarTabela() {
                tabelaBody.innerHTML = '';

                const usuariosFiltrados = usuarios.filter(u => {
                    const texto = (u.nome + u.email).toLowerCase();
                    return texto.includes(filtroAtual.toLowerCase());
                });

                if (usuariosFiltrados.length === 0) {
                    tabelaBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Nenhum usuário cadastrado.</td></tr>';
                    return;
                }

                usuariosFiltrados.forEach((usuario, index) => {
                    const indiceReal = usuarios.indexOf(usuario);

                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${usuario.nome}</td>
                    <td>${usuario.email}</td>
                    <td>*****</td>
                    <td>${usuario.cargo || ''}</td>
                    <td>
                    <button class="salvar" onclick="editarUsuario(${indiceReal})">Editar</button>
                    <button class="excluir" onclick="excluirUsuario(${indiceReal})">Excluir</button>
                    </td>
                    `;
                    tabelaBody.appendChild(tr);
                });
            }

            function filtrarUsuarios() {
                filtroAtual = filtroInput.value;
                renderizarTabela();
            }

            function excluirUsuario(index) {
                if (confirm(`Deseja realmente excluir o usuário "${usuarios[index].nome}"?`)) {
                    usuarios.splice(index, 1);
                    salvarUsuarios();
                    renderizarTabela();
                    esconderFormulario();
                }
            }

            function editarUsuario(index) {
                indiceEditando = index;
                const usuario = usuarios[index];
                inputNome.value = usuario.nome;
                inputEmail.value = usuario.email;
                inputSenha.value = usuario.senha;
                formEdicao.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function esconderFormulario() {
                formEdicao.style.display = 'none';
                indiceEditando = null;
                inputNome.value = '';
                inputEmail.value = '';
                inputSenha.value = '';
            }

            btnSalvar.addEventListener('click', () => {
                const nome = inputNome.value.trim();
                const email = inputEmail.value.trim();
                const senha = inputSenha.value.trim();
                const senhaAntiga = usuarios[indiceEditando].senha;

                if (!nome || !email || !senha) {
                    alert('Por favor, preencha todos os campos.');
                    return;
                }

                const emailExiste = usuarios.some((u, i) => u.email.toLowerCase() === email.toLowerCase() && i !== indiceEditando);
                if (emailExiste) {
                    alert('Já existe outro usuário com esse email.');
                    return;
                }

                usuarios[indiceEditando] = {
                    ...usuarios[indiceEditando],
                    nome,
                    email,
                    senha
                };

                salvarUsuarios();

                if (senha !== senhaAntiga) {
                    const notificacoes = JSON.parse(localStorage.getItem('notificacoes')) || [];

                    notificacoes.push({
                        id: Date.now(),
                        mensagem: `Senha do usuário "${nome}" foi alterada pelo admin.`,
                        tipo: 'alteracaoSenha',
                        senhaNova: senha,
                        lido: false,
                        data: new Date().toISOString()
                    });

                    localStorage.setItem('notificacoes', JSON.stringify(notificacoes));

                    const emailDestinatario = usuarios[indiceEditando].email;
                    const assunto = 'Senha alterada';
                    const mensagem = `Olá ${nome},\n\nSua senha foi alterada pelo administrador.\n\nNova senha: ${senha}\n\nAtenciosamente,`;

                    enviarEmail(emailDestinatario, assunto, mensagem);
                }

                function enviarEmail(destinatario, assunto, mensagem) {
                    const smtp = {
                        host: 'smtp.gmail.com',
                        port: 587,
                        secure: false,
                        auth: {
                            user: 'seu_email@gmail.com',
                            pass: 'sua_senha'
                        }
                    };

                    const transporter = nodemailer.createTransport(smtp);

                    const mailOptions = {
                        from: 'seu_email@gmail.com',
                        to: destinatario,
                        subject: assunto,
                        text: mensagem
                    };

                    transporter.sendMail(mailOptions, (error, info) => {
                        if (error) {
                            console.log(error);
                        } else {
                            console.log('Email enviado com sucesso!');
                        }
                    });
                }

                const usuarioAtual = JSON.parse(localStorage.getItem('usuarioLogado'));
                if (usuarioAtual && usuarioAtual.email === email) {
                    localStorage.setItem('usuarioLogado', JSON.stringify({ nome, email, senha }));
                }

                renderizarTabela();
                esconderFormulario();

                document.getElementById('modalSucesso').style.display = 'flex';

                document.getElementById('fecharModalSucesso').addEventListener('click', () => {
                    document.getElementById('modalSucesso').style.display = 'none';
                });
            });

            btnCancelar.addEventListener('click', () => {
                esconderFormulario();
            });

            function init() {
                carregarUsuarios();
                renderizarTabela();
                esconderFormulario();
            }

            window.editarUsuario = editarUsuario;
            window.excluirUsuario = excluirUsuario;
            window.filtrarUsuarios = filtrarUsuarios;

            init();

            const btnToggleSenha = document.getElementById('toggleSenha');

            btnToggleSenha.addEventListener('click', () => {
                if (inputSenha.type === 'password') {
                    inputSenha.type = 'text';
                    btnToggleSenha.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    inputSenha.type = 'password';
                    btnToggleSenha.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });

            document.getElementById('btnNovoUsuario').addEventListener('click', () => {
                document.getElementById('modalConfirmacao').style.display = 'flex';
            });

            document.getElementById('confirmarCadastro').addEventListener('click', () => {
                window.location.href = 'cadastro.html';
            });

            document.getElementById('cancelarCadastro').addEventListener('click', () => {
                document.getElementById('modalConfirmacao').style.display = 'none';
            });
        });
    </script>

</body>

</html>