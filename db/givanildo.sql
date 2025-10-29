create database givanildo;

use givanildo;

create table tarefa(
    id int primary key auto_increment,
    nome varchar(100) not null,
    descricao varchar(255),
    prioridade enum('Baixa', 'Media', 'Alta') default 'Media',
    status enum('Pendente', 'Em Andamento', 'Concluida') default 'Pendente',
    data_criacao timestamp default current_timestamp,
    data_conclusao date
);