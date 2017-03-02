from Bio import SeqIO
import re

ligne= 0

for seq_record in SeqIO.parse("../data/All50Dickeya.fasta", "fasta"):
	ligne += 1
	print(ligne)	
	i = 0	
	pos = seq_record.id.find("$")
	fonction = []
	res = ""

	souche = seq_record.id[0:pos]

	prot = seq_record.id[pos+1:len(seq_record.id)]

	seq = seq_record.seq

	description = seq_record.description.split()[1:len(seq_record.description.split())]
	
	description = " ".join(description)

	while description[i] != "[":
		i+=1
		res = res+description[i]
	res.split(" ")
		
	for ele in res: 
		if ele != "MULTISPECIES:":
			fonction.append(ele)
	print(fonction)
	
	
			
			
	
