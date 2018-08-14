<?php

require_once 'ControleurAccueil.php';
require_once 'ControleurResultat.php';
require_once 'ControleurOrganisation.php';
require_once 'ControleurJuridique.php';
require_once 'ControleurOutil.php';

class Routeur {

	private $ctrlAccueil;
	private $ctrlResultat;
	private $ctrlOrganisation;
	private $ctrlJuridique;
	private $ctrlOutil;
	
	public function __construct() {
		$this->ctrlAccueil = new ControleurAccueil();
		$this->ctrlResultat = new ControleurResultat();
		$this->ctrlOrganisation = new ControleurOrganisation();
		$this->ctrlJuridique = new ControleurJuridique();
		$this->ctrlOutil = new ControleurOutil();
	}
 
	public function ouvrir() {
		
		 try {
			
			 //Gestion du menu de navigation
			 if(isset($_POST['accueil'])) {

				$fichier = "accueil";
				$this->ctrlAccueil->ouvre($fichier);
			 }
			 else if (isset($_POST['organisation'])) {
					$fichier = "organisation";
					$this->ctrlOrganisation->ouvre($fichier);
			 }
			 else if (isset($_POST['juridique'])) {
					$fichier = "juridique";
					$this->ctrlJuridique->ouvre($fichier);	
			 }
			 else if (isset($_POST['outil'])) {
					$fichier = "outil";
					$this->ctrlOutil->ouvre($fichier);	
			 }
			 else if (isset($_POST['contact'])) {
					$fichier = "contact";
					$this->ctrlAccueil->ouvre($fichier);	
			 }

			 
			//Gestion du bouton de recherche
			if(isset($_POST['valid_rechercher'])) {
				$fichier = "resultat";
				if((isset($_POST['recherche']))&&(!empty($_POST['recherche']))) {
				$recherche = $_POST['recherche'];
				$this->ctrlResultat->ouvre($fichier,$recherche);
				}
				else
				{
					throw new Exception("Recherche invalide !!");
				}
			 }
			 
			 //Gestion du bouton de recherche avancee
			 if(isset($_POST['valid_avc'])) {
				 $fichier = "resultat";
				 $chaineavc = $_POST['mot_avc']."//".$_POST['date1']."//".$_POST['date2']."//".$_POST['choixtheme']."//".$_POST['choixedit']."//".$_POST['choixsup'];
					$this->ctrlResultat->ouvre_avc($fichier,$chaineavc);
					 
			 }
			 
			 //Initialiser la recherche avancee
			 if(isset($_POST['init_avc'])) {
				 $fichier = "resultat";
				 $chaineavc = "// // // // //";
					$this->ctrlResultat->ouvre_avc($fichier,$chaineavc);
			 }
			 
			 ////Gestion du bouton des thèmes (recherche par theme)
			 if(isset($_POST['btn_theme'])) {
				 $cetheme = $_POST['idtheme'];
				 $fichier = "resultat";
				 $this->ctrlResultat->ouvre_theme($fichier,$cetheme);
				 
			 }
			 
			 ////Gestion de la timeline
			 if(isset($_POST['valid_time'])) {
				if(strlen($_POST['choix_theme_time'])>0) {$IDtheme = $_POST['choix_theme_time'];}
				if(strlen($_POST['choix_mot_time'])>0) {$mot = $_POST['choix_mot_time'];}
				$this->ctrlOutil->ouvre_timeline($IDtheme, $mot); 
			 }
			 
			 ///Gestion du menu des outils à disposition
			 if(isset($_POST['out_nomenclature'])) {
				 $fichier = "organisation";
				 $panneau = "esmss";
				 $this->ctrlOrganisation->ouvre($fichier,$panneau);
			 }
			 
			 if(isset($_POST['out_profession'])) {
				 $fichier = "organisation";
				 $panneau = "metier";
				 $this->ctrlOrganisation->ouvre($fichier,$panneau);
			 }
			 
			 if(isset($_POST['out_lexique'])) {
				 $fichier = "organisation";
				 $panneau = "lexique";
				 $this->ctrlOrganisation->ouvre($fichier,$panneau);
			 }
			 
			if(isset($_POST['envoimail'])) {
				
				$this->ctrlAccueil->envoimail();
			}
			 
			if(!isset($fichier)) { // Affichage par défaut de l'accueil
				$fichier = "accueil";
				$this->ctrlAccueil->ouvre($fichier); 
				}
			 }
		 catch (Exception $e) {
			
			$this->erreur($e->getMessage());
			}
			}
   
    // Affiche une erreur
	private function erreur($msgErreur) {
		$fichier_err = $_POST['fichier_err'];
		$fichier = "erreur";
		$this->ctrlAccueil->affiche_contenu(array('message' => $msgErreur, 'fichier' => $fichier, 'fichier_retour' => $fichier_err));
  }
}
		