create database givanildo;

use givanildo;

create table usuarios(
    id int primary key auto_increment,
    nome varchar(255) not null,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table categorias(
    id int primary key auto_increment,
    nome varchar(255) not null
);

create table temas(
    id int primary key auto_increment,
    nome varchar(255) not null,
    id_categoria int,
    foreign key (id_categoria) references categorias (id)
);

create table tarefas(
    id int primary key auto_increment,
    nome varchar(255) not null,
    descricao TEXT,
    id_usuario int,
    id_tema int,
    concluida TINYINT(1) DEFAULT 0,
    foreign key (id_usuario) references usuarios (id),
    foreign key (id_tema) references temas (id)
);

DELIMITER $$
CREATE OR REPLACE PROCEDURE inserir_categoria(IN b_nome VARCHAR(255))
BEGIN
    DECLARE novo_id INT;

    -- Insere a nova categoria
    INSERT INTO categorias (nome)
    VALUES (b_nome);

    -- Obtém o ID da última categoria inserida
    SET novo_id = LAST_INSERT_ID();

    -- Cria o tema padrão vinculado à nova categoria
    INSERT INTO temas (nome, id_categoria)
    VALUES ('Tema', novo_id);
END $$
DELIMITER ;