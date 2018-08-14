<?php

require_once 'Modele.php';

class Nomenclature extends Modele {

	
	public function recup_tout() {
	$sql = 'SELECT IDentite, sigle, definition, mission, disposition, Nom_autorisation, Nom_autorite, Nom_financeur, CE_type, Nom_typessms, CE_secteur, Nom_secteur, cadre 
	FROM entite 
	JOIN autorisation ON CE_autorisation = IDautorisation
	JOIN autorite ON CE_autorite = IDautorite
	JOIN financeur ON CE_financeur = IDfinanceur
	JOIN type_esmss ON CE_type = IDtype_esmss
	JOIN secteur on CE_secteur = IDsecteur
	ORDER BY sigle';
	$nomenc = $this->executerRequete($sql);
	return $nomenc->fetchAll();
	}
	
	public function recup_pop() {
	$sql = "SELECT `Population_entite` as IDent, `IDpopulation`, `Nom_population` FROM `ref_population` JOIN population ON `Population_population` = IDpopulation";
	$pop = $this->executerRequete($sql);
	return $pop->fetchAll();
	}
	
	public function recup_ori() {
	$sql = "SELECT `Orientation_entite` as IDent, `Nom_orientation` FROM `ref_orientation` JOIN orientation ON `Orientation_orientation` = IDorientation";
	$ori = $this->executerRequete($sql);
	return $ori->fetchAll();
	}
	
	public function recup_type() {
	$sql = "SELECT `IDtype_esmss` as idtype, `Nom_typessms` as nomtype FROM `type_esmss` ORDER BY nomtype";
	$type = $this->executerRequete($sql);
	return $type->fetchAll();
	}
	
	public function recup_secteur() {
	$sql = "SELECT `IDsecteur` as idsecteur, `Nom_secteur` as nomsecteur FROM `secteur` ORDER BY nomsecteur";
	$secteur = $this->executerRequete($sql);
	return $secteur->fetchAll();
	}
	
	public function recup_public() {
	$sql = "SELECT `IDpopulation`, `Nom_population` FROM `population` ORDER BY `Nom_population`";
	$public = $this->executerRequete($sql);
	return $public->fetchAll();
	}

}

?>