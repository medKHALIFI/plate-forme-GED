<?
	session_start();
	session_register("cat","souscat");
?>
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function valider(i)
	{
		//document.forms["cat"].action="categories_fonc.php?i=" + i;
		document.forms["cat"].submit ()
	}
</script>
</head>

<body bottommargin="15" topmargin="15" leftmargin="15">
	<form name="cat" method="post" action="categories_fonc.php">

  <table width="100%" border="0">
    <tr>
      <td width="35%" valign="top"><table width="100%" border="0">
    <?
		include("connexion.php");
		$rst="SELECT * FROM categories ORDER BY categories.nom_categorie";
		//echo"{$rst}<br>";
		$requete=mysql_query($rst);
		$i=0;
		$j=0;
		$cat="";
		$souscat="";
		while($dbresult=mysql_fetch_row($requete))
		{
			echo"<tr> 
			  <td colspan=\"2\"><input name=\"categories[]\" type=\"text\" size=\"40\" value=\"{$dbresult[1]}\" class=\"Categories\"></td>
			</tr>";
			$cat[$i]=$dbresult[0];
			$i++;			
			$rse="SELECT * FROM souscategories WHERE souscategories.id_categorie='$dbresult[0]' ORDER BY souscategories.nom_souscategorie";
			$requete2=mysql_query($rse);
			while($souscat_array=mysql_fetch_row($requete2))
			{
				echo"<tr> 
				  <td width=\"5%\">&nbsp;</td>
				  <td width=\"94%\"> 
					<input name=\"souscategories[]\" type=\"text\" size=\"40\" value=\"{$souscat_array[1]}\" class=\"souscategories\"></td>
				</tr>";
				$souscat[$j]=$souscat_array[0];
				$j++;
			}
		}
	?>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>&nbsp;</td>
      <td width="65%" valign="top"><table width="100%" border="0">
          <tr> 
            <td colspan="2" class="titrecel">Ins&eacute;rer une cat&eacute;gorie</td>
          </tr>
          <tr> 
            <td>Nom de la cat&eacute;gorie :</td>
            <td><input name="NomCategorie" type="text" class="categories"></td>
          </tr>
          <tr> 
            <td colspan="3"><hr></td>
          </tr>
          <tr> 
            <td colspan="2" class="titrecel">Ins&eacute;rer une sous cat&eacute;gorie</td>
          </tr>
          <tr> 
            <td>Nom de la sous cat&eacute;gorie :</td>
            <td><input name="NomSousCategorie" type="text" class="souscategories"></td>
          </tr>
          <tr> 
            <td>De quelle cat&eacute;gorie d&eacute;pend-elle ?</td>
            <td>
				<select name="id_cat" class="categories">
					<?
					$rst="SELECT * FROM categories ORDER BY nom_categorie";
					$requete=mysql_query($rst);
					while($dbresult=mysql_fetch_row($requete))
					{
					
						echo"<option value=\"{$dbresult[0]}\">{$dbresult[1]}</option>";
					}
				?>
				</select>	
			</td>
          </tr>
          <tr> 
            <td><? echo"<a href=\"javascript:valider({$i})\" class=\"menu\">Valider</a></td>";?>
            <td></td>
          </tr>	
        </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
