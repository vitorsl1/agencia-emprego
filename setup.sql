-- =============================================
-- Sistema: Agência de Emprego Temporário
-- Banco de Dados: if0_42040402_agencia
-- =============================================

CREATE TABLE IF NOT EXISTS profissional (
    cpf VARCHAR(14) NOT NULL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    data_nascimento DATE NOT NULL,
    profissao VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS empresa (
    cnpj VARCHAR(18) NOT NULL PRIMARY KEY,
    razao_social VARCHAR(150) NOT NULL,
    endereco VARCHAR(200) NOT NULL
);

CREATE TABLE IF NOT EXISTS contrato (
    numero INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cpf_profissional VARCHAR(14) NOT NULL,
    cnpj_empresa VARCHAR(18) NOT NULL,
    data_inicio DATE NOT NULL,
    data_termino DATE NOT NULL,
    valor_hora DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cpf_profissional) REFERENCES profissional(cpf) ON DELETE CASCADE,
    FOREIGN KEY (cnpj_empresa) REFERENCES empresa(cnpj) ON DELETE CASCADE
);
