<?php
require_once('Modele.php');
require_once('simple_html_dom.php');

class Visite extends Modele {
	
	//recupération des visites
	public function recup_tout() {
		$sql = "SELECT `IDvisite`, `Datex`, `IP`, `host`, `pays`, `region`, `ville` FROM `visite` WHERE `host` NOT LIKE ('%google%') AND `host` NOT LIKE ('%spider%') ORDER BY Datex DESC";
		$visit = $this->executerRequete($sql);
		return $visit->fetchAll();
	}
	
	//Insérer une nouvelle visite
	public function Insere_visite($ip) {
		$url = "https://www.speedguide.net/ip/".$ip;
		$result = file_get_html($url);
		$host = "inconnu";
		$country = "inconnu";
		$region = "inconnu";
		$ville = "inconnu";
		foreach($result->find('td#content') as $article) {
			$ligneatrouver = $article->find('td');
			$cp=0;
			foreach($ligneatrouver as $element) {
				$test = $element->innerText();
				if($test=='hostname: '){$host = $ligneatrouver[$cp+1]->plaintext;}
				if($test=='Country: '){$country = $ligneatrouver[$cp+1]->plaintext;}
				if($test=='Region: '){$region = $ligneatrouver[$cp+1]->plaintext;}
				if($test=='City: '){$ville = $ligneatrouver[$cp+1]->plaintext;}
				$cp++;
			}
		}
		$sql = "INSERT INTO visite (`Datex`,`IP`,`host`,`pays`,`region`,`ville`) VALUES (NOW(),?,?,?,?,?)";
		$ajout = $this->executerRequete($sql,array($ip,$host,$country,$region,$ville));
		
		//Envoi d'un mail simple 
		$date = date("d-m-Y H:i:s");	
		$message = "Le ".$date." : IP->".$ip." | Host->".$host." | Localisation->".$country."-".$region."-".$ville;
		mail('ermss.leglou@gmail.com', 'Alerte click', $message);
		 
		return;
	}
	
	//Cpter le nbre de visites
	public function cpt_visite() {
		$sql = "SELECT COUNT(*) CPTOT, (SELECT COUNT(*) FROM visite WHERE `host` NOT LIKE ('%google%') AND `host` NOT LIKE ('%spider%')) CPT FROM `visite`";
		$visit= $this->executerRequete($sql);
		return $visit->fetchAll();
	}
	
		//Cpter le nbre de visites par jour (pour graph)
	public function cpt_visite_ByDays() {
		$sql = "SELECT Datex, COUNT(*) CPT FROM visite WHERE Datex BETWEEN date(now() - INTERVAL 2 month) AND now() AND `host` NOT LIKE ('%google%') AND `host` NOT LIKE ('%spider%') GROUP BY MONTH(Datex), DAY(Datex) ORDER BY Datex DESC";
		$visit= $this->executerRequete($sql);
		return $visit->fetchAll();
	}
	
		//Cpter le nbre de visites par pays
	public function cpt_visite_ByPays() {
		$sql = "SELECT pays, count(pays) as cpt FROM `visite` WHERE `host` NOT LIKE ('%google%') AND `host` NOT LIKE ('%spider%') group by pays order by cpt desc";
		$visit= $this->executerRequete($sql);
		return $visit->fetchAll();
	}
	
			//Supprimer visite
	public function supprime_visite($ID) {
		$sql = "DELETE FROM visite WHERE IDvisite = ?";
		$sup= $this->executerRequete($sql,array($ID));
		return;
	}
	
		//Record de visites tot sur une journée
	public function cpt_record_Days() {
		$sql = "SELECT CONCAT(DAY(Datex),'-',MONTH(Datex),'-',YEAR(Datex)) JOURECORD, COUNT(*) CPT FROM visite WHERE `host` NOT LIKE ('%google%') AND `host` NOT LIKE ('%spider%') GROUP BY MONTH(Datex), DAY(Datex) ORDER BY CPT DESC LIMIT 1";
		$visit= $this->executerRequete($sql);
		return $visit->fetchAll();
	}
}

?>