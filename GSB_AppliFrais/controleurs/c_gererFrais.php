<?php
include(VIEWSPATH."v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = trim(htmlentities($_REQUEST['action']));
switch($action){
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
	case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include(VIEWSPATH."v_erreurs.php");
		}
	  break;
	}
	case 'validerCreationFrais':{
		$dateFrais = trim(htmlentities($_REQUEST['dateFrais']));
		$libelle = trim(htmlentities($_REQUEST['libelle']));
		$montant = trim(htmlentities($_REQUEST['montant']));
		valideInfosFrais($dateFrais,$libelle,$montant);
		if (nbErreurs() != 0 ){
			include(VIEWSPATH."v_erreurs.php");
		}
		else{
			$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
		}
		break;
	}
	case 'supprimerFrais':{
		$idFrais = trim(htmlentities($_REQUEST['idFrais']));
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
include(VIEWSPATH."v_listeFraisForfait.php");
include(VIEWSPATH."v_listeFraisHorsForfait.php");

?>