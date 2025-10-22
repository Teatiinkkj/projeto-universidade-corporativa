<?php
require_once("../../db/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? null;

    if (!$email) {
        http_response_code(400);
        echo "Erro: E-mail não informado.";
        exit;
    }

    // Busca o usuário que solicitou
    $stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo "Usuário não encontrado.";
        exit;
    }

    $usuario = $result->fetch_assoc();
    $stmt->close();

    // Busca todos os administradores e coordenadores
    $sql_destinatarios = "SELECT id FROM usuarios WHERE cargo IN ('Administrador', 'Coordenador')";
    $result_dest = $conn->query($sql_destinatarios);

    if ($result_dest->num_rows === 0) {
        echo "Nenhum destinatário encontrado.";
        exit;
    }

    // Cria notificações para cada um
    $stmt_notif = $conn->prepare("
        INSERT INTO notificacoes (usuario_id, tipo, descricao)
        VALUES (?, 'perfil_atualizado', ?)
    ");

    $descricao = "O usuário {$usuario['nome']} ({$usuario['email']}) solicitou recuperação de senha.";

    while ($dest = $result_dest->fetch_assoc()) {
        $stmt_notif->bind_param("is", $dest["id"], $descricao);
        $stmt_notif->execute();
    }

    $stmt_notif->close();
    $conn->close();

    echo "sucesso";
}
?>
