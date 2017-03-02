conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

f=open('correspondance_protID_GeneName.txt', 'r')

for line in f :
        if len(line.split()) == 2 :
                prot = line.split()[0]
                gene = line.split()[1]
                c="UPDATE proteine SET NomGene = '" + gene + "' WHERE NomP = '" + prot +"'"
                cursor.execute(c) #je ne peux pas tester donc je ne suis pas sure à 100% qu'on y rédige comme celà

f.close			
			
	
conn.close()
