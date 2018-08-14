<?php
require_once 'modele/Theme.php';
require_once 'modele/Reference.php';

class ControleurAccueil {
	
	private $theme;
	private $image;
	private $mail;
	private $suggestion;
	private $footer;
	private $evenement;
	
	public function __construct() {
		$this->theme = new Theme();
		$this->reference = new Reference();
	}
	
	//Affichage du contenu de la page
	public function affiche($fichier) {
	require_once('vue/header.php');
	require_once("vue/".$fichier.".php");
	require_once('vue/footer.php');

	}
	
	
	//Affichage du contenu de la page avec des données
	public function affiche_contenu($donnees) {
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
		$theme = $this->theme->recup_derniers();
		$suggestion = $this->reference->recup_img();
		$footer = $this->reference->compter_reference();
		$evenement = $this->reference->recup_even();
		self::affiche_contenu(array('fichier' => $fichier, 'themes' => $theme, 'suggestion' => $suggestion, 'footer' => $footer, 'evenement' => $evenement));
	}
	
	//gestion du mail
	public function envoimail() {
		$mail = $this->reference->envoi_mail();
		$fichier = "contact";
		self::affiche_contenu(array('fichier' => $fichier, 'message' => $mail));
	}
	
	
}
	