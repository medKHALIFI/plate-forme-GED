<?
//Page de configuration pour l'envoie de fichiers

global $Rep_Temp;
$Rep_Temp = "\\Antony\\Documents\\Site\\images\\Temp\\"; //R�pertoire temporaire du serveur sur lequel les fichiers sont envoy�s
global $Rep;
$Rep = "\\Antony\\Documents\\Site\\images\\"; //R�pertoire dans lequel les fichiers appartenant � un document sont stock�s
global $Rep_lien;
$Rep_lien = "http://152.9.251.205/Antony/documents/site/images/"; //Adresse internet � partir de laquelle on peut acc�der aux fichiers
global $Rep_archivage;
$Rep_archivage = "\\Antony\\Documents\\Site\\images\\Archives\\"; //R�pertoire de stockage dans lequel se trouve les fichiers dont le document assoic� est archiv�
global $Taille_Limite;
$Taille_Limite = 1048576; //Taille maximale que l'on peut envoyer pour un fichier
?>

