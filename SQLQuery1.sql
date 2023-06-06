CREATE DATABASE php_hardcore_project;

use php_hardcore_project;

create table Student(
username varchar(30),
password varchar(30) not null,
fullname varchar(30),
email varchar(30),
phonenum varchar(10),
id int IDENTITY(1,1) primary key,
)

create table Teacher(
id int IDENTITY(1,1),
username varchar(30),
password varchar(30) not null,
primary key(id, password),
)

select * from Teacher
select * from Student

insert into Student (username, password, fullname, email, phonenum )
values ('ngocht','168910','Hoang Thi Ngoc','ngochths150417@fpt.edu.vn',0349361014),
		('nampxh','1234','Pham Xuan Hoai Nam','nampxhhe151338@fpt.edu.vn',012356723);

insert into Teacher (username, password)
values ('ducdm','admin'),
		('binh','123');