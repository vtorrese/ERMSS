<?php
require_once 'Modele.php';

class Reference extends Modele {
	
	
	//Récupération compléte d'une référence à partir de son ID
	public function recup_ref_tot($id) {
		$sql = "SELECT * FROM `reference` WHERE IDref =?";
		$refe = $this->executerRequete($sql, array($id));
		return $refe->fetchAll();
	}
	
	
	
	//recupération des résultats d'une recherche sà partir d'un mot
	public function recherche_mot($recherche) {
		if($recherche){$recherche = str_replace("'","''",$recherche);$req_comp = "AND (titre LIKE '%".$recherche."%' OR commentaire LIKE '%".$recherche."%' OR url LIKE '%".$recherche."%' OR Nom_support LIKE '%".$recherche."%' OR Nom_personne LIKE '%".$recherche."%' OR Prenom_personne LIKE '%".$recherche."%' OR Nom_theme LIKE '%".$recherche."%')";} else {$req_comp = "";}
		$sql = "SELECT IDref as ID,`CE_IDcat`, Nom_cat,`titre`,`vdate`,`Nom_personne`,`Prenom_personne`,`url`,`Nom_support`,`num`,`Nom_theme`,`Nom_groupe`,`Nom_type`,`commentaire`,`lien_image` 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe 
		LEFT JOIN ref_personne ON IDref = CE_ref 
		LEFT JOIN personne ON CE_personne = IDpersonne 
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_comp." GROUP BY IDref
		ORDER BY CE_IDcat, vdate DESC
		";
		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
	
	//recupération des résultats d'une recherche sà partir d'un theme
	public function recherche_theme($cetheme) {
		if($cetheme>0){$req_comp = "AND CE_theme ='".$cetheme."'";} else {$req_comp = "";}
		$sql = "SELECT IDref as ID,`CE_IDcat`, Nom_cat,`titre`,`vdate`,`Nom_personne`,`Prenom_personne`,`url`,`Nom_support`,`num`,`Nom_theme`,`Nom_groupe`,`Nom_type`,`commentaire`,`lien_image` 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe 
		LEFT JOIN ref_personne ON IDref = CE_ref 
		LEFT JOIN personne ON CE_personne = IDpersonne 
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_comp." GROUP BY IDref
		ORDER BY CE_IDcat, vdate DESC
		";
		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
	
	
	//récupération des résultats à partir d'une recherche avancée
	public function recherche_avc($titre,$datedeb,$datefin,$cethem,$edit,$supp) {
		
		if(strlen($datedeb)>1) {$date1 = strtotime($datedeb);$db = date('Y-m-d',$date1);$req_datd = "AND vdate >= '".$db."' ";} else {$req_datd = "";}
		if(strlen($datefin)>1) {$date2 = strtotime($datefin);$df = date('Y-m-d',$date2);$req_datf = "AND vdate <= '".$df."' ";} else {$req_datf = "";}
		
		if(strlen($titre)>0) {$req_titre = "AND (titre LIKE '%".$titre."%' OR commentaire LIKE '%".$titre."%' OR url LIKE '%".$titre."%' OR Nom_support LIKE '%".$titre."%' OR Nom_personne LIKE '%".$titre."%' OR Prenom_personne LIKE '%".$titre."%' OR Nom_theme LIKE '%".$titre."%')";} else {$req_titre = "";}
		if($cethem>0){$req_th = "AND CE_theme ='".$cethem."'";} else {$req_th = "";}
		if($edit>0){$req_ed = "AND CE_groupe ='".$edit."'";} else {$req_ed = "";}
		if($supp>0){$req_sp = "AND CE_support ='".$supp."'";} else {$req_sp = "";}
		$sql = "SELECT IDref as ID,`CE_IDcat`, Nom_cat,`titre`,`vdate`,`Nom_personne`,`Prenom_personne`,`url`,`Nom_support`,`num`,`Nom_theme`,`Nom_groupe`,`Nom_type`,`commentaire`,`lien_image` 
		FROM reference 
		LEFT JOIN cat ON CE_IDcat = IDcat 
		LEFT JOIN support ON CE_support = IDsupport 
		LEFT JOIN groupe ON CE_groupe = IDgroupe 
		LEFT JOIN ref_personne ON IDref = CE_ref 
		LEFT JOIN personne ON CE_personne = IDpersonne 
		LEFT JOIN theme ON CE_theme = IDtheme 
		LEFT JOIN type ON CE_type = IDtype
		WHERE `CE_IDcat` NOT IN ('4') ".$req_titre.$req_th.$req_ed.$req_sp.$req_datd.$req_datf." GROUP BY IDref
		ORDER BY CE_IDcat, vdate DESC
		";
		$result = $this->executerRequete($sql);
		return $result->fetchAll();
	}
	
	//Récupération de l'initiale des mots présents dans le lexique
	public function recup_initiale() {
		$sql = "SELECT DISTINCT(LEFT(titre, 1)) AS initial FROM `reference` WHERE CE_IDcat = 4";
		$initiale = $this->executerRequete($sql);
		return $initiale->fetchAll();
	}
	
	//Récupération des sigles definition + initiale présents dans le lexique
	public function recup_definition() {
		$sql = "SELECT LEFT(titre, 1) AS initial, titre, commentaire FROM `reference` WHERE CE_IDcat = 4 ORDER BY titre";
		$definition = $this->executerRequete($sql);
		return $definition->fetchAll();		
	}
	 
	//Récupération d'une image bandeau suggestion
	public function recup_img() {
			
			//commencer par choisir une référence au hasard
			$sql="SELECT IDref, titre, url, vdate, Nom_type, Nom_Support, Nom_groupe, num, lien_image FROM `reference` JOIN support ON CE_support =IDsupport JOIN type ON CE_type =IDtype JOIN groupe ON CE_groupe = IDgroupe WHERE `lien_image` IS NOT NULL  AND month(vdate) > (month(now())-6) AND year(vdate) = year(now()) ORDER BY RAND() LIMIT 1";
			$suggestion = $this->executerRequete($sql);
			return $suggestion->fetchAll();

	}
	

		//Récupération des auteurs d'une référence
	public function recup_auteur($id) {
		$sql="SELECT IDpersonne FROM `ref_personne` JOIN personne ON CE_personne = IDpersonne WHERE `CE_ref` =?";
		$IDpersonne = $this->executerRequete($sql,array($id));
		return $IDpersonne->fetchAll();
	}
	
	//Récupération des textes de lois pour la page juridique
	public function recup_textes() {
		$sql="SELECT `IDref`, `titre`, `url`, `num`, `CE_theme`, `Nom_theme`, `CE_type`, `Nom_type`, `commentaire`, `vdate` FROM `reference` JOIN theme ON IDtheme = CE_theme JOIN type ON IDtype = CE_type WHERE `CE_IDcat` = 1 ORDER BY vdate DESC";
		$texte = $this->executerRequete($sql);
		return $texte->fetchAll();
	}
	
	//Récupération des textes de lois par types
	public function recup_NBtype() {
		$sql="SELECT Nom_type, Count(CE_type) as NBt, CE_type FROM reference JOIN type ON IDtype = CE_type WHERE `CE_IDcat` = 1 GROUP BY Nom_type ORDER BY NBt DESC";
		$typet = $this->executerRequete($sql);
		return $typet->fetchAll();
	}
	
	//Pour récupérer les données de la timeline
	public function recup_timeline($IDtheme, $mot) {
		if($IDtheme!=null){$req_th = "AND CE_theme ='".$IDtheme."'";} else {$req_th = "";}
		if($mot!=null) {$req_titre = " AND (titre LIKE '%".$mot."%' OR commentaire LIKE '%".$mot."%' OR url LIKE '%".$mot."%')";$req_rss = " AND (titre LIKE '%".$mot."%' OR url LIKE '%".$mot."%')";} else {$req_titre = "";$req_rss = "";}
		$sql="(SELECT Nom_cat, titre, YEAR(vdate) as annee, MONTH(vdate) as mois, DAY(vdate) as jour, CE_theme, commentaire, url, Nom_type FROM reference JOIN cat ON CE_IDcat = IDcat JOIN type ON CE_type = IDtype WHERE CE_IDcat NOT IN (3, 4, 8) ".$req_th.$req_titre." ORDER BY vdate) UNION (SELECT 'News' as Nom_cat, titre, YEAR(date) as annee, MONTH(date) as mois, DAY(date) as jour, CE_theme,'', url, '' as Nom_type FROM rss WHERE archive < 1 ".$req_th.$req_rss.") ORDER BY annee, mois, jour";

		$timel = $this->executerRequete($sql, array($theme, $mot));
		return $timel->fetchAll();
	}
	
	//Pour récupérer les derniers événements
	public function recup_even() {
		$sql ="SELECT titre, url, vdate, lien_image FROM `reference` WHERE `CE_IDcat` = 6 AND CE_type = 11 ORDER BY vdate DESC LIMIT 5";
		$even = $this->executerRequete($sql);
		return $even->fetchAll();
	}
	
	////////////// GESTION ERMSS ///////////////////////////////////////////////////////////////
	
	public function compter_reference() {
			$sql="SELECT 'references' as base, count(IDref) as nb FROM `reference` UNION SELECT 'rss valides' as base, count(IDrss) from rss where archive <1 UNION SELECT 'rss non valides' as base, count(IDrss) from rss where archive >0";
			$compte = $this->executerRequete($sql);
			return $compte->fetchAll();
			}
			
	public function compter_categorie() {
			$a =0;
			$reqte = "SELECT COUNT(CE_IDcat) AS CPT FROM `reference` WHERE CE_IDcat IS NOT Null GROUP BY CE_IDcat ORDER BY CE_IDcat";
			$data = $this->executerRequete($reqte);
		
			while ($drone = $data->fetch()) {
				$tib[$a++] = $drone['CPT'];
			}
			return $tib;
			}
			
	public function dater_reference() {
			$sql="(SELECT 'references' as base, vdate FROM `reference` WHERE vdate IS NOT NULL ORDER BY vdate DESC limit 1) UNION (SELECT 'rss valides' as base, (date) as vdate FROM rss WHERE archive < 1 ORDER BY vdate DESC limit 1)";
			$dater = $this->executerRequete($sql);
			return $dater->fetchAll();
			}
	
	public function sans_auteur() {
			$sql="SELECT IDref from reference WHERE IDref NOT IN (SELECT IDref FROM `ref_personne` join reference on IDref = CE_ref) AND CE_IDcat IN (2,5) ORDER BY IDref DESC";
			$ssauteur = $this->executerRequete($sql);
			return $ssauteur->fetchAll();
			}

	public function sans_image() {
			$sql="SELECT IDref, url from reference WHERE CE_IDcat NOT IN (4) AND lien_image IS NULL ORDER BY IDref DESC";
			$ssimage = $this->executerRequete($sql);
			return $ssimage->fetchAll();
			}
			
	public function sans_com() {
			$sql="SELECT `IDref` FROM `reference` WHERE commentaire = '' ORDER BY IDref DESC";
			$sscom = $this->executerRequete($sql);
			return $sscom->fetchAll();
			}
			
	public function recup_url($min,$nb) {
			$sql="SELECT IDref, url from reference WHERE url NOT IN ('') AND IDref>".$min." ORDER BY IDref LIMIT ".$nb;
			$sscom = $this->executerRequete($sql);
			return $sscom->fetchAll();
	}
	
	public function taille_table() {
			$sql="SELECT TABLE_NAME, ROUND(((DATA_LENGTH + INDEX_LENGTH - DATA_FREE) / 1024 / 1024), 2) AS TailleMo FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'ERMSS' ORDER BY TailleMo DESC";
			$taille = $this->executerRequete($sql);
			return $taille->fetchAll();
			}
	
	public function verif_ref($lienx,$tit) {
			$sql="SELECT count(*) as CONTROLE FROM `reference` WHERE `url` =? OR `titre` =?";
			$verif = $this->executerRequete($sql,array($lienx,$tit));
			return $verif->fetchAll();
			}
	
	public function Insere_ref($tableau,$mode) {
			if($mode=='archive') {
				$valeurs = "";
				foreach($tableau as $item) {
					  $cat = 1;
					  $titre = str_replace("'","\'",$item['titre']);
					  $url = str_replace("'","\'",$item['url']);
					  $num = $item['num'];
					  $theme = $item['idtheme'];
					  $type = $item['idtype'];
					  $date = $item['date'];
					  $valeur .= ",('$cat','$titre','$url','$num','$date','$theme','$type','$date')"; 
					}
				$valeur = substr($valeur,1);
				$sql = "INSERT INTO reference (`CE_IDcat`, `titre`, `url`, `num`, `dateraj`,`CE_theme`, `CE_type`, `vdate`) VALUES ".$valeur;
				$ajouter_reference = $this->executerRequete($sql);
				return;
			}
			else
			{
				//faire l'intégration d'une ref par le menu reference de la maj
				$valeurs = "";
				foreach($tableau as $item) {
					  $titre = str_replace("'","\'",$item['titre']);
					  $url = str_replace("'","\'",$item['url']);
	
					if($item['desc_rvsvo']) {$description = substr($item['desc_rvsvo'],1);} else {
						$description = str_replace("'","\'",substr($item['description'],1,395));
					}
					  $theme = $item['idtheme'];
					  $date = $item['date'];
					  $valeur .= ",('$titre','$url','$date','$theme','$description','$date')"; 
					}
				$valeur = substr($valeur,1);
				$sql = "INSERT INTO reference (`titre`, `url`, `dateraj`,`CE_theme`, `commentaire`, `vdate`) VALUES ".$valeur;

				
				$ajouter_reference = $this->executerRequete($sql);
				return;
			}
			}
	
	//Fonction importante pour la boucle de la page edition
	public function recup_newref() {
			$sql="SELECT * FROM `reference` WHERE CE_IDcat IS Null ORDER BY IDref";
			$sscat = $this->executerRequete($sql);
			return $sscat->fetchAll();
			}
			
	//Ajouter un nouvel auteur à une référence précise
	public function Insere_auteur($idnwauteur,$idref) {
			if($idnwauteur>0) {
			//On commence par vérifier que l'auteur n'existe pas déjà
				$control = self::verif_auteur($idnwauteur,$idref);
				if($control[0]['controle']<1) {
				$valeur = "('".$idref."','".$idnwauteur."')";
				$sql = "INSERT INTO ref_personne (`CE_ref`, `CE_personne`) VALUES ".$valeur;
				$ajouter_auteur = $this->executerRequete($sql);
				}
			}
			return;
	}
	
	//Vérifier si un auteur n'est pas déjà dans la base pour une ref
	public function verif_auteur($idpers,$idref) {
			$sql="SELECT count(*) as controle FROM `ref_personne` WHERE `CE_personne` =? AND `CE_ref` =?";
			$dbauteur = $this->executerRequete($sql,array($idpers,$idref));
			return $dbauteur->fetchAll();
	}
	
	//Pour supprimer un auteur
	public function Supprime_auteur($idref,$idauteur) {
			$sql="DELETE FROM ref_personne WHERE `CE_ref`=? AND `CE_personne`=?";
			$supp_auteur = $this->executerRequete($sql,array($idref,$idauteur));
			return;
			}
			
	//Pour supprimer une référence
	public function Supprime_reference($idref) {
			$sql="DELETE FROM reference WHERE `IDref`=?";
			$supp_ref = $this->executerRequete($sql,array($idref));
			return;
			}
	
	//Modifie une référence
	public function Modifie_reference($idref,$titre,$categorie,$date,$theme,$type,$url,$groupe,$support,$num,$commentaire,$image) {
			$sql="UPDATE `reference` SET `CE_IDcat`=?,`titre`=?,`url`=?,`CE_support`=?,`num`=?,`CE_theme`=?,`CE_groupe`=?,`CE_type`=?,`commentaire`=?,`vdate`=?,`lien_image`=? WHERE `IDref`=?";
			$supp_ref = $this->executerRequete($sql,array($categorie,$titre,$url,$support,$num,$theme,$groupe,$type,$commentaire,$date,$image,$idref));
			return;
		
	}
	
	//modifie une img par defaut d'une ref
	public function Insere_img($idref,$adresse) {
			$img = 'https://images-eu.ssl-images-amazon.com/images/I/81QTqUhQ-DL._SL150_.jpg';
			$sql="UPDATE `reference` SET `lien_image`=? WHERE `IDref`=?";
			$supp_ref = $this->executerRequete($sql,array($adresse,$idref));
			return;
	}
	
	//Pour ajouter une reference unique (procedure particuliere)
	public function Enregistre_reference($titre,$categorie,$date,$theme,$type,$url,$groupe,$support,$num,$commentaire,$image) {
		$sql="INSERT INTO reference (`CE_IDcat`,`titre`, `url`, `CE_support`,`num`,`dateraj`,`CE_theme`,`CE_groupe`, `CE_type`,`commentaire`, `vdate`,`lien_image`) VALUES (?,?,?,?,?,NOW(),?,?,?,?,?,?)";
			$supp_ref = $this->executerRequete($sql,array($categorie,$titre,$url,$support,$num,$theme,$groupe,$type,$commentaire,$date,$image));
			return;
	}
	
	//Donne le dernier ID entré
	public function recup_lastID() {
		$sql="SELECT MAX(IDref) as dernier FROM `reference`";
			$supp_last_ref = $this->executerRequete($sql);
			return $supp_last_ref->fetchAll();
	}
	
	//Donne la structure de la base par theme
	public function structure_theme() {
		$sql="SELECT Nom_theme, Nom_cat, COUNT(`CE_IDcat`) CPT FROM reference JOIN theme ON `CE_theme` = IDtheme JOIN cat ON `CE_IDcat` = IDcat GROUP BY CE_theme, `CE_IDcat` ORDER BY Nom_theme, CPT DESC";
		$struc_th = $this->executerRequete($sql);
			return $struc_th->fetchAll();
	}
	
	//Donne la structure de la base par catégorie
	public function structure_cat() {
		$sql="SELECT Nom_cat, Nom_theme, COUNT(`CE_IDcat`) CPT FROM reference JOIN theme ON `CE_theme` = IDtheme JOIN cat ON `CE_IDcat` = IDcat GROUP BY Nom_cat,`CE_theme` UNION SELECT 'rss' as Nom_cat, Nom_theme, count(*) as CPT FROM `rss` JOIN theme ON CE_theme = IDtheme WHERE `archive` = 0 GROUP BY Nom_cat, Nom_theme";
		$struc_cat = $this->executerRequete($sql);
			return $struc_cat->fetchAll();
	}
	
	//////////////////gestion du mail //////////////////////////
	public function envoi_mail() {
		/*
    	********************************************************************************************
    	CONFIGURATION
    	********************************************************************************************
    */
    // destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
	
    $destinataire = 'ermss.leglou@gmail.com';
     
    // copie ? (envoie une copie au visiteur)
    $copie = 'oui'; // 'oui' ou 'non'
     
    // Messages de confirmation du mail
    $message_envoye = "Votre message nous est bien parvenu ! Nous nous efforçons de vous répondre rapidement.";
    $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
     
    // Messages d'erreur du formulaire
    $message_erreur_formulaire = "Le bouton d'envoi ne fonctionne pas.";
    $message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
     
    /*
    	********************************************************************************************
    	FIN DE LA CONFIGURATION
    	********************************************************************************************
    */
     
    // on teste si le formulaire a été soumis
    if (!isset($_POST['envoimail']))
    {
    	// formulaire non envoyé
    	return $message_erreur_formulaire;
    }
    else
    {
    	/*
    	 * cette fonction sert à nettoyer et enregistrer un texte
    	 */
    	function Rec($text)
    	{
    		$text = htmlspecialchars(trim($text), ENT_QUOTES);
    		if (1 === get_magic_quotes_gpc())
    		{
    			$text = stripslashes($text);
    		}
     
    		$text = nl2br($text);
    		return $text;
    	};
     
    	/*
    	 * Cette fonction sert à vérifier la syntaxe d'un email
    	 */
    	function IsEmail($email)
    	{
    		$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
    		return (($value === 0) || ($value === false)) ? false : true;
    	}
     
    	// formulaire envoyé, on récupère tous les champs.
    	$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    	$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
    	$objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
    	$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
     
    	// On va vérifier les variables et l'email ...
    	$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
     
    	if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
    	{
    		// les 4 variables sont remplies, on génère puis envoie le mail
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
    				'Reply-To:'.$email. "\r\n" .
    				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
    				'Content-Disposition: inline'. "\r\n" .
    				'Content-Transfer-Encoding: 7bit'." \r\n" .
    				'X-Mailer:PHP/'.phpversion();
    	
    		// envoyer une copie au visiteur ?
    		if ($copie == 'oui')
    		{
    			$cible = $destinataire.';'.$email;
    		}
    		else
    		{
    			$cible = $destinataire;
    		};
     
    		// Remplacement de certains caractères spéciaux
    		$message = str_replace("&#039;","'",$message);
    		$message = str_replace("&#8217;","'",$message);
    		$message = str_replace("&quot;",'"',$message);
    		$message = str_replace('<br>','',$message);
    		$message = str_replace('<br />','',$message);
    		$message = str_replace("&lt;","<",$message);
    		$message = str_replace("&gt;",">",$message);
    		$message = str_replace("&amp;","&",$message);
     
    		// Envoi du mail
    		$num_emails = 0;
    		$tmp = explode(';', $cible);
    		foreach($tmp as $email_destinataire)
    		{
    			if (mail($email_destinataire, $objet, $message, $headers))
    				$num_emails++;
    		}
     
    		if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
    		{
    			return $message_envoye;
    		}
    		else
    		{
    			return $message_non_envoye;
    		};
    	}
    	else
    	{
    		// une des 3 variables (ou plus) est vide ...
    		return $message_formulaire_invalide;
    	};
    }; // fin du if (!isset($_POST['envoi']))
		
	}
	

	
}