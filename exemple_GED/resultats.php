<html>
<head>
<title>Résultats de la recherche</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
	//----------------------------------------
	//CETTE PAGE N'AFFICHE AUCUNE INFORMATION A L'ECRAN
	//Elle traite seulement les choix de l'utilisateur afin de faire une requête précise
	//Pour générer un fichier *.js dans qui sert au treeview de navigation
	//----------------------------------------

	//----------------------------------------
	include("connexion.php");
	include("fonctions.php");
	$finrequete = "";
	if($valeurs!="")
	{
		$mots = explode(" ",$valeurs);
		$i=0;
		while($mots[$i])
		{
			echo"{$mots[$i]}<br>";
			$finrequete .= " documents.nom_document LIKE '%$mots[$i]%'  AND";
			$i++;
		}
	}
	
	if($Categories != 0)
	{
		$finrequete .= " souscategories.id_categorie = '$Categories'  AND";
	}
	
	if($SousCategories != 0)
	{
		$finrequete .= " souscategories.id_souscategorie = '$SousCategories'  AND ";
	}
	
	if($Annee != 0)
	{	
		$finrequete .= " YEAR(documents.date_parution_document) = '$Annee'  AND";
	}

	if($Mois != 0)
	{	
		$finrequete .= " MONTH(documents.date_parution_document) = '$Mois'  AND";
	}

	if($Source != "")
	{
		$finrequete .= " documents.source_document LIKE '%$Source%' AND";
	}

	if($Archive != 1)
	{
		$finrequete .= " documents.archive_document = '0'";
	}
	//echo"{$finrequete}<br>";

	//On vérifie si la fin de la requete se termine par AND
	//Si c'est le cas, la requête av retourner une erreur
	//Il faut donc le supprimer
	$and=strrchr($finrequete,"a");
	if($and == "AND")
	{
		$finrequete=substr($finrequete,0,strlen($finrequete)-3);
	}

	//On va vérifier si l'utilisateur veut développer l'arbre après la recherche
	//S'il a cliqué sur le checkbox, developper_arbre vaut 1
	//Pour développer l'arbre, la variable STARTALLOPEN dans le javascript doit valoir 1 sinon 0
	//Donc si l'utilisateur n'a pas cliqué il faut que developper_arvre valle 0
	if($developper_arbre != 1)
	{
		$developper_arbre=0;	
	}

	$fp=fopen(".\\javascript\\treeview\\FramesetNodes.js","w+");
	//On insère les options qui permettent de gérer le treeview. 
	//On retrouve notamment la possibilité d'avoir l'arbre directement déployé ou non 
	//ou encore si les noms des éléments possèdent un lien hypertext. 
	//Si ce n'est pas le cas, seule l'image de l'élément possède un lien
	fputs($fp,"// You can find instructions for this file here:\n// http://www.treeview.net\n// Decide if the names are links or just the icons\nUSETEXTLINKS = 1  //replace 0 with 1 for hyperlinks\n// Decide if the tree is to start all open or just showing the root folders\nSTARTALLOPEN = {$developper_arbre} //replace 0 with 1 to show the whole tree\nICONPATH = '././img/' //change if the gif's folder is a subfolder, for example: 'images/'\n\nfoldersTree = gFld(\"Documents\", \"\")\n");
	
	//CREATION DE LA REQUETE DE RECHERCHE
	//Noter que les différentes tables sont liées entre elles.
	$rst="SELECT * FROM documents INNER JOIN _souscategories ON documents.id_document=_souscategories.id_document INNER JOIN souscategories ON _souscategories.id_souscategorie = souscategories.id_souscategorie INNER JOIN categories ON categories.id_categorie = souscategories.id_categorie WHERE  " . $finrequete .  " ORDER BY categories.nom_categorie,souscategories.nom_souscategorie,documents.nom_document";
	//echo"{$rst}<br>";
	$requete=mysql_query($rst);
	$j=0;
	while($dbresult=mysql_fetch_row($requete))
	{
		//On fait une comparaison au niveau des noms des catégories pour savoir si on est toujours dans la meme
		//Si ce n'est pas le cas, on créé un nouveau noeud
		if($nom_cat!=$dbresult[16])
		{		
			$nom_cat=$dbresult[16];
			fputs($fp,"aux1 = insFld(foldersTree, gFld(\"{$dbresult[16]}\", \"\"))\n");
		}

		//De même que le commenataire ci dessus, sauf qu'il s'agit des sous-catégories.
		if($nom_souscat!=$dbresult[12])
		{
			$nom_souscat=$dbresult[12];
			fputs($fp,"aux2 = insFld(aux1, gFld(\"{$dbresult[12]}\", \"\"))\n");
		}

		//On met au format français la date de parution
		$dbresult[3]=date_us_to_fr($dbresult[3]);

		fputs($fp,"insDoc(aux2, gLnk(\"R\", \"{$dbresult[1]}, {$dbresult[5]}, {$dbresult[3]}\", \"liredocument.php?id={$dbresult[0]}\"))\n");	
		$j++;
	}
	echo"<a class=\"titregris\">La recherche a généré {$j} résultats</a><br>";

		fclose($fp);
?>
</body>
<script language="JavaScript">
	//On réactualise la frame dans laquelle se trouve le treeview.
	//En effet, en fonction des résultats, un nouveau treeview est généré
	parent.treeframe.location.href="treeview.htm";
</script>
</html>
