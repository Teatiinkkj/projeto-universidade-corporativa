
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
('Admin', 'Administrador', 'M', '00000000001', 'admin@gmail.com', 'admin', 'https://i.imgur.com/3G0Xh1t.png'),
('Coordenador', 'Coordenador', 'M', '00000000002', 'coordenador@gmail.com', '123', 'https://i.imgur.com/z9sKzix.png'),
('Professor', 'Professor', 'M', '00000000003', 'professor@gmail.com', '123', 'https://i.imgur.com/8s9G8ZH.png'),
('Aluno', 'Aluno', 'M', '00000000004', 'aluno@gmail.com', '123', 'https://i.imgur.com/7P2mYFm.png');

-- --------------------------------------------------
-- CURSOS REAIS
-- --------------------------------------------------
INSERT INTO cursos (titulo, descricao, imagem, status) VALUES
('Curso de HTML e CSS', 'Aprenda os fundamentos da criação de sites modernos com HTML e CSS.', 'https://upload.wikimedia.org/wikipedia/commons/d/d5/CSS3_logo_and_wordmark.svg', 1),
('Curso de JavaScript', 'Domine a linguagem que dá vida às páginas web.', 'https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png', 1),
('Curso de Python', 'Do básico ao avançado em programação Python.', 'https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg', 1),
('Curso de PHP', 'Aprenda a criar aplicações web com PHP e MySQL.', 'https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg', 1),
('Curso de SQL', 'Domine consultas, joins e manipulação de dados em SQL.', 'https://upload.wikimedia.org/wikipedia/commons/4/4f/SQL_Logo.png', 1),
('Curso de Node.js', 'Aprenda backend moderno com Node.js.', 'https://upload.wikimedia.org/wikipedia/commons/d/d9/Node.js_logo.svg', 1),
('Curso de React', 'Crie interfaces modernas com React.js.', 'https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg', 1),
('Curso de Git e GitHub', 'Controle de versão e colaboração em projetos.', 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Git-logo.svg', 1);

-- --------------------------------------------------
-- TESTE FINAL
-- --------------------------------------------------
SELECT * FROM usuarios;
SELECT * FROM cursos;
SELECT * FROM topicos;
SELECT * FROM conteudo;
SELECT * FROM progresso;
SELECT * FROM notificacoes;