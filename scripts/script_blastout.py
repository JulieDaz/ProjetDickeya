import mysql.connector

conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

f=open('../data/all-vs-all_50Dickeya.blastout', 'r')

for line in f :
	p1 = line.split()[0]
	k=p1.find("$")
	souche1=p1[:k]
	prot1=p1[k+1:]

        
	p2 = line.split()[1]
	i=p2.find("$")
	souche1=p2[:i]
	prot2=p2[i+1:]

	if prot1 != prot2 :
		Id=line.split()[2]
		Gap=line.split()[5]
		TailleAli=line.split()[3]

		cursor.execute("""SELECT idP FROM PROTEINE WHERE NomP =  %s""", (prot1,))
		rows = cursor.fetchall()
		idP1=rows[0][0]
                
		cursor.execute("""SELECT idP FROM PROTEINE WHERE NomP =  %s""", (prot2,))
		rows = cursor.fetchall()
		idP2=rows[0][0]

		cursor.execute("""SELECT * FROM COMPARE WHERE (idP1 = %s AND idP2 = %s) OR (idP1 = %s AND idP2 = %s)""", (idP1, idP2, idP2, idP1))
		rows = cursor.fetchall()
		if rows == []:
			cursor.execute("""INSERT INTO COMPARE(idP1, idP2, PourcentageId, PourcentageGap, TailleAli) VALUES (%s, %s, %s, %s, %s)""", (idP1, idP2, Id, Gap, TailleAli))
			conn.commit()

conn.close()

f.close
