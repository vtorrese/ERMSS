<?php


abstract class Modele {

  // Objet PDO d'accès à la BD
  private $bdd;

  // Exécute une requête SQL éventuellement paramétrée
  protected function executerRequete($sql, $params = null) {
    if ($params == null) {
	
			$resultat = $this->getBdd()->query($sql);    // exécution directe
	
    }
    else {
      $resultat = $this->getBdd()->prepare($sql);  // requête préparée
      $resultat->execute($params);
    }
    return $resultat;
  }

  // Renvoie un objet de connexion à la BD en initialisant la connexion au besoin
  private function getBdd() {
    if ($this->bdd == null) {
      // Création de la connexion
     /*$this->bdd = new PDO('mysql:host=db625074085.db.1and1.com;dbname=db625074085;charset=utf8', '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	  */
	  $this->bdd = new PDO('mysql:host=localhost:3306;dbname=ERMSS;charset=utf8', '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    return $this->bdd;
  }

}
?>
