<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuários | Curso</title>

    <link rel="stylesheet" href="../css/listar_usuarios.css">
    <link rel="stylesheet" href="../css/back-button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body>
    <header>
        <a onclick="history.back()" class="back-button" role="button" tabindex="0">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </header>

    <main class="main-container">
        <h1>Usuários cadastrados neste curso</h1>

        <p class="fs-5">
            Nome do Curso
        </p>

        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>João Silva</td>
                    <td>joao.silva@email.com</td>
                    <td>123.456.789-00</td>
                </tr>
                <tr>
                    <td>Maria Oliveira</td>
                    <td>maria.oliveira@email.com</td>
                    <td>987.654.321-00</td>
                </tr>
            </tbody>
        </table>

    </main>

    <footer>
        <div class="footer-text">
            <p class="pull-left">&copy; 2025 - Todos os direitos reservados</p>
        </div>
    </footer>
</body>

</html>