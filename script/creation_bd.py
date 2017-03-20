import mysql.connector

conn = mysql.connector.connect(host="localhost",user="",password="", database="Dickeya")
cursor = conn.cursor()

cursor.execute("""
CREATE TABLE IF NOT EXISTS PROJET(
        id              int (11) Auto_increment  NOT NULL ,
        Nom             Varchar (200) NOT NULL ,
        NomFichierFasta Varchar (200) ,
        NomFichierBlast Varchar (200) ,
        NomFichierSilix Varchar (200) ,
        NomFichierGene  Varchar (200) ,
        PRIMARY KEY (id ) ,
        UNIQUE (Nom )
);""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS SOUCHE(
           idS  int (11) Auto_increment  NOT NULL ,
        NomS Varchar (200) ,
        id   Int NOT NULL ,
        PRIMARY KEY (idS) ,
        UNIQUE (NomS));""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS PROTEINE(
         idP      int (11) Auto_increment  NOT NULL ,
        NomP     Varchar (200) NOT NULL ,
        Sequence Text NOT NULL ,
        NomGene  Varchar (200) ,
        idFo     Int ,
        idFa     Int ,
        PRIMARY KEY (idP ) ,
        UNIQUE (NomP )
);""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS FONCTION(
        idFo  int (11) Auto_increment  NOT NULL ,
        NomFo Varchar (200) NOT NULL ,
        PRIMARY KEY (idFo ) ,
        UNIQUE (NomFo )
);""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS FAMILLE(
        idFa  int (11) Auto_increment  NOT NULL ,
        nomFa Varchar (200) NOT NULL ,
        PRIMARY KEY (idFa ) ,
        UNIQUE (nomFa )
);""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS CONTIENT(
        idS Int NOT NULL ,
        idP Int NOT NULL ,
        PRIMARY KEY (idS ,idP )
);""")

cursor.execute ("""CREATE TABLE IF NOT EXISTS COMPARE(
        PourcentageId  Float NOT NULL ,
        PourcentageGap Float NOT NULL ,
        TailleAli      Int NOT NULL ,
        idP1            Int NOT NULL ,
        idP2   Int NOT NULL ,
        PRIMARY KEY (idP1 ,idP2 )
);""")

cursor.execute("""ALTER TABLE SOUCHE ADD CONSTRAINT FK_SOUCHE_id FOREIGN KEY (id) REFERENCES PROJET(id);""")
cursor.execute("""ALTER TABLE PROTEINE ADD CONSTRAINT FK_PROTEINE_idFo FOREIGN KEY (idFo) REFERENCES FONCTION(idFo);""")
cursor.execute("""ALTER TABLE PROTEINE ADD CONSTRAINT FK_PROTEINE_idFa FOREIGN KEY (idFa) REFERENCES FAMILLE(idFa);""")
cursor.execute("""ALTER TABLE CONTIENT ADD CONSTRAINT FK_CONTIENT_idS FOREIGN KEY (idS) REFERENCES SOUCHE(idS);""")
cursor.execute("""ALTER TABLE CONTIENT ADD CONSTRAINT FK_CONTIENT_idP FOREIGN KEY (idP) REFERENCES PROTEINE(idP);""")
cursor.execute("""ALTER TABLE COMPARE ADD CONSTRAINT FK_COMPARE_idP1 FOREIGN KEY (idP1) REFERENCES PROTEINE(idP);""")
cursor.execute("""ALTER TABLE COMPARE ADD CONSTRAINT FK_COMPARE_idP2 FOREIGN KEY (idP2) REFERENCES PROTEINE(idP);""")

cursor.execute("""INSERT INTO PROJET(id,Nom) VALUES(1,"test")""")