#Script fichier famille, projet Dickeya#

import mysql.connector

conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

with open ("../data/allDickeya5060_SLX.fnodes", "r") as fich :
	fichier = fich.readlines()
fich.closed

for ligne in fichier : 
	text = ligne.split("\t")
	souche_prot = text[1].strip("\n")
	
	pos = souche_prot.find("$")
	prot = souche_prot[pos+1:]
	famille = text[0]

#Remplissage de la famille dans la table Famille

	cursor.execute("""SELECT * FROM FAMILLE WHERE NomFa = %s""", (famille,))
	rows = cursor.fetchall()
	if rows == []:
		cursor.execute("""INSERT INTO FAMILLE(NomFa) VALUES(%s)""", (famille,))

#Remplissage de idFa dans la table protéine

	cursor.execute("""SELECT idFa FROM FAMILLE WHERE NomFa = %s""", (famille,))
	rows = cursor.fetchall()
	idFa = rows[0][0]

	cursor.execute("""UPDATE PROTEINE SET idFa = %s WHERE NomP = %s""", (idFa, prot))

conn.commit()

conn.close()



