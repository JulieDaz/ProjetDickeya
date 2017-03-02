conn = mysql.connector.connect(host="localhost",user="root",password="", database="Dickeya")
cursor = conn.cursor()

f=open('all-vs-all_50Dickeya_test.blastout', 'r')

for line in f :
        p1 = line.split()[0]
        k=p1.find("$")
        souche1=p1[:k]
        prot1=p1[k:]

        
        p2 = line.split()[1]
        i=p2.find("$")
        souche1=p2[:i]
        prot2=p2[i:]

        if prot1 != prot2 :
                Id=line.split()[2]
                Gap=line.split()[5]
                TailleAli=line.split()[3]

                requete1 = "SELECT IdP FROM proteine WHERE NomP = '" + prot1 + "';"
                print(requete1)
                #stocker le résultats de la requètes dans Id1
                #Id1 = cursor.execute(requete1)
                
                requete2 = "SELECT IdP FROM proteine WHERE NomP = '" + prot2 + "';"
                print(requete2)
                #stocker le résultats de la requètes dans Id2
                #Id2 = cursor.execute(requete2)

                #requeteF = "INSERT INTO compare(idP1, idP2, PourcentageId, PourcentageGap, TailleAli) VALUES ('" + Id1 + "', '" + Id2 + "', '" + Id + "', '" + Gap + "', '" + TailleAli + "');"
                #cursor.execute(requeteF)

f.close

conn.close()
