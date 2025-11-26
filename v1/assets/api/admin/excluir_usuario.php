<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "universidade_corporativa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro de conexão."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data["id"] ?? 0);

if (!$id) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID inválido."]);
    exit();
}

$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Usuário excluído com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro ao excluir usuário."]);
}
$stmt->close();
$conn->close();
?>
