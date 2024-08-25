CREATE DATABASE jmk_travel;

USE jmk_travel;

-- Table 'role'
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table 'user'
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    noms VARCHAR(300) NOT NULL,
    sexe VARCHAR(2) NOT NULL,
    password VARCHAR(255) NOT NULL,
    etat BOOLEAN DEFAULT TRUE,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES role(id)
);

-- Table 'compagnie'
CREATE TABLE compagnie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(255),
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table 'vol'
CREATE TABLE vol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ville_depart VARCHAR(100) NOT NULL,
    ville_arrivee VARCHAR(100) NOT NULL,
    date_vol_depart DATETIME NOT NULL,
    date_vol_arrivee DATETIME NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    compagnie_id INT,
    FOREIGN KEY (compagnie_id) REFERENCES compagnie(id)
);

-- Table 'mon_vol'
CREATE TABLE mon_vol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nbre_adulte INT NOT NULL,
    nbre_bebe INT NOT NULL,
    nbre_enfant INT NOT NULL,
    vol_id INT,
    user_id INT,
    FOREIGN KEY (vol_id) REFERENCES vol(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Table 'paiement'
CREATE TABLE paiement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10, 2) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    mon_vol_id INT,
    FOREIGN KEY (mon_vol_id) REFERENCES mon_vol(id)
);
