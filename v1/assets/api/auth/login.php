<?php
include "../../db/conexao.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email']) || !isset($input['senha'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Email e senha são obrigatórios."
    ]);
    exit();
}

$email = trim($input['email']);
$senha = $input['senha'];

// ----------------------
// LOGIN COM BANCO
// ----------------------
$stmt = $conn->prepare("SELECT id, nome, email, senha, cargo FROM usuarios WHERE email = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erro ao preparar consulta: " . $conn->error
    ]);
    exit();
}
$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erro ao executar consulta: " . $stmt->error
    ]);
    exit();
}
$result = $stmt->get_result();
if (!$result) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erro ao obter resultado: " . $stmt->error
    ]);
    exit();
}

if ($result->num_rows === 0) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Email não encontrado: " . $email
    ]);
    exit();
}

$usuario = $result->fetch_assoc();

$senhaCorreta = false;
if (password_verify($senha, $usuario['senha'])) {
    $senhaCorreta = true;
} elseif ($senha === $usuario['senha']) {
    $senhaCorreta = true;
}

if (!$senhaCorreta) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Senha incorreta."
    ]);
    exit();
}

// ----------------------
// REDIRECIONAMENTO
// ----------------------
$cargo = strtolower(trim($usuario['cargo']));
$paginaRedirecionamento = "";

switch ($cargo) {
    case 'aluno':
        $paginaRedirecionamento = "v1/assets/aluno/html/inicio.php";
        break;
    case 'professor':
        $paginaRedirecionamento = "v1/assets/professor/html/inicio.php";
        break;
    case 'coordenador':
        $paginaRedirecionamento = "v1/assets/coordenador/html/inicio.php";
        break;
    case 'admin':
    case 'administrador':
        $paginaRedirecionamento = "v1/assets/admin/html/inicio.php";
        break;
    default:
        $paginaRedirecionamento = "v1/assets/aluno/html/inicio.php";
        break;
}

// Criar sessão normal
session_start();
$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_email'] = $usuario['email'];
$_SESSION['usuario_cargo'] = $usuario['cargo'];

http_response_code(200);
echo json_encode([
    "success" => true,
    "message" => "Login realizado com sucesso!",
    "usuario" => [
        "id" => $usuario['id'],
        "nome" => $usuario['nome'],
        "email" => $usuario['email'],
        "cargo" => $usuario['cargo']
    ],
    "redirecionamento" => $paginaRedirecionamento,
    "debug" => [
        "cargo_detectado" => $cargo,
        "caminho_completo" => $paginaRedirecionamento
    ]
]);

$stmt->close();
$conn->close();
?>
