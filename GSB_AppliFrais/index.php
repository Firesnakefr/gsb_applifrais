<?php
session_start();
// Définition du chemin de la racine du site
define("APPATH", realpath(dirname("__FILE__")).DIRECTORY_SEPARATOR);
// Inclusion des paramètres de l'application
require_once APPATH."config".DIRECTORY_SEPARATOR."constants.php";
// Inclusion de la classe de gestion de la base de données
require_once (MODELSPATH."class.pdogsb.inc.php");
// Inclusion de l'entête et de l'include
include(VIEWSPATH."v_entete.php");
require_once(INCLUDEPATH."fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
}	 
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{
		include(CONTROLLERSPATH."c_connexion.php");break;
	}
	case 'gererFrais' :{
		include(CONTROLLERSPATH."c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include(CONTROLLERSPATH."c_etatFrais.php");break; 
	}
	case 'suivrePaiementFrais' :{
		include(CONTROLLERSPATH."c_suivrePaiementFrais.php");break;
	}
	case 'validerFrais' :{
		include(CONTROLLERSPATH."c_validerFrais.php");break;
	}
}
include(VIEWSPATH."v_pied.php") ;
?>

