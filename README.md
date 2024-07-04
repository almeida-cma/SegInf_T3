# SegInf_T3
Plano de contingência


Criar DATABASE = seguro

RODAR SCRIPT TABELA:
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    autenticacao_habilitada TINYINT(1) DEFAULT 0,
    codigo_autenticacao INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


Enviar repositório com as atividades do Tema 3 para: https://almeida-cma.github.io/receber/
