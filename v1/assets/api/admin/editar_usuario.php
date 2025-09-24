<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "universidade_corporativa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . $conn->connect_error]);
    exit();
}

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
    echo json_encode(["success" => true, "message" => "Usuário atualizado com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro ao atualizar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
