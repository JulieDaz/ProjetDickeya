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
			/* si aucune case de cochée*/
			if (!isset($_POST['proteome']) && !isset($_POST['pfonction']) && !isset($_POST['paires']))
			{
				echo "Aucune requête n'est cochée";
			}
			else
			{
				/* si la case 1 est cochée*/
				if(isset($_POST['proteome']))
				{	
					$cNomS = "('";
					$cNoNomS = "('";
					$j = 0;
					$pb=0;
					
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
					if($cNoNomS == "")
					{
					$cNoNomS = "('')";
					}
					else
					{
					$cNoNomS = $cNoNomS.")";
					}
					
					if($cNomS == "")
					{
					$pb=1;
					echo "Erreur, vous n'avez pas sélectionné de souche d'interêt .";
					}
					
					#si seulement la requête 1 est cochée
					if(!isset($_POST['pfonction']) && !isset($_POST['paires']) && $pb!=1)
					{
						$reqCase1='SELECT NOMS, NomP, NomGene, NomFo
						FROM PROTEINE AS p NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE LEFT JOIN FONCTION AS f ON p.IdFo = f.IdFO
						WHERE NomS IN '.$cNomS.' AND NomP NOT IN
						(SELECT DISTINCT NomP 
						FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE
						WHERE NomS IN '.$cNoNomS.')
						LIMIT 5';
						$tabCase1=do_request($reqCase1, $connexion);
						print_request($tabCase1);
					}
					else
					{
						#si la requête 1 et 2 sont cochées
						if(isset($_POST['pfonction']) && !isset($_POST['paires']) && $pb!=1)
						{
							$reqCase2et3='SELECT NOMS, NomP, NomGene, NomFo
							FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE NATURAL JOIN FONCTION 
							WHERE NomS IN '.$cNomS.' AND NomFo = \''.$_POST['fonction'].'\'
							AND NomP NOT IN(SELECT DISTINCT NomP 
							FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE
							WHERE NomS IN '.$cNoNomS.')
							LIMIT 5';
							$tabCase2et3=do_request($reqCase2et3, $connexion);
							print_request($tabCase2et3);
						}
						else
						{
							#si la requête 1 et 3 est cochées
							if(!isset($_POST['pfonction']) && isset($_POST['paires']) && $pb!=1)
							{
								echo "<p>Protéines identiques :</p>"
								$reqCase1et3Bis='SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, f1.NomFo AS Fonction1, s2.NomS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
								FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
								INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
								INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
								INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
								INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
								INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
								WHERE p1.NomP=p2.NomP AND s1.NomS>s2.NomS
								AND s1.NomS IN '.$cNomS.' AND s2.NomS IN '.$cNomS.'
								AND p1.NomP NOT IN (SELECT DISTINCT NomP FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE WHERE NomS IN '.$cNoNomS.')'
								$tabCase1et3Bis=do_request($reqCase1et3Bis, $connexion);
								print_request($tabCase1et3Bis);
							
								echo "<p>Protéines similaires :</p>"
								$reqCase1et3='SELECT s1.NomS, p1.NomP, s2.NomS, p2.NomP, p1.NomGene AS Gene, f.NomFo AS Fonction
								FROM CONTIENT c1 NATURAL JOIN SOUCHE s1 NATURAL JOIN PROTEINE p1,
								c2 NATURAL JOIN SOUCHE s2 NATURAL JOIN PROTEINE p2
								LEFT JOIN FONCTION f ON f.idFo=p2.idFo
								WHERE s1.NomS>s2.NomS AND  p1.NomP=p2.NomP
								AND s1.NomS IN '.$cNomS.' AND s2.NomS IN '.$cNomS.'
								AND p1.NomP NOT IN (SELECT DISTINCT NomP FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE WHERE NomS IN '.$cNoNomS.')
								ORDER BY p1.NomP, s1.NOMS, , s2.NOMS
								LIMIT 5';
								$tabCase1et3=do_request($reqCase1et3, $connexion);
								print_request($tabCase1et3);
							}
							else
							{
								#les 3 requêtes sont cochées
								if(isset($_POST['pfonction']) && isset($_POST['paires']) && $pb!=1)
								{
								
									echo "<p>Protéines identiques :</p>"
									$reqCase1et3Bis='SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, f1.NomFo AS Fonction1, s2.NomS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
									FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
									INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
									INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
									INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
									INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
									INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
									WHERE p1.NomP=p2.NomP AND s1.NomS>s2.NomS
									AND f1.NomFo = \''.$_POST['fonction'].'\'
									AND s1.NomS IN '.$cNomS.' AND s2.NomS IN '.$cNomS.'
									AND p1.NomP NOT IN (SELECT DISTINCT NomP FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE WHERE NomS IN '.$cNoNomS.')'

							
									echo "<p>Protéines similaires :</p>"
									$reqCase1et2et3='SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, s2.NOMS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
									FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
									INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
									INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
									INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
									INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
									INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
									WHERE s1.NomS IN '.$cNomS.' AND s2.NomS IN '.$cNomS.' AND f1.NomFo = \''.$_POST['fonction'].'\' AND f2.NomFo = \''.$_POST['fonction'].'\' AND c.PourcentageId >= '.$_POST['PourcentId'].' AND c.PourcentageGap <= '.$_POST['PourcentGap'].' AND c.TailleAli >= '.$_POST['TailleAli'].'
									AND p1.NomP NOT IN (SELECT DISTINCT NomP FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE WHERE NomS IN '.$cNoNomS.')
									AND p2.NomP NOT IN (SELECT DISTINCT NomP FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE WHERE NomS IN '.$cNoNomS.')
									ORDER BY c.PourcentageId DESC, c.PourcentageGap, s1.NOMS, p1.NomP, s2.NOMS, p2.NomP 
									LIMIT 5';
									$tabCase1et2et3=do_request($reqCase1et2et3, $connexion);
									print_request($tabCase1et2et3);
								}
							}
						}
					}
				}
				else
				{   
					#si case 3 cochée
					if(isset($_POST['paires']))
					{ 
						if(empty($_POST['PourcentId']))
						{$_POST['PourcentId']=0;}
						if(empty($_POST['PourcentGap']))
						{$_POST['PourcentGap']=100;}
						if(empty($_POST['TailleAli']))
						{$_POST['TailleAli']=0;}
						
						/* si seulement case 3 cochée*/
						if(!isset($_POST['pfonction']))
						{ 
							echo "<p>Protéines identiques :</p>"
							$reqCase3Bis='SELECT s1.NomS, p1.NomP, s2.NomS, p2.NomP, p1.NomGene AS Gene, f.NomFo AS Fonction
							FROM CONTIENT c1 NATURAL JOIN SOUCHE s1 NATURAL JOIN PROTEINE p1,
							CONTIENT c2 NATURAL JOIN SOUCHE s2 NATURAL JOIN PROTEINE p2
							LEFT JOIN FONCTION f ON f.idFo=p2.idFo
							WHERE s1.NomS>s2.NomS AND  p1.NomP=p2.NomP
							ORDER BY p1.NomP, s1.NOMS, , s2.NOMS'
							$tabCase3Bis=do_request($reqCase3Bis, $connexion);
							print_request($tabCase3Bis);
							
							echo "<p>Protéines similaires :</p>"
							$reqCase3='SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, f1.NomFo AS Fonction1, s2.NOMS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
							FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
							INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
							INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
							INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
							INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
							INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
							WHERE c.PourcentageId >= '.$_POST['PourcentId'].' AND c.PourcentageGap <= '.$_POST['PourcentGap'].' AND c.TailleAli >= '.$_POST['TailleAli'].'
							ORDER BY c.PourcentageId DESC, c.PourcentageGap, s1.NOMS, p1.NomP, s2.NOMS, p2.NomP 
							LIMIT 5';
							$tabCase3=do_request($reqCase3, $connexion);
							print_request($tabCase3);
						
						}
						else
						{ 
							#si la case 3 et la case 2 sont cochées
							if(isset($_POST['pfonction']))
							{ 
								if(empty($_POST['fonction']))
								{echo "Vous n'avez pas sélectionné de fonction";} #on ne fait que la 3ieme requete dans ce cas
							
								else
								{ 
									echo "<p>Protéines identiques :</p>"
									$reqCase2Et3Bis='SELECT s1.NomS, p1.NomP, s2.NomS, p2.NomP, p1.NomGene AS Gene, f.NomFo AS Fonction
									FROM CONTIENT c1 NATURAL JOIN SOUCHE s1 NATURAL JOIN PROTEINE p1,
									CONTIENT c2 NATURAL JOIN SOUCHE s2 NATURAL JOIN PROTEINE p2
									INNER JOIN FONCTION f ON f.idFo=p2.idFo
									WHERE s1.NomS>s2.NomS AND  p1.NomP=p2.NomP AND f1.NomFo = \''.$_POST['fonction'].'\'
									ORDER BY p1.NomP, s1.NOMS, , s2.NOMS'
									$tabCase2Et3Bis=do_request($reqCase2Et3Bis, $connexion);
									print_request($tabCase2Et3Bis);
							
									echo "<p>Protéines similaires :</p>"
									$reqCase2Et3 = 'SELECT s1.NomS AS Souche1, p1.NomP AS Proteine1, p1.NomGene AS Gene1, s2.NOMS AS Souche2, p2.NomP AS Proteine2, p2.NomGene AS Gen2, f2.NomFo AS Fonction2, c.PourcentageId, c.PourcentageGap, c.TailleAli
									FROM COMPARE c INNER JOIN PROTEINE p1 ON c.idP1=p1.idP INNER JOIN PROTEINE p2 ON c.idP2=p2.idP INNER JOIN CONTIENT c1 ON c1.idP=p1.idP
									INNER JOIN CONTIENT c2 ON c2.idP=p2.idP
									INNER JOIN SOUCHE s1 ON s1.idS=c1.idS
									INNER JOIN SOUCHE s2 ON s2.idS=c2.idS 
									INNER JOIN FONCTION f1 ON f1.idFo=p1.idFo
									INNER JOIN FONCTION f2 ON f2.idFo=p2.idFo
									WHERE f1.NomFo = \''.$_POST['fonction'].'\' AND f2.NomFo = \''.$_POST['fonction'].'\' AND c.PourcentageId >= '.$_POST['PourcentId'].' AND c.PourcentageGap <= '.$_POST['PourcentGap'].' AND c.TailleAli >='.$_POST['TailleAli'].'
									ORDER BY c.PourcentageId DESC, c.PourcentageGap, s1.NOMS, p1.NomP, s2.NOMS, p2.NomP 
									LIMIT 5';
									echo $reqCase2Et3 ;
									$tabCase2Et3=do_request($reqCase2Et3, $connexion);
									print_request($tabCase2Et3);
								}
							}
						}
						
					}
					else
					{
						/* si seulement case 2 cochée*/
						if(isset($_POST['pfonction']))
						{
							if(empty($_POST['fonction']))
							{echo "Vous n'avez pas sélectionné de fonction";}
							else
							{
								$reqCase2='SELECT NomS, NomP, NomGene, NomFo
								FROM PROTEINE NATURAL JOIN CONTIENT NATURAL JOIN SOUCHE NATURAL JOIN FONCTION 
								WHERE NomFo = \''.$_POST['fonction'].'\'';
								$tabCase2=do_request($reqCase2, $connexion);
								print_request($tabCase2);		
							}
						}
					}					
				}
				
			}
	}
	?>

	<?php 
		require ('includes/pieddepage.php') ;
	?>
