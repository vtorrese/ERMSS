<?php
require_once 'Modele.php';

class News extends Modele {
	
	//Cpter le nombre de catégories sur une recherche par mot
	public function compte_mot($recherche) {
		if($recherche){$recherche = str_replace("'","''",$recherche);$req_comp = "AND (titre LIKE '%".$recherche."%' OR url LIKE '%".$recherche."%' OR Nom_theme LIKE '%".$recherche."%')";} else {$req_comp = "";}
		$sql = "SELECT IDrss,0 as `CE_IDcat`, 'news' as Nom_cat,`titre`,date as `vdate`,'' as Nom_personne,'' as Prenom_personne,`url`,'' as Nom_support,'' as num ,`Nom_theme`,'' as Nom_groupe,'' as Nom_type,'' as commentaire
		FROM rss
		LEFT JOIN theme ON CE_theme = IDtheme
		WHERE archive < 1
		".$req_comp."
		ORDER BY CE_IDcat, vdate DESC
		";
		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
	
		//Cpter le nombre de catégories sur une recherche avancée
	public function compte_avc($titre,$datedeb,$datefin,$cethem) {
		
		if(strlen($datedeb)>0) {$date1 = strtotime($datedeb);$db = date('Y-m-d',$date1);$req_datd = "AND date >= '".$db."' ";} else {$req_datd = "";}
		if(strlen($datefin)>0) {$date2 = strtotime($datefin);$df = date('Y-m-d',$date2);$req_datf = "AND date <= '".$df."' ";} else {$req_datf = "";}
		
		if(strlen($titre)>0) {$req_titre = "AND (titre LIKE '%".$titre."%' OR url LIKE '%".$titre."%' OR Nom_theme LIKE '%".$titre."%')";} else {$req_titre = "";}
		if($cethem>0){$req_th = "AND CE_theme ='".$cethem."'";} else {$req_th = "";}
		$sql = "SELECT IDrss,0 as `CE_IDcat`, 'news' as Nom_cat,`titre`,date as `vdate`,'' as Nom_personne,'' as Prenom_personne,`url`,'' as Nom_support,'' as num ,`Nom_theme`,'' as Nom_groupe,'' as Nom_type,'' as commentaire
		FROM rss
		LEFT JOIN theme ON CE_theme = IDtheme
		WHERE archive < 1
		".$req_titre.$req_th.$req_datd.$req_datf."
		ORDER BY CE_IDcat, vdate DESC
		";

		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche par mot
	public function compte_theme($cetheme) {
		if($cetheme>0){$req_comp = "AND CE_theme ='".$cetheme."'";} else {$req_comp = "";}
		$sql = "SELECT IDrss,0 as `CE_IDcat`, 'news' as Nom_cat,`titre`,date as `vdate`,'' as Nom_personne,'' as Prenom_personne,`url`,'' as Nom_support,'' as num ,`Nom_theme`,'' as Nom_groupe,'' as Nom_type,'' as commentaire
		FROM rss
		LEFT JOIN theme ON CE_theme = IDtheme
		WHERE archive < 1
		".$req_comp."
		ORDER BY CE_IDcat, vdate DESC
		";
		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
}

?>