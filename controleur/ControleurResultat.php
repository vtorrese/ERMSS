<?php
require_once 'modele/Reference.php';
require_once 'modele/Categorie.php';
require_once 'modele/News.php';
require_once 'modele/Theme.php';
require_once 'modele/Groupe.php';
require_once 'modele/Support.php';

class ControleurResultat {
	
	private $resultat;
	private $categorie;
	private $resultat_news;
	private $recherche;
	private $theme;
	private $editeur;
	private $support;
	private $footer;
	
	public function __construct() {
		$this->reference = new Reference();
		$this->categorie= new Categorie();
		$this->news= new News();
		$this->theme= new Theme();
		$this->groupe= new Groupe();
		$this->support= new Support();
	}
	//Gestion des données avant affichage (recherche à partir d'un mot)
	public function ouvre($fichier,$recherche) {
		$resultat = $this->reference->recherche_mot($recherche);
		$theme = $this->theme->recup_theme();
		$editeur = $this->groupe->recup_groupe();
		$support = $this->support->recup_support();
		$categorie = $this->categorie->compte_mot($recherche);
		$categorie_news = $this->categorie->compte_mot_news($recherche);
		$resultat_news = $this->news->compte_mot($recherche);
		$resultat_total = array_merge($resultat_news, $resultat);
		$categorie_total = array_merge($categorie_news, $categorie);
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'recherche' => $recherche,'resultats' => $resultat_total,'NBref' => $categorie_total, 'tabtheme' => $theme,'editeur' => $editeur, 'support' => $support, 'lock' => false, 'footer' => $footer));
	}
	
	//Gestion des données avant affichage (recherche à partir d'un theme)
	public function ouvre_theme($fichier,$cetheme) {
		$resultat = $this->reference->recherche_theme($cetheme);
		$theme = $this->theme->recup_theme();
		$support = $this->support->recup_support();
		$editeur = $this->groupe->recup_groupe();
		$recherche = $this->theme->recupInfo($cetheme);
		$categorie = $this->categorie->compte_theme($cetheme);
		$categorie_news = $this->categorie->compte_theme_news($cetheme);
		$resultat_news = $this->news->compte_theme($cetheme);
		$resultat_total = array_merge($resultat_news, $resultat);
		$categorie_total = array_merge($categorie_news, $categorie);
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'recherche' => "Théme -> ".$recherche[0]['Nom_theme'],'resultats' => $resultat_total,'NBref' => $categorie_total, 'tabtheme' => $theme,'editeur' => $editeur, 'support' => $support, 'lock' => false, 'footer' => $footer));
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
	
	//Gestion des données avant affichage recherche avancée
	public function ouvre_avc($fichier,$chaine) {
		$rechavc = explode('//',$chaine);
		$titre = $rechavc[0];
		$datedeb = $rechavc[1];
		$datefin = $rechavc[2];
		$cethem = $rechavc[3];
		$edit = $rechavc[4];
		$supp = $rechavc[5];
		$resultat = $this->reference->recherche_avc($titre,$datedeb,$datefin,$cethem,$edit,$supp);
		$categorie = $this->categorie->compte_avc($titre,$datedeb,$datefin,$cethem,$edit,$supp);
		$theme = $this->theme->recup_theme();
		$support = $this->support->recup_support();
		$editeur = $this->groupe->recup_groupe();
		if(strlen($titre)>0) {$titrex = $titre;}
		if(strlen($datedeb)>1) {$dated = substr($datedeb,8,2)."-".substr($datedeb,5,2)."-".substr($datedeb,0,4);}
		if(strlen($datefin)>1) {$datef = substr($datefin,8,2)."-".substr($datefin,5,2)."-".substr($datefin,0,4);}
		if(strlen($cethem)>0) {
			$them = $this->theme->recupInfo($cethem);
			$themx = $them[0]['Nom_theme'];
			}
		if(strlen($edit)>0) {
			$gpe = $this->groupe->recup_info($edit);
			$gpex = $gpe[0]['Nom_groupe'];
			}
		if(strlen($supp)>0) {
			$spp = $this->support->recup_info($supp);
			$sppx = $spp[0]['Nom_support'];
			}
		$recherche = $titrex."/".$dated."/".$datef."/".$themx."/".$gpex."/".$sppx;
		$resultat_news = $this->news->compte_avc($titre,$datedeb,$datefin,$cethem);
		$resultat_total = array_merge($resultat_news, $resultat);
		$categorie_news = $this->categorie->compte_theme_avc($titre,$datedeb,$datefin,$cethem);
		$categorie_total = array_merge($categorie_news, $categorie);
		$footer = $this->reference->compter_reference();
		self::affiche_contenu(array('fichier' => $fichier, 'tabtheme' => $theme,'editeur' => $editeur, 'support' => $support,'resultats' => $resultat,'rechercheavc' => $recherche, 'NBref' => $categorie, 'lock' => true, 'footer' => $footer));
	}

	
}