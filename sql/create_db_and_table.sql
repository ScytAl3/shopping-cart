#------------------------------------------------------------
#                        Script MySQL.
#------------------------------------------------------------
#-- creation de la base de donnees si elle n existe pas
CREATE DATABASE IF NOT EXISTS db_gestion_panier;
#-- on precise que l on va utiliser cette datbase pour creer les tables
USE db_gestion_panier;

#------------------------------------------------------------
# Table: USERS
#------------------------------------------------------------

CREATE TABLE users (
    userId                     int                       not null  Auto_increment,
    userLastName        varchar(75)         not null,
    userFirstName       varchar(75)         not null, 
    userEmail               varchar(100)       not null,
    userPassword         varchar(255)         not null,
    userSalt                    varchar(255)         not null,
    accountCreated_at               datetime     not null,
    userRole                varchar(20)             not null DEFAULT 'Default',
    CONSTRAINT users_PK PRIMARY KEY (userId),
    UNIQUE KEY unique_email (userEmail)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: PRODUITS
#------------------------------------------------------------

CREATE TABLE produits (
    produitsId                       int                        not null Auto_increment,
    produitsName                   varchar(255)        not null,
    produitsDescription        varchar(255)       not null,
    produitsQuantite                int                     not null,
    produitsPrix                        decimal(5, 2) not null,
    created_at                       datetime               not null,
    CONSTRAINT produits_PK PRIMARY KEY (produitsId)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: PICTURES
#------------------------------------------------------------

CREATE TABLE pictures (
    picturesId                   int                    not null  Auto_increment,
    produitsId                    int                    not null,    
    pictureFilename         varchar(100)    ,
    CONSTRAINT pictures_PK PRIMARY KEY (picturesId),
    FOREIGN KEY (produitsId) REFERENCES produits(produitsId)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: PANIERS
#------------------------------------------------------------

CREATE TABLE paniers (
    paniersId                       int                        not null Auto_increment,
    panierUserTemp              varchar(100)    not null,
    created_at                       datetime               not null,
    CONSTRAINT paniers_PK PRIMARY KEY (paniersId)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: LIGNE_COMMANDE
#------------------------------------------------------------
CREATE TABLE lignes_commande (
    ligneCmdId              int                       not null Auto_increment,
    paniersId                   int                      not null,
    produitsId                 int                      not null,
    quantite                    int                     not null,
    prixTotal                 decimal(5, 2) not null,
    CONSTRAINT lignes_commande_PK PRIMARY KEY (ligneCmdId),
    FOREIGN KEY (paniersId) REFERENCES paniers(paniersId),
    FOREIGN KEY (produitsId) REFERENCES produits(produitsId)
) ENGINE=InnoDB;

#-----------------------------------------------------------
#                     JEU DE DONNEES
#-----------------------------------------------------------
#-----------------------------------------------------------
# Table: USERS - Data
#-----------------------------------------------------------

INSERT INTO 
    users(userLastName, userFirstName, userEmail, userPassword, userSalt, accountCreated_at, userRole) 
VALUES 
    ('Doe', 'John', 'j.doe@cci.fr', '54e4feb636204d1e5fcf49fb202946db', 'b7c8cb5b20beb2733470a65bb59722de', '2020-02-20 13:29:09', 'Admin'),              -- az3rty
    ( 'Jobs', 'Steve', 'amazing@rip.com', '1f1c153c6717024f825a862901f9c3bc', '476e62fcde5fcaa1e7fc2629da120ce9', '2020-02-20 15:29:09', 'Admin'),                  -- 4pple 
    ('Tuttle', 'Archibald', 'harry.tuttle@br.com', '78169d67d449272b6bad1438b75bf4fe', '1641b4d0b9a50afbadb3cedf983c9cd1', '2020-02-21 16:25:49', DEFAULT),    -- Ninj4
    ('Bismuth', 'Paul', 'ns-2017@lr.fr', 'b4f56e6dca3905a5b3f4e73058ba2ab2', '5e406044172b4831cf110e63b51f0b47', '2020-02-22 19:15:25', DEFAULT),                   -- Sark0
    ('Balkany', 'Patrick', 'la-sante@gouv.fr', '4fcf95ce8284291469466c0b2aecaed8', '61a722aee2cc2e539778622bc7ee7c4d', '2020-02-22 21:09:27', DEFAULT),             -- money
    ('Abagnale', 'Frank', 'catch.me@noop.fr', 'a87f2462177f71232e05bd00f68675ef', '5d969f98d53259fe94d0245eb8d3ac26', '2020-02-22 12:04:49', DEFAULT);          -- c4tchM3

#-----------------------------------------------------------
# Table: Produits - Data
#-----------------------------------------------------------
INSERT INTO
    produits(`produitsName`, `produitsDescription`, `produitsQuantite`, `produitsPrix`, `created_at`)
VALUES
    ('Produit 01', 'Est at possimus et deserunt. Dicta sed amet ipsum dolorem quam adipisci pariatur.', 99, 87.55, '2020-02-18 13:29:09'),
    ('Produit 02', 'Qui modi nam consectetur eius quia possimus omnis adipisci. Cupiditate sed sed aut.', 99,  55.25, '2020-02-19 17:59:20'),
    ('Produit 03', 'Sit dolores maiores voluptates sint.', 99, 25.85, '2020-02-19 18:19:34'),
    ('Produit 04', 'Maiores similique sit voluptas.', 99, 75.65,  '2020-02-20 08:29:18'),
    ('Produit 05', 'Quasi ipsa est unde illo.', 99, 45.55,  '2020-02-20 13:59:58'),
    ('Produit 06', 'Possimus reprehenderit odit et error.', 99, 48.95, '2020-02-24 15:19:08'),
    ('Produit 07', 'Excepturi laborum ut voluptates consequuntur adipisci dolores sit iusto.', 99, 84.25, '2020-02-25 11:54:48');

#-----------------------------------------------------------
# Table: PICTURES - Data
#-----------------------------------------------------------
INSERT INTO
    pictures(`produitsId`,`pictureFilename`)
VALUES
    (1, null),
    (2, null),
    (3, null),
    (4, null),
    (5, null),
    (6, null),
    (7, null);
