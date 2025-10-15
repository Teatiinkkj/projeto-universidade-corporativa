<?php
session_start();

// Se não houver usuário logado, redireciona para login
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: ../../html/login.html");
    exit();
}
?>
