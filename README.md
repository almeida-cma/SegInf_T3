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

Sugestões de Melhorias:


Usar Prepared Statements: Protege contra injeção de SQL.

Verificar Sessão em Todas as Páginas: Assegurar que todas as páginas que requerem autenticação verifiquem se a sessão está ativa.

Redirecionamento Adequado Após Logout: Assegurar que todas as páginas redirecionem corretamente após o logout.

Uso de HTTPS: Configurar o servidor para usar HTTPS (No caso do local da homologação configurar o Xampp)


Enviar repositório com as atividades do Tema 3 para: https://almeida-cma.github.io/receber/
