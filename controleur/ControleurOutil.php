<?php
require_once 'modele/Reference.php';
require_once 'modele/Theme.php';
require_once 'modele/Categorie.php';

class ControleurOutil {
	
	private $theme;
	private $footer;
	private $timeline;
	private $categorie;
	
	public function __construct() {
			$this->reference = new Reference();
			$this->theme= new Theme();
			$this->categorie= new Categorie();
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
		//if($donnees['panneau']!='') {exit;}
		}
		
	//Gestion des données avant affichage
	public function ouvre($fichier) {
		$theme = $this->theme->recup_theme();
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'theme' => $theme, 'footer' => $footer));
		}
		
	//Gestion affichage timeline
	public function ouvre_timeline($IDtheme, $mot) {
		$theme = $this->theme->recup_theme();
		$footer = $this->reference->compter_reference();
		$timeline = $this->reference->recup_timeline($IDtheme, $mot);
		$categorie = $this->categorie->recup_cat();
		$fichier = "outil";
		$panneau = "time";
		self::affiche_contenu(array('fichier' => $fichier, 'theme' => $theme, 'footer' => $footer, 'timeline'=> $timeline, 'panneau' => $panneau,'cat'=>$categorie));
		}
		
}

?>