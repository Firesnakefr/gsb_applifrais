<?php
// gestion du comptable
include(VIEWSPATH."v_sommairecomptable.php");
$idComptable = $_SESSION['idComptable'];
$action = trim(htmlentities($_REQUEST['action'])); /* variable de l'action à effectuer */
switch($action){
    case 'selectionnerVisiteur':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        //$mois = getMoisATraiter();
        include(VIEWSPATH."v_listeVisiteur.php"); /* ajoute la vue v_listeVisiteur.php */
        break;
    }
    case 'validerFicheVisiteur':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        //$mois = getMoisATraiter();
        $idVisiteur = $_REQUEST['lstVisiteur'];
        if ($pdo->existeFicheFraiscloturee($mois, $idVisiteur)){
            include(VIEWSPATH."v_listeFrais.php"); /* ajoute la vue v_listeFrais.php */
        }
        else{ /* sinon il y a une erreur et on l'affiche */
            ajouterErreur("Les valeurs des frais doivent être numériques");
            include(VIEWSPATH."v_erreurs.php");
        }
        break;
    }
    case 'modifierFraisForfait':{
        $lesFrais = $_REQUEST['lesFrais']; /* récup des frais */
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{ /* sinon il y a une erreur et on l'affiche */
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include(VIEWSPATH."v_erreurs.php");
		}
        break;
    }
    case 'validerFrais':{
        $dateFrais = trim(htmlentities($_REQUEST['mois']));
		$justificatif = trim(htmlentities($_REQUEST['nbJustificatifs']));
		$montant = trim(htmlentities($_REQUEST['montantValide']));
		valideInfosFrais($justificatif,$montant,$dateFrais);
		if (nbErreurs() != 0 ){ /* si il y a une erreur, on l'affiche */
            ajouterErreur("Les valeurs des frais doivent être numériques");
			include(VIEWSPATH."v_erreurs.php");
		}
		else{
			$pdo->validerFrais($justificatif,$montant,$dateFrais); /* a faire */
		}
        break;
    }
    case 'SupprimerFraisHorsForfait':{
        $idFrais = trim(htmlentities($_REQUEST['idFrais']));
	    $pdo->supprimerFraisHorsForfait($idFrais);
        break;
    }
    case 'reporterFraisHorsForfait':{
        $idFrais = trim(htmlentities($_REQUEST['idFrais']));
	    $pdo->reporterFraisHorsForfait($idFrais);
        break;
    }
}

?>
