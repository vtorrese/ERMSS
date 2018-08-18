<?php
require_once 'Modele.php';

class Rss extends Modele {
	
	
	////////////// GESTION ERMSS ///////////////////////////////////////////////////////////////
	
	
	//pour tout récupérer
	public function ttrecup() {
			$sql="SELECT * FROM `rss`ORDER BY IDrss DESC";
			$recuptt = $this->executerRequete($sql);
			return $recuptt->fetchAll();
	}
	
	//Pour récupérer les inactives
	public function inactrecup() {
			$sql="SELECT * FROM `rss` WHERE archive>0 ORDER BY date DESC";
			$recupttinact = $this->executerRequete($sql);
			return $recupttinact->fetchAll();
	}
	
	//récupérer une rss
	public function supprss($idrss) {
			$sql="DELETE FROM rss WHERE `IDrss`=?";
			$supp_rss = $this->executerRequete($sql,array($idrss));
			return;
	}
	
	//Désactiver/activer rss
	public function activerss($idrss,$statut) {
			if($statut=='on') {$statut = 1;} else {$statut = 0;}
			$sql="UPDATE `rss` SET `archive`=? WHERE `IDrss`=?";
			$activ_rss = $this->executerRequete($sql,array($statut,$idrss));
			return;
	}
	
	//supprimer une rss
	public function slrecup($idrss) {
			$sql="SELECT * FROM `rss` WHERE IDrss =?";
			$recupsl = $this->executerRequete($sql,array($idrss));
			return $recupsl->fetchAll();
	}
	
	//pour modifier une rss
	public function modifierss($idrss,$titre,$url,$cethe,$date,$statut) {
		$titre = str_replace("'","\'",$titre);
		$url = str_replace("'","\'",$url);
		$sql="UPDATE `rss` SET `titre`=?,`date`=?,`url`=?,`CE_theme`=?,`archive`=? WHERE `IDrss`=?";
		$valid_rss = $this->executerRequete($sql,array($titre,$date,$url,$cethe,$statut,$idrss));
		return;
		
	}
	
	//pour vérifier les doublons
	public function verif_rss($lienx,$titre) {
			$trex = "'%".$titre."%'";
			$sql="SELECT count(*) as CONTROLE FROM `rss` WHERE `url` =? OR `titre` LIKE ?";
			$verif = $this->executerRequete($sql,array($lienx,$trex));
			return $verif->fetchAll();
			}
	
	//Pour insérer une nouvelle rss
	public function Insere_rss($tableau) {
		$valeurs = "";
				foreach($tableau as $item) {
					  $titre = str_replace("'","\'",$item['titre'][0]);
					  $url = str_replace("'","\'",$item['url'][0]);
					  $theme = $item['IDtheme'];
					  $date = $item['date'];
					  $valeur .= ",('$titre','$date','$url','$theme','0')"; 
					 
					}
				$valeur = substr($valeur,1);
				$sql = "INSERT INTO rss (`titre`, `date`,`url`, `CE_theme`, `archive`) VALUES ".$valeur;
		
				$ajouter_rss = $this->executerRequete($sql);
				return;
	}
	
	//récupération de quelques news pour le bandeau vertical droit de la page organisation
	public function recup_news_orga() {
			$sql="SELECT * FROM (SELECT IDrss, titre, url, date FROM `rss` WHERE CE_theme = '10' AND `archive` < 1 UNION SELECT IDref, titre, url, vdate date FROM `reference` WHERE CE_theme = '10' AND CE_IDcat NOT IN ('1','4')) REQ ORDER BY date desc, RAND() LIMIT 5";
			$suggestion_orga = $this->executerRequete($sql);
			return $suggestion_orga->fetchAll();
	}
	
	//récupération de quelques news professions pour le bandeau haut de page organisation
	public function recup_news_prof() {
			$sql="SELECT * FROM (SELECT IDrss, titre, url, date FROM `rss` WHERE CE_theme = '22' AND `archive` < 1
			UNION
			SELECT IDref, titre, url, vdate date FROM `reference` WHERE CE_theme = '22' AND CE_IDcat NOT IN ('1','4')) REQ
			ORDER BY date desc, RAND() LIMIT 5";
			$suggestion_prof = $this->executerRequete($sql);
			return $suggestion_prof->fetchAll();
	}
	
	//fonction de recherche par mot du titre
	public function rcrecup($cible) {
		$texts = "'%".$cible."%'";
			$sql="SELECT * FROM `rss` WHERE titre LIKE $texts ORDER BY IDrss DESC";
			$rech_rss = $this->executerRequete($sql);
			return $rech_rss->fetchAll();
	}
	
		//Donne la structure de la base par catégorie
	/*public function structure_cat_rss() {
		$sql="SELECT "rss" as Nom_cat, Nom_theme, count(*) as CPT FROM `rss` JOIN theme ON CE_theme = IDtheme WHERE `archive` = 0 GROUP BY Nom_theme ORDER BY Nom_cat, CPT DESC";
		$struc_cat = $this->executerRequete($sql);
			return $struc_cat->fetchAll();
	}*/
	
	
}
