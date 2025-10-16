<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Usuário não logado, redireciona para login
    header("Location: ../../html/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel ADM - Gerenciar Usuários</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/admin.css" />
  <link rel="stylesheet" href="../../css/back-button.css" />
</head>

<body>
  <a href="inicio.php" class="back-button">
    <i class="fa fa-arrow-left"></i> Início
  </a>

  <h1>
    <i class="fas fa-users" style="margin-right: 8px"></i> Painel ADM - Gerenciar Usuários
  </h1>

  <div class="top-controls">
    <input type="search" id="filtroUsuarios" placeholder="Filtrar usuários pelo nome ou email..." />
    <button id="btnNovoUsuario">Cadastrar Novo Usuário</button>
  </div>

  <table id="tabelaUsuarios">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Cargo</th>
        <th>Sexo</th>
        <th>CPF</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <!-- FORM EDITAR -->
  <div class="form-edicao" id="formEdicao" style="display: none">
    <h2>Editar Usuário</h2>
    <label for="editNome">Nome:</label>
    <input type="text" id="editNome" />

    <label for="editEmail">Email:</label>
    <input type="email" id="editEmail" />

    <label for="editCargo">Cargo:</label>
    <select id="editCargo">
      <option value="" disabled selected>Selecione o cargo</option>
      <option value="aluno">Aluno</option>
      <option value="professor">Professor</option>
      <option value="coordenador">Coordenador</option>
    </select>

    <label for="editSexo">Sexo:</label>
    <select id="editSexo">
      <option value="" disabled selected>Selecione o sexo</option>
      <option value="masculino">Masculino</option>
      <option value="feminino">Feminino</option>
    </select>

    <label for="editCpf">CPF:</label>
    <input type="text" id="editCpf" maxlength="14" />

    <label for="editSenha">Senha:</label>
    <div style="position: relative; display: inline-block; width: 100%">
      <input type="password" id="editSenha" style="padding-right: 30px; width: 100%" />
      <button type="button" id="toggleSenha"
        style="position: absolute; right: 5px; top: 55%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; color: #333;"
        title="Mostrar/Esconder senha">
        <i class="fas fa-eye"></i>
      </button>
    </div>

    <button class="salvar" id="btnSalvar">Salvar</button>
    <button class="cancelar" id="btnCancelar">Cancelar</button>
  </div>

  <!-- MODAIS -->
  <div id="modalSucesso" class="modal">
    <div class="modal-conteudo">
      <p>Usuário atualizado com sucesso!</p>
      <div class="modal-botoes">
        <button id="fecharModalSucesso" class="confirmar">OK</button>
      </div>
    </div>
  </div>

  <div id="modalCadastro" class="modal">
    <div class="modal-conteudo">
      <h2><i class="fas fa-user-plus" style="margin-right:8px;"></i>Cadastrar Novo Usuário</h2>
      <form id="formCadastro" autocomplete="off">
        <div class="campo-form">
          <input type="text" id="cadNome" placeholder=" " required />
          <label for="cadNome">Nome</label>
        </div>

        <div class="campo-form">
          <select id="cadCargo" required>
            <option value="" disabled selected></option>
            <option value="aluno">Aluno</option>
            <option value="professor">Professor</option>
            <option value="coordenador">Coordenador</option>
          </select>
          <label for="cadCargo">Cargo</label>
        </div>

        <div class="campo-form">
          <select id="cadSexo" required>
            <option value="" disabled selected></option>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
          </select>
          <label for="cadSexo">Sexo</label>
        </div>

        <div class="campo-form">
          <input type="text" id="cadCpf" maxlength="14" placeholder=" " required />
          <label for="cadCpf">CPF</label>
        </div>

        <div class="campo-form">
          <input type="email" id="cadEmail" placeholder=" " required />
          <label for="cadEmail">Email</label>
        </div>

        <div class="campo-form senha">
          <div class="input-senha">
            <input type="password" id="cadSenha" placeholder=" " required />
            <label for="cadSenha">Senha</label>
            <button type="button" id="toggleSenhaCadastro" title="Mostrar/Esconder senha">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="modal-botoes">
          <button type="button" id="btnConfirmarCadastro" class="confirmar">Cadastrar</button>
          <button type="button" id="btnCancelarCadastro" class="cancelar">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <div id="modalErro" class="modal">
    <div class="modal-conteudo">
      <p id="mensagemErro">Erro ao atualizar o usuário.</p>
      <div class="modal-botoes">
        <button id="fecharModalErro" class="confirmar">OK</button>
      </div>
    </div>
  </div>

  <div id="modalConfirmacao" class="modal" style="display: none">
    <div class="modal-conteudo">
      <p id="mensagemConfirmacao">Tem certeza que deseja excluir este usuário?</p>
      <div class="modal-botoes">
        <button id="btnConfirmarExclusao" class="confirmar">Sim</button>
        <button id="btnCancelarExclusao" class="cancelar">Não</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const tabelaBody = document.querySelector("#tabelaUsuarios tbody");
      const filtroInput = document.getElementById("filtroUsuarios");

      function abrirModal(id) { document.getElementById(id).style.display = "flex"; }
      function fecharModal(id) { document.getElementById(id).style.display = "none"; }

      window.addEventListener("click", (event) => {
        ["modalSucesso", "modalErro", "modalCadastro"].forEach(id => {
          const modal = document.getElementById(id);
          if (event.target === modal) fecharModal(id);
        });
      });

      async function carregarUsuarios(filtro = "") {
        try {
          const response = await fetch("../../api/admin/usuarios.php");
          const result = await response.json();
          if (!result.success) return abrirModalErro("Erro ao carregar usuários do banco de dados.");

          const usuarios = result.data.filter(u => (u.nome + u.email).toLowerCase().includes(filtro.toLowerCase()));
          renderizarTabela(usuarios);
        } catch (error) {
          abrirModalErro("Erro ao buscar dados do servidor: " + error.message);
        }
      }

      function renderizarTabela(usuarios) {
        tabelaBody.innerHTML = "";
        if (usuarios.length === 0) {
          tabelaBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">Nenhum usuário encontrado.</td></tr>';
          return;
        }

        usuarios.forEach(u => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
        <td>${u.nome}</td>
        <td>${u.cargo || ""}</td>
        <td>${(u.sexo || "").toUpperCase()}</td>
        <td>${u.cpf || ""}</td>
        <td>${u.email}</td>
        <td>${u.senha ? "*****" : ""}</td>
        <td>
          <button class="salvar" data-id="${u.id}">Editar</button>
          <button class="excluir" data-id="${u.id}">Excluir</button>
        </td>
      `;
          tabelaBody.appendChild(tr);
        });

        document.querySelectorAll(".salvar").forEach(btn => btn.addEventListener("click", e => editarUsuario(e.target.dataset.id)));
        document.querySelectorAll(".excluir").forEach(btn => btn.addEventListener("click", e => confirmarExclusao(e.target.dataset.id)));
      }

      async function editarUsuario(id) {
        try {
          const response = await fetch(`../../api/admin/usuario.php?id=${id}`);
          const result = await response.json();
          if (!response.ok || !result.success) throw new Error(result.message || "Erro ao buscar usuário.");

          const u = result.data;
          document.getElementById("editNome").value = u.nome;
          document.getElementById("editEmail").value = u.email;
          document.getElementById("editCargo").value = u.cargo;
          document.getElementById("editSexo").value = u.sexo;
          document.getElementById("editCpf").value = u.cpf;
          document.getElementById("editSenha").value = "";

          document.getElementById("formEdicao").style.display = "block";
          document.getElementById("btnSalvar").dataset.id = id;
        } catch (error) {
          abrirModalErro("Erro ao carregar usuário para edição: " + error.message);
        }
      }

      document.getElementById("btnSalvar").addEventListener("click", async () => {
        const id = document.getElementById("btnSalvar").dataset.id;
        const nome = document.getElementById("editNome").value.trim();
        const email = document.getElementById("editEmail").value.trim();
        const cargo = document.getElementById("editCargo").value.trim();
        const sexo = document.getElementById("editSexo").value.trim();
        const cpf = document.getElementById("editCpf").value.trim();
        const senha = document.getElementById("editSenha").value.trim();

        if (!nome || !email || !cargo || !sexo || !cpf) return abrirModalErro("Preencha todos os campos obrigatórios.");

        try {
          const response = await fetch("../../api/admin/editar_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id, nome, email, cargo, sexo, cpf, senha })
          });
          const result = await response.json();
          if (!response.ok || !result.success) throw new Error(result.message || "Erro ao editar usuário.");

          document.getElementById("formEdicao").style.display = "none";
          abrirModalSucesso("Usuário atualizado com sucesso!");
          carregarUsuarios();
        } catch (error) {
          abrirModalErro("Erro ao salvar alterações: " + error.message);
        }
      });

      document.getElementById("btnCancelar").addEventListener("click", () => {
        document.getElementById("formEdicao").style.display = "none";
      });

      filtroInput.addEventListener("input", () => carregarUsuarios(filtroInput.value));

      function abrirModalSucesso(msg) { document.querySelector("#modalSucesso p").textContent = msg; abrirModal("modalSucesso"); }
      function abrirModalErro(msg) { document.querySelector("#mensagemErro").textContent = msg; abrirModal("modalErro"); }
      document.getElementById("fecharModalSucesso").addEventListener("click", () => fecharModal("modalSucesso"));
      document.getElementById("fecharModalErro").addEventListener("click", () => fecharModal("modalErro"));

      document.getElementById("btnNovoUsuario").addEventListener("click", () => abrirModal("modalCadastro"));
      document.getElementById("btnCancelarCadastro").addEventListener("click", () => fecharModal("modalCadastro"));

      document.getElementById("btnConfirmarCadastro").addEventListener("click", async () => {
        const nome = document.getElementById("cadNome").value.trim();
        const cargo = document.getElementById("cadCargo").value.trim();
        const sexo = document.getElementById("cadSexo").value.trim();
        const cpf = document.getElementById("cadCpf").value.trim();
        const email = document.getElementById("cadEmail").value.trim();
        const senha = document.getElementById("cadSenha").value.trim();

        if (!nome || !cargo || !sexo || !cpf || !email || !senha) return abrirModalErro("Preencha todos os campos.");

        try {
          const response = await fetch("../../api/admin/cadastrar_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nome, email, senha, cargo, sexo, cpf })
          });

          const result = await response.json();
          if (!response.ok || !result.success) throw new Error(result?.message || "Erro ao cadastrar usuário.");

          fecharModal("modalCadastro");
          abrirModalSucesso("Usuário cadastrado com sucesso!");
          carregarUsuarios();
        } catch (error) {
          abrirModalErro("Erro ao cadastrar usuário: " + error.message);
        }
      });

      document.getElementById("toggleSenha").addEventListener("click", () => {
        const senhaInput = document.getElementById("editSenha");
        senhaInput.type = senhaInput.type === "password" ? "text" : "password";
      });

      document.getElementById("toggleSenhaCadastro").addEventListener("click", () => {
        const senhaInput = document.getElementById("cadSenha");
        senhaInput.type = senhaInput.type === "password" ? "text" : "password";
      });

      function confirmarExclusao(id) {
        abrirModal("modalConfirmacao");
        const btnConfirmar = document.getElementById("btnConfirmarExclusao");
        const btnCancelar = document.getElementById("btnCancelarExclusao");

        const btnConfirmarClone = btnConfirmar.cloneNode(true);
        const btnCancelarClone = btnCancelar.cloneNode(true);
        btnConfirmar.parentNode.replaceChild(btnConfirmarClone, btnConfirmar);
        btnCancelar.parentNode.replaceChild(btnCancelarClone, btnCancelar);

        btnConfirmarClone.addEventListener("click", () => { excluirUsuario(id); fecharModal("modalConfirmacao"); });
        btnCancelarClone.addEventListener("click", () => fecharModal("modalConfirmacao"));
      }

      async function excluirUsuario(id) {
        try {
          const response = await fetch("../../api/admin/excluir_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
          });
          const result = await response.json();
          if (!response.ok || !result.success) throw new Error(result.message || "Erro ao excluir usuário.");

          abrirModalSucesso("Usuário excluído com sucesso!");
          carregarUsuarios();
        } catch (error) {
          abrirModalErro("Erro ao excluir usuário: " + error.message);
        }
      }

      carregarUsuarios();
    });
  </script>

</body>

</html>