
<html>
<head>
<title>Ajout d'un document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
<script language="JavaScript" src="javascript/calendrier/calendar1.js"></script><!-- Date only with year scrolling -->
<script language="JavaScript">
function Joindre()
{
	if(document.forms["AjoutDoc"].Fichier.value!="")
	{
		//On va s�lectionn� tous les �l�ments du menu
		//ceci est utilis� pour ajouter � la suite la nouvelle adresse � la suite de celles d�j� pr�sentes
		// On compte le nombre d'item de la liste select
   		NbFichiers = document.forms["AjoutDoc"].elements.Fichiers.length;
    
    	// On lance une boucle pour selectionner tous les items
    	for (a = 0; a < NbFichiers; a++)
    	{
    		document.forms["AjoutDoc"].elements.Fichiers.options[a].selected = true;
    	}
    	// On modifie l'ID  du champ select pour que PHP traite cette 
    	// derni�re comme un array
    	document.forms["AjoutDoc"].elements.Fichiers.name = "Fichiers[]";
		document.forms["AjoutDoc"].action="ajoutdoc.php?Joindre=True";
		//document.forms["AjoutDoc"].enctype="multipart/form-data";
		document.forms["AjoutDoc"].submit()
	}
	else
	{
		alert("Veuillez choisir un document avant de cliquer sur \"Joindre\"")
	}
}

function Supprimer()
{
	if (document.forms["AjoutDoc"].Fichiers.options.selectedIndex>=1) 
	{
		//On r�cup�re le nom du fichier s�lectionn�
		fichier = document.forms["AjoutDoc"].Fichiers.options[document.forms["AjoutDoc"].Fichiers.options.selectedIndex].value
		//Puis on efface la ligne
		document.forms["AjoutDoc"].Fichiers.options[document.forms["AjoutDoc"].Fichiers.options.selectedIndex]=null;
		//Si on supprime un �l�ment d'un document d�j� existant, il faut pouvoir supprimer le fichier
		if(document.forms["AjoutDoc"].id.value!=0)
		{
			//On va s�lectionn� tous les �l�ments du menu puisque l'utilisateur vient de cliquer sur le lien supprimer
			//Par cons�quent, les valeurs contenues dans les champs sont plus r�centes que celles contenues dans kla base de donn�es
			//Or, d'apr�s le code, la m�thode post �crase les valeurs contenues dans la base de donn�es s'il s'agit d'une modification
			//Cependant, les valeurs contenues dans la balise select ne sont envoy�es que si elles sont s�lectionn�es
			//Il faut donc s�lectionner les fichiers restants.
			//ceci est utilis� pour ajouter � la suite la nouvelle adresse � la suite de celles d�j� pr�sentes
			//On compte le nombre d'item de la liste select
			NbFichiers = document.forms["AjoutDoc"].elements.Fichiers.length;
		
			// On lance une boucle pour selectionner tous les items
			for (a = 0; a < NbFichiers; a++)
			{
				document.forms["AjoutDoc"].elements.Fichiers.options[a].selected = true;
			}
			document.forms["AjoutDoc"].elements.Fichiers.name = "Fichiers[]";
			document.forms["AjoutDoc"].action="ajoutdoc.php?id=" + document.forms["AjoutDoc"].id.value + "&Supprimer=True&fichier=" + fichier;
			document.forms["AjoutDoc"].submit()	
		}
	} 
	else 
	{
		alert("Suppression impossible : aucune ligne s�lectionn�e");
	}
}
function Valider()
{
	erreur=""
	if(document.forms["AjoutDoc"].Nom.value=="")
	{
		erreur+="Vous devez choisir un nom de document\n"
	}

	if(document.forms["AjoutDoc"].Desc.value=="")
	{
		erreur+="Vous devez saisir une description\n"
	}

	if(document.forms["AjoutDoc"].DateParution.value=="")
	{
		erreur+="Vous devez saisir une date de parution\n"
	}

	if(document.forms["AjoutDoc"].Source.value=="")
	{
		erreur+="Vous devez saisir une source\n"
	}

	//for(i=0;i<document.forms["AjoutDoc"].SousCategories.length;i++)
	//{
		if (document.forms["AjoutDoc"].clic.value!=1)
		{
			erreur+="Vous devez s�lectionner au moins une sous-cat�gorie\n"
		}
	//}


	if(erreur=="")
	{
		//On va s�lectionn� tous les �l�ments du menu
		//ceci est utilis� pour ajouter � la suite la nouvelle adresse � la suite de celles d�j� pr�sentes
		// On compte le nombre d'item de la liste select
   		NbFichiers = document.forms["AjoutDoc"].elements.Fichiers.length;
    
    	// On lance une boucle pour selectionner tous les items
    	for (a = 0; a < NbFichiers; a++)
    	{
    		document.forms["AjoutDoc"].elements.Fichiers.options[a].selected = true;
    	}
		document.forms["AjoutDoc"].elements.Fichiers.name = "Fichiers[]";
		document.forms["AjoutDoc"].submit ()
	}
	else
	{
		alert(erreur)
	}
}

</script>
</head>

<body bottommargin="15" topmargin="15" leftmargin="15">
<table width="100%" border="0">
  <tr>
    <td> 
<?
	//Connexion � la base de donn�es documents
	include("connexion.php");
	include("fonctions.php");
	//Appel du fichier de configuration pour l'envoie de fichiers, 
	//Il contient notamment le r�pertoire temporaire, le r�pertoire d�finitif, la taille maxi...
	include("config.php"); 
	//------------------------------------
	
	//Lorsque l'on veut ajouter un document, la variable id pass�e en param�tre dans le lien appelant la page vaut 0
	//Exemple : ajoutdoc.php?id=0

	//Lorsqu'il s'agit d'une modification, cette id est n�cessairement sup�rieur � 0.
	//Exemple : ajoutdoc.php?id=45

	//En fonction de la valeur id, on r�alise certaine tache pour permettre de remplir le formulaire
	//En effet, s'il s'agit d'un ajout, mais que l'utilisateur � joint des fichiers, il ne faut pas qu'il perde les informations
	//qu'il a saisies.
	function post()
	{

	}
	if($id==0)
	{
		if($REQUEST_METHOD== 'POST')
		{
			//On enregistre les valeurs du formulaire dans un tableau
			$Data['id'] = $id;
			$Data['Nom'] = $HTTP_POST_VARS['Nom'];
			$Data['Desc'] = $HTTP_POST_VARS['Desc'];
			$Data['Source'] = $HTTP_POST_VARS['Source'];
			$Data['DateParution'] = $HTTP_POST_VARS['DateParution'];
			$Data['DateArchivage'] = $HTTP_POST_VARS['DateArchivage'];
			$Data['SousCategories'] = $HTTP_POST_VARS['SousCategories'];
			$Data['Fichiers'] = $HTTP_POST_VARS['Fichiers'];
			$Data['Fichier'] = $HTTP_POST_VARS['Fichier'];
			$Data['NumSource'] = $HTTP_POST_VARS['NumSource'];
			$Data['MotsCles'] = $HTTP_POST_VARS['MotsCles'];
		}		
	}
	else
	{
		$rst="SELECT * FROM documents WHERE documents.id_document='$id' ";
		$requete=mysql_query($rst);
		$dbresult=mysql_fetch_row($requete);
		$Data['id'] = $id;
		$Data['Nom'] = $dbresult[1];
		$Data['Desc'] = $dbresult[2];
		$Data['Source'] = $dbresult[5];
		$Data['DateParution'] = date_us_to_fr($dbresult[3]);
		$Data['DateArchivage'] = date_us_to_fr($dbresult[4]);
		$rse="SELECT * FROM souscategories,_souscategories WHERE _souscategories.id_document='$id' AND souscategories.id_souscategorie = _souscategories.id_souscategorie ORDER BY souscategories.id_categorie,souscategories.nom_souscategorie ";
		$requete2=mysql_query($rse);
		$i=0;
		while($dbresult2=mysql_fetch_row($requete2))
		{
			$Data['SousCategories'][$i] = $dbresult2[0];
			$i++;
		}
		
		$rse="SELECT * FROM fichiers WHERE id_document='$id'";
		$requete2=mysql_query($rse);
		$i=1;
		while($dbresult2=mysql_fetch_row($requete2))
		{
			$slash=strrpos($dbresult2[1],"\\");
			$NomFic=substr($dbresult2[1],$slash+1);
			$Data['Fichiers'][$i] = $NomFic;
			$i++;
		}
		$Data['NumSource'] = $dbresult[7];
		$Data['MotsCles'] = $dbresult[8];

		if($REQUEST_METHOD== 'POST')
		{
			//On enregistre les valeurs du formulaire dans un tableau
			$Data['Nom'] = $HTTP_POST_VARS['Nom'];
			$Data['Desc'] = $HTTP_POST_VARS['Desc'];
			$Data['Source'] = $HTTP_POST_VARS['Source'];
			$Data['DateParution'] = $HTTP_POST_VARS['DateParution'];
			$Data['DateArchivage'] = $HTTP_POST_VARS['DateArchivage'];
			$Data['SousCategories'] = $HTTP_POST_VARS['SousCategories'];
			$Data['Fichiers'] = $HTTP_POST_VARS['Fichiers'];
			$Data['Fichier'] = $HTTP_POST_VARS['Fichier'];
			$Data['NumSource'] = $HTTP_POST_VARS['NumSource'];
			$Data['MotsCles'] = $HTTP_POST_VARS['MotsCles'];
		}		
	}

	//------------------------------------

	if(isset($Joindre))
	{
		$taille=filesize($Fichier);
		if($Fichier != "none")
		{
			if($taille<$Taille_Limite)
			{
				$nom_vrai=$HTTP_POST_FILES['Fichier']['name'];
				$slash=strrpos($nom_vrai,"\\");
				$NomFic=substr($nom_vrai,$slash);
				$nouveau_nom=$Rep_Temp.$NomFic;
				move_uploaded_file($Fichier,$nouveau_nom);
			}
		}
		//On va au dernier enregistrement
		//On r�cup�re le nombre correspondant au dernier �l�ment
		end($Data['Fichiers']);
		$i=key($Data['Fichiers']);
		//Fichier, c'est le champ texte qui r�cup�re le chemin d'acces au fichier
		//Fichiers, c'est le nom de la liste qui affiche l'ensemble des fichiers s�lectionn�s
		$i++;
		$Data['Fichiers'][$i]=$NomFic;
	}
	//------------------------------------

	//Cette fonction supprime le fichier du serveur si l'utilisateur clique sur le lien Supprimer de la page
	//Il efface en effet le fichier associ� au document
	if(isset($Supprimer))
	{
		//echo"{$Rep}<br>";
		if(file_exists($Rep.$fichier))
		{
			unlink($Rep.$fichier);
			$rst="DELETE FROM fichiers WHERE nom_fichier = '$fichier'";
			mysql_query($rst);
		}
	}
?>
      <form action="ajoutdoc_fonc.php" method="post" name="AjoutDoc" enctype="multipart/form-data">
		<? echo"<input type=\"hidden\" name=\"id\" value=\"$id\""; ?>
        <table cellspacing=0 cellpadding=2 width="600" border=0>
          <tbody>
            <tr valign=top> 
              <td width="16%" class="CaseLibM">Ajout d'un document</td>
              <td width="1%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
              <td width="1%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
              <td width="1%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
              <td width="1%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
            </tr>
          </tbody>
        </table>
        <table cellSpacing=0 width=600 border=0>
          <tbody>
            <tr> 
              <td bgColor=#fcdab9> <table cellSpacing=0 cellPadding=0 border=0>
                  <tbody>
                    <tr> 
                      <td height=5></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table>
        <SCRIPT language=JavaScript1.2 type=text/javascript>
<!--
document.write("<table WIDTH=\"600\" BORDER=\"1\" CELLSPACING=\"0\" CELLPADDING=\"0\" BORDERCOLOR=\"#fcdab9\" BORDERCOLORLIGHT=\"fcdab9\" BORDERCOLORDARK=\"#c0c0c0\"><tr><td>");
// -->
</SCRIPT>
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top width=35 align="right"><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 
      border=0><BR>
                  &nbsp;<BR></td>
              <td vAlign=top noWrap colSpan=3>Veuillez saisir le nom du document<BR> <? echo"<input type=\"text\" name=\"Nom\" size=\"50\" value=\"{$Data['Nom']}\">"; ?>
              </td>
            </tr>
          </tbody>
        </table>
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top width=35 align="right"><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 
      border=0><BR>
                  &nbsp;<BR></td>
              <td vAlign=top noWrap colSpan=3>Veuillez saisir une description 
                du document<BR> <? echo"<input type=\"text\" name=\"Desc\" size=\"80\" value=\"{$Data['Desc']}\">"; ?>
              </td>
            </tr>
          </tbody>
        </table>
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top noWrap width=35 align="right"><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Date de parution<br> <? echo"<input type=\"text\" name=\"DateParution\" size=\"30\" value=\"{$Data['DateParution']}\">"; ?> 
                <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Cliquer ici pour ajouter une date"></a> 
              </td>
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Date d'archivage<br> <? echo"<input type=\"text\" name=\"DateArchivage\" size=\"30\" value=\"{$Data['DateArchivage']}\">"; ?> 
                <a href="javascript:cal2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Cliquer ici pour ajouter une date"></a> 
              </td>
            </tr>
            <tr>
              <td align="right" vAlign=top><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Source<br> <? echo"<input type=\"text\" name=\"Source\" size=\"30\" value=\"{$Data['Source']}\">"; ?> </td>
              <td align="right" vAlign=top><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0>&nbsp;</td>
              <td vAlign=top>Num&eacute;ro de la source<br><? echo"<input type=\"text\" name=\"NumSource\" size=\"30\" value=\"{$Data['NumSource']}\">"; ?></td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35>
                <IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td
              >
              <td vAlign=top> Fichiers s&eacute;lectionn&eacute;s<br> <select name="Fichiers" size="9" multiple  class="CaseLibM" >
				<option value="0" selected >- - Fichiers joints - -</option>
                  <?
							//On va afficher l'ensemble des fichiers � charger
							//Ce sera leur nom, et en valeur, le chemin compelt
							
							$i=1;
							while($Data['Fichiers'][$i]!="")
							{
								echo"<option value=\"{$Data['Fichiers'][$i]}\"  onClick=\"clic=1\">{$Data['Fichiers'][$i]}</option>";
								$i++;
							}
						?>
                </select>
                <br> <a class="menu" href="javascript:Supprimer()">Supprimer</a><br> 
              </td>
              <td align="right" vAlign=top width=35>
                <IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0>&nbsp;</td>
              <td vAlign=top>Dans quelles sous cat&eacute;gories appartient-il 
                ?<br>
				<input type="hidden" name="clic" value="0">  
                <select name="SousCategories[]" multiple size="10" class="CaseLibM" onFocus="javascript:document.AjoutDoc.clic.value=1">
                  <?
							$i=0; //Cette variable sert lorsque la page se recharge, pour r�cup�rer les valeurs d�ja choisies
							//on charge les sous categories et lorsque l'utilisateur clique sur certains champs, ils prennent
							//la valeur de l'identifiant de la sous categorie et l'identifiant de la categorie associ�e
							$rst="SELECT * FROM souscategories ORDER BY id_categorie,nom_souscategorie ";
							$requete=mysql_query($rst);
							while($dbresult=mysql_fetch_row($requete))
							{
								echo"<option value=\"{$dbresult[0]}\"";
								//Si jamais l'utilisateur a cliqu� sur le lien joindre pour ajouter des fichiers
								//Il ne doit pas perdre les informations qu'il a d�j� coch�es.
								//Lorsqu'il a joint les fichiers, le formulaire a envoy� le tableau de valeurs $SousCategories[]
								//Ce tableau a �t� copi� dans un autre tableau $Data (note : c'est � un tableau � deux dimensions)
								//Si la valeur contenue dans $Data est �gale � la valeur de l'ensemble {$dbresult[0]};{$dbresult[3]}
								//Alors il faut s�lectionn� l'�l�ment dans la liste
								if($Data['SousCategories'][$i]==$dbresult[0])
								{
									echo"selected id=\"javascript:document.AjoutDoc.clic.value=1\"";
									$clic=1;
									$i++;
								}
								echo">{$dbresult[1]}</option>";

							}
							//Cette m�thode permet de v�rifier si au moins une sous-cat�gorie a �t� s�lectionn�e
							//En effet, une variable cach�e clic vaut 0. Si l'utilisateur clique sur une souscategorie
							//Cette valeur vaut 1, et lors de la validation, le code javascript verifie que cette valeur vaut 1
							//Si ce n'est p�s le cas, un message informant qu'il faut choisir au moins une sous-cat�gorie appara�t
							//Or lors de la modification, l'utilisateur ne va pas forc�ment cliqu� sur une sous-cat�gorie
							//Puisque le document est d�j� r�f�renc�
							//Par cons�quent, pour chaque �l�ment s�lectionn�, on met la valeur php $clic � 1
							//Puis on v�rifie si cette valeur est � 1, si c'est le cas, un code javascript modifie la variable cach�e
							//qui prouve qu'une sous-cat�gorie a �t� choisie
							if($clic==1)
							{
								echo"<script language=\"JavaScript\">document.AjoutDoc.clic.value=1</script>";
							}
						?>
                </select><br>&nbsp;</td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>Fichier � joindre (cliquez sur Parcourir) :<br> <input type="file" name="Fichier" size="50"> 
                &nbsp;<a class="menu" href="javascript:Joindre()">Joindre</a></td>
            </tr>
			<tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top> 
                Liste des mots cl&eacute;s<br>
				<?
					echo"<input type=\"text\" name=\"MotsCles\" size=\"80\" value=\"{$Data['MotsCles']}\">";
				?>
			  </td>
            </tr>
			<tr> 
              <td align="right" vAlign=top width=35></td>
              <td colspan="3" vAlign=top><br>
                <a class="menu" href="javascript:Valider()">Valider</a> </td>
            </tr>
          </tbody>
        </table>
      </form>
		<script language="JavaScript">
		<!-- // create calendar object(s) just after form tag closed
			 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
			 // note: you can have as many calendar objects as you need for your application
			var cal1 = new calendar1(document.forms['AjoutDoc'].elements['DateParution']);
			cal1.year_scroll = true;
			cal1.time_comp = false;
			var cal2 = new calendar1(document.forms['AjoutDoc'].elements['DateArchivage']);
			cal2.year_scroll = true;
			cal2.time_comp = false;
		//-->
		</script>
<?
	mysql_close();
?>
    </td>
  </tr>

</table>
</body>
</html>
