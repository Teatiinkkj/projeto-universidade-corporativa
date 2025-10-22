<?php
require_once '../../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Verifica se o e-mail existe
    $stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();

    if ($usuario) {
        // Busca todos administradores e coordenadores
        $admins = $conn->query("SELECT id, nome FROM usuarios WHERE cargo IN ('Administrador', 'Coordenador')");

        // Tipo da notificação (você pode criar ENUM 'recuperacao_senha' se quiser)
        $tipo = 'perfil_atualizado';
        $descricao = "O usuário {$usuario['nome']} ({$usuario['email']}) solicitou recuperação de senha.";

        // Cria notificação para cada administrador e coordenador
        while ($adm = $admins->fetch_assoc()) {
            $insert = $conn->prepare("INSERT INTO notificacoes (usuario_id, tipo, descricao) VALUES (?, ?, ?)");
            $insert->bind_param("iss", $adm['id'], $tipo, $descricao);
            $insert->execute();
        }

        // Redireciona para próxima etapa
        header("Location: ../../html/confirmar-recuperacao.php?email=" . urlencode($email));
        exit();
    } else {
        echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
    }
}
?>
