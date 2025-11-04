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
    id_usuario int,
    id_tema int,
    foreign key (id_usuario) references usuarios (id),
    foreign key (id_tema) references temas (id)
);

delimiter $$
create or replace procedure inserir_categoria(b_nome varchar(255))
begin
insert into categorias (nome)
values (b_nome);
end $$
delimiter ;