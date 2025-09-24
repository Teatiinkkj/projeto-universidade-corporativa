<?php
session_start();
header('Content-Type: application/json');
include '../../db/conexao.php';

$sql = "SELECT id, titulo, descricao, status FROM cursos ORDER BY id desc";
$res = mysqli_query($conn, $sql);

$cursos= [];
while ($row = mysqli_fetch_assoc($res)) {
    $cursos[] = $row;
}

echo json_encode($cursos);

?>