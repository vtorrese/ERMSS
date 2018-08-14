<br>
<?php
require_once('../../modele/Theme.php');
require_once('../../modele/Reference.php');
require_once('../../modele/Type.php');

$theme = new Theme();
$recup_theme = (array)$theme->recup_theme();
$type = new Type();
$recup_type = (array)$type->recup_type();
foreach($recup_type as $typ) {
	$tabtype[$typ['Nom_type']] = $typ['IDtype'];
}

  $boiteMail = 'pop.orange.fr';
  $port = 110;
  $login = 'vincent.torrese@orange.fr';
  $motDePasse = 'Sp8L34wd';

$imapLink = imap_open('{'.$boiteMail.':'.$port.'/pop3}', $login, $motDePasse);
    // Test sur le retour de la fonction imap_open()
    if(!$imapLink) // Échec
    {
        echo "La connexion a échoué.";
    }
    else // Connexion établie
    {

	// On récupère les informations
	$mailBoxInfos = imap_check($imapLink);
	//imap_close($imapLink);
	$mails = FALSE;
	if(!$mailBoxInfos) // Échec
        {
            echo "La récupération a échoué.";
        }
        else // On affiche ces informations
        {
			
			echo "La boite aux lettres contient ".$mailBoxInfos->Nmsgs." message(s) dont ".
                                            $mailBoxInfos->Recent." recent(s)<br><hr>";
			
			$sujet='';
			$datemes = '';
			$nbMessages = min(150, $mailBoxInfos->Nmsgs);
			$mails = imap_fetch_overview($imapLink, '1:'.$nbMessages, 0);
			$cptlegifrance = 0;
			$cptrevueorg = 0;
			foreach ($mails as $mail) {
				$expediteur = $mail->from;
				$num = $mail->uid;
				if($expediteur=='legifrance@legifrance.gouv.fr') {
					$corpsMail = imap_fetchbody($imapLink, $num,1);
					$sujet = $mail->subject;
					$datemes = $mail->date;
					$cptlegifrance++;					
				}
				if($mail->from==='OpenEdition - La Lettre <noreply@openedition.org>') {
					$revueorg = imap_fetchbody($imapLink, $num,1);
					$cptrevueorg++;
				}
			}
			
			
			if($cptrevueorg>0) {echo $cptrevueorg." message(s) Revue.org à analyser  <br><div id='result'></div><hr>";}
			echo $cptlegifrance." message(s) Legifrance à analyser avec ";
			
			
			$test = explode("=id",$corpsMail);
			$countest = count($test);
			$tabpremiertri = [];
			for ($a=0;$a<$countest-1;$a++) {

				if(strrpos($test[$a],"Loi")) {$rang=strripos($test[$a],"Loi");}
				if(strrpos($test[$a],"Arrêté")) {$rang=strripos($test[$a],"Arrêté");}
				if(strrpos($test[$a],"Décret")) {$rang=strripos($test[$a],"Décret");}
				if(strrpos($test[$a],"Ordonnance")) {$rang=strripos($test[$a],"Ordonnance");}
				if(strrpos($test[$a],"Circulaire")) {$rang=strripos($test[$a],"Circulaire");}			
				//echo substr($test[$a],$rang)."<br>";
				if(isset($rang)) {
					
					
					array_push($tabpremiertri,substr($test[$a],$rang));
					
					}
			}
			
	
			//tri deux
		$tabdeux = [];
			$cible = ['Arrêté','Circulaire','Ordonnance','Loi','Décret'];
			foreach($tabpremiertri as $item) {
				for($a=0;$a<count($cible);$a++) {
					$seuil = $cible[$a];
					$pattern = "#^".$seuil."#";
					if (preg_match($pattern,$item)) {
						array_push($tabdeux,$item);
					}
				}
			}
		
			echo count($tabdeux)." lignes à filtrer<br>";
			echo "<span style='font-size : small'>Sujet : ".$sujet."</span><br>";
			echo "Date : ".$datemes."<br>";
			$tabmois = ['janvier'=>'1','février'=>'2','mars'=>'3','avril'=>'4','mai'=>'5','juin'=>'6','juillet'=>'7','août'=>'8','septembre'=>'9','octobre'=>'10','novembre'=>'11','décembre'=>'12'];
			$pt=0;
			
	
			//tri trois
			foreach($tabdeux as $item) {
				$decoupe = explode(" ",$item);
				$type = $decoupe[0];
				if ($decoupe[1]=='du') {$jour = $decoupe[2];$mois = $decoupe[3];$annee = $decoupe[4];$numero = "";} else {$numero = $decoupe[2];$jour = $decoupe[4];$mois = $decoupe[5];$annee = $decoupe[6];}
				$datex = $annee."-".$tabmois[$mois]."-".$jour." 00:00:00";
				$reste = substr($item , strrpos($item,$annee)+5);
				$titre = substr($reste,0,strrpos($reste,"https"));
				$url = substr($reste,strrpos($reste,"https"));
				//echo $type." ".$numero." | ".$jour." | ".$mois." | ".$annee." | ".$titre." | ".$url."<br>";
				$tabtrois[$pt] = array('type'=>$type,'num'=>$numero,'titre'=>$titre, 'date'=>$datex,'url'=>$url);
				$pt++;
			}
			
			//Tri du tableau trois par date
			usort($tabtrois, 'date_compare');
			
			
			//triquatre : matches avec thème de ERMSS
	
 			$pt=0;
			foreach($tabtrois as $key=>$item) {
				
				$reference = new Reference();
				$test_db = $reference->verif_ref($item['url']);
				if(($test_db[0]['CONTROLE'])<1) {
					$idtype = $tabtype[$item['type']];
					foreach($recup_theme as $itheme) {
							$nwth = $itheme['Nom_theme'];
							$nwthid = $itheme['IDtheme'];
							if  (preg_match(" /$nwth/i ",$item['titre'])){
							$tabquatre[$pt] = array('type'=>$item['type'],'idtype'=>$idtype,'num'=>$item['num'],'titre'=>$item['titre'], 'date'=>$item['date'],'url'=>$item['url'],'nomtheme'=>$nwth,'idtheme'=>$nwthid);
							$pt++;
						}
						
					}
				}
			}
			echo "<span style='color : red;'>$pt</span> lignes à insérer temporairement<br>";
		}

		return array($tabquatre,$revueorg);
		
			
	 } // Connexion établie
	 
	   $imapClose = imap_close($imapLink);
        
        if(!$imapClose) // Échec
        {
            echo "<p style='color : red;'>La fermeture a échoué.</p>";
        }
		else
        {
            echo "<p style='color : green;'>La fermeture a été effectué avec succès.</p>";
        } 
		
	 ////////les fonctions /////////////////////////

	 
	function urlExist($url) {
    $file_headers = @get_headers($url);
    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
       return "Pas ok";
	}
    return "Ok";
}

	function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t2 - $t1;
} 
	
?>
