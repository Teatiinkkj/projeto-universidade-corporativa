<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro | UNICORP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/cadastro.css" />
  <link rel="stylesheet" href="../css/back-button.css" />
</head>

<body>
  <a onclick="history.back()" class="back-button">
    <i class="fa fa-arrow-left"></i> Voltar
  </a>

  <div class="container">
    <div class="caixa-cadastro">
      <div class="cabecalho-cadastro">
        <i class="fas fa-user-circle"></i>
        <h1>Cadastro</h1>
      </div>
      <form class="formulario-cadastro" id="formCadastro" novalidate>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input class="campo-input" type="text" id="nome" name="nome" placeholder="Nome de usuário" required />
        </div>

        <div class="input-group">
          <i class="fas fa-briefcase"></i>
          <select class="campo-input" id="cargo" name="cargo" required>
            <option value="" disabled selected>Selecione o cargo</option>
            <option value="aluno">Aluno</option>
            <option value="professor">Professor</option>
          </select>
        </div>

        <div class="input-group">
          <i class="fas fa-venus-mars"></i>
          <select class="campo-input" id="sexo" name="sexo" required>
            <option value="" disabled selected>Selecione o sexo</option>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
          </select>
        </div>

        <div class="input-group">
          <i class="fas fa-id-card"></i>
          <input class="campo-input" type="text" id="cpf" name="cpf" placeholder="CPF" required maxlength="14" />
        </div>

        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input class="campo-input" type="email" id="email" name="email" placeholder="Digite seu email" required />
        </div>

        <div class="input-group grupo-senha">
          <i class="fas fa-lock"></i>
          <input class="campo-input" type="password" id="senha" name="senha" placeholder="Digite sua senha" required />
          <span class="icone-senha" onclick="mostrarSenha(this)">
            <i class="fas fa-eye"></i>
          </span>
        </div>

        <button class="botao-cadastrar" type="submit">Criar conta</button>
      </form>
    </div>

    <div class="container-imagem">
      <div class="imagem-wrapper">
        <img class="imagem-fundo-bg" src="../images/feixe-azul.png" alt="Imagem de fundo" />
        <img class="imagem-fundo" src="../images/logo.png" alt="Imagem da frente" />
      </div>
    </div>
  </div>

  <script>
    function mostrarSenha(element) {
      const senha = document.getElementById("senha");
      const icone = element.querySelector("i");
      if (senha.type === "password") {
        senha.type = "text";
        icone.classList.remove("fa-eye");
        icone.classList.add("fa-eye-slash");
      } else {
        senha.type = "password";
        icone.classList.remove("fa-eye-slash");
        icone.classList.add("fa-eye");
      }
    }

    document.getElementById('cpf').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); 
      if (value.length > 11) value = value.slice(0, 11);
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      e.target.value = value;
    });

    function validarEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }

    function validarCPF(cpf) {
      cpf = cpf.replace(/[^\d]+/g, '');
      if (cpf.length !== 11) return false;

      if (/^(\d)\1{10}$/.test(cpf)) return false;

      let soma = 0;
      for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
      }
      let resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      if (resto !== parseInt(cpf.charAt(9))) return false;

      soma = 0;
      for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
      }
      resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      if (resto !== parseInt(cpf.charAt(10))) return false;

      return true;
    }

    document.getElementById('formCadastro').addEventListener('submit', function (event) {
      event.preventDefault();

      const nome = document.getElementById('nome').value.trim();
      const cargo = document.getElementById('cargo').value;
      const sexo = document.getElementById('sexo').value;
      const cpf = document.getElementById('cpf').value.trim();
      const email = document.getElementById('email').value.trim();
      const senha = document.getElementById('senha').value.trim();

      if (!nome || !cargo || !sexo || !cpf || !email || !senha) {
        alert('Por favor, preencha todos os campos.');
        return;
      }

      if (!validarEmail(email)) {
        alert('Por favor, insira um e-mail válido.');
        return;
      }

      if (!validarCPF(cpf)) {
        alert('Por favor, insira um CPF válido.');
        return;
      }

      let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

      if (usuarios.some(u => u.email.toLowerCase() === email.toLowerCase())) {
        alert('E-mail já cadastrado! Utilize outro.');
        return;
      }

      usuarios.push({ nome, cargo, sexo, cpf, email, senha });
      localStorage.setItem('usuarios', JSON.stringify(usuarios));

      alert('Cadastro realizado com sucesso!');
      window.location.href = 'admin.html';
    });
  </script>
</body>

</html>