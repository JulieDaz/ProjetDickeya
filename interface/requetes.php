	<?php
		require ('includes/entete.php');
		require ('includes/informations.php') ;
	?>

	<section>
		<br>
		<h2>Requêtes</h2>
		

		<form method="POST" action="resultats.php" name="formulaire">
		
<!--Block de requête n°1 : selection des souches d'interêt-->
		<input type="checkbox" name="proteome" id="proteome"/><label><b>Protéines présentes dans ces protéomes :</b></label>
		<br><br>
		<div class="divScroll" id="div1">
		
		<?php
		$connexion= connect();
		$req2='SELECT NomS FROM SOUCHE;' ;
		$tab2=do_request($req2, $connexion);
		
		$i = 0;
		foreach($tab2 as $v1) {
			foreach($v1 as $v2) {
				if ($v2 != "NomS") {
				echo '<input type="checkbox" onclick="putEnabled()" name="NomS'.$i.'" value="'.$v2.'">' ,$v2,'<br>';
				$i = $i + 1	;}
			}
		}
		echo '</div>
		<br>
		<input type="button" onclick="clickAll()" value="Tout cocher"/>
		<input type="button" onclick="declickAll()" value="Tout décocher"/>
		<br>
		<p><b>Mais absentes dans ceux-ci:</b></p>
		<div class="divScroll" id="div2">';
		
		$i = 0;
		foreach($tab2 as $v1) {
			foreach($v1 as $v2) {
				if ($v2 != "NomS") {
				echo '<input type="checkbox" onclick="makeEnabled()" name="NoNomS'.$i.'" value="'.$v2.'">' ,$v2,'<br>';
				$i = $i + 1	;}
			}
		}
		echo'<input type="hidden" name="valueI" value="'.$i.'"/>';
		?>
		
		</div>
		<br>
		<input type="button" onclick="clickAllWithout()" value="Cocher tous les autres"/>
		<input type="button" onclick="declickAllWithout()" value="Tout décocher"/>
		<br>
		<br>
		
		<!--Block de requête n°2 : selection de la fonction d'interêt-->
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

		<!--Block de requête n°3 : selection des paires de protéines selon trois contraintes: ID, Gap, Taille alignement-->
		<input type="checkbox" name="paires" id="paires"/><label><b>Paires de protéines telles que: </b></label>
		<br><br>
		<label for ="PourcentageId">Pourcentage identité supérieur à :</label>
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
	<script type="text/javascript" src="clickBtn.js"></script>
	<?php require ('includes/pieddepage.php') ;  ?>
