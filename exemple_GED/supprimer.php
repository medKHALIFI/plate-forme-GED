<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<?
		include("connexion.php");
		//Cette page gère la suppression de documents
		//c'est-à-dire les fichiers associés au document,
		//Les enregistrements dans les tables documents, fichiers et _souscategories
		//La table _souscategories contient les identifiants des documents associés aux catégories

		//Il faut donc commencer par supprimer les fichiers du disque dur
		//On récupère les informations concernant les fichiers associés au document à supprimer
		$rst="SELECT * FROM fichiers WHERE id_document='$id'";
		echo"{$rst}<br>";
		$requete = mysql_query($rst);
		while($dbresult=mysql_fetch_row($requete))
		{
			if(file_exists($dbresult[1]))
			{
				//On supprime le fichier dont l'adresse est contenue dans $dbresult[1]
				unlink($dbresult[1]);
				echo"<a class=\"titregris\">Fichier {$dbresult[5]} supprimé<br>";
			}
		}

		//Puis on efface les enregistrements de la table fichiers
		$rst="DELETE FROM fichiers WHERE id_document = '$id'";
		if(mysql_query($rst))
		{
			echo"<a class=\"titregris\">Enregistrements dans la table fichiers supprimés<br>";
		}

		//Ensuite on efface les liens entre le document et les sous-catégories
		$rst="DELETE FROM _souscategories WHERE id_document = '$id'";
		if(mysql_query($rst))
		{
			echo"<a class=\"titregris\">Enregistrements dans la table _souscategories supprimés<br>";
		}		

		//Enfin, on efface les enregistrements dans la table document
		$rst="DELETE FROM documents WHERE id_document = '$id'";
		if(mysql_query($rst))
		{
			echo"<a class=\"titregris\">Enregistrements dans la table documents supprimés<br>";
		}			
	?>
</body>
</html>
