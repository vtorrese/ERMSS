<?php
require_once 'Modele.php';

class Type extends Modele {
	
	//recupération des résultats d'une recherche sà partir d'un mot
	public function recup_type() {
		$sql = "SELECT `IDtype`,`Nom_type` FROM `type` WHERE `IDtype` > 1 ORDER BY Nom_type";
		$type = $this->executerRequete($sql);
		return $type->fetchAll();
	}
	
	//Insérer une nouveau type
	public function Insere_nouveau($nomty) {
		$control = self::control_db($nomty);
		if($control[0]['CPT']=='0') {
		$sql = "INSERT INTO type (`Nom_type`) VALUES (?)";
		$ajout = $this->executerRequete($sql,array($nomty));
		}
		return;
	}
	
	//Control db
	public function control_db($nom) {
		$sql = "SELECT COUNT(*) as CPT FROM type WHERE Nom_type =?";
		$ctrl = $this->executerRequete($sql,array($nom));
		return $ctrl->fetchAll();
	}
}

?>