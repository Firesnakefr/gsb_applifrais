<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = trim(htmlentities($_REQUEST['action']));
switch($action){
	case 'demandeConnexion':{
		include(VIEWSPATH."v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = trim(htmlentities($_REQUEST['login']));
		$mdp = trim(htmlentities($_REQUEST['mdp']));
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include(VIEWSPATH."v_erreurs.php");
			include(VIEWSPATH."v_connexion.php");
		}
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include(VIEWSPATH."v_sommaire.php");
			include(VIEWSPATH."v_accueil.php");			
		}
		break;
	}
	default :{
		include(VIEWSPATH."v_connexion.php");
		break;
	}
}
?>