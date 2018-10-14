<?
	//Fichier qui contient l'ensemble des fonctions utilisées dans l'application


	//Requete qui permet de récupérer l'identifiant de la fiche nouvellement créée 
	//Fonction inutile remplacée par mysql_insert_id()
	function id_cree($rse)
	{
		//echo"{$rse}<br>";
		$requete=mysql_query($rse);
		$rst=mysql_fetch_row($requete);
		return($rst[0]);
	}
	//fonction qui recherche les doublons dans une table suivant les conditions contenues dans la requete $rse
	function doublons($rse)
	{
		$requete=mysql_query($rse);
		//Si il y a un doublon, on affiche un message
		//echo "{$rse}<br>";
		if ($rst=mysql_fetch_row($requete))
		{
			echo'<h1 align="center">Modèle déjà existant</h1><br>';
			echo'<table align="center" width="90%" border="0">';
				echo'<tr align="center"><td align="center"><a href="principale.php">Page principale</a></td></tr>';
				echo'</table>';
			mysql_close();
			exit;
		}
	}	

	//Fonction de tabulation, elle permet de mettre j tabulations dans un champ texte
	//Entrée : entier j
	//Sortie : aucune
	function tabulation($j)
	{
		for($i=0;$i<$j;$i++)
		{
			echo'&nbsp;';
		}
	}

	//Fonction qui permet de rediriger la page en javascript
	//Entrée : nom de la page à recharger ou à appeler
	//Sortie : aucune
	function reload($page)
	{
		echo"<script language=\"javascript\">\n";
		echo"<!--\n";
			echo"document.location.href=\"$page\"\n";
		echo"//-->\n";
		echo"</script>\n";
	}
	//Fonction qui converti une date au format us au format françait
	//Entrée : chaine de caractère, format us
	//Sortie : chaine de caractère, format fr
	function date_us_to_fr($us)
	{
		list($annee,$mois,$jour) = explode("-",$us);
		return($jour."-".$mois."-".$annee); 
	}

	function date_fr_to_us($fr)
	{
		list($jour,$mois,$annee) = explode("-",$fr);
		return($annee."-".$mois."-".$jour); 
	}
?>
