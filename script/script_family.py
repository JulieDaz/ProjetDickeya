#Script fichier famille, projet Dickeya#



with open ("allDickeya5060_SLX.fnodes", "r") as fich :
	fichier = fich.readlines()
fich.closed

for ligne in fichier : 
	text = ligne.split("\t")
	souche_prot = text[1].strip("\n")
	
	pos = souche_prot.find("$")
	prot = souche_prot[pos+1:]

print (prot)





