drop database if exists dbApi;
create database dbApi;
use dbApi;

-- API
create table Mensagem (
    msgId int not null auto_increment,
    msgTitulo varchar(100) not null,
    msgTexto varchar(500) not null,
    msgData date not null,
    msgRemetente varchar(50) not null,
    msgVotes int default 0,
    primary key (msgId)
);


insert into Mensagem (msgTitulo, msgTexto, msgData, msgRemetente) 
values 
("Teste", "Testando testando", '2024-05-22', "eu mesmo"),
("Teste 2", "Testando aqui", '2024-05-22', "Rodrigo Buarque");


desc Mensagem;


select * from Mensagem;

-- --Filtros especificos de busca
-- select * from Mensagem where msgId = ?; -- Busca por id
-- select * from Mensagem where msgTitulo like '%?%'; -- Busca por titulo
-- select * from Mensagem where msgData = ?; -- Busca por data
-- select * from Mensagem where msgRemetente like '%?%'; -- Busca por remetente
-- select * from Mensagem where msgTexto like '%?%'; -- Busca por texto
-- select * from Mensagem order by msgVotes DES; --ordernador por votos
-- select * from Mensagem order by msgData DES; --ordenador por data 

-- --Votação
-- update Mensagem set msgVotes = msgVotes+1 where msgId = ?; -- Votar em uma mensagem