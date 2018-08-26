<?php
require_once('Modele.php');
require_once('Theme.php');

class Maj extends Modele {
	
	//recupération de tout les résultats
	public function recup_tout() {
		$sql = "SELECT iddepot_maj ID, origine, titre, url, statut FROM depot_maj";
		$retour = $this->executerRequete($sql);
		return $retour->fetchAll();
	}
	
		//recupération de tout les résultats pour affichage et edition
	public function recup_affichage() {
		$sql = "SELECT iddepot_maj ID, origine, titre, url, statut FROM depot_maj WHERE statut=0 ORDER BY titre";
		$retour = $this->executerRequete($sql);
		return $retour->fetchAll();
	}

			//recupération du nb des résultats pour affichage et edition
	public function recup_base_cpt() {
		$sql = "SELECT origine ORG, (SELECT COUNT(*) FROM ERMSS.depot_maj WHERE statut = 1 AND origine = ORG) arch, (SELECT COUNT(*) FROM ERMSS.depot_maj WHERE statut = 2 AND origine = ORG) intg FROM ERMSS.depot_maj GROUP BY origine";
		$retour = $this->executerRequete($sql);
		return $retour->fetchAll();
	}
	
			//recupération du nb des résultats détaillés avec statut
	public function recup_cpt_affichage() {
		$sql = "SELECT COUNT(*) cpt FROM depot_maj WHERE statut=0";
		$retour = $this->executerRequete($sql);
		return $retour->fetch();
	}
	
	
				//Archiver résultats
	public function archive($ssreq,$stat) {
		$sql = "UPDATE depot_maj SET statut = '".$stat."' WHERE iddepot_maj IN ".$ssreq;
		$sup= $this->executerRequete($sql);
		return;
	}
	
					//Integrer résultats
	public function integre($valreq) {
		// on récupére titre et url de la référence
		$sql = "SELECT titre, url, origine FROM depot_maj WHERE iddepot_maj=".$valreq;
		$sup= $this->executerRequete($sql);
		$tabres = $sup->fetchAll();
		
		
		if($tabres[0][2]!="rss") {
			//on integre dans la base de données référence
			$ddat = date("Y-m-d");
			//var_dump($ddat);
			$titre = str_replace("'","\'",$tabres[0][0]);
			$url = str_replace("'","\'",$tabres[0][1]);
			
			//Vérification doublon sur url reference
			$ssql = "SELECT COUNT(*) CPT FROM ERMSS.reference WHERE url = '".$url."'";
			$ctl = $this->executerRequete($ssql);
			$tabctl = $ctl->fetch();
			if($tabctl['CPT']=='0') {
				$sql = "INSERT INTO reference (`CE_IDcat`, `titre`, `url`,`vdate`) VALUES (0,'".$titre."','".$url."','".$ddat."')";
				//var_dump($sql);
				$ajout = $this->executerRequete($sql);
				}
			} 
		else
		{ //on integre dans la base de données rss
			$theme = new Theme();
			$recup_theme = (array)$theme->recup_theme();
			for($i=0;$i<count($tabres);$i++) {
				foreach($recup_theme as $itheme) {
					$nwth = $itheme['Nom_theme'];
					$nwthid = $itheme['IDtheme'];
					$titre = str_replace("'","\'",$tabres[$i][0]);
					$url = str_replace("'","\'",$tabres[$i][1]);
					if (preg_match(" /$nwth/i ",$titre)) {
						$sql = "INSERT INTO rss (`titre`, `date`,`url`, `CE_theme`, `archive`) VALUES ('".$titre."', NOW(),'".$url."','".$nwthid."',0)";
						//$ajout = $this->executerRequete($sql);
					} else {
						$sql = "INSERT INTO rss (`titre`, `date`,`url`, `CE_theme`, `archive`) VALUES ('".$titre."', NOW(),'".$url."','1',0)";
					}
				}
				
				$ajout = $this->executerRequete($sql);	
			}	
		}
		return;
	}
	
		// historique cron
	public function recup_base_histo() {
		$sql = "SELECT date_cron, origin_cron, duree_cron, nb_cron FROM historique_cron ORDER BY date_cron DESC LIMIT 5;";
		$sup= $this->executerRequete($sql);
		return $sup->fetchAll();
	}
}