<?php session_start();

/***** Connexion à la base de donnée ******/
function connect() 
{
    $user = 'root'; // utilisatrice
    $mdp = '';  // mot de passe
    $machine = '127.0.0.1'; //serveur sur lequel tourne le SGBD
    $bd = 'Dickeya';  // base de données à laquelle se connecter
    $connexion = mysqli_connect($machine, $user, $mdp, $bd);
	
    mysqli_set_charset($connexion, "utf8");
    
	if (mysqli_connect_errno()) // erreur si > 0
    {
        printf("Échec de la connexion :%s", mysqli_connect_error());
    }
    return $connexion;
}

/*****deconnexion a la base de donnée****/

function deconnect($connexion)
{
	mysqli_close($connexion);
}

/******requetes à la base****/

/* Execute une requête et renvoie un tableau utilisable en php */
function do_request($request, $connexion) {

    $sql = mysqli_query($connexion, $request);
	//si request renvoie une table nulle alors, sql  = 0 ( donc un booléen )
	// si request renvoie rien, le nombre de ligne de sql sera en dessous de 1 donc ligne vide
	// si pas d'erreur ( donc pas 0 ) et table non vide 
    if (!is_bool($sql) && mysqli_num_rows($sql) >= 1) {
		// On renvoie quelque chose exploitable par PHP	
        return sql_to_array($sql);
    }
}


/***** sql_to_array ( Transforme le resultat obtenu par la fonction requetes en un tableau utilisable par PHP )***/

/* Convertit un objet SQL en array PHP */
function sql_to_array($sql_result) {

    $table_sql = array();
    $header = array();
	
    if ($sql_result != false && mysqli_num_rows($sql_result) > 0) {
			
            $info = mysqli_fetch_fields($sql_result);
			// retourne tous les noms de colonnes
			
            for ($i = 0; $i < count($info); $i++) {
                $header[$i] = $info[$i]->name;
				// recupere la valeur name à l'index i de info et la met dans header à l'index i
            }
			
            $table_sql[0] = $header;
			// la cellule 0 contient le tableau header
			
            $i = 1;
			
            while ($row = mysqli_fetch_array($sql_result, MYSQLI_ASSOC)) {
                $table_sql[$i++] = $row;
            }
    }
    return $table_sql;
}


/***** Afficher une requetes SQL *****/
function print_request($table_sql) {
if(count($table_sql) >= 1) {
    $table = '<table>';
	
    foreach ($table_sql as $tuple) {
        $table .= '<tr>';
        foreach ($tuple as $attr) {
            $table .= '<td>' . $attr . '</td>';
        }
        $table .= '</tr>';
    }
	
    $table.= '</table>';
    echo $table;
	} else {
	echo "Aucun résultat disponible...";
	}
}


/* renvoi les 5 dernieres lignes de la table A en php */
function news($A, $b) 
	{
		$req1='SELECT * FROM '.$A.' ORDER BY ' .$b. ' DESC LIMIT 5';
		$connexion = connect();
		$tab1=do_request($req1, $connexion);
		print_request($tab1);
		deconnect($connexion);
	}
