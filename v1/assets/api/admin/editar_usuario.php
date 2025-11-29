<?php
session_start();
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

// Verificar se o usuário logado é administrador
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuário não autenticado."]);
    exit();
}

$stmt = $conn->prepare("SELECT cargo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
$current_user = $result->fetch_assoc();
$current_user_cargo = $current_user['cargo'] ?? '';
$stmt->close();

if ($cargo === "Administrador" && $current_user_cargo !== "Administrador") {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Apenas administradores podem atribuir o cargo de Administrador."]);
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
