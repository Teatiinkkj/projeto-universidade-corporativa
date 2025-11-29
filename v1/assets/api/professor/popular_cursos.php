<?php
include "../../db/conexao.php";

// -----------------------------------------
// FUNÇÃO: adiciona tópicos e conteúdos por curso
// -----------------------------------------
function popularCurso($conn, $curso_id) {

    // Criar tópicos padrão
    $topicos = [
        ["Introdução", 1],
        ["Conteúdo Intermediário", 2],
        ["Conteúdo Avançado", 3]
    ];

    foreach ($topicos as $t) {
        $stmt = $conn->prepare("INSERT INTO topicos (curso_id, titulo, ordem) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $curso_id, $t[0], $t[1]);
        $stmt->execute();
    }

    // Buscar tópicos criados
    $sql = "SELECT id, ordem FROM topicos WHERE curso_id = ? ORDER BY ordem ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $topicos_criados = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // VÍDEOS específicos por curso
    $videos_iniciais = [
        1 => "https://www.youtube.com/watch?v=UB1O30fR-EE",
        2 => "https://www.youtube.com/watch?v=PkZNo7MFNFg",
        3 => "https://www.youtube.com/watch?v=_uQrJ0TkZlc",
        4 => "https://www.youtube.com/watch?v=OK_JCtrrv-c",
        5 => "https://www.youtube.com/watch?v=HXV3zeQKqGY",
        6 => "https://www.youtube.com/watch?v=TlB_eWDSMt4",
        7 => "https://www.youtube.com/watch?v=bMknfKXIFA8",
        8 => "https://www.youtube.com/watch?v=RGOj5yH7evk"
    ];

    $videos_intermediarios = [
        1 => "https://www.youtube.com/watch?v=yfoY53QXEnI",
        2 => "https://www.youtube.com/watch?v=hdI2bqOjy3c",
        3 => "https://www.youtube.com/watch?v=rfscVS0vtbw",
        4 => "https://www.youtube.com/watch?v=OK_JCtrrv-c",
        5 => "https://www.youtube.com/watch?v=HXV3zeQKqGY",
        6 => "https://www.youtube.com/watch?v=ENrzD9HAZK4",
        7 => "https://www.youtube.com/watch?v=SqcY0GlETPk",
        8 => "https://www.youtube.com/watch?v=RGOj5yH7evk"
    ];

    $videos_avancados = [
        1 => "https://www.youtube.com/watch?v=pQN-pnXPaVg",
        2 => "https://www.youtube.com/watch?v=W6NZfCO5SIk",
        3 => "https://www.youtube.com/watch?v=rfscVS0vtbw",
        4 => "https://www.youtube.com/watch?v=OK_JCtrrv-c",
        5 => "https://www.youtube.com/watch?v=HXV3zeQKqGY",
        6 => "https://www.youtube.com/watch?v=ENrzD9HAZK4",
        7 => "https://www.youtube.com/watch?v=SqcY0GlETPk",
        8 => "https://www.youtube.com/watch?v=RGOj5yH7evk"
    ];

    foreach ($topicos_criados as $t) {

        $topico_id = $t['id'];
        $ordem = $t['ordem'];

        // Selecionar vídeo correto
        $video = ($ordem == 1) ? $videos_iniciais[$curso_id] :
                 (($ordem == 2) ? $videos_intermediarios[$curso_id] :
                                   $videos_avancados[$curso_id]);

        // Inserir vídeo
        $stmt = $conn->prepare("
            INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
            VALUES (?, 'video', ?, ?, 1)
        ");
        $titulo = ($ordem == 1) ? "Introdução ao curso" :
                  (($ordem == 2) ? "Aulas intermediárias" : "Projeto Final");
        $stmt->bind_param("iss", $topico_id, $titulo, $video);
        $stmt->execute();

        // Inserir PDF
        $pdf_padrao = ($ordem == 1) 
            ? "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
            : (($ordem == 2)
                ? "https://www.clickdimensions.com/links/TestPDFfile.pdf"
                : "https://www.adobe.com/support/products/enterprise/knowledgecenter/media/c4611_sample_explain.pdf");

        $titulo_pdf = ($ordem == 1) ? "Guia do iniciante" :
                      (($ordem == 2) ? "Apostila Intermediária" : "Certificação e conclusão");

        $stmt = $conn->prepare("
            INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
            VALUES (?, 'pdf', ?, ?, 2)
        ");
        $stmt->bind_param("iss", $topico_id, $titulo_pdf, $pdf_padrao);
        $stmt->execute();
    }
}

// -----------------------------------------
// SEÇÃO PRINCIPAL: popula todos os cursos
// -----------------------------------------
$sql = "SELECT id FROM cursos ORDER BY id ASC";
$result = $conn->query($sql);
$cursos = $result->fetch_all(MYSQLI_ASSOC);

foreach ($cursos as $c) {
    popularCurso($conn, $c['id']);
}

echo "Cursos populados com sucesso!";
?>
