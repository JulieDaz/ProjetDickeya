
	<?php
		require ('includes/entete.php');
	?>

	<section>
		<br>
		<h2>Accueil</h2>
		
		<?php
		$connexion= connect();
		$recherche = "SELECT * FROM PROJET" ;
		$result=do_request($recherche, $connexion);
		?>
		
		<p> Sélectionner un projet : <select name="Nom">
		<?php
		while ($row=mysql_fetch_array($result))
		{
		?>
		<OPTION><?php echo $row['Nom']; ?></OPTION>
		<?php
		}
		deconnect($connexion);
		?>
		
		<input type="submit" name="valider" value="Visualiser ce projet"/>
		</form> 
	
	</section>
	<table>
	</table>
	<?php require ('includes/pieddepage.php') ;  ?>
