	<?php
		require ('includes/entete.php');
	?>

	<section>
	<br>
	<h2> Résultats </h2>
	</section>
	
		<?php
		$connexion= connect();
	
		if (isset($_POST['valider']))
		{
				/* si aucune case de coché*/
				if (!isset($_POST['proteome']) && !isset($_POST['pfonction']) && !isset($_POST['paires']))
				{
					echo "Aucune requête n'est cochée";
				}
				
				/* si seulement case 1 cocheés*/
				$cNomS = "('";
				$cNoNomS = "('";
				$j = 0;
				$pb=0;
				if(isset($_POST['proteome'])&& !isset($_POST['pfonction']) && !isset($_POST['paires']))
				{
					while ($j <= $_POST['valueI'])
					{
						if(isset($_POST['NomS'.$j]) && isset($_POST['NoNomS'.$j]))
						{
							echo "Erreur, vous ne pouvez pas cocher 2 fois la même souche.";
							$pb=1;
							break;
						}
						else
						{
							if(isset($_POST['NomS'.$j]))
							{
								$cNomS = $cNomS.$_POST['NomS'.$j]."','";
							}
							if(isset($_POST['NoNomS'.$j]))
							{
								$cNoNomS = $cNoNomS.$_POST['NoNomS'.$j]."','";
							}
							$j++;
						}
						
					}
					$cNomS = substr($cNomS,0,-2);
					$cNomS = $cNomS.")";
					$cNoNomS = substr($cNoNomS,0,-2);
					$cNoNomS = $cNoNomS.")";
					
					if($pb!=1)
					{
						$reqCase1='SELECT NOMS, NomP, NomGene, NomFo
						FROM PROTEINE AS p NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE LEFT JOIN FONCTION AS f ON p.IdFo = f.IdFO
						WHERE NomS IN '.$cNomS.' AND NomP NOT IN
						(SELECT DISTINCT NomP 
						FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE
						WHERE NomS IN '.$cNoNomS.')';
						$tabCase1=do_request($reqCase1, $connexion);
						print_request($tabCase1);
					}
				}
				
				
				/* si seulement case 2 cocheés*/
				if(!isset($_POST['proteome']) && isset($_POST['pfonction']) && !isset($_POST['paires']))
				{
					if(empty($_POST['fonction']))
					{echo "Vous n'avez pas sélectionné de fonction";}
					else
					{
						$reqCase2='SELECT NOMS, NomP, NomGene, NomFo
						FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE NATURAL JOIN FONCTION 
						WHERE NomFo =  '.$_POST['fonction'].';';
						$tabCase2=do_request($reqCase2, $connexion);
						print_request($tabCase2);
						
					}
				}
				
				/* si seulement case 3 coché*/
				if(!isset($_POST['proteome'])&& !isset($_POST['pfonction']) &&isset($_POST['paires']))
				{	
					if(empty($_POST['PourcentId']))
					{$_POST['PourcentId']=0;}
					if(empty($_POST['PourcentGap']))
					{$_POST['PourcentGap']=100;}
					if(empty($_POST['TailleAli']))
					{$_POST['TailleAli']=0;}
					$reqCase3='SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, f1.NomFo AS Fonction1, s2.NOMS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
					FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
					INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
					INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
					INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
					INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
					INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
					WHERE c.PourcentageId >= '.$_POST['PourcentId'].' AND c.PourcentageGap <= '.$_POST['PourcentGap'].' AND c.TailleAli >= '.$_POST['TailleAli'].'
					ORDER BY c.PourcentageId, c.PourcentageGap, s1.NOMS, p1.NomP, s2.NOMS, p2.NomP';
					$tabCase3=do_request($reqCase3, $connexion);
					print_request($tabCase3);
				}
				
				/* si case 2 et 3 cochées*/
				if(!isset($_POST['proteome'])&& isset($_POST['pfonction']) && isset($_POST['paires']))
				{
					if(empty($_POST['PourcentId']))
						{$_POST['PourcentId']=0;}
						if(empty($_POST['PourcentGap']))
						{$_POST['PourcentGap']=100;}
						if(empty($_POST['TailleAli']))
						{$_POST['TailleAli']=0;}
						if(empty($_POST['fonction']))
					{echo "Vous n'avez pas sélectionné de fonction";}
					else
					{
						$reqCase2Et3 = 'SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, s2.NOMS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
						FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
						INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
						INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
						INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
						INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
						INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
						WHERE f1.NomFo = $Fct AND f2.NomFo = '.$_POST['fonction'].' AND c.PourcentageId >= '.$_POST['PourcentId'].' AND c.PourcentageGap <= '.$_POST['PourcentGap'].' AND c.TailleAli >='.$_POST['paires'].'
						ORDER BY c.PourcentageId, c.PourcentageGap, s1.NOMS, p1.NomP, s2.NOMS, p2.NomP';
						$tabCase2Et3=do_request($reqCase2Et3, $connexion);
						print_request($tabCase2Et3);
						
					}
				
				}
		}
		?>

	<?php 
		require ('includes/pieddepage.php') ;
	?>
