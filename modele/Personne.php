<?php
require_once 'Modele.php';

class Personne extends Modele {
	
	//recupération des résultats d'une recherche sà partir d'un mot
	public function recup_personne() {
		$sql = "SELECT `IDpersonne`,`Nom_personne`,`Prenom_personne` FROM `personne` WHERE `IDpersonne` > 1 ORDER BY Nom_personne, Prenom_personne";
		$groupe = $this->executerRequete($sql);
		return $groupe->fetchAll();
	}
	
	//Insérer nouveau auteur
	public function Insere_nouveau($nom,$prenom) {
		$control = self::control_db($nom,$prenom);
		if($control[0]['CPT']=='0') {
		$sql = "INSERT INTO personne (`Nom_personne`,`Prenom_personne`) VALUES (?,?)";
		$ajoute = $this->executerRequete($sql,array($nom,$prenom));
		}
		return;
	}
	
	//Control db
	public function control_db($nom,$prenom) {
		$sql = "SELECT COUNT(*) as CPT FROM personne WHERE Nom_personne =? AND Prenom_personne =?";
		$ctrl = $this->executerRequete($sql,array($nom,$prenom));
		return $ctrl->fetchAll();
	}
}

?>