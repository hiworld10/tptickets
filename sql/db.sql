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