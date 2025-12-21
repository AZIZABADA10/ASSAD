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


CREATE TABLE habitats (
    id_habitat int primary key AUTO_INCREMENT,
    nom_habitat varchar(250),
    type_climat varchar(250),
    description_habitat varchar(250),
    zonezoo varchar(250)
);

CREATE TABLE animal (
    id_animal int primary key AUTO_INCREMENT,
    nom_animal varchar(150),
    espace varchar(150),
    alimentation varchar(100),
    image_animal varchar(250),
    pays_origine varchar(250),
    description_courte varchar(250),
    id_habitat int,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id_habitat)
);
  

CREATE TABLE IF NOT EXISTS visitesguidees (
    id_visite INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(250) NOT NULL,
    date_heure DATETIME NOT NULL,
    langue VARCHAR(100),
    capacite_max INT,
    statut ENUM('ouverte','complete','annulee') DEFAULT 'ouverte',
    duree INT COMMENT 'Durée en minutes',
    prix DECIMAL(8,2)
);


CREATE TABLE IF NOT EXISTS etapesvisite (
    id_etape INT AUTO_INCREMENT PRIMARY KEY,
    titreetape VARCHAR(250) NOT NULL,
    descriptionetape TEXT,
    ordreetape INT,
    id_visite INT NOT NULL,
    CONSTRAINT fk_etape_visite
        FOREIGN KEY (id_visite)
        REFERENCES visitesguidees(id_visite)
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_visite INT NOT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,
    nb_personnes INT NOT NULL,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservation_visite
        FOREIGN KEY (id_visite)
        REFERENCES visitesguidees(id_visite)
        ON DELETE CASCADE,
    CONSTRAINT fk_reservation_utilisateur
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateurs(id_utilisateur)
        ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS commentaires (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    id_visite INT NOT NULL,
    id_utilisateur INT NOT NULL,
    note INT,
    texte TEXT,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commentaire_visite
        FOREIGN KEY (id_visite)
        REFERENCES visitesguidees(id_visite)
        ON DELETE CASCADE,
    CONSTRAINT fk_commentaire_utilisateur
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateurs(id_utilisateur)
        ON DELETE CASCADE
);



ALTER TABLE visitesguidees
ADD COLUMN id_guide INT UNSIGNED NOT NULL AFTER id_visite,
ADD CONSTRAINT fk_visite_guide
  FOREIGN KEY (id_guide) REFERENCES utilisateurs(id_utilisateur);


ALTER TABLE visitesguidees
ADD COLUMN description TEXT AFTER titre;
