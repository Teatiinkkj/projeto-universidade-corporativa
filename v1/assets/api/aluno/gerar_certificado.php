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

// 🔹 Fontes UTF-8
$pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSans-Bold.ttf',true);
$pdf->AddFont('DejaVu','I','DejaVuSans-Oblique.ttf',true);

// -----------------------------
// ESTILO E LAYOUT
// -----------------------------

// Fundo degradê (simulado com retângulos sobrepostos)
for ($i = 0; $i < 210; $i++) {
    $r = 245 - ($i * 0.05);
    $g = 240 - ($i * 0.05);
    $b = 250;
    $pdf->SetFillColor($r, $g, $b);
    $pdf->Rect(0, $i, 297, 1, "F");
}

// Borda com cor principal roxa
$pdf->SetLineWidth(3);
$pdf->SetDrawColor(90, 45, 145);
$pdf->Rect(10, 10, 277, 190, "D");

// Logo (se existir)
if (file_exists('../../images/logo.png')) {
    $pdf->Image('../../images/logo.png', 15, 15, 40);
}

// -----------------------------
// TÍTULO E CONTEÚDO
// -----------------------------
$pdf->SetY(35);
$pdf->SetFont("DejaVu", "B", 28);
$pdf->SetTextColor(60, 30, 100);
$pdf->Cell(0, 15, "CERTIFICADO DE CONCLUSÃO", 0, 1, "C");

$pdf->SetFont("DejaVu", "I", 14);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0, 5, "Universidade Corporativa", 0, 1, "C");

$pdf->Ln(20);
$pdf->SetTextColor(50, 50, 50);
$pdf->SetFont("DejaVu", "", 16);
$pdf->MultiCell(0, 8, "Certificamos que o(a) aluno(a)", 0, "C");

// Nome do aluno
$pdf->Ln(6);
$pdf->SetFont("DejaVu", "B", 22);
$pdf->SetTextColor(40, 20, 90);
$pdf->MultiCell(0, 5, strtoupper($dados['nome']), 0, "C");

$pdf->Ln(4);
$pdf->SetFont("DejaVu", "", 16);
$pdf->SetTextColor(50, 50, 50);
$pdf->MultiCell(0, 5, "concluiu com êxito o curso", 0, "C");

// Nome do curso
$pdf->Ln(5);
$pdf->SetFont("DejaVu", "B", 20);
$pdf->SetTextColor(70, 40, 120);
$pdf->MultiCell(0, 5, "“{$dados['titulo']}”", 0, "C");

$pdf->Ln(5);
$pdf->SetFont("DejaVu", "", 14);
$pdf->SetTextColor(60, 60, 60);
$pdf->MultiCell(0, 5, "Realizado em {$dados['data_emissao']}.", 0, "C");

// -----------------------------
// ASSINATURA
// -----------------------------
$pdf->Ln(25);
$pdf->SetFont("DejaVu", "", 14);
$pdf->SetTextColor(80, 80, 80);
$pdf->Cell(0, 5, "________________________________________", 0, 1, "C");
$pdf->SetFont("DejaVu", "I", 12);
$pdf->Cell(0, 10, "Direção da Universidade Corporativa", 0, 1, "C");

// -----------------------------
// RODAPÉ
// -----------------------------
$pdf->SetY(-20);
$pdf->SetFont("DejaVu", "I", 10);
$pdf->SetTextColor(120, 120, 120);
$pdf->Cell(0, -20, " Universidade Corporativa © " . date("Y"), 0, 0, "C");

// -----------------------------
// SAÍDA
// -----------------------------
$pdf->Output("D", "certificado-{$dados['titulo']}.pdf");
?>
