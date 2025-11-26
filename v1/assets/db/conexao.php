<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "universidade_corporativa";

// Desativa warnings que podem quebrar o JSON
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', 0);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Apenas encerra silenciosamente
    die("Erro na conexão com o banco de dados.");
}
