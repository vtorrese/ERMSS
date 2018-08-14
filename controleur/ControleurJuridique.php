<?php
require_once 'modele/Reference.php';
require_once 'modele/Theme.php';

class ControleurJuridique {
	
	private $textes;
	private $NBtextes;
	private $theme;
	private $footer;
	
	public function __construct() {
		$this->reference = new Reference();
		$this->theme= new Theme();
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
	
	//Gestion des données avant affichage
	public function ouvre($fichier) {
		$textes = $this->reference->recup_textes();
		$NBtextes = $this->reference->recup_NBtype();
		$theme = $this->theme->recup_theme();
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'textes' => $textes, 'NBtype' => $NBtextes, 'theme' => $theme, 'footer' => $footer));
	}
}

?>