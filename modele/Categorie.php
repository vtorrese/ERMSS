<?php
require_once 'Modele.php';

class Categorie extends Modele {
	
	
	
	//Récupérer un tableau avec les ID et les noms de categorie en clé
	public function recup_cat() {
		$sql = "SELECT IDcat, Nom_cat from cat"; 
		$recup_cat = $this->executerRequete($sql);
		return $recup_cat->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche par mot
	public function compte_mot($recherche) {
		if($recherche){$recherche = str_replace("'","''",$recherche);$req_comp = "AND (titre LIKE '%".$recherche."%' OR commentaire LIKE '%".$recherche."%' OR url LIKE '%".$recherche."%' OR Nom_support LIKE '%".$recherche."%' OR Nom_personne LIKE '%".$recherche."%' OR Prenom_personne LIKE '%".$recherche."%' OR Nom_theme LIKE '%".$recherche."%')";} else {$req_comp = "";}
		$sql = "SELECT CE_IDcat, Nom_cat,count(DISTINCT(IDref)) as NBcat 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe 
		LEFT JOIN ref_personne ON IDref = CE_ref 
		LEFT JOIN personne ON CE_personne = IDpersonne 
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_comp." GROUP BY Nom_cat 
		ORDER BY CE_IDcat
		";
		$cpt_cat = $this->executerRequete($sql);
		return $cpt_cat->fetchAll();
	}

	//Cpter le nombre de catégories sur une recherche par mot dans les news
	public function compte_mot_news($recherche) {
		if($recherche){$recherche = str_replace("'","''",$recherche);$req_comp = "AND (titre LIKE '%".$recherche."%' OR url LIKE '%".$recherche."%' OR Nom_theme LIKE '%".$recherche."%')";} else {$req_comp = "";}
		$sql = "SELECT 0 as `CE_IDcat`, 'news' as Nom_cat, count(*) as NBcat
				from rss
				LEFT JOIN theme ON CE_theme = IDtheme
				WHERE archive <1
				".$req_comp."
				ORDER BY CE_IDcat
		";
		
		$cpt_cat_news = $this->executerRequete($sql);
		return $cpt_cat_news->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche par theme
	public function compte_theme($cetheme) {
		if($cetheme>0){$req_comp = "AND CE_theme ='".$cetheme."'";} else {$req_comp = "";}
		$sql = "SELECT CE_IDcat, Nom_cat,count(CE_IDcat) as NBcat 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe  
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_comp." GROUP BY Nom_cat 
		ORDER BY CE_IDcat
		";

		$cpt_cat = $this->executerRequete($sql);
		return $cpt_cat->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche par theme dans les news
	public function compte_theme_news($cetheme) {
		if($cetheme>0){$req_comp = "AND CE_theme ='".$cetheme."'";} else {$req_comp = "";}
		$sql = "SELECT 0 as `CE_IDcat`, 'news' as Nom_cat, count(*) as NBcat
				from rss
				LEFT JOIN theme ON CE_theme = IDtheme
				WHERE archive <1
				".$req_comp."
				ORDER BY CE_IDcat
		";
		
		$cpt_cat_news = $this->executerRequete($sql);
		return $cpt_cat_news->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche avancée
	public function compte_theme_avc($titre,$datedeb,$datefin,$cethem) {
		if(strlen($datedeb)>1) {$date1 = strtotime($datedeb);$db = date('Y-m-d',$date1);$req_datd = "AND date >= '".$db."' ";} else {$req_datd = "";}
		if(strlen($datefin)>1) {$date2 = strtotime($datefin);$df = date('Y-m-d',$date2);$req_datf = "AND date <= '".$df."' ";} else {$req_datf = "";}
		
		if(strlen($titre)>0) {$req_titre = "AND (titre LIKE '%".$titre."%' OR url LIKE '%".$titre."%' OR Nom_theme LIKE '%".$titre."%')";} else {$req_titre = "";}
		if($cethem>0){$req_th = "AND CE_theme ='".$cethem."'";} else {$req_th = "";}
		
		$sql = "SELECT 0 as `CE_IDcat`, 'news' as Nom_cat, count(*) as NBcat
				from rss
				LEFT JOIN theme ON CE_theme = IDtheme
				WHERE archive <1
				".$req_titre.$req_th.$req_datd.$req_datf."
				ORDER BY CE_IDcat
		";

		$cpt_cat_avc = $this->executerRequete($sql);
		return $cpt_cat_avc->fetchAll();
	}
	
	//Insérer une nouelle categorie
	public function Insere_nouveau($nomcat) {
		$control = self::control_db($nomcat);
		if($control[0]['CPT']=='0') {
			
		$sql = "INSERT INTO cat (`Nom_cat`) VALUES (?)";
		$ajoutere = $this->executerRequete($sql,array($nomcat));
		}
		return;
	}
	
	//Control db
	public function control_db($nom) {
		$sql = "SELECT COUNT(*) as CPT FROM cat WHERE Nom_cat =?";
		$ctrl = $this->executerRequete($sql,array($nom));
		return $ctrl->fetchAll();
	}
	
	//Cpter le nombre de catégories sur une recherche avancée
	public function compte_avc($titre,$datedeb,$datefin,$cethem,$edit,$supp) {
		if(strlen($datedeb)>1) {$date1 = strtotime($datedeb);$db = date('Y-m-d',$date1);$req_datd = "AND vdate >= '".$db."' ";} else {$req_datd = "";}
		if(strlen($datefin)>1) {$date2 = strtotime($datefin);$df = date('Y-m-d',$date2);$req_datf = "AND vdate <= '".$df."' ";} else {$req_datf = "";}
		
		if(strlen($titre)>0) {$req_titre = "AND (titre LIKE '%".$titre."%' OR commentaire LIKE '%".$titre."%' OR url LIKE '%".$titre."%' OR Nom_support LIKE '%".$titre."%' OR Nom_personne LIKE '%".$titre."%' OR Prenom_personne LIKE '%".$titre."%' OR Nom_theme LIKE '%".$titre."%')";} else {$req_titre = "";}
		if($cethem>0){$req_th = "AND CE_theme ='".$cethem."'";} else {$req_th = "";}
		if($edit>0){$req_ed = "AND CE_groupe ='".$edit."'";} else {$req_ed = "";}
		if($supp>0){$req_sp = "AND CE_support ='".$supp."'";} else {$req_sp = "";}
		$sql = "SELECT CE_IDcat, Nom_cat,count(DISTINCT(IDref)) as NBcat 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe 
		LEFT JOIN ref_personne ON IDref = CE_ref 
		LEFT JOIN personne ON CE_personne = IDpersonne 
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_titre.$req_th.$req_ed.$req_sp.$req_datd.$req_datf." GROUP BY Nom_cat 
		ORDER BY CE_IDcat
		";

		$cpt_cat = $this->executerRequete($sql);
		return $cpt_cat->fetchAll();
	}
	
	

}