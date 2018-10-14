<html>
<head>
<title>Informations du document</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href="styles.css" rel="stylesheet" type="text/css">

</head>

<body topmargin="15" leftmargin="15">
	<?
		include("connexion.php");
		include("fonctions.php");
		include("config.php");
		$rst="SELECT * FROM documents WHERE id_document = '$id'";
		//echo"{$rst}<br>";
		$requete=mysql_query($rst);
		$dbresult=mysql_fetch_row($requete);

		//On met au format français les dates
		$dbresult[3]=date_us_to_fr($dbresult[3]);
		$dbresult[4]=date_us_to_fr($dbresult[4]);
	
	echo"<table cellSpacing=1 cellPadding=1 width=\"100%\"  bgColor=#fcdab9 border=\"0\">
		<tbody>
			<tr>
				<td align=middle width=\"16%\" class=\"CaseLibM\">Informations</td>
				<td align=right width=\"53%\"  bgColor=#ffffff></td>
			</tr>
			<tr>
				<td class=\"titrecel\" colSpan=2>
					<table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">
					  <tr>
						<td width=\"2%\" valign=\"center\"><a class=titre href=\"ajoutdoc.php?id={$id}\"><img src=\"img\modifier.gif\"  border=\"0\"></a></td>
						<td width=\"23%\" valign=\"center\"><a class=titre href=\"ajoutdoc.php?id={$id}\">Modifier</a></td>
						<td width=\"2%\" valign=\"center\"><a class=titre href=\"javascript:supprimer({$id},'{$dbresult[1]}')\"><img src=\"img\supprimer.gif\" border=\"0\"></a></td>
						<td width=\"23%\" valign=\"center\"><a class=titre href=\"javascript:supprimer({$id},'{$dbresult[1]}')\">Supprimer</a></td>
						<td width=\"2%\" valign=\"center\"><a class=titre href=\"javascript:email()\"><img src=\"img\outlook.gif\" border=\"0\"></a></td>
						<td width=\"23%\" valign=\"center\"><a class=titre href=\"javascript:email()\">Envoyer un email</a></td>
						<td width=\"2%\" valign=\"center\"><a class=titre href=\"archivage.php?id={$id}\"><img src=\"img\archive.gif\" border=\"0\"></a></td>
						<td width=\"23%\" valign=\"center\"><a class=titre href=\"archivage.php?id={$id}\">Archiver le document</a></td>					
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgColor=#ffffff colSpan=2>
					<table width=\"100%\" border=\"0\">
					  <tr>
						<td valign=\"top\" width=\"60%\"><table cellSpacing=1 cellPadding=1 width=\"100%\" bgColor=#ffffff border=0 >
							<tbody>
							  <tr valign=\"top\"> 
								<td width=\"40%\"><a class=\"mininews\">Nom du document :</td>
								<td width=\"60%\" valign=\"center\"><a class=\"txtgris\">{$dbresult[1]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Identifiant :</a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[0]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Description :</a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[2]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Date de parution :</a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[3]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Date d'archivage :</a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[4]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Source : </a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[5]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Num&eacute;ro de la source : </a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[7]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Mots cl&eacute;s : </a></td>
								<td><a class=\"txtgris\" valign=\"center\">{$dbresult[8]}</a></td>
							  </tr>
							  <tr valign=\"top\"> 
								<td><a class=\"mininews\">Archivé : </a></td>
								<td><a class=\"txtgris\" valign=\"center\">";
									if($dbresult[6])
									{
										echo"oui";
									}
									else
									{
										echo"non";	
									}
								echo"</a></td>
							  </tr>
							</tbody>
						  </table>
						</td>
            			<td valign=\"top\" width=\"40%\">
							<table cellSpacing=1 cellPadding=1 width=\"100%\" bgColor=#ffffff border=0>
								<tbody >";

				//----------------------------------------------------------------------------------------
									//Requête qui récupère les fichiers associés au document sélectionné
									$rst="SELECT * FROM fichiers WHERE id_document = '$id' ORDER BY nom_fichier";
									$requete=mysql_query($rst);
									while($dbresult=mysql_fetch_row($requete))
									{
										//On sauve dans un fichier les adresses à partir desquelles on peut accéder au fichier
										//Cette variable sert à l'envoie d'un mail avec les liens
										//Note : la chaine %0a sert de retour à la ligne dans le corps de message de l'email dans outlook
										$body .= $dbresult[2] . "%0a";
										echo"<tr><td><a class=\"mininews\" href=\"{$dbresult[2]}\" target=\"_blank\">";
										switch($dbresult[3])
										{
											case ".doc" : echo"<img src=\"img/word.gif\" border=\"0\">";
												break;
											case ".pdf" : echo"<img src=\"img/acrobat.gif\" border=\"0\">";
												break;
											case ".xls" : echo"<img src=\"img/excel.gif\" border=\"0\">";
												break;
											case ".ppt" : echo"<img src=\"img/powerpoint.gif\" border=\"0\">";
												break;
											case ".jpg" : echo"<img src=\"img/ftvimage.gif\" border=\"0\">";
												break;
											case ".bmp" : echo"<img src=\"img/ftvimage.gif\" border=\"0\">";
												break;
											case ".jpeg" : echo"<img src=\"img/ftvimage.gif\" border=\"0\">";
												break;
											default : echo"<img src=\"img/ftvimage.gif\" border=\"0\">";
										}
										echo"&nbsp;{$dbresult[5]}</a></td></tr>";
									} 
							echo"</tbody>
						  </table>
						</td>
       				</tr>
				</table> 
			</td>
		</tr>
	</tbody>
	</table>
	<form name=\"Doc\">
	<input type=\"hidden\" name=\"lien\" value=\"{$body}\">
	</form>";
	?>
<script language="JavaScript">
	function email()
	{
		chaine_mail = "mailto:?subject= Documents à consulter ";
 		chaine_mail += "&body=Voici les liens à partir desquels vous pouvez consulter les documents :%0a" 
		chaine_mail += document.forms["Doc"].lien.value; 
 		location.href = chaine_mail;
	}

	//Fonction qui récupère en entrée l'identifiant du document à supprimer et le nom pour l'afficher dans la boite de dialogue
	function supprimer(id,nom_document)
	{
		if(confirm("Voulez vous réellement supprimer " + nom_document))
		{
			location.href="supprimer.php?id=" + id;
		}
	}
</script>
</body>
</html>
