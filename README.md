# SegInf_T3
Plano de contingência

-- Verifica e cria o banco de dados se não existir <br>
CREATE DATABASE IF NOT EXISTS seguro;<br>

-- Usa o banco de dados<br>
USE seguro;<br>

-- Verifica se a tabela 'usuarios' já existe antes de criá-la<br>
CREATE TABLE IF NOT EXISTS usuarios (<br>
    id INT AUTO_INCREMENT PRIMARY KEY,<br>
    username VARCHAR(50) NOT NULL,<br>
    email VARCHAR(100) NOT NULL UNIQUE,<br>
    senha VARCHAR(255) NOT NULL,<br>
    autenticacao_habilitada TINYINT(1) DEFAULT 0,<br>
    codigo_autenticacao INT,<br>
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP<br>
);<br>

Sugestões de Melhorias:<br>

Usar Prepared Statements: Protege contra injeção de SQL.<br>
Verificar Sessão em Todas as Páginas: Assegurar que todas as páginas que requerem autenticação verifiquem se a sessão está ativa.<br>
Redirecionamento Adequado Após Logout: Assegurar que todas as páginas redirecionem corretamente após o logout.<br>
Uso de HTTPS: Configurar o servidor para usar HTTPS (No caso do local da homologação configurar o Xampp)<br>


Enviar repositório com as atividades do Tema 3 para: https://almeida-cma.github.io/receber/
