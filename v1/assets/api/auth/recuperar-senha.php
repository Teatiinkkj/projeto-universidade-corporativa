<?php
include "../../db/conexao.php"; // conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Verifica se o e-mail existe
    $query = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Busca coordenadores e administradores
        $queryAdmins = $conn->query("SELECT id, nome FROM usuarios WHERE cargo IN ('Coordenador', 'Administrador')");

        // Mensagem da notificação
        $descricao = "O usuário " . $usuario['nome'] . " (" . $usuario['email'] . ") solicitou a recuperação de senha.";

        // Envia a notificação para cada coordenador e administrador
        while ($adm = $queryAdmins->fetch_assoc()) {
            $tipo = 'perfil_atualizado'; // podemos usar esse tipo, já que é um evento de alteração de conta
            $insert = $conn->prepare("INSERT INTO notificacoes (usuario_id, tipo, descricao) VALUES (?, ?, ?)");
            $insert->bind_param("iss", $adm['id'], $tipo, $descricao);
            $insert->execute();
        }

        // Redireciona para a próxima etapa
        header("Location: ../html/confirmar-recuperacao.html");
        exit();
    } else {
        echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
    }
}
?>
