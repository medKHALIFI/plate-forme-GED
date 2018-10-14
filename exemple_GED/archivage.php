<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="STYLESHEET" href="styles.css" Type="text/css">
</head>

<body>
	<?
		include("connexion.php");
		include("config.php");
		include("fonctions.php");
		
		//Cette page va modifier le champ archive_document de la table documents
		//On va en effet le mettre à 1
		//Ceci va servir à alléger les résultats lors de recherches.

		//D'autre part l'archivage doit aussi permettre d'alléger les espaces de stockage des serveurs.
		
		//MODIFICATION DE L'ATTRIBUT ARCHIVE_DOCUMENT DE LA TABLE documents
		$rst="UPDATE documents SET archive_document='1' WHERE id_document = '$id'";
		//echo"{$rst}<br>";
		mysql_query($rst);

		//DEPLACEMENT DES FICHIERS DANS UN DOSSIER CONTENANT LES ARCHIVES
		$rst="SELECT * FROM fichiers WHERE id_document = '$id'";
		//echo"{$rst}<br>";
		$requete=mysql_query($rst);
		while($dbresult=mysql_fetch_row($requete))
		{
			if(file_exists($dbresult[1]))
			{
				copy($dbresult[1],$Rep_archivage.$dbresult[5]);
				unlink($dbresult[1]);
			}
		}
		

		//MODIFICATION DU LIEN 
		$rst="UPDATE fichiers SET lien_fichier='nondisponible.htm', adresse_fichier = '0' WHERE id_document = '$id'";
		//echo"{$rst}<br>";
		mysql_query($rst);
		
		reload("liredocument.php?id=".$id);
	?>
</body>
</html>
