-- Run this sql file before using

-- TODO: maybe create a new sql user with some restriction on privileges.

CREATE DATABASE IF NOT EXISTS ivms;
USE ivms;

-- define user staff and hr, 

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
    managerflag CHAR(1)         NOT NULL,             
    PRIMARY KEY (uname),
    FOREIGN KEY (branch)        REFERENCES branch (branch)
);

-- create inventory

CREATE TABLE IF NOT EXISTS inventory (
    lot_id      INT             NOT NULL AUTO_INCREMENT,
    i_name      VARCHAR(20)     NOT NULL,
    i_type      VARCHAR(20)     NOT NULL,
    quantity    INT             NOT NULL,
    price       INT             NOT NULL,
    branch      VARCHAR(20)     NOT NULL,
    PRIMARY KEY (lot_id),
    FOREIGN KEY (branch)        REFERENCES branch (branch)
);

-- create warehouse

CREATE TABLE IF NOT EXISTS warehouse (
    ware_id     INT             NOT NULL AUTO_INCREMENT,
    w_address   VARCHAR(30)     NOT NULL,
    PRIMARY KEY (ware_id)
);

-- create shipment

CREATE TABLE IF NOT EXISTS shipment (
    ship_id     INT             NOT NULL AUTO_INCREMENT,
    uname       VARCHAR(20)     NOT NULL,
    branch      VARCHAR(20)     NOT NULL,
    lot_id      INT             NOT NULL,
    ware_id     INT             NOT NULL,
    ship_mthd   VARCHAR(20)     NOT NULL,
    PRIMARY KEY (ship_id),
    FOREIGN KEY (uname)         REFERENCES staff (uname)     ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (lot_id)        REFERENCES inventory (lot_id),
    FOREIGN KEY (branch)        REFERENCES branch (branch),
    FOREIGN KEY (ware_id)       REFERENCES warehouse (ware_id)
);

-- insert warehouses

INSERT INTO warehouse (w_address) VALUES ("Rangsit"), ("Bangkadi"), ("Hatyai"), ("Tokyo");

CREATE TRIGGER shipment_delete BEFORE DELETE ON shipment
FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'table shipment does not support deletion';

CREATE USER 'staff'@'localhost' IDENTIFIED BY 'staff';
CREATE USER 'manager'@'localhost' IDENTIFIED BY 'manager';

GRANT ALL PRIVILEGES ON ivms.* to 'manager'@'localhost';
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON ivms.staff to 'staff'@'localhost';
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON ivms.branch to 'staff'@'localhost';
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON ivms.inventory to 'staff'@'localhost';
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON ivms.warehouse to 'staff'@'localhost';
FLUSH PRIVILEGES;
GRANT SELECT, INSERT ON ivms.shipment to 'staff'@'localhost';
FLUSH PRIVILEGES;
