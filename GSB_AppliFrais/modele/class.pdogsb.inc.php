<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur=DB_HOST;
      	private static $bdd=DB_NAME;   		
      	private static $user=DB_LOGIN;    		
      	private static $mdp=DB_MDP;		
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
		PdoGsb::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom from visiteur 
		where visiteur.login= :login and visiteur.mdp= :mdp";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':login' => $login, ':mdp' => $mdp));			
		$ligne = $idJeuRes->fetch();
		return $ligne;
	}

/**
 * Retourne les informations d'un comptable
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
public function getInfosComptable($login, $mdp){
	$req = "select comptable.idcomptable as id, comptable.nom as nom, comptable.prenom as prenom from comptable 
	where comptable.login= :login and comptable.mdp= :mdp";
	$idJeuRes = PdoGsb::$monPdo->prepare($req); 
	$idJeuRes->execute(array( ':login' => $login, ':mdp' => $mdp));			
	$ligne = $idJeuRes->fetch();
	return $ligne;
}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur = :idVisiteur 
		and lignefraishorsforfait.mois = :mois";	
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois));	
		$lesLignes = $idJeuRes->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['dateFrais'];
			$lesLignes[$i]['dateFrais'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois));	
		$ligne = $idJeuRes->fetch();
		return $ligne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois= :mois 
		order by lignefraisforfait.idfraisforfait";	
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois));	
		$lesLignes = $idJeuRes->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$idJeuRes = PdoGsb::$monPdo->prepare($req);  
		$idJeuRes->execute();				
		$lesLignes = $idJeuRes->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :idFrais";
			$resultat = PdoGsb::$monPdo->prepare($req); 
			$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois, ':idFrais' => $unIdFrais , ':qte' => $qte ));
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = :nbJustificatifs 
		where fichefrais.idVisiteur = :idVisiteur and fichefrais.mois = :mois";
		$resultat = PdoGsb::$monPdo->prepare($req); 
		$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois, ':nbJustificatifs' => $nbJustificatifs ));
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois));	
		$ligne = $idJeuRes->fetch();
		if($ligne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur));	
		$ligne = $idJeuRes->fetch();
		$dernierMois = $ligne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		if ($dernierMois != null)
		{
			$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
			if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
			}
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values(:idVisiteur,:mois,0,0,now(),'CR')";
		$resultat = PdoGsb::$monPdo->prepare($req); 
		$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois ));
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values(:idVisiteur, :mois, :unIdFrais,0)";
			$resultat = PdoGsb::$monPdo->prepare($req); 
			$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois, ':unIdFrais' => $unIdFrais ));
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait (idVisiteur, mois, dateFrais, libelle, montant)
		values(:idVisiteur, :mois, :dateFr, :libelle , :montant)";
		$resultat = PdoGsb::$monPdo->prepare($req); 
		$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois, ':libelle' => $libelle, ':dateFr' => $dateFr, ':montant' => $montant ));
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		$resultat = PdoGsb::$monPdo->prepare($req); 
		$resultat->execute(array( ':idFrais' => $idFrais ));
	}
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur = :idVisiteur 
		order by fichefrais.mois desc ";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur));	
		$ligne = $idJeuRes->fetch();
		$lesMois =array();
		while($ligne != null)	{
			$mois = $ligne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$ligne = $idJeuRes->fetch();		
		}
		return $lesMois;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$idJeuRes = PdoGsb::$monPdo->prepare($req); 
		$idJeuRes->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois));	
		$ligne = $idJeuRes->fetch();
		return $ligne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = :etat, dateModif = now() 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$resultat = PdoGsb::$monPdo->prepare($req); 
		$resultat->execute(array( ':idVisiteur' => $idVisiteur, ':mois' => $mois, ':etat' => $etat ));
	}
}
?>