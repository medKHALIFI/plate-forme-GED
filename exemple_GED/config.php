<?
//Page de configuration pour l'envoie de fichiers

global $Rep_Temp;
$Rep_Temp = "\\Antony\\Documents\\Site\\images\\Temp\\"; //Répertoire temporaire du serveur sur lequel les fichiers sont envoyés
global $Rep;
$Rep = "\\Antony\\Documents\\Site\\images\\"; //Répertoire dans lequel les fichiers appartenant à un document sont stockés
global $Rep_lien;
$Rep_lien = "http://152.9.251.205/Antony/documents/site/images/"; //Adresse internet à partir de laquelle on peut accéder aux fichiers
global $Rep_archivage;
$Rep_archivage = "\\Antony\\Documents\\Site\\images\\Archives\\"; //Répertoire de stockage dans lequel se trouve les fichiers dont le document assoicé est archivé
global $Taille_Limite;
$Taille_Limite = 1048576; //Taille maximale que l'on peut envoyer pour un fichier
?>

