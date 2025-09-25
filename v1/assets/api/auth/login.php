<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "universidade_corporativa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erro na conexão com o banco de dados: " . $conn->connect_error
    ]);
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
// LOGIN FIXO ADMIN
// ----------------------
if ($email === "admin" && $senha === "admin") {
    session_start();
    $_SESSION['usuario_id'] = 0; // ID fictício
    $_SESSION['usuario_nome'] = "Administrador";
    $_SESSION['usuario_email'] = "admin@unicorp.com";
    $_SESSION['usuario_cargo'] = "admin";

    echo json_encode([
        "success" => true,
        "message" => "Login de administrador realizado com sucesso!",
        "usuario" => [
            "id" => 0,
            "nome" => "Administrador",
            "email" => "admin@unicorp.com",
            "cargo" => "admin"
        ],
        "redirecionamento" => "../../assets/admin/html/inicio.php"
    ]);
    exit();
}

// ----------------------
// LOGIN COM BANCO
// ----------------------
$stmt = $conn->prepare("SELECT id, nome, email, senha, cargo FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

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
        $paginaRedirecionamento = "../../assets/aluno/html/inicio.php";
        break;
    case 'professor':
        $paginaRedirecionamento = "../../assets/professor/html/inicio.php";
        break;
    case 'coordenador':
        $paginaRedirecionamento = "../../assets/coordenador/html/inicio.php";
        break;
    case 'admin':
    case 'administrador':
        $paginaRedirecionamento = "../../assets/admin/html/inicio.php";
        break;
    default:
        $paginaRedirecionamento = "../../assets/aluno/html/inicio.php";
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
