DROP DATABASE IF EXISTS CMS;
CREATE DATABASE IF NOT EXISTS CMS CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE CMS;

CREATE TABLE IF NOT EXISTS preferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo_landing VARCHAR(255),
    favicon VARCHAR(255),
    logo_cabecalho VARCHAR(255),
    facebook VARCHAR(255),
    twitter VARCHAR(255),
    instagram VARCHAR(255),
    titulo_secaoHome VARCHAR(255),
    subtitulo_secaoHome TEXT,
    imagem_secaoHome VARCHAR(255),
    titulo_caracticasHome VARCHAR(255),
    titulo_testemunhos VARCHAR(255),
    titulo_secaoLojaApp VARCHAR(255),
    subtitulo_secaoLojaApp TEXT,
    imagem_secaoLojaApp VARCHAR(255),
    link_AppStore VARCHAR(255),
    imagem_AppStore VARCHAR(255),
    link_GooglePlay VARCHAR(255),
    imagem_GooglePlay VARCHAR(255),
    telefone_contato VARCHAR(25),
    logo_rodape VARCHAR(255),
    mensagem_rodape TEXT,
    url_rodape VARCHAR(255),
    mensagem_powered TEXT
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS caracteristicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS aplicativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    icon VARCHAR(255) NOT NULL

)ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS testemunhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    funcao VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    foto VARCHAR(255) NOT NULL,
    imagem_fundo VARCHAR(255) NOT NULL
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(25) NOT NULL,
    mensagem TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (email, password) VALUES ('test@gmail','123456789');