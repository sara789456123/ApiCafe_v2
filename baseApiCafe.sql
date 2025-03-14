#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

DROP DATABASE IF EXISTS apicafe;
CREATE DATABASE IF NOT EXISTS apicafe;
USE apicafe;


#------------------------------------------------------------
# Table: marque
#------------------------------------------------------------

CREATE TABLE marque(
        id  Int  Auto_increment  NOT NULL ,
        nom Varchar (100) NOT NULL
	,CONSTRAINT marque_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: continent
#------------------------------------------------------------

CREATE TABLE continent(
        id  Int  Auto_increment  NOT NULL ,
        nom Varchar (50) NOT NULL
	,CONSTRAINT continent_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pays
#------------------------------------------------------------

CREATE TABLE pays(
        id           Int  Auto_increment  NOT NULL ,
        nom          Varchar (200) NOT NULL ,
        id_continent Int NOT NULL
	,CONSTRAINT pays_PK PRIMARY KEY (id)

	,CONSTRAINT pays_continent_FK FOREIGN KEY (id_continent) REFERENCES continent(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: utilisateur
#------------------------------------------------------------
CREATE TABLE utilisateur (
    login VARCHAR (150) NOT NULL PRIMARY KEY,
    mdp VARCHAR(150) NOT NULL,
    token VARCHAR(300) NULL,
    admin boolean NULL DEFAULT NULL
    )

#------------------------------------------------------------
# Table: dosette
#------------------------------------------------------------


CREATE TABLE dosette(
        id        Int  Auto_increment  NOT NULL ,
        nom       Varchar (100) NOT NULL ,
        intensite Int NOT NULL ,
        prix      Decimal (4,2) NOT NULL ,
        id_marque Int NOT NULL ,
        id_pays   Int NOT NULL
	,CONSTRAINT dosette_PK PRIMARY KEY (id)

	,CONSTRAINT dosette_marque_FK FOREIGN KEY (id_marque) REFERENCES marque(id)
	,CONSTRAINT dosette_pays0_FK FOREIGN KEY (id_pays) REFERENCES pays(id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Insertion des données dans la table continent
#------------------------------------------------------------

INSERT INTO continent (nom) VALUES
('Afrique'),
('Amérique'),
('Asie'),
('Europe'),
('Océanie');

#------------------------------------------------------------
# Insertion des données dans la table pays
#------------------------------------------------------------

INSERT INTO pays (nom, id_continent) VALUES
('Indonésie', 3),
('Colombie', 2),
('Italie', 4),
('Espagne', 4),
('Ouganda', 1),
('États-Unis', 2),
('Éthiopie', 1),
('Brésil', 2),
('Australie', 5);

#------------------------------------------------------------
# Insertion des données dans la table marque
#------------------------------------------------------------

INSERT INTO marque (nom) VALUES
('Nespresso'),
('Lavazza'),
('Illy'),
('Starbucks'),
('Dolce Gusto'),
('Tassimo'),
('Jacobs'),
('Carte Noire'),
('Segafredo'),
('Café Royal'),
('Melitta'),
('Senseo');

#------------------------------------------------------------
# Insertion des données dans la table dosette
#------------------------------------------------------------

INSERT INTO dosette (nom, intensite, prix, id_marque, id_pays) VALUES
('Arpeggio', 9, 0.45, 1, 1),
('Ristretto', 10, 0.50, 1, 1),
('Volluto', 4, 0.40, 1, 1),
('Caramelito', 6, 0.45, 1, 1),
('Vanizio', 6, 0.45, 1, 1),
('Espresso', 8, 0.40, 2, 2),
('Lungo', 4, 0.35, 2, 2),
('Decaffeinato', 3, 0.40, 2, 2),
('Crema', 5, 0.40, 3, 3),
('Forte', 8, 0.45, 3, 3),
('Mild', 4, 0.35, 4, 4),
('Dark Roast', 9, 0.50, 4, 4),
('Blonde Roast', 5, 0.40, 4, 4),
('Cappuccino', 6, 0.45, 5, 5),
('Latte Macchiato', 5, 0.40, 5, 5),
('Choco', 6, 0.45, 6, 6),
('Café au Lait', 4, 0.35, 6, 6),
('Espresso Intenso', 9, 0.50, 7, 7),
('Crema Classico', 5, 0.40, 7, 7),
('Mild Roast', 4, 0.35, 8, 8),
('Dark Roast', 9, 0.50, 8, 8),
('Espresso', 8, 0.40, 9, 9),
('Lungo', 4, 0.35, 9, 9),
('Decaffeinato', 3, 0.40, 9, 9),
('Crema', 5, 0.40, 10, 2),
('Forte', 8, 0.45, 10, 2),
('Mild', 4, 0.35, 11, 3),
('Dark Roast', 9, 0.50, 11, 2),
('Blonde Roast', 5, 0.40, 11, 2),
('Cappuccino', 6, 0.45, 12, 2),
('Latte Macchiato', 5, 0.40, 12, 7),
('Choco', 6, 0.45, 12, 8),
('Café au Lait', 4, 0.35, 12, 8),
('Espresso Intenso', 9, 0.50, 12, 8),
('Crema Classico', 5, 0.40, 12, 8);
