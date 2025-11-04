create database givanildo;

use givanildo;

create table categorias(
    id int primary key auto_increment,
    nome VARCHAR(255) not null
);

delimiter $$
CREATE OR replace PROCEDURE inserir_categoria(b_nome VARCHAR(255))
BEGIN 
INSERT INTO categorias (nome) VALUES (b_nome);

END $$
delimiter ;
