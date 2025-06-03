CREATE DATABASE IF NOT EXISTS video_inventory_system;

USE video_inventory_system;

CREATE TABLE IF NOT EXISTS types_of_user (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO types_of_user (name)
VALUES ("super_usuario"),
("administrador"),
("inspector"),
("responsable");

CREATE TABLE IF NOT EXISTS equipment_categories (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO equipment_categories (name)
VALUES ("camaras"),
("luces");

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  nickname VARCHAR(100) NOT NULL,
  password VARCHAR(32) NOT NULL,
  user_type_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(user_type_id) REFERENCES types_of_user(id)
);

INSERT INTO users (nickname, password, user_type_id)
VALUES ("super usuario", md5('123'), 1);

CREATE TABLE IF NOT EXISTS equipment_types (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  equipment_type_category_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(equipment_type_category_id) REFERENCES equipment_categories(id)
);

INSERT INTO equipment_types (name, equipment_type_category_id)
VALUES ("grande", 1),
("small", 1),
("incandecentes", 2),
("led", 2);

CREATE TABLE IF NOT EXISTS equipments_status (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO equipments_status (name)
VALUES ("operativo"),
("averiado");


