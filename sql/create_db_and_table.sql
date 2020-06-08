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
    userId                          int                       not null  Auto_increment,
    userLastName            varchar(75)         not null,
    userFirstName           varchar(75)         not null, 
    userEmail                   varchar(100)       not null,
    userPassword            varchar(255)         not null,
    userSalt                      varchar(255)         not null,
    accountCreated_at       datetime     not null,
    userRole                    varchar(20)             not null  DEFAULT 'Member',
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
    produitavailable                boolean             not null DEFAULT 1,
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
