-- ============================================================
-- TP 7 : Conception et CRUD multi-entités
-- Base : tp7_crud  (centre de formation)
-- ============================================================
DROP DATABASE IF EXISTS tp7_crud;
CREATE DATABASE tp7_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tp7_crud;

-- Table FORMATION (côté "1" des deux relations)
CREATE TABLE formation (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    titre        VARCHAR(100) NOT NULL,
    description  TEXT,
    duree_mois   INT NOT NULL
) ENGINE=InnoDB;

-- Table ETUDIANT (N étudiants -> 1 formation)
CREATE TABLE etudiant (
    id_etudiant  INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(50)  NOT NULL,
    prenom       VARCHAR(50)  NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    id_formation INT NOT NULL,
    CONSTRAINT fk_etudiant_formation FOREIGN KEY (id_formation)
        REFERENCES formation(id_formation)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table MODULE (N modules -> 1 formation)
CREATE TABLE module (
    id_module     INT AUTO_INCREMENT PRIMARY KEY,
    titre         VARCHAR(100) NOT NULL,
    nombre_heures INT NOT NULL,
    id_formation  INT NOT NULL,
    CONSTRAINT fk_module_formation FOREIGN KEY (id_formation)
        REFERENCES formation(id_formation)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Données de test
INSERT INTO formation (titre, description, duree_mois) VALUES
('Développement Web Full Stack', 'HTML, CSS, JavaScript, PHP et MySQL', 12),
('Administration Réseaux', 'Configuration et sécurité des réseaux', 10),
('Data Analyst', 'Analyse et visualisation de données', 8);

INSERT INTO etudiant (nom, prenom, email, id_formation) VALUES
('Alaoui',  'Sara',   'sara.alaoui@example.com',   1),
('Bennani', 'Youssef','youssef.bennani@example.com',1),
('Cherkaoui','Imane', 'imane.cherkaoui@example.com',2),
('Daoudi',  'Omar',   'omar.daoudi@example.com',   3);

INSERT INTO module (titre, nombre_heures, id_formation) VALUES
('HTML & CSS', 30, 1),
('PHP & PDO', 45, 1),
('MySQL', 35, 1),
('Routage et commutation', 50, 2),
('Sécurité réseau', 40, 2),
('Python pour la data', 45, 3),
('Visualisation de données', 30, 3);
