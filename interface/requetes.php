
	<?php
		require ('includes/entete.php');
	?>

	<section>
		<br>
		<h2>Requêtes</h2>
		<p>Protéines présentent dans ces protéomes :</p>
		
		<?php
		$connexion= connect();
		$req2='SELECT NomS FROM SOUCHE;' ;
		$tab2=do_request($req2, $connexion);
		#print_request($tab2);
		#deconnect($connexion);
		$i = 0;
		foreach($tab2 as $v1) {
			foreach($v1 as $v2) {
				if ($v2 != "NomS") {
				echo '<form method="POST" action="checkbox.php">
				<input type="checkbox" name="choix[]" value=$i>' ,$v2,'<br>
				</form>';
				#echo "$v2\n";
				$i = $i + 1	;}
			}
		}
		?>

		<label for ="PourcentageId">Pourcentage identité suppérieur à :</label>
		<input type="float" name="PourcentId" id="PourcentId" value="100"/>
		<label for ="Pourcentageid">%</label>
		<br>
		<label for ="PourcentageGap">Pourcentage de gap inférieur à :</label>
		<input type="float" name="PourcentGap" id="PourcentIGap" value="0"/>
		<label for ="PourcentageGap">%</label>
		<br>
		<label for ="TailleAli">Taille alignement plus grand que :</label>
		<input type="number" name="TailleAli" id="TailleAli" value="75"/>
		<label for ="TailleAli">acides aminés</label>
		<br>
		<label for ="Fonction">Fonctions:</label>

		<?php
		$connexion = connect();
		$resultat = mysqli_query($connexion, "SELECT NomFo FROM FONCTION;");
		if ($resultat==FALSE|| mysqli_num_rows($resultat) != 0)
		{
			echo "<select name='fonction".$i."'>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo '<option>'.$donnees['NomFo'].'</option>';
			}
			echo "</select>";
			mysqli_free_result($resultat);
		}
		?>

		<br>
		<input type="submit" name="valider" value="Valider"/>		
		
	</section>
	<table>
	</table>
	<?php require ('includes/pieddepage.php') ;  ?>
