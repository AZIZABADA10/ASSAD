CREATE DATABASE if NOT EXISTS assad;
use assad;
CREATE TABLE if not EXISTS utilisateurs (
    id_utilisateur int unsigned  AUTO_INCREMENT  PRIMARY KEY,
    nom_complet varchar(50),
    email varchar(256) UNIQUE,
    `role` ENUM('admin','visiteur','guide'),
    mot_de_passe varchar(255)
);


create user 'adminAssad'@'localhost' IDENTIFIED BY 'Assad@286';
grant all privileges on assad.* to 'adminAssad'@'localhost';


insert into utilisateurs (nom_complet,email,`role`,mot_de_passe) 
values ('administrateur','admin@assad.ma','admin','Assad@286');

ALTER TABLE utilisateurs 
MODIFY COLUMN statut_de_compet ENUM('active', 'blocked', 'en_attend');
