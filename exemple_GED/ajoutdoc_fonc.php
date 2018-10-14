<html>
<head>
<title>Traitement de l'ajout d'un document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
	include("connexion.php");
	include("config.php");
	include("fonctions.php");
	$Data['Fichiers'] = $HTTP_POST_VARS['Fichiers'];
	$Data['SousCategories'] = $HTTP_POST_VARS['SousCategories'];


	function insertion_fichier($NomFicSel,$id_doc)
	{
			//une variable globale doit être déclarée à l'intérieur de chaque fonction afin de pouvoir être utilisée dans cette fonction. 
			global $Rep_Temp,$Rep,$Rep_lien;
			//On vérifie que le fichier dont le nom est contenu dans la variable $Data['Fichiers'][$i]
			//est présent dans le dossier temporaire
			//Si c'est le cas, on cherche la position du point . dans le nom du fichier 
			//pour récupérer le nom du fichier et son extension
			//En effet, le fichier aura pour nom définitif, son nom d'origine + l'identifiant du document + son extension
			//Ensuite, on recopie le fichier du répertoire temporaire vers le répertoire de stockage des fichiers
			//Après on supprime le fichier du répertoire temporaire
			//Enfin, on insère un enregistrement dans la table
			
			//$d=$Rep_Temp.$NomFicSel;
			//echo"{$Rep_Temp}<br>";
			//echo"{$Rep}<br>";
			//echo"{$d}<br>";
			if(file_exists($Rep_Temp.$NomFicSel))
			{
				
				$point=strpos($NomFicSel,".");
				if($point)
				{
					$extension=substr($NomFicSel,$point);
					$NomFic=substr($NomFicSel,0,$point);
				}
				$NomComplet = $NomFic."_".$id_doc.$extension;
				$Fic=$Rep.$NomFic."_".$id_doc.$extension;
				copy($Rep_Temp.$NomFicSel,$Fic);
				unlink($Rep_Temp.$NomFicSel);
				$Fic=addslashes($Fic);
				$lien=$Rep_lien.$NomComplet;
				$rst="INSERT INTO fichiers (adresse_fichier,id_document,extension_fichier,nom_fichier,lien_fichier) VALUES ('$Fic','$id_doc','$extension','$NomComplet','$lien')";
				//echo"{$rst}<br><br>";
				mysql_query($rst);
			}
			
	}
	if($id==0)
	{
		//On insère dans la table documents les renseignements concernant le nouvel enregistrement
		//On converti les dates au format us qui correspond au format mysql
		//Note la fonction date_fr_to_us est dans le fichier fonctions.php
		$DateParution = date_fr_to_us($DateParution);
		$DateArchivage = date_fr_to_us($DateArchivage);
		$rst="INSERT INTO documents (nom_document,desc_document,date_parution_document,date_archivage_document,source_document,archive_document,numero_document,motscles_document) VALUES ('$Nom','$Desc','$DateParution','$DateArchivage','$Source','0','$NumSource','$MotsCles')";
		//echo"{$rst}<br><br>";
		mysql_query($rst);

		//Puis on récupère l'identifiant du document nouvellement créé
		$id=mysql_insert_id();

		//On appelle la fonction insertion_fichier pour gérer cet aspect
		$i=1;
		//On récupère l'ensemble des adresses des fichiers joints contenus dans la variables Fichiers
		while($Data['Fichiers'][$i]!="")
		{
			insertion_fichier($Data['Fichiers'][$i],$id);
			$i++;
		}

		//On crée les liens dans la base de données concernant les documents et les sous catégories
		$i=0;
		while($Data['SousCategories'][$i]!="")
		{
			$id_souscat = $Data['SousCategories'][$i];
			$rst="INSERT INTO _souscategories (id_document,id_souscategorie) VALUES ('$id','$id_souscat')";
			echo"{$rst}<br>";
			mysql_query($rst);
			$i++;
		}
	}
	else
	{
		//On insère dans la table documents les renseignements concernant le nouvel enregistrement
		//On converti les dates au format us qui correspond au format mysql
		//Note la fonction date_fr_to_us est dans le fichier fonctions.php
		$DateParution = date_fr_to_us($DateParution);
		$DateArchivage = date_fr_to_us($DateArchivage);
		//On met à jour les informations saisies par l'utilisateur
		$rst = "UPDATE documents SET nom_document='$Nom',desc_document='$Desc',date_parution_document='$DateParution',date_archivage_document='$DateArchivage',source_document='$Source',archive_document='0',numero_document='$NumSource',motscles_document='$MotsCles' WHERE id_document='$id'";
		//echo"{$rst}<br>";
		mysql_query($rst);


		//La fenêtre ajoutdoc.php a listé l'ensemble des fichiers qui sont attachés au document
		//L'utilisateur peut en ajouter des nouveaux ou en supprimer
		//Pour savoir s'il s'agit d'un nouveau document, on vérifie qu'il n'existe pas dans le répertoire de stockage
		//D'après le choix de nommination des fichiers, il apprait peu probable qu'un utilisateur nomme un fichier 
		//du type nomfichier_id.* où id est un entier et * une extension
		$i=1;
		//On récupère l'ensemble des adresses des fichiers joints contenus dans la variables Fichiers
		while($Data['Fichiers'][$i]!="")
		{
			if(file_exists($Rep.$Data['Fichiers'][$i])==false)
			{	
				insertion_fichier($Data['Fichiers'][$i],$id);
			}
			$i++;
		}		
		//On crée les liens dans la base de données concernant les documents et les sous catégories
		//On efface tous les liens existant concernant le document et on en ajoute des nouveaux
		$i=0;
		$rst="DELETE FROM _souscategories WHERE id_document = '$id'";
		echo"{$rst}<br>";
		mysql_query($rst);
		while($Data['SousCategories'][$i]!="")
		{
			$id_souscat = $Data['SousCategories'][$i];
			$rst="INSERT INTO _souscategories (id_document,id_souscategorie) VALUES('$id','$id_souscat')";
			echo"{$rst}<br>";
			mysql_query($rst);
			$i++;
		}		
		
		

	}
	reload("liredocument.php?id=".$id);
?>
</body>
</html>
