-- Run this sql file before using

CREATE DATABASE IF NOT EXISTS ivms;
USE ivms;

-- TODO: create tables, add foreign keys, etc.
CREATE TABLE IF NOT EXISTS staff (
    uname       VARCHAR(20)     NOT NULL    PRIMARY KEY,
    passwd      CHAR(60)        NOT NULL,
    fname       VARCHAR(20)     NOT NULL,
    lname       VARCHAR(20)     NOT NULL,
    branch      VARCHAR(20)     NOT NULL
);

-- TODO: maybe create a new sql user with some restriction on privileges.