<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "universidade_corporativa";

// Desativa warnings que podem quebrar o JSON
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', 0);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Apenas encerra silenciosamente
    die("Erro na conexão com o banco de dados.");
}

// Conexão PDO para compatibilidade
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão PDO com o banco de dados: " . $e->getMessage());
}
