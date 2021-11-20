create database avitsdms;

use avitsdms;

create table useraccount (uid int not null auto_increment primary key, fname varchar(50), lname varchar(50), email varchar(150), password varchar(50), role varchar(50), active varchar(10), image varchar(250));

create table folders (id int not null auto_increment primary key, uid int, foldername varchar(200), folderdesc varchar(200), path varchar(500), dor varchar(50));

create table files (id int not null auto_increment primary key, uid int, folderid int, filename varchar(200), uploaddate varchar(50), filetype varchar(250), filesize varchar(20),extension varchar(50));

create table permission (id int not null auto_increment primary key, uid int, fileid int, download varchar(25), view varchar(25), copy varchar(25), sharedid int, accept varchar(25), reject varchar(25), waiting varchar(25));

create table company (id int not null auto_increment primary key, institute varchar(250), city varchar(50), location varchar(250), address varchar(300));