<?
	$user = "";
	$host = "";
	$password = "";
	//Connexion � la base de donn�es
	$connexion = mysql_connect($host,$user,$password) or die ("<H1>Erreur de connexion</H1><br>\n");
	mysql_select_db("documents",$connexion);
	//Affiche toutes les erreurs sauf les notices
	error_reporting(E_ALL & ~E_NOTICE);
?>