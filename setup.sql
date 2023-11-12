-- run this sql file before using

create database if not exists ivms;
use ivms;
set @key = SHA1('upflb');

-- TODO: create tables, add foreign keys, etc.
create table if not exists staff (
    uname varchar(20) NOT NULL,
    passwd char(60) NOT NULL,
    fname varchar(20) NOT NULL,
    lname varchar(20) NOT NULL,
    branch varchar(20) NOT NULL,
    PRIMARY KEY (uname)
);

-- TODO: maybe create a new sql user with some restriction on privileges.