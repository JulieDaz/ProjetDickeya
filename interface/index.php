
	<?php
		require ('includes/entete.php');
	?>

	<section>
		<br>
		<h2>Accueil</h2>
		
		<p> Sélectionner un projet : </p>
		
		<form name="Select" method="post" action="requetes.php">
		<?php
		$connexion= connect();
		$recherche = "SELECT Nom FROM PROJET" ;
		$resultat = mysqli_query($connexion, $recherche);
		if ($resultat==FALSE|| mysqli_num_rows($resultat) != 0)
		{
			echo "<select name='fonction'>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo '<option>'.$donnees['Nom'].'</option>';
			}
			echo "</select>";
			mysqli_free_result($resultat);
		}
		?>
		<br>
		<br>
		<input type="submit" name="valider" value="Visualiser ce projet"/>
		</form> 
	
	</section>
	<table>
	</table>
	<?php require ('includes/pieddepage.php') ;  ?>
