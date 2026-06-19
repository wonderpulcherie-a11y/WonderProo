CREATE DATABASE IF NOT EXISTS wonderprotest;
USE wonderprotest;

-- 1. TABLE MÈRE : UTILISATEUR (Clé primaire VARCHAR)
CREATE TABLE utilisateur(
    id_utilisateur CHAR(36) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    email VARCHAR(150) UNIQUE NOT NULL,
    telephone VARCHAR(20) UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    type_utilisateur ENUM('Visiteur','Entreprise','Admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. TABLE ENFANT : ADMIN
CREATE TABLE admin(
    id_admin VARCHAR(50) PRIMARY KEY,
    profil VARCHAR(255),
    id_utilisateur CHAR(36) UNIQUE NOT NULL,
    FOREIGN KEY(id_utilisateur)
    REFERENCES utilisateur(id_utilisateur)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABLE ENFANT : VISITEUR
CREATE TABLE visiteur(
    id_visiteur VARCHAR(50) PRIMARY KEY,
    age INT,
    profil VARCHAR(255),
    id_utilisateur CHAR(36) UNIQUE NOT NULL,
    FOREIGN KEY(id_utilisateur)
    REFERENCES utilisateur(id_utilisateur)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABLE ENFANT : ENTREPRISE
CREATE TABLE entreprise(
    id_entreprise VARCHAR(50) PRIMARY KEY,
    nom_entreprise VARCHAR(150) NOT NULL,
    quartier VARCHAR(100),
    description TEXT,
    nombre_vues INT DEFAULT 0,
    RCCM VARCHAR(100) UNIQUE,
    site_web VARCHAR(150),
    statut ENUM(
        'en attente',
        'valide',
        'rejete',
        'desactive'
    ) DEFAULT 'en attente',
    logo VARCHAR(255),
    essai_utilise TINYINT(1) DEFAULT 0, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    id_utilisateur CHAR(36) UNIQUE NOT NULL,
    FOREIGN KEY(id_utilisateur)
    REFERENCES utilisateur(id_utilisateur),
    INDEX(nom_entreprise),
    INDEX(quartier)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE entreprise
ADD document_rccm VARCHAR(255) NULL;

-- 5. DOMAINE D'ACTIVITÉ
CREATE TABLE domaine_activite(
    id_domaine VARCHAR(50) PRIMARY KEY,
    nom_domaine VARCHAR(100) UNIQUE NOT NULL,
    description TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. TABLE D'ASSOCIATION : APPARTENANCE (Entreprise <-> Domaine)
CREATE TABLE appartenance(
    id_entreprise VARCHAR(50),
    id_domaine VARCHAR(50),
    date_appartenance DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_entreprise, id_domaine),
    FOREIGN KEY(id_entreprise) REFERENCES entreprise(id_entreprise),
    FOREIGN KEY(id_domaine) REFERENCES domaine_activite(id_domaine)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. SERVICE
CREATE TABLE service(
    id_service VARCHAR(50) PRIMARY KEY,
    libelle VARCHAR(100) UNIQUE NOT NULL,
    description TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. TABLE D'ASSOCIATION : PROPOSITION (Entreprise <-> Service)
CREATE TABLE proposition(
    id_entreprise VARCHAR(50),
    id_service VARCHAR(50),
    date_proposition DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_entreprise, id_service),
    FOREIGN KEY(id_entreprise) REFERENCES entreprise(id_entreprise),
    FOREIGN KEY(id_service) REFERENCES service(id_service)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. ABONNEMENT
CREATE TABLE abonnement(
    id_abonnement VARCHAR(50) PRIMARY KEY,
    type_abonnement ENUM(
        'essai',
        '3_mois',
        '6_mois',
        '1_an'
    ) NOT NULL,
    duree_jours INT NOT NULL,
    prix DECIMAL(10,0) NOT NULL,
    limite_annonces INT DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
UPDATE abonnement
SET limite_annonces = 10
WHERE id_abonnement = 'STANDARD';

UPDATE abonnement

SET limite_annonces = 30
WHERE id_abonnement = 'VIP';

UPDATE abonnement
SET limite_annonces = NULL
WHERE id_abonnement = 'VVIP';

-- 10. PAIEMENT
CREATE TABLE paiement(
    id_paiement VARCHAR(50) PRIMARY KEY,
    date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
    montant DECIMAL(10,0) NOT NULL,
    mode_paiement ENUM(
        'Orange Money',
        'MTN Mobile Money',
        'Carte Bancaire'
    ) NOT NULL,
    statut_paiement ENUM(
        'en_attente',
        'effectue',
        'echoue'
    ) DEFAULT 'en_attente',
    reference_transaction VARCHAR(100) UNIQUE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE paiement ADD id_souscription VARCHAR(50);
ALTER TABLE paiement ADD CONSTRAINT fk_paiement_souscription
FOREIGN KEY(id_souscription)
REFERENCES souscription(id_souscription);

CREATE TABLE souscription(
    id_souscription VARCHAR(50) PRIMARY KEY,
    id_entreprise VARCHAR(50) NOT NULL,
    id_abonnement VARCHAR(50) NOT NULL,
    id_paiement VARCHAR(50),
    date_souscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_expiration DATETIME NOT NULL,
    statut ENUM(
        'actif',
        'expire'
    ) DEFAULT 'actif',
    FOREIGN KEY(id_entreprise)
        REFERENCES entreprise(id_entreprise),
    FOREIGN KEY(id_abonnement)
        REFERENCES abonnement(id_abonnement),
    FOREIGN KEY(id_paiement)
        REFERENCES paiement(id_paiement)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 11. DEMANDE INSCRIPTION
CREATE TABLE demande_inscription(
    id_demande VARCHAR(50) PRIMARY KEY,
    statut ENUM('en attente', 'valide', 'rejete') DEFAULT 'en attente',
    date_demande DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_entreprise VARCHAR(50) NOT NULL,
    FOREIGN KEY(id_entreprise) REFERENCES entreprise(id_entreprise)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 12. ANNONCE

CREATE TABLE annonce(
    id_annonce VARCHAR(50) PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATETIME
    DEFAULT CURRENT_TIMESTAMP,
    id_entreprise VARCHAR(50) NOT NULL,
    FOREIGN KEY(id_entreprise)
    REFERENCES entreprise(id_entreprise)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE annonce ADD image VARCHAR(255) NULL;
ALTER TABLE annonce
ADD date_debut DATE NOT NULL,
ADD date_fin DATE NOT NULL;

-- 13. COMMENTAIRE
CREATE TABLE commentaire(
    id_commentaire VARCHAR(50) PRIMARY KEY,
    description TEXT NOT NULL,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,

    id_visiteur VARCHAR(50) NOT NULL,
    id_entreprise VARCHAR(50) NOT NULL,

    FOREIGN KEY(id_visiteur)
        REFERENCES visiteur(id_visiteur),

    FOREIGN KEY(id_entreprise)
        REFERENCES entreprise(id_entreprise)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE commentaire
ADD note TINYINT NOT NULL
CHECK (note BETWEEN 1 AND 5);

-- USE wonderpro;

-- -- 1. On vide la table
-- DELETE TABLE domaine_activite;

-- -- 2. On réinsère les données avec des accents propres
INSERT INTO domaine_activite (id_domaine, nom_domaine, description) VALUES 
('dom_sante01', 'Sante', 'Cliniques, pharmacies, laboratoires...'),
('dom_info02', 'Informatique', 'Developpement, maintenance, reseaux...'),
('dom_comm03', 'Commerce', 'Boutiques, magasins, supermarches...'),
('dom_educ04', 'Education', 'Ecoles, universites, formations...');

INSERT INTO abonnement
(
    id_abonnement,
    type_abonnement,
    duree_jours,
    prix,
    limite_annonces
)
VALUES
(
    'ABO-ESSAI',
    'essai',
    90,
    0,
    1
),
(
    'STANDARD',
    '3_mois',
    90,
    5000,
    NULL
),
(
    'VIP',
    '6_mois',
    180,
    9000,
    NULL
),
(
    'VVIP',
    '1_an',
    365,
    15000,
    NULL
);


INSERT INTO utilisateur
(
    id_utilisateur,
    nom,
    prenom,
    email,
    telephone,
    mot_de_passe,
    type_utilisateur
)
VALUES
(
    'USR-ADMIN',
    'Super',
    'Admin',
    'admin@wonderpro.com',
    '670000000',
    '$2y$10$Ke2nXmpLNlBCXvP4aIr9Z./NMS0IgsTfCZagvjeO6rBL.7ML4rucG',
    'Admin'
);

UPDATE abonnement
SET duree_jours = 90
WHERE id_abonnement = 'ABO-ESSAI';



-- -- 1. Insertion de deux utilisateurs génériques
-- INSERT INTO utilisateur (id_utilisateur, nom, prenom, type_utilisateur) VALUES 
-- ('usr_0192a3b4', 'Kamdem', 'Pierre', 'Entreprise'),
-- ('usr_0567c8d9', 'Tchinda', 'Alain', 'Entreprise');

-- -- 2. Insertion de deux entreprises liées à ces utilisateurs (Quartiers de Bafoussam)
-- INSERT INTO entreprise (id_entreprise, nom_entreprise, mot_de_passe, quartier, telephone, description, email, statut, logo, id_utilisateur) VALUES 
-- ('ent_wondertech777', 'Wonder Tech', '123456', 'Tamja', '677112233', 'Développement web, maintenance et réseaux informatiques.', 'contact@wondertech.cm', 'valide', 'logo_simple_wonderpro.png', 'usr_0192a3b4'),
-- ('ent_saintluc888', 'Clinique Saint Luc', '123456', 'Djeleng', '699445566', 'Consultation, laboratoire et pharmacie moderne.', 'info@saintluc.cm', 'valide', 'logo_simple_wonderpro.png', 'usr_0567c8d9');
-- DELETE FROM utilisateur;
-- DELETE FROM entreprise;

-- -- 1. INSÉRER L'UTILISATEUR (Avec un ID unique 'USER-WONDER-99')
-- INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `type_utilisateur`) 
-- VALUES ('USER-WONDER-99', 'Wonder', 'Pulcherie', 'Entreprise');

-- -- 2. S'ASSURER QUE LE DOMAINE INFORMATIQUE EXISTE AVEC L'ID 'DOM-INFO-99'
-- INSERT INTO `domaine_activite` (`id_domaine`, `nom_domaine`, `description`) 
-- VALUES ('DOM-INFO-99', 'Informatique', 'Développement de logiciels, applications web et mobiles.')
-- ON DUPLICATE KEY UPDATE id_domaine=id_domaine;

-- -- 3. INSÉRER L'ENTREPRISE (Liée à l'utilisateur 'USER-WONDER-99')
-- INSERT INTO `entreprise` (
--     `id_entreprise`, `nom_entreprise`, `mot_de_passe`, `quartier`, 
--     `telephone`, `description`, `email`, `statut`, `id_utilisateur`
-- ) VALUES (
--     'ENT-WONDER-99', 
--     'Wonder Tech', 
--     'pass_entreprise_123', 
--     'Akwa', 
--     '+237 692 11 23 88', 
--     'Développement d\'applications web et mobiles, installation de réseaux et maintenance informatique.', 
--     'contact@wondertech.cm', 
--     'valide', 
--     'USER-WONDER-99'
-- );

-- -- 4. INSÉRER LA RELATION DANS LA TABLE APPARTENANCE
-- INSERT INTO `appartenance` (`id_entreprise`, `id_domaine`) 
-- VALUES ('ENT-WONDER-99', (SELECT id_domaine FROM domaine_activite WHERE nom_domaine = 'Informatique' LIMIT 1));