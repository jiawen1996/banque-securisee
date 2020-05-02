CREATE DATABASE devoir_sr03;

CREATE USER 'sr03'@'localhost' IDENTIFIED BY 'sr03';
GRANT ALL ON devoir_sr03.* TO 'sr03'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE users (
    id_user int AUTO_INCREMENT PRIMARY KEY,
    login varchar(20),
    mot_de_passe varchar(20),
    nom varchar(20),
    prenom varchar(20),
    numero_compte varchar(20),
    solde_compte float,
    profil_user varchar(7) CHECK (profil_user IN ('client', 'employe'))
);

CREATE VIEW v_client AS
SELECT
    *
FROM
    users
WHERE
    profil_user = 'client';

CREATE VIEW v_employe AS
SELECT
    *
FROM
    users
WHERE
    profil_user = 'employe';


CREATE TABLE messages (
    id_msg int AUTO_INCREMENT PRIMARY KEY,
    sujet_msg varchar(50),
    corps_msg text(200),
    id_user_to int,
    id_user_from int,
    FOREIGN KEY (id_user_to) REFERENCES users (id_user),
    FOREIGN KEY (id_user_from) REFERENCES users (id_user)
);
-- CHIFFRER DES MOTS DE PASSE AVANT INSERER
INSERT INTO users (login, mot_de_passe, profil_user, nom, prenom, numero_compte, solde_compte, mot_de_passe_virement) VALUES ('annab','annab','client', 'anna', 'beral', '0001', 100,'annav');
INSERT INTO users (login, mot_de_passe, profil_user, nom, prenom, numero_compte, solde_compte, mot_de_passe_virement) VALUES ('davidd','davidd','employe', 'david', 'dupont', '0002', 100,'davidv');
INSERT INTO users (login, mot_de_passe, profil_user, nom, prenom, numero_compte, solde_compte, mot_de_passe_virement) VALUES ('beanj','beanj','employe', 'bean', 'jackson', '0003', 100,'beanv');
INSERT INTO users (login, mot_de_passe, profil_user, nom, prenom, numero_compte, solde_compte, mot_de_passe_virement) VALUES ('billyw','billyw','employe', 'bean', 'jackson', '0003', 100,'billyv');

