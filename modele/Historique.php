<?php
require_once 'Modele.php';

class Historique extends Modele {
	
	//recupération des données 'référence'
	public function recup_histo_ref() {
		$sql="SELECT histo_date as Hdate, MAX(histo_tot) as Heff FROM `historique_ref` WHERE histo_date BETWEEN date(now() - INTERVAL 2 month) AND now() GROUP BY Hdate ORDER BY `Hdate`";
		$href = $this->executerRequete($sql);
		return $href->fetchAll();
	}
	
	//recupération des données 'rss'
	public function recup_histo_rss() {
		$sql="SELECT histo_date_rss as Hdate, MAX(`histo_rss_act`) as Heffact, MAX(`histo_rss_tot`) as Hefftot FROM `historique_rss` WHERE `histo_date_rss` BETWEEN date(now() - INTERVAL 2 month) AND now() GROUP BY date(histo_date_rss) ORDER BY `historique_rss`.`histo_date_rss` DESC";
		$hrss = $this->executerRequete($sql);
		return $hrss->fetchAll();
	}
	
}

?>