	<div class="statistiques" id="div1">
	<p><b>Informations</b><p>
	<?php
	$connexion= connect();
	
// Cadre pour afficher informations sur le projet en cours (Dickeya)
	$Proteome='SELECT COUNT(*) FROM SOUCHE';
	$TabProteome=do_request($Proteome, $connexion);
	$rProteome=print_result($TabProteome);
	echo " ".$rProteome." protéomes<br>";
	

	$Proteine='SELECT COUNT(*) FROM PROTEINE';
	$TabProteine=do_request($Proteine, $connexion);
	print_result($TabProteine);
	echo " proteines totales<br>";
	
	$Gene='SELECT COUNT(DISTINCT(NomGene)) FROM PROTEINE';
	$TabGene=do_request($Gene, $connexion);
	print_result($TabGene);
	echo " gènes<br>";
	
	$Fonction='SELECT COUNT(*) FROM FONCTION';
	$TabFonction=do_request($Fonction, $connexion);
	print_result($TabFonction);
	echo " fonctions<br>";
	
	$Famille='SELECT COUNT(*) FROM FAMILLE';
	$TabFamille=do_request($Famille, $connexion);
	print_result($TabFamille);
	echo " familles<br>";

	?>
	
	</div>