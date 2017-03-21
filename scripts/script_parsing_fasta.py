from Bio import SeqIO
import re
import mysql.connector

idProjet = "1"

conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

for seq_record in SeqIO.parse("../data/All50Dickeya.fasta", "fasta"):

	pos = seq_record.id.find("$")
	fonction = []

	souche = seq_record.id[0:pos]

	prot = seq_record.id[pos+1:]

	seq = str(seq_record.seq)
	
	i= seq_record.description.find("MULTISPECIES:")+14

	for k in re.finditer("\[",seq_record.description):
		fonction.append(k.start())
	if fonction != []:
		j = max(fonction)
	else :
		j=len(seq_record.description)
	if i == 13 : #si pas de MULTISPECIES: alors on fait rien
		i = seq_record.description.find(" ")+1
	fct = seq_record.description[i:j]

 
# Remplissage de la table Souche

	cursor.execute("""SELECT * FROM SOUCHE WHERE NomS = %s AND id = %s""", (souche,idProjet))
	rows = cursor.fetchall()
	if rows == []:
		cursor.execute("""INSERT INTO SOUCHE(NomS, id) VALUES(%s,%s)""", (souche,idProjet))

# Remplissage de la table Proteine

	cursor.execute("""SELECT * FROM PROTEINE WHERE NomP = %s""", (prot,))
	rows = cursor.fetchall()
	if rows == []:
		cursor.execute("""INSERT INTO PROTEINE(NomP,Sequence) VALUES(%s,%s)""", (prot, seq))

# Remplissage de la table Contient

	cursor.execute("""SELECT idS FROM SOUCHE WHERE NomS = %s AND id = %s""",(souche,idProjet))
	rows = cursor.fetchall()
	idS = rows[0][0]
	cursor.execute("""SELECT idP FROM PROTEINE WHERE NomP = %s""",(prot,))
	rows = cursor.fetchall()
	idP = rows[0][0]
	cursor.execute("""INSERT INTO CONTIENT(idS,idP) VALUES(%s,%s)""", (idS,idP))

# Remplissage de la table Fonction

	if len(seq_record.description.split(" ")) > 1:
		cursor.execute("""SELECT * FROM FONCTION WHERE NomFo = %s""", (fct,))
		rows = cursor.fetchall()
		if rows == []:
			cursor.execute("""INSERT INTO FONCTION(NomFo) VALUES(%s)""", (fct,))
	
		cursor.execute("""SELECT idFo FROM FONCTION WHERE NomFo = %s""", (fct,))
		rows = cursor.fetchall()
		idFo = rows[0][0]
		cursor.execute("""UPDATE PROTEINE SET idFo = %s WHERE idP = %s""", (idFo, idP))

	conn.commit()

conn.close()

