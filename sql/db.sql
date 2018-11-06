DROP DATABASE IF EXISTS tptickets;
CREATE DATABASE tptickets;
use tptickets;

CREATE TABLE artists(
id_artist int AUTO_INCREMENT PRIMARY KEY,
name varchar(40)
);

INSERT INTO artists(name) 
VALUES
("Luis Miguel"),
("Metallica"),
("Red Hot Chili Peppers"),
("Bob Dylan"),
("Iron Maiden"),
("ZZ Top"),
("Rata Blanca");

CREATE TABLE categories(
id_category int AUTO_INCREMENT PRIMARY KEY,
type varchar(30)
);

INSERT INTO categories(type) 
VALUES
("Concierto"),
("Obra teatral");

CREATE TABLE events(
id_event int AUTO_INCREMENT PRIMARY KEY,
name varchar(60),
id_category int,
image varchar(60),
FOREIGN KEY(id_category) REFERENCES categories(id_category)
);

INSERT INTO events(name, id_category, image)
VALUES
("Luis Miguel en Argentina", 1, "imagen1.jpg"),
("Woodstock 2018", 1, "imagen2.jpg"),
("Una Obra Teatral Cualquiera", 2, "imagen3.jpg");

CREATE TABLE users(
id_user int AUTO_INCREMENT PRIMARY KEY,
email varchar(255),
password varchar(50),
first_name varchar(30),
last_name varchar(40),
is_admin boolean
);

INSERT INTO users(email, password, first_name, last_name, is_admin)
VALUES
("admin@tptickets.com", "lapassword", "El", "Admin", 1),
("user@email.com", "thecontra", "Sr", "Usuario", 0);
