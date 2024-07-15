CREATE
DATABASE autopark
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE
autopark;

CREATE TABLE parks
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(128)
);

CREATE TABLE cars
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    park_id INT,
    model   VARCHAR(128),
    price   FLOAT
);

CREATE TABLE drivers
(
    id     INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT,
    name   VARCHAR(128),
    phone  VARCHAR(128)
);

CREATE TABLE orders
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    driver_id   INT,
    customer_id INT,
    start       TEXT,
    finish      TEXT,
    total       FLOAT
);

CREATE TABLE customers
(
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(128),
    phone VARCHAR(128)
);