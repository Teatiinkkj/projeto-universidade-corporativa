<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "universidade_corporativa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erro na conexão: " . $conn->connect_error]);
    exit();
}

$sql = "SELECT id, nome, email, senha, cargo, sexo, cpf FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode(["success" => true, "data" => $usuarios]);

$conn->close();
?>
