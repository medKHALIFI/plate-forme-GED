<html>
<head>
<title>Résultats de la recherche par mots clés</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<?
		include("connexion.php");
		include("fonctions.php");
		$j=0;
		
		//Boucle for qui va permttre de faire la recherche sur les 3 mots clés
		for($i=0;$i<3;$i++)
		{
			if($MotsCles[$i] != "")
			{
				//On vérifie si l'utilisateur veut aussi rechercher dans les documents archivés
				if($Archive == false)
				{
					$RecArchive = " AND archive_document = '0' ";
				}
				else
				{
					$RecArchive = "";
				}
				$rst="SELECT * FROM documents WHERE motscles_document LIKE '%$MotsCles[$i]%' " . $RecArchive . " ORDER BY nom_document";
				//echo"{$rst}<br>";
				$requete=mysql_query($rst);
				while($dbresult=mysql_fetch_row($requete))
				{
					//On va ajouter les identifiants des documents dans un tableau à deux dimensions
					//$tab[$i][0] contient l'identifiant
					//$tab[$i][1] contient le nombre d'occurrence des mots clés (de 1 à 3)
					//Boucle for pour savoir si le document est déjà présent
					$redondant = 0;
					for($k=0;$k<$j;$k++)
					{
						if($tab[$k][0] == $dbresult[0])
						{
							$redondant = 1;
							$tab[$k][1]++;
							$tab[$k][2] = $tab[$k][2] . "/" . $MotsCles[$i];
						}
					}
		
					if($redondant == 0)
					{
						$tab[$j][0] = $dbresult[0];
						$tab[$j][1] = 1;
						$tab[$j][2] = $MotsCles[$i];
						$j++;
					}
	
					
				}
			}
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

		for($i=3;$i>0;$i--)
		{
			if($i!=1)
			{
				echo"<a class=\"titregris\">{$i} mots<br>-------------------------<br></a>";
				fputs($fp,"aux1 = insFld(foldersTree, gFld(\"{$i} mots\", \"\"))\n");
			}
			else
			{
				echo"<a class=\"titregris\">{$i} mot<br>-------------------------<br></a>";
				fputs($fp,"aux1 = insFld(foldersTree, gFld(\"{$i} mot\", \"\"))\n");
			}
			
			for($k=0;$k<$j+1;$k++)
			{
				if($tab[$k][1]==$i)
				{
					$id=$tab[$k][0];
					$rst="SELECT * FROM documents WHERE id_document = '$id'";
					$requete=mysql_query($rst);
					$dbresult=mysql_fetch_row($requete);
					echo"<a class=\"titregris\" href=\"liredocument.php?id={$id}\">&nbsp;&nbsp;&nbsp;{$dbresult[1]}</a><br>";
					//On met au format français la date de parution
					$dbresult[3]=date_us_to_fr($dbresult[3]);

					fputs($fp,"insDoc(aux1, gLnk(\"R\", \"{$dbresult[1]}, {$dbresult[5]}, {$dbresult[3]} ({$tab[$k][2]})\", \"liredocument.php?id={$dbresult[0]}\"))\n");	
				}
			}
		}
		fclose($fp);
	?>
<script language="JavaScript">
	//On réactualise la frame dans laquelle se trouve le treeview.
	//En effet, en fonction des résultats, un nouveau treeview est généré
	parent.treeframe.location.href="treeview.htm";
</script>
</body>
</html>
