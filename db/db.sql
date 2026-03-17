DROP DATABASE IF EXISTS CMS;
CREATE DATABASE IF NOT EXISTS CMS CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE CMS;

CREATE TABLE IF NOT EXISTS Preferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo_landing VARCHAR(255) NOT NULL,
    favicon VARCHAR(255) NOT NULL,
    logo_cabecalho VARCHAR(255) NOT NULL,
    facebook VARCHAR(255) NOT NULL,
    twitter VARCHAR(255) NOT NULL,
    instagram VARCHAR(255) NOT NULL,
    titulo_secaoHome VARCHAR(255) NOT NULL,
    subtitulo_secaoHome TEXT NOT NULL,
    imagem_secaoHome VARCHAR(255) NOT NULL,
    titulo_caracticasHome VARCHAR(255) NOT NULL,
    titulo_secaoLojaApp VARCHAR(255) NOT NULL,
    subtitulo_secaoLojaApp TEXT NOT NULL,
    imagem_secaoLojaApp VARCHAR(255) NOT NULL,
    image_AppStore VARCHAR(255) NOT NULL,
    image_GooglePlay VARCHAR(255) NOT NULL,
    telefone_contato VARCHAR(25) NOT NULL,
    logo_rodape VARCHAR(255) NOT NULL,
    mesagem_rodape TEXT NOT NULL,
    url_rodape VARCHAR(255) NOT NULL,
    mensagem_powered TEXT NOT NULL
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