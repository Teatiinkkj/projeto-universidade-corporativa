<?php
header('Content-Type: application/json');
include '../../db/conexao.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);
$nome = trim($data["nome"] ?? "");
$email = trim($data["email"] ?? "");
$senha = trim($data["senha"] ?? "");
$cargo = trim($data["cargo"] ?? "");
$sexo = trim($data["sexo"] ?? "");
$cpf = trim($data["cpf"] ?? "");

if (!$id || !$nome || !$email || !$cargo || !$sexo || !$cpf) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Dados incompletos."]);
    exit();
}

if ($senha) {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, cargo = ?, sexo = ?, cpf = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $nome, $email, $senha, $cargo, $sexo, $cpf, $id);
} else {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, cargo = ?, sexo = ?, cpf = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nome, $email, $cargo, $sexo, $cpf, $id);
}

if ($stmt->execute()) {
    // Criar notificação de perfil atualizado
    $stmtNotif = $conn->prepare("INSERT INTO notificacoes (usuario_id, tipo, descricao) VALUES (?, ?, ?)");
    $tipo = 'perfil_atualizado';
    $descricaoNotif = "Seu perfil foi atualizado com sucesso";
    $stmtNotif->bind_param("iss", $id, $tipo, $descricaoNotif);
    $stmtNotif->execute();

    echo json_encode(["success" => true, "message" => "Usuário atualizado com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro ao atualizar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
