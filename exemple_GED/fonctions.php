<?
	//Fichier qui contient l'ensemble des fonctions utilis�es dans l'application


	//Requete qui permet de r�cup�rer l'identifiant de la fiche nouvellement cr��e 
	//Fonction inutile remplac�e par mysql_insert_id()
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
			echo'<h1 align="center">Mod�le d�j� existant</h1><br>';
			echo'<table align="center" width="90%" border="0">';
				echo'<tr align="center"><td align="center"><a href="principale.php">Page principale</a></td></tr>';
				echo'</table>';
			mysql_close();
			exit;
		}
	}	

	//Fonction de tabulation, elle permet de mettre j tabulations dans un champ texte
	//Entr�e : entier j
	//Sortie : aucune
	function tabulation($j)
	{
		for($i=0;$i<$j;$i++)
		{
			echo'&nbsp;';
		}
	}

	//Fonction qui permet de rediriger la page en javascript
	//Entr�e : nom de la page � recharger ou � appeler
	//Sortie : aucune
	function reload($page)
	{
		echo"<script language=\"javascript\">\n";
		echo"<!--\n";
			echo"document.location.href=\"$page\"\n";
		echo"//-->\n";
		echo"</script>\n";
	}
	//Fonction qui converti une date au format us au format fran�ait
	//Entr�e : chaine de caract�re, format us
	//Sortie : chaine de caract�re, format fr
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
