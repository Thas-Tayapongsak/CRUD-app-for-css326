-- Run this sql file before using

-- TODO: maybe create a new sql user with some restriction on privileges.

CREATE DATABASE IF NOT EXISTS ivms;
USE ivms;

-- TODO: create tables, add foreign keys, etc.

CREATE TABLE IF NOT EXISTS branch (
    branch      VARCHAR(20)     NOT NULL,
    b_address   VARCHAR(30)     NOT NULL,
    b_email     VARCHAR(30)     NOT NULL,
    b_tel       CHAR(10)        NOT NULL,
    PRIMARY KEY (branch)
);

CREATE TABLE IF NOT EXISTS staff (
    uname       VARCHAR(20)     NOT NULL,
    passwd      CHAR(60)        NOT NULL,
    fname       VARCHAR(20)     NOT NULL,
    lname       VARCHAR(20)     NOT NULL,
    dateofbirth DATE            NOT NULL,
    branch      VARCHAR(20)     NOT NULL,
    PRIMARY KEY (uname),
    FOREIGN KEY (branch) REFERENCES branch (branch)
);

-- create inventory

-- create warehouse

-- create shipment