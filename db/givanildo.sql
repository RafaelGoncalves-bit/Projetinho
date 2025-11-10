create database givanildo;

use givanildo;

create table usuarios(
    id int primary key auto_increment,
    nome varchar(255) not null,
    email varchar(255) not null,
    senha varchar(255) not null
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