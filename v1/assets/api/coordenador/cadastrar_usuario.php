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

$nome = trim($data["nome"] ?? "");
$email = trim($data["email"] ?? "");
$senha = trim($data["senha"] ?? "");
$cargo = trim($data["cargo"] ?? "");
$sexo = trim($data["sexo"] ?? "");
$cpf = trim($data["cpf"] ?? "");

if (!$nome || !$email || !$senha || !$cargo || !$sexo || !$cpf) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Campos obrigatórios não preenchidos."]);
    exit();
}

// Verifica se o email já está cadastrado
$check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["success" => false, "message" => "Email já está em uso."]);
    exit();
}
$check->close();

// Insere novo usuário
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, cargo, sexo, cpf) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nome, $email, $senha, $cargo, $sexo, $cpf);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Usuário cadastrado com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro ao cadastrar usuário: " . $stmt->error]);
}
$stmt->close();
$conn->close();
?>
