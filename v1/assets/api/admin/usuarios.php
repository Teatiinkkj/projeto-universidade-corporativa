<?php
header('Content-Type: application/json');

include '../../db/conexao.php';

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
