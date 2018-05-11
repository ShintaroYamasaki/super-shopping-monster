create database shopping;
use shopping;
create table items(id int auto_increment primary key, name varchar(60), category varchar(60), price int);
create table accounts(id int auto_increment primary key, name varchar(60), password varchar(60));
insert into items values(null, "chocolate", "snacks", 100);
insert into accounts values(null, "test", "test");