	<?php
		require ('includes/entete.php');
	?>

	<section>
		<br>
		<h2>Requêtes</h2>
		

		<form method="POST" action="resultats.php" name="formulaire">
		
		<input type="checkbox" name="proteome" id="proteome"/><label><b>Protéines présentes dans ces protéomes :</b></label>
		<br><br>
		<div class="divScroll">
		
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
				echo '<input type="checkbox" name="NomS'.$i.'" value="'.$v2.'">' ,$v2,'<br>';
				#echo "$v2\n";
				$i = $i + 1	;}
			}
		}
		echo '</div>
		<br>
		<input type="button" onclick="clickAll()" value="Tout cocher"/>
		<br>
		<p><b>Mais pas dans ceux-ci:</b></p>
		<div class="divScroll">';
		
		$i = 0;
		foreach($tab2 as $v1) {
			foreach($v1 as $v2) {
				if ($v2 != "NomS") {
				echo '<input type="checkbox" name="NoNomS'.$i.'" value="'.$v2.'">' ,$v2,'<br>';
				$i = $i + 1	;}
			}
		}
		echo'<input type="hidden" name="valueI" value="'.$i.'"/>';
		?>
		
		</div>
		<br>
		<input type="button" onclick="clickAllWithout()" value="Cocher tous les autres"/>
		<br>
		<br>
		
		<input type="checkbox" name="pfonction" id="pfonction"/><label><b>Protéines impliquées dans la fonction</b></label>
		<br><br>

		<?php
		$connexion = connect();
		$resultat = mysqli_query($connexion, "SELECT NomFo FROM FONCTION;");
		if ($resultat==FALSE|| mysqli_num_rows($resultat) != 0)
		{
			echo "<select name='fonction'>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo '<option>'.$donnees['NomFo'].'</option>';
			}
			echo "</select>";
			mysqli_free_result($resultat);
		}
		?>
		<br>
		<br>
		<input type="checkbox" name="paires" id="paires"/><label><b>Paires de protéines telles que: </b></label>
		<br><br>
		<label for ="PourcentageId">Pourcentage identité suppérieur à :</label>
		<input type="float" name="PourcentId" id="PourcentId" value="0"/>
		<label for ="Pourcentageid">%</label>
		<br>
		<br>
		<label for ="PourcentageGap">Pourcentage de gap inférieur à :</label>
		<input type="float" name="PourcentGap" id="PourcentIGap" value="100"/>
		<label for ="PourcentageGap">%</label>
		<br>
		<br>
		<label for ="TailleAli">Taille alignement plus grand que :</label>
		<input type="number" name="TailleAli" id="TailleAli" value="0"/>
		<label for ="TailleAli">acides aminés</label>


		<br>
		<br>
		<input type="submit" name="valider" value="Lancer les requêtes"/>		
		</form>
	</section>
	<table>
	</table>
	<script type="text/javascript" src="clickBtn.js"></script>
	<?php require ('includes/pieddepage.php') ;  ?>
