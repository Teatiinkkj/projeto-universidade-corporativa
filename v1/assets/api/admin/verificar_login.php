<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    echo json_encode(['logado' => true, 'usuario_id' => $_SESSION['usuario_id']]);
} else {
    echo json_encode(['logado' => false]);
}
?>