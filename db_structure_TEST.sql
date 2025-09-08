CREATE DATABASE IF NOT EXISTS video_inventory_system_TEST;

USE video_inventory_system_TEST;

CREATE TABLE IF NOT EXISTS types_of_user (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO types_of_user (name)
VALUES ("super_usuario"),
("administrador"),
("inspector"),
("responsable"),
("verificador");

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
VALUES ("super usuario", md5('123'), 1),
("administrador", md5('123'), 2),
("inspector", md5('123'), 3),
("responsable", md5('123'), 4)
("verificador", md5('123'), 5);

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

CREATE TABLE IF NOT EXISTS types_of_activities (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO types_of_activities (name)
VALUES ("pauta"),
("prestamo"),
("en almacen");

CREATE TABLE IF NOT EXISTS equipments (
  id INT NOT NULL AUTO_INCREMENT,
  equipment_category_id INT NOT NULL,
  type_of_equipment_id INT NOT NULL,
  equipment_status_id INT NOT NULL,
  image_path VARCHAR(255),
  qr_equipment_image VARCHAR(255),
  last_verification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  note VARCHAR(255),
  is_deleted BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(equipment_category_id) REFERENCES equipment_categories(id),
  FOREIGN KEY(type_of_equipment_id) REFERENCES equipment_types(id),
  FOREIGN KEY(equipment_status_id) REFERENCES equipments_status(id)
);

INSERT INTO equipments (equipment_category_id, type_of_equipment_id, equipment_status_id, image_path, qr_equipment_image, note, is_deleted)
VALUES (1, 1, 1, "default_image.png", "default_qr.png", '', 0),
(2, 3, 2, "default_image.png", "default_qr.png", '', 0),
(1, 2, 1, "default_image.png", "default_qr.png", '', 0);

CREATE TABLE IF NOT EXISTS warehouses (
  id INT NOT NULL AUTO_INCREMENT,
  equipment_id INT NOT NULL,
  in_the_warehouse BOOLEAN NOT NULL,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  type_of_activity_id INT NOT NULL,
  activity VARCHAR(255) NOT NULL,
  responsible_id INT NOT NULL,
  verified_by_id INT NOT NULL,
  is_deleted BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(equipment_id) REFERENCES equipments(id),
  FOREIGN KEY(type_of_activity_id) REFERENCES types_of_activities(id),
  FOREIGN KEY(responsible_id) REFERENCES users(id),
  FOREIGN KEY(verified_by_id) REFERENCES users(id)
);

INSERT INTO warehouses (equipment_id, in_the_warehouse, type_of_activity_id, activity, responsible_id, verified_by_id, is_deleted)
VALUES (1, 0, 1, "video del parque", 4, 3, 0),
(2, 0, 2, "sesion en la playa", 4, 3, 0),
(3, 1, 3, "almacenado", 4, 3, 0);
