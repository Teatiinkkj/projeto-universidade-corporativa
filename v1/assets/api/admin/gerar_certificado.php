<?php
require('../../lib/tfpdf/tfpdf.php'); // tFPDF suporta UTF-8
include __DIR__ . '/../../db/conexao.php';

session_start();
$usuario_id = $_SESSION['usuario_id'] ?? null;
$curso_id = intval($_GET['curso_id'] ?? 0);

if (!$usuario_id || !$curso_id) {
    die("Acesso inválido!");
}

// Buscar dados do certificado
$sql = "SELECT u.nome, c.titulo, ce.data_emissao
        FROM certificados ce
        INNER JOIN usuarios u ON ce.usuario_id = u.id
        INNER JOIN cursos c ON ce.curso_id = c.id
        WHERE ce.usuario_id = ? AND ce.curso_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$dados = $stmt->get_result()->fetch_assoc();

if (!$dados) {
    die("Certificado não encontrado!");
}

// -----------------------------
// CONFIGURAÇÕES DO PDF
// -----------------------------
$pdf = new tFPDF("L", "mm", "A4"); // paisagem
$pdf->AddPage();

// 🔹 Adicionando todas as variantes de fonte UTF-8
$pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSans-Bold.ttf',true);
$pdf->AddFont('DejaVu','I','DejaVuSans-Oblique.ttf',true);
$pdf->AddFont('DejaVu','BI','DejaVuSans-BoldOblique.ttf',true);

// Fundo
$pdf->SetFillColor(245, 245, 245);
$pdf->Rect(0, 0, 297, 210, "F");

// Borda
$pdf->SetLineWidth(2);
$pdf->SetDrawColor(100, 50, 150);
$pdf->Rect(10, 10, 277, 190, "D");

// Logo
if(file_exists('../../img/logo.png')){
    $pdf->Image('../../img/logo.png', 20, 15, 40);
}

// Título
$pdf->SetFont("DejaVu", "B", 28);
$pdf->SetTextColor(60, 30, 100);
$pdf->Cell(0, 40, "CERTIFICADO DE CONCLUSÃO", 0, 1, "C");

// Linha separadora
$pdf->SetDrawColor(180, 180, 180);
$pdf->SetLineWidth(0.5);
$pdf->Line(50, 55, 247, 55);

// Texto principal
$pdf->Ln(20);
$pdf->SetFont("DejaVu", "", 16);
$pdf->SetTextColor(50, 50, 50);
$pdf->MultiCell(0, 10, 
    "Certificamos que o(a) aluno(a) \n\n" .
    strtoupper($dados['nome']) . "\n\n" .
    "concluiu com êxito o curso:\n\n" .
    "'{$dados['titulo']}'\n\n" .
    "realizado em {$dados['data_emissao']}.", 0, "C"
);

// Assinatura
$pdf->Ln(30);
$pdf->SetFont("DejaVu", "I", 14);
$pdf->Cell(0, 10, "________________________________________", 0, 1, "C");
$pdf->Cell(0, 10, "Direção da Universidade Corporativa", 0, 1, "C");

// Rodapé
$pdf->SetY(-25);
$pdf->SetFont("DejaVu", "I", 10);
$pdf->SetTextColor(120, 120, 120);
$pdf->Cell(0, 10, "Universidade Corporativa © " . date("Y"), 0, 0, "C");

// Saída do PDF
$pdf->Output("D", "certificado-{$dados['titulo']}.pdf");
?>
