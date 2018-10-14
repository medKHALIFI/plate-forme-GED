<?
	session_start();
	session_register("cat","souscat");
?>
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?
		include("connexion.php");
		include("fonctions.php");
		//---------------------------------------------------------------------------------------
		//Page de traitement des informations envoyées par la page categories.php
		//---------------------------------------------------------------------------------------

		//Si le champ texte contenant le nouveau nom d'une catégorie n'est pas nul, il faut l'ajouter dans la base
		if($NomCategorie!="")
		{	
			$rst="INSERT INTO categories (nom_categorie) VALUES ('$NomCategorie')";
			echo"{$rst}<br>";
			mysql_query($rst);
		}
		if($NomSousCategorie!="")
		{	
			$rst="INSERT INTO souscategories (nom_souscategorie,id_categorie) VALUES ('$NomSousCategorie','$id_cat')";
			echo"{$rst}<br>";
			if(mysql_query($rst))
			{
				echo"Insertion sous catégorie réussie";
			}
		}
		
		//FONCTION DE MODIFICATION OU DE SUPPRESSION DE CATEGORIES
		$i=0;
		while($cat[$i])
		{

			if($categories[$i]=="")
			{
				$rst="SELECT id_souscategorie FROM souscategories WHERE id_categorie='$cat[$i]'";
				$requete=mysql_query($rst);
				if(mysql_fetch_row($requete)==false)
				{
					$rst="DELETE FROM categories WHERE id_categorie = '$cat[$i]'";
					mysql_query($rst);
				}
				else
				{
					echo"<a class=\"titre\">Impossible de supprimer la catégorie car des sous catégories y sont associées !</a>";
				}
			}
			else
			{
				$rst="UPDATE categories SET nom_categorie = '$categories[$i]' WHERE id_categorie = '$cat[$i]'";
				echo"{$rst}<br>";
				mysql_query($rst);
			}
			$i++;
		}

		//FONCTION DE MODIFICATION OU DE SUPPRESSION DE SOUS CATEGORIES
		$i=0;
		while($souscat[$i]!="")
		{
			if($souscategories[$i]=="")
			{
				$rst="SELECT id_souscategorie FROM _souscategories WHERE id_souscategorie='$souscat[$i]'";
				$requete=mysql_query($rst);
				if(mysql_fetch_row($requete)==false)
				{
					$rst="DELETE FROM souscategories WHERE id_souscategorie = '$souscat[$i]'";
					mysql_query($rst);
				}
				else
				{
					echo"<a class=\"titre\">Impossible de supprimer la sous catégorie car des documents y sont associés !</a>";
				}
			}
			else
			{
				$rst="UPDATE souscategories SET nom_souscategorie = '$souscategories[$i]' WHERE id_souscategorie = '$souscat[$i]'";
				echo"{$rst}<br>";
				mysql_query($rst);
			}
			$i++;
		}
		reload("categories.php");
	?>
</body>
</html>
