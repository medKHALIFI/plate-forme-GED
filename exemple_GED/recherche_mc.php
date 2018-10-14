<html>
<head>
<title>Recherche de mots clés</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body bottommargin="15" topmargin="15" leftmargin="15">
<table width="100%" border="0">
  <tr>
    <td> 
      <?
	//Connexion à la base de données documents
	include("connexion.php");
?>
      <form action="resultats_mc.php" method="post" name="Recherche">
        <table cellSpacing=0 cellPadding=2 width=600 border=0>
          <tbody>
            <tr vAlign=top> 
              <td width="16%" class="CaseChampG"><a href="recherche.php" class="menu">Recherche 
                g&eacute;n&eacute;rale</a></td>
              <td width="1%">&nbsp;</td>
              <td width="16%" class="CaseLibM">Recherche par mots cl&eacute;s</td>
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
              <td vAlign=top width=35> <DIV align=right><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 
      border=0><BR>
                  &nbsp;<BR>
                </DIV></td>
              <td vAlign=top noWrap colSpan=3>Veuillez saisir les mots cl&eacute;s 
                &agrave; rechercher dans les documents<BR> &nbsp; </td>
            </tr>
          </tbody>
        </table>
        <table cellSpacing=0 cellPadding=1 width=596 border=0>
          <tbody>
            <tr> 
              <td vAlign=top noWrap width=35> <DIV align=right><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></DIV></td>
              <td colspan="2" vAlign=top>Mot cl&eacute; 1<br> <input type="text" value="" name="MotsCles[]" size="50"></td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="2" vAlign=top>Mot cl&eacute; 2<br> <input type="text" value="" name="MotsCles[]" size="50"> 
              </td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="2" vAlign=top>Mot cl&eacute; 3<br> <input type="text" value="" name="MotsCles[]" size="50"> 
              </td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td width="454" vAlign=top><input type="checkbox" name="Archive" >
                Rechercher aussi dans les documents archivés </td>
            </tr>
            <tr> 
              <td align="right" vAlign=top width=35><IMG height=18 alt="Flèche jaune" 
      src="img/fleche.gif" width=11 border=0></td>
              <td colspan="3" vAlign=top>
				<input type="checkbox" name="developper_arbre" value="1">
                Développer l'arbre</td>
			  <td width="101"><input type="submit" name="ValiderRecherche" value="Rechercher"></td>
            </tr>
          </tbody>
        </table>
        <BR>
      </form>
      <?
	mysql_close();
?>
    </td>
  </tr>
</table>
</body>
</html>
