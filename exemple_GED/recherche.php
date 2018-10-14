<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function SCategories(cat)
{
	//On récupère la valeur de l'élément sélectionné.
	//On a évidemment veillé à ce que ce soit l'identifiant de la catégorie (voir code php)
	cat = document.forms["Recherche"].Categories.options[document.forms["Recherche"].Categories.selectedIndex].value;
	document.forms["Recherche"].action="recherche.php?cat=" + cat;
	document.forms["Recherche"].submit()	
}
//-->
</script>
</head>

<body bottommargin="15" topmargin="15" leftmargin="15">

<table width="100%" border="0">
  <tr>
    <td> 
    <?
	//Connexion à la base de données documents
	include("connexion.php");

	if($REQUEST_METHOD== 'POST')
	{
		//On enregistre les valeurs du formulaire dans un tableau
		$Data['valeurs'] = $HTTP_POST_VARS['valeurs'];
		$Data['Categories'] = $HTTP_POST_VARS['Categories'];
		$Data['SousCategories'] = $HTTP_POST_VARS['SousCategories'];
		$Data['Annee'] = $HTTP_POST_VARS['Annee'];
		$Data['Mois'] = $HTTP_POST_VARS['Mois'];
		$Data['Source'] = $HTTP_POST_VARS['Source'];
		$Data['Archive'] = $HTTP_POST_VARS['Archive'];
	}
	?>
      <form action="resultats.php" method="post" name="Recherche">
        <table cellspacing=0 cellpadding=2 width="600" border=0>
          <tbody>
            <tr valign=top> 
              <td width="16%" class="CaseLibM">Recherche g&eacute;n&eacute;rale</td>
              <td width="1%">&nbsp;</td>
              <td width="16%" class="CaseChampG"><a href="recherche_mc.php" class="menu">Recherche 
                par mots cl&eacute;s</a></td>
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
<!--Trace le contour du tableau
document.write("<table WIDTH=\"600\" BORDER=\"1\" CELLSPACING=\"0\" CELLPADDING=\"0\" BORDERCOLOR=\"#fcdab9\" BORDERCOLORLIGHT=\"fcdab9\" BORDERCOLORDARK=\"#c0c0c0\"><tr><td>");
// -->
</SCRIPT>
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top width=35> <DIV align=right><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 
      border=0><BR>
                  &nbsp;<BR>
                </DIV></td>
              <td vAlign=top noWrap colSpan=3>Veuillez saisir les mots &agrave; 
                rechercher dans les documents<BR> 
				<? 
					//On affiche le champ texte avec les valeurs saisies par l'utilisateur
					echo"<input type=\"text\" name=\"valeurs\" size=\"50\" value=\"{$Data['valeurs']}\">";
					
				?>
                &nbsp;
                <input type="submit" name="ValiderRecherche" value="Rechercher"></td>
            </tr>
          </tbody>
        </table>
        <HR align=center width="88%">
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top noWrap width=35> <DIV align=right><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></DIV></td>
              <td vAlign=top>Recherche dans la cat&eacute;gorie<br> 
				<!-- On appelle la fonctiono java script qui va recharger la page avec les sous categories associées à la catégorie choisie-->
				<select name="Categories" onChange="SCategories()">
                  <option value="0">Toutes les cat&eacute;gories</option>
                  <?
					//On insère toutes les catégories disponibles dans la base de données
					//On récupère l'ensemble des catégories classées par ordre alphabétique
					$rst="SELECT * FROM categories ORDER BY nom_categorie";
					$requete=mysql_query($rst);
					while($dbresult=mysql_fetch_row($requete))
					{
						echo"<option value=\"{$dbresult[0]}\"";
						//Si l'utilisateur a déjà choisi une valeur dans le combo, il faut le resélectionné.
						if($cat==$dbresult[0])
						{
							echo"selected";
						}
						echo">{$dbresult[1]}</options>";
					}
				?>
                </select> </td>
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Recherche dans la sous-cat&eacute;gorie<br> <select name="SousCategories">
                  <option value="0">Toutes les sous-cat&eacute;gories</option>
                  <?
					//On insère toutes les catégories disponibles dans la base de données
					//On récupère l'ensemble des catégories classées par ordre alphabétique
					//En fonction de la catégorie sélectionnée
					$rst="SELECT * FROM souscategories WHERE id_categorie='$cat' ORDER BY nom_souscategorie";
					$requete=mysql_query($rst);
					while($dbresult=mysql_fetch_row($requete))
					{
						echo"<option value=\"{$dbresult[0]}\">{$dbresult[1]}</options>";
					}
				?>
                </select> </td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Pour l'ann&eacute;e<br> <select name="Annee">
                  <option value="0" selected>Toutes</option>
                  <? 
					//On affiche les années. Pour cela on fait une boucle for en incrémentant de 1.
					//Si la valeur choisie par l'utilisateur est égale à la valeur qui va s'ajouter alors cette dernière est sélectionnée
					for($i=0;$i<5;$i++)
					{
						$annee=2003+$i;
						echo"<option value=\"{$annee}\"";
						if($Data['Annee']==$annee)
						{
							echo"selected";
						}
						echo">{$annee}</option>";
					}
				  ?>
                </select> </td>
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Pour le mois<br> <select name="Mois">
				<option value="0" selected>Tous</option>
				<?
					//On va créer un tableau dans le quel contient les mois de l'année en chaine de caracteres
					//Ceci va permettre de générer le menu des mois plus facilement
					//En effet, lorsque l'utilisateur changera de catégories, la page sera rechargée. Il ne doit pas perdre
					//les critères de recherche qu'il veint de choisir
					$mois=array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
					//On créé la boucle pour ajouter les mois au menu
					for($i=1;$i<13;$i++)
					{
						echo"<option value=\"{$i}\"";
						if($Data['Mois']==$i)
						{
							echo"selected";
						}
						echo">{$mois[$i-1]}</option>";
					}
   				?>
                </select> </td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Source<br> 
				<?
					//On affiche le champ texte source avec éventuellement une valeur saisie
					echo"<input type=\"text\" value=\"{$Data['Source']}\" name=\"Source\" size=\"30\">";
				?>
              </td>
              <td align="right" vAlign=top width=35>&nbsp;</td>
              <td vAlign=top>&nbsp;</td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>
				<?
					//Si l'utilisateur a choisi de rechercher dans les documents archivés et qu'il change
					//De catégories, la page se recharge mais la coche doit toujours être présente
					//En effet, la page est rechargée.
					echo"<input type=\"checkbox\" name=\"Archive\" value=\"1\"";
					if($Data['Archive'])
					{
						echo"checked";
					}
					echo">";
				?>
                Rechercher aussi dans les documents archivés</td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>
				<? //On utilise cette variable pour pouvoir modifier l'attribut STARTALLOPEN du code javascript correspondant au treeview ?>
				<input type="checkbox" name="developper_arbre" value="1">
                Développer l'arbre</td>
            </tr>
          </tbody>
        </table>
      </form>
      <?
	mysql_close();
?>
    </td>
  </tr>

</table>
</body>
</html>
