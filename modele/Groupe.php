<?php
require_once 'Modele.php';

class Groupe extends Modele {
	
	//recupération à partir d'un ID
	public function recup_info($id) {
		$sql = "SELECT `IDgroupe`,`Nom_groupe` FROM `groupe` WHERE `IDgroupe`=? LIMIT 1";
		$IDgroupe = $this->executerRequete($sql,array($id));
		return $IDgroupe->fetchAll();
	}
	
	//recupération des résultats d'une recherche sà partir d'un mot
	public function recup_groupe() {
		$sql = "SELECT `IDgroupe`,`Nom_groupe` FROM `groupe` WHERE `IDgroupe` > 1 ORDER BY Nom_groupe";
		$groupe = $this->executerRequete($sql);
		return $groupe->fetchAll();
	}
	
	//Insérer une nouveau groupe
	public function Insere_nouveau($nomgp) {
		$control = self::control_db($nomgp);
		if($control[0]['CPT']=='0') {
		$sql = "INSERT INTO groupe (`Nom_groupe`) VALUES (?)";
		$ajout = $this->executerRequete($sql,array($nomgp));
		}
		return;
	}
	
	//Control db
	public function control_db($nom) {
		$sql = "SELECT COUNT(*) as CPT FROM groupe WHERE Nom_groupe =?";
		$ctrl = $this->executerRequete($sql,array($nom));
		return $ctrl->fetchAll();
	}
}

?>