<?php
require_once 'Modele.php';

class Lien_url extends Modele {
	
	//recupération des données totales
	public function recup_tout() {
		$sql="SELECT IDlien_url, label, adresse, (SELECT COUNT(*) FROM reference WHERE lien_image=adresse) CPT FROM lien_url ORDER BY label";
		$lien = $this->executerRequete($sql);
		return $lien->fetchAll();
	}
	
		//Insérer nouveau lien image
	public function ajoute_lien($label,$adresse) {
		$sql = "INSERT INTO lien_url (`label`,`adresse`) VALUES (?,?)";
		$ajout = $this->executerRequete($sql,array($label,$adresse));
		return;
	}
	
		//Pour supprimer un lien image
	public function supp_lien($id) {
			$sql="DELETE FROM lien_url WHERE `IDlien_url`=?";
			$supp_lien = $this->executerRequete($sql,array($id));
			return;
			}
			
		//Pour supprimer un lien image
	public function modif_lien($id,$newadresse) {
			
			//Modification dans la table reference
			$sql = "UPDATE `reference` SET `lien_image`=? WHERE `lien_image` = (SELECT adresse FROM `lien_url` WHERE IDlien_url =?)";
			$modif_lien = $this->executerRequete($sql,array($newadresse,$id));
			
			//Modification dans la table lien_url
			$sql = "UPDATE `lien_url` SET `adresse`=? WHERE `IDlien_url` =?";
			$modif_lien_url = $this->executerRequete($sql,array($newadresse,$id));
			
			return;
			}
}

?>