<?php
require_once 'Modele.php';

class Support extends Modele {
	
	
	//Récupération par IDsupport`
	public function recup_info($supp) {
		$sql = "SELECT `IDsupport`,`Nom_support` FROM `support` WHERE `IDsupport`=? LIMIT 1";
		$IDsupport = $this->executerRequete($sql,array($supp));
		return $IDsupport->fetchAll();
	}
	
	//recupération des résultats d'une recherche sà partir d'un mot
	public function recup_support() {
		$sql = "SELECT `IDsupport`,`Nom_support` FROM `support` WHERE `IDsupport` > 1 ORDER BY Nom_support";
		$support = $this->executerRequete($sql);
		return $support->fetchAll();
	}
	
	//Insérer une nouveau type
	public function Insere_nouveau($nomsp) {
		$control = self::control_db($nomsp);
		if($control[0]['CPT']=='0') {
		$sql = "INSERT INTO support (`Nom_support`) VALUES (?)";
		$ajout = $this->executerRequete($sql,array($nomsp));
		}
		return;
	}
	
	//Control db
	public function control_db($nom) {
		$sql = "SELECT COUNT(*) as CPT FROM support WHERE Nom_support =?";
		$ctrl = $this->executerRequete($sql,array($nom));
		return $ctrl->fetchAll();
	}
}

?>