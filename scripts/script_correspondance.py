import mysql.connector

conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

f=open('../data/correspondance_protID_GeneName.txt', 'r')

for line in f :
	if len(line.split()) == 2 :
		prot = line.split()[0]
		gene = line.split()[1]

		cursor.execute("""UPDATE PROTEINE SET NomGene = %s WHERE NomP = %s""", (gene, prot))
		conn.commit()

conn.close()

f.close			
			
	

