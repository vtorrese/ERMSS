<?php
require_once 'modele/Reference.php';
require_once 'modele/Nomenclature.php';
require_once 'modele/Rss.php';

class ControleurOrganisation {
	
	private $lettre;
	private $definition;
	private $nomenclature;
	private $population;
	private $orientation;
	private $type;
	private $secteur;
	private $public;
	private $suggestion;
	private $footer;
	
	public function __construct() {
		$this->reference = new Reference();
		$this->nomenclature = new Nomenclature();
		$this->rss = new Rss();
	}
	
	public function ouvre($fichier,$panneau) {
		$lettre = $this->reference->recup_initiale();
		$definition = $this->reference->recup_definition();
		$nomenclature = $this->nomenclature->recup_tout();
		$population = $this->nomenclature->recup_pop();
		$orientation = $this->nomenclature->recup_ori();
		$type = $this->nomenclature->recup_type();
		$secteur = $this->nomenclature->recup_secteur();
		$public = $this->nomenclature->recup_public();
		$suggestion = $this->rss->recup_news_orga();
		$suggestion_prof = $this->rss->recup_news_prof();
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'panneau' => $panneau, 'initiale' => $lettre, 'definition' => $definition, 'nomenclature' => $nomenclature, 'population' => $population, 'orientation' => $orientation, 'type' => $type, 'secteur' => $secteur, 'public' => $public, 'suggestion_orga' => $suggestion, 'suggestion_prof' => $suggestion_prof, 'footer' => $footer));
	}
	
	//Affichage du contenu de la page avec des données
	private function affiche_contenu($donnees) {
		$fichier = $donnees['fichier'];
		require_once('vue/header.php');
		extract($donnees);
		// Démarrage de la temporisation de sortie
		ob_start();
		require_once("vue/".$fichier.".php");
		require_once('vue/footer.php');	
	}
}
?>