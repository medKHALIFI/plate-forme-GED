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
	//On r�cup�re la valeur de l'�l�ment s�lectionn�.
	//On a �videmment veill� � ce que ce soit l'identifiant de la cat�gorie (voir code php)
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
	//Connexion � la base de donn�es documents
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
              <td vAlign=top width=35> <DIV align=right><IMG height=18 alt="Fl�che jaune" 
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
              <td vAlign=top noWrap width=35> <DIV align=right><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></DIV></td>
              <td vAlign=top>Recherche dans la cat&eacute;gorie<br> 
				<!-- On appelle la fonctiono java script qui va recharger la page avec les sous categories associ�es � la cat�gorie choisie-->
				<select name="Categories" onChange="SCategories()">
                  <option value="0">Toutes les cat&eacute;gories</option>
                  <?
					//On ins�re toutes les cat�gories disponibles dans la base de donn�es
					//On r�cup�re l'ensemble des cat�gories class�es par ordre alphab�tique
					$rst="SELECT * FROM categories ORDER BY nom_categorie";
					$requete=mysql_query($rst);
					while($dbresult=mysql_fetch_row($requete))
					{
						echo"<option value=\"{$dbresult[0]}\"";
						//Si l'utilisateur a d�j� choisi une valeur dans le combo, il faut le res�lectionn�.
						if($cat==$dbresult[0])
						{
							echo"selected";
						}
						echo">{$dbresult[1]}</options>";
					}
				?>
                </select> </td>
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Recherche dans la sous-cat&eacute;gorie<br> <select name="SousCategories">
                  <option value="0">Toutes les sous-cat&eacute;gories</option>
                  <?
					//On ins�re toutes les cat�gories disponibles dans la base de donn�es
					//On r�cup�re l'ensemble des cat�gories class�es par ordre alphab�tique
					//En fonction de la cat�gorie s�lectionn�e
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
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Pour l'ann&eacute;e<br> <select name="Annee">
                  <option value="0" selected>Toutes</option>
                  <? 
					//On affiche les ann�es. Pour cela on fait une boucle for en incr�mentant de 1.
					//Si la valeur choisie par l'utilisateur est �gale � la valeur qui va s'ajouter alors cette derni�re est s�lectionn�e
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
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Pour le mois<br> <select name="Mois">
				<option value="0" selected>Tous</option>
				<?
					//On va cr�er un tableau dans le quel contient les mois de l'ann�e en chaine de caracteres
					//Ceci va permettre de g�n�rer le menu des mois plus facilement
					//En effet, lorsque l'utilisateur changera de cat�gories, la page sera recharg�e. Il ne doit pas perdre
					//les crit�res de recherche qu'il veint de choisir
					$mois=array("Janvier","F�vrier","Mars","Avril","Mai","Juin","Juillet","Ao�t","Septembre","Octobre","Novembre","D�cembre");
					//On cr�� la boucle pour ajouter les mois au menu
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
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td vAlign=top>Source<br> 
				<?
					//On affiche le champ texte source avec �ventuellement une valeur saisie
					echo"<input type=\"text\" value=\"{$Data['Source']}\" name=\"Source\" size=\"30\">";
				?>
              </td>
              <td align="right" vAlign=top width=35>&nbsp;</td>
              <td vAlign=top>&nbsp;</td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>
				<?
					//Si l'utilisateur a choisi de rechercher dans les documents archiv�s et qu'il change
					//De cat�gories, la page se recharge mais la coche doit toujours �tre pr�sente
					//En effet, la page est recharg�e.
					echo"<input type=\"checkbox\" name=\"Archive\" value=\"1\"";
					if($Data['Archive'])
					{
						echo"checked";
					}
					echo">";
				?>
                Rechercher aussi dans les documents archiv�s</td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Fl�che jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>
				<? //On utilise cette variable pour pouvoir modifier l'attribut STARTALLOPEN du code javascript correspondant au treeview ?>
				<input type="checkbox" name="developper_arbre" value="1">
                D�velopper l'arbre</td>
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
