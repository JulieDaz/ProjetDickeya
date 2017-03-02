#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Projet
#------------------------------------------------------------

CREATE TABLE Projet(
        id              int (11) Auto_increment  NOT NULL ,
        Nom             Varchar (200) NOT NULL ,
        NomFichierFasta Varchar (200) ,
        NomFichierBlast Varchar (200) ,
        NomFichierSilix Varchar (200) ,
        NomFichierGene  Varchar (200) ,
        PRIMARY KEY (id ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Souche
#------------------------------------------------------------

CREATE TABLE Souche(
        idS  int (11) Auto_increment  NOT NULL ,
        NomS Varchar (200) ,
        id   Int NOT NULL ,
        PRIMARY KEY (idS ) ,
        UNIQUE (NomS )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Protéine
#------------------------------------------------------------

CREATE TABLE Proteine(
        idP      int (11) Auto_increment  NOT NULL ,
        NomP     Varchar (200) NOT NULL ,
        Sequence Text NOT NULL ,
        NomGene  Varchar (200) ,
        idFo     Int NOT NULL ,
        idFa     Int NOT NULL ,
        PRIMARY KEY (idP ) ,
        UNIQUE (NomP )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Fonction
#------------------------------------------------------------

CREATE TABLE Fonction(
        idFo  int (11) Auto_increment  NOT NULL ,
        NomFo Varchar (200) NOT NULL ,
        PRIMARY KEY (idFo ) ,
        UNIQUE (NomFo )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Famille
#------------------------------------------------------------

CREATE TABLE Famille(
        idFa  int (11) Auto_increment  NOT NULL ,
        nomFa Varchar (200) NOT NULL ,
        PRIMARY KEY (idFa ) ,
        UNIQUE (nomFa )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: contient
#------------------------------------------------------------

CREATE TABLE contient(
        idS Int NOT NULL ,
        idP Int NOT NULL ,
        PRIMARY KEY (idS ,idP )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Compare
#------------------------------------------------------------

CREATE TABLE Compare(
        PourcentageId  Float NOT NULL ,
        PourcentageGap Float NOT NULL ,
        TailleAli      Int NOT NULL ,
        idP            Int NOT NULL ,
        idP_Proteine   Int NOT NULL ,
        PRIMARY KEY (idP ,idP_Proteine )
)ENGINE=InnoDB;

ALTER TABLE Souche ADD CONSTRAINT FK_Souche_id FOREIGN KEY (id) REFERENCES Projet(id);
ALTER TABLE Proteine ADD CONSTRAINT FK_Proteine_idFo FOREIGN KEY (idFo) REFERENCES Fonction(idFo);
ALTER TABLE Proteine ADD CONSTRAINT FK_Proteine_idFa FOREIGN KEY (idFa) REFERENCES Famille(idFa);
ALTER TABLE contient ADD CONSTRAINT FK_contient_idS FOREIGN KEY (idS) REFERENCES Souche(idS);
ALTER TABLE contient ADD CONSTRAINT FK_contient_idP FOREIGN KEY (idP) REFERENCES Proteine(idP);
ALTER TABLE Compare ADD CONSTRAINT FK_Compare_idP FOREIGN KEY (idP) REFERENCES Proteine(idP);
ALTER TABLE Compare ADD CONSTRAINT FK_Compare_idP_Proteine FOREIGN KEY (idP_Proteine) REFERENCES Proteine(idP);
