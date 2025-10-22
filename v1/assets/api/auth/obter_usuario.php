<?php
require_once("../../db/conexao.php"); // ajuste o caminho se necessário

if (!isset($_GET['email'])) {
    http_response_code(400);
    echo json_encode(["erro" => "E-mail não informado."]);
    exit();
}

$email = $_GET['email'];

$stmt = $conn->prepare("SELECT nome, email FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["erro" => "Usuário não encontrado."]);
}

$stmt->close();
$conn->close();
