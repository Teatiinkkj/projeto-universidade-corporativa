<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "universidade_corporativa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . $conn->connect_error]);
    exit();
}

$id = intval($_GET["id"] ?? 0);
if (!$id) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID do usuário não informado."]);
    exit();
}

$stmt = $conn->prepare("SELECT id, nome, email, senha, cargo, sexo, cpf FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit();
}

$usuario = $result->fetch_assoc();
echo json_encode(["success" => true, "data" => $usuario]);

$stmt->close();
$conn->close();
?>
