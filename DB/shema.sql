CREATE DATABASE assad;
USE assad;

DROP TABLE utilisateurs;
CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(50) NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL,
    `role` ENUM('admin','visiteur','guide') NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    statut_de_compet ENUM('active','blocked','en_attente') DEFAULT 'active'
);


-- CREATE USER 'adminAssad'@'localhost'
-- IDENTIFIED BY 'Assad@286';

-- GRANT ALL PRIVILEGES ON assad.* TO 'adminAssad'@'localhost';
-- FLUSH PRIVILEGES;


INSERT INTO utilisateurs (nom_complet, email, `role`, mot_de_passe)
VALUES (
    'Administrateur',
    'admin@assad.ma',
    'admin',
    '$2y$10$Jv6f23innul92p/lXtELOO0Coi9TKTSJz.Ks2R/hMueEomcX56Biu'
);


CREATE TABLE habitats (
    id_habitat INT AUTO_INCREMENT PRIMARY KEY,
    nom_habitat VARCHAR(250) NOT NULL,
    type_climat VARCHAR(250),
    description_habitat VARCHAR(250),
    zone_zoo VARCHAR(250)
);


CREATE TABLE animal (
    id_animal INT AUTO_INCREMENT PRIMARY KEY,
    nom_animal VARCHAR(150) NOT NULL,
    espace VARCHAR(150),
    alimentation VARCHAR(100),
    image_animal VARCHAR(250),
    pays_origine VARCHAR(250),
    description_courte VARCHAR(250),
    id_habitat INT,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id_habitat)
);


CREATE TABLE visitesguidees (
    id_visite INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(250) NOT NULL,
    description TEXT,
    date_heure DATETIME NOT NULL,
    langue VARCHAR(100),
    capacite_max INT,
    statut ENUM('ouverte','complete','annulee') DEFAULT 'ouverte',
    duree INT,
    prix DECIMAL(8,2),
    id_guide INT,
    FOREIGN KEY (id_guide) REFERENCES utilisateurs(id_utilisateur)
);


CREATE TABLE etapesvisite (
    id_etape INT AUTO_INCREMENT PRIMARY KEY,
    titreetape VARCHAR(250) NOT NULL,
    descriptionetape TEXT,
    ordreetape INT,
    id_visite INT,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees(id_visite)
);


CREATE TABLE reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_visite INT,
    id_utilisateur INT,
    nb_personnes INT,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en_attente','confirmee','annulee') DEFAULT 'en_attente',
    FOREIGN KEY (id_visite) REFERENCES visitesguidees(id_visite),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

CREATE TABLE commentaires (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    id_visite INT,
    id_utilisateur INT,
    note INT CHECK (note BETWEEN 1 AND 5),
    texte TEXT,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_visite) REFERENCES visitesguidees(id_visite),
        FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);
