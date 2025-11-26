-- --------------------------------------------------
-- DELETAR BANCO EXISTENTE
-- --------------------------------------------------
DROP DATABASE IF EXISTS universidade_corporativa;
CREATE DATABASE universidade_corporativa;
USE universidade_corporativa;

-- --------------------------------------------------
-- TABELA DE USUÁRIOS
-- --------------------------------------------------
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    sexo CHAR(1) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL
);

-- --------------------------------------------------
-- TABELA DE CURSOS
-- --------------------------------------------------
DROP TABLE IF EXISTS cursos;
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    status TINYINT(1) DEFAULT 1
);

-- --------------------------------------------------
-- TABELA DE TÓPICOS
-- --------------------------------------------------
DROP TABLE IF EXISTS topicos;
CREATE TABLE topicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    ordem INT NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- TABELA DE CONTEÚDO
-- --------------------------------------------------
DROP TABLE IF EXISTS conteudo;
CREATE TABLE conteudo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topico_id INT NOT NULL,
    tipo ENUM('video','pdf','imagem') NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    arquivo_path VARCHAR(255) NOT NULL,
    ordem INT NOT NULL,
    FOREIGN KEY (topico_id) REFERENCES topicos(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- TABELA DE PROGRESSO
-- --------------------------------------------------
DROP TABLE IF EXISTS progresso;
CREATE TABLE progresso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    conteudo_id INT NOT NULL,
    concluido BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (conteudo_id) REFERENCES conteudo(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_conteudo (usuario_id, conteudo_id)
);

-- --------------------------------------------------
-- TABELA DE MATRÍCULAS
-- --------------------------------------------------
DROP TABLE IF EXISTS matriculas;
CREATE TABLE matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    data_matricula DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------
-- VIEW: PROGRESSO POR CURSO
-- --------------------------------------------------
DROP VIEW IF EXISTS view_progresso_curso;
CREATE VIEW view_progresso_curso AS
SELECT 
    m.usuario_id,
    m.curso_id,
    ROUND(
        (COUNT(DISTINCT CASE WHEN p.concluido = 1 THEN p.conteudo_id END) / 
         COUNT(DISTINCT c.id)) * 100, 0
    ) AS progresso
FROM matriculas m
JOIN cursos cu ON cu.id = m.curso_id
JOIN topicos t ON t.curso_id = cu.id
JOIN conteudo c ON c.topico_id = t.id
LEFT JOIN progresso p 
    ON p.conteudo_id = c.id AND p.usuario_id = m.usuario_id
GROUP BY m.usuario_id, m.curso_id;

-- --------------------------------------------------
-- TABELA DE CERTIFICADOS
-- --------------------------------------------------
DROP TABLE IF EXISTS certificados;
CREATE TABLE certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    data_emissao DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- TABELA DE NOTIFICAÇÕES
-- --------------------------------------------------
DROP TABLE IF EXISTS notificacoes;
CREATE TABLE notificacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo ENUM('novo_curso','curso_concluido','perfil_atualizado') NOT NULL,
    descricao TEXT NOT NULL,
    lida TINYINT(1) DEFAULT 0,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- USUÁRIOS DE TESTE
-- --------------------------------------------------
INSERT INTO usuarios (nome, cargo, sexo, cpf, email, senha, foto)
VALUES
('Teatin', 'Administrador', 'M', '51117171884', 'muriloteatin@gmail.com', 'admin', 'https://i.imgur.com/3G0Xh1t.png'),
('Admin', 'Administrador', 'M', '00000000001', 'admin@gmail.com', 'admin', 'https://i.imgur.com/3G0Xh1t.png'),
('Coordenador', 'Coordenador', 'M', '00000000002', 'coordenador@gmail.com', '123', 'https://i.imgur.com/z9sKzix.png'),
('Professor', 'Professor', 'M', '00000000003', 'professor@gmail.com', '123', 'https://i.imgur.com/8s9G8ZH.png'),
('Aluno', 'Aluno', 'M', '00000000004', 'aluno@gmail.com', '123', 'https://i.imgur.com/7P2mYFm.png');

-- --------------------------------------------------
-- CURSOS COM IMAGENS LIVRES (PEXELS/PIXABAY/DOMÍNIO PÚBLICO)
-- --------------------------------------------------
INSERT INTO cursos (titulo, descricao, imagem, status) VALUES
('Matemática - Fundamentos e Resolução de Problemas', 'Curso completo sobre aritmética, álgebra, geometria e exercícios práticos.', 'https://images.pexels.com/photos/623167/pexels-photo-623167.jpeg', 1),
('Português - Gramática, Interpretação e Redação', 'Estudos completos da língua portuguesa, incluindo interpretação e redação.', 'https://images.pexels.com/photos/261895/pexels-photo-261895.jpeg', 1),
('História do Brasil', 'Linha do tempo completa desde o período colonial até o Brasil contemporâneo.', 'https://upload.wikimedia.org/wikipedia/commons/6/6b/Map_of_Brazil_1900.png', 1),
('Geografia Geral e do Brasil', 'Conteúdos sobre espaço geográfico, clima, vegetação, mapas e geopolítica.', 'https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg', 1),
('Biologia - Fundamentos da Vida', 'Estudo de células, genética, ecologia e corpo humano.', 'https://images.pexels.com/photos/2280549/pexels-photo-2280549.jpeg', 1),
('Química - Estrutura da Matéria e Reações', 'Atomística, ligações químicas, soluções e cálculos químicos.', 'https://images.pexels.com/photos/256302/pexels-photo-256302.jpeg', 1),
('Física - Mecânica, Energia e Eletricidade', 'Movimento, força, leis de Newton, energia, ondas e eletricidade.', 'https://images.pexels.com/photos/256381/pexels-photo-256381.jpeg', 1),
('Inglês - Básico ao Intermediário', 'Vocabulário, verbos, leitura e conversação.', 'https://images.pexels.com/photos/3184325/pexels-photo-3184325.jpeg', 1);

-- --------------------------------------------------
-- PROCEDURE PARA POPULAR CONTEÚDOS LIVRES
-- --------------------------------------------------
DELIMITER $$

CREATE PROCEDURE popular_cursos_reais()
BEGIN
    DECLARE c INT DEFAULT 1;
    DECLARE total_cursos INT;
    SELECT COUNT(*) INTO total_cursos FROM cursos;

    WHILE c <= total_cursos DO
    
        INSERT INTO topicos (curso_id, titulo, ordem) VALUES (c, 'Introdução ao Conteúdo', 1);
        INSERT INTO topicos (curso_id, titulo, ordem) VALUES (c, 'Conteúdo Intermediário', 2);
        INSERT INTO topicos (curso_id, titulo, ordem) VALUES (c, 'Conteúdo Avançado', 3);

        -- --------------------------------------------------
        -- TÓPICO 1 — INTRODUÇÃO (VÍDEOS CC & PDFs LIVRES)
        -- --------------------------------------------------

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'video', 'Introdução ao Curso',
        CASE c
            WHEN 1 THEN 'https://www.youtube.com/watch?v=ZQJ6yqQRAQs' -- Khan Academy Brasil (CC BY)
            WHEN 2 THEN 'https://www.youtube.com/watch?v=k6s3Wz5iT0c' -- Português livre - CC
            WHEN 3 THEN 'https://www.youtube.com/watch?v=gcS9n7Ejh10' -- História Brasil CC
            WHEN 4 THEN 'https://www.youtube.com/watch?v=9vN2C38nSvw'
            WHEN 5 THEN 'https://www.youtube.com/watch?v=FzRH3iTQPrk'
            WHEN 6 THEN 'https://www.youtube.com/watch?v=C6YtJW5u5nM'
            WHEN 7 THEN 'https://www.youtube.com/watch?v=4Q1FBOGfEy0'
            WHEN 8 THEN 'https://www.youtube.com/watch?v=1j0VgZkA2xQ'
        END, 1
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 1;

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'pdf', 'Material Introdutório',
        'https://openstax.org/books/college-algebra-2e/pages/1-introduction' -- OpenStax livre
        , 2
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 1;

        -- --------------------------------------------------
        -- TÓPICO 2 — INTERMEDIÁRIO
        -- --------------------------------------------------

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'video', 'Aula Intermediária',
        'https://www.youtube.com/watch?v=HAnw168huqA' -- CC Licensing
        , 1
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 2;

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'pdf', 'Apostila Intermediária',
        'https://openstax.org/books/biology-2e/pages/1-introduction' -- OpenStax livre
        , 2
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 2;

        -- --------------------------------------------------
        -- TÓPICO 3 — AVANÇADO
        -- --------------------------------------------------

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'video', 'Aula Avançada',
        'https://archive.org/details/KhanAcademyMath'  -- Vídeos domínio público
        , 1
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 3;

        INSERT INTO conteudo (topico_id, tipo, titulo, arquivo_path, ordem)
        SELECT t.id, 'pdf', 'Material de Revisão Final',
        'https://openstax.org/books/physics/pages/1-introduction'
        , 2
        FROM topicos t WHERE t.curso_id = c AND t.ordem = 3;

        SET c = c + 1;
    END WHILE;

END$$

DELIMITER ;

CALL popular_cursos_reais();
DROP PROCEDURE popular_cursos_reais;

-- TESTE FINAL
SELECT * FROM usuarios;
SELECT * FROM cursos;
SELECT * FROM topicos;
SELECT * FROM conteudo;
SELECT * FROM progresso;
SELECT * FROM notificacoes;