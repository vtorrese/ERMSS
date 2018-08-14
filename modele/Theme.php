<?php
require_once 'Modele.php';

class Theme extends Modele {
	
	//recupération des références d'un theme donné à partir de son IDtheme
	public function recupInfo($cetheme) {
		$sql = "SELECT `IDtheme`, `Nom_theme` FROM `theme` WHERE IDtheme=?";
		$theme = $this->executerRequete($sql,array($cetheme));
		return $theme->fetchAll();
	}
	
	
	//recupération de la derniere news par themes classés par fréquence
	public function recup_derniers() {
		$sql = 'SELECT `CE_theme` as CETheme, Nom_theme, (select date from rss WHERE CE_theme=CETheme ORDER BY date DESC LIMIT 1) as dat, (select titre from rss WHERE CE_theme=CETheme ORDER BY date DESC LIMIT 1) as tit, (select url from rss WHERE CE_theme=CETheme ORDER BY date DESC LIMIT 1) as url, max(date) as mmax FROM rss JOIN theme ON CE_theme = IDtheme GROUP BY CE_theme, Nom_theme, tit ORDER BY mmax DESC LIMIT 16';
		$dernier_th = $this->executerRequete($sql);
		return $dernier_th->fetchAll();
	}
	
	//pour le TDB compter et ordonner les thèmes en fréquence
	public function compter_theme() {
		$sql = "SELECT id, SUM(amount) as CPTH FROM (SELECT Nom_theme as id, Count(*) AS `amount` FROM reference JOIN theme ON reference.CE_theme = IDtheme GROUP BY id UNION ALL SELECT Nom_theme as id, Count(*) AS `amount` FROM rss JOIN theme ON rss.CE_theme = IDtheme WHERE archive < 1 GROUP BY id) `resultat` GROUP BY `id` ORDER BY SUM(amount) DESC"; 
		$cptr_th = $this->executerRequete($sql);
		return $cptr_th->fetchAll();
	}
	
	//pour la MAJ donner les noms des thèmes + id
	public function recup_theme() {
		$sql = "SELECT IDtheme, Nom_theme from theme WHERE IDtheme > 1 ORDER BY Nom_theme"; 
		$recup_th = $this->executerRequete($sql);
		return $recup_th->fetchAll();
	}
	
	//Insérer nouveau theme
	public function Insere_nouveau($nomth) {
		$control = self::control_db($nomth);
		if($control[0]['CPT']=='0') {
		$sql = "INSERT INTO theme (`Nom_theme`) VALUES (?)";
		$ajoutere = $this->executerRequete($sql,array($nomth));
		}
		return;
	}
	
	//Control db
	public function control_db($nom) {
		$sql = "SELECT COUNT(*) as CPT FROM theme WHERE Nom_theme =?";
		$ctrl = $this->executerRequete($sql,array($nom));
		return $ctrl->fetchAll();
	}
	
}