<br>
<?php
require_once('../../modele/Theme.php');
require_once('../../modele/Reference.php');
require_once('../../web/librairie/simple_html/simple_html_dom.php');

$theme = new Theme();
$recup_theme = (array)$theme->recup_theme();

$lien =array('http://www.revues.org/?page=backend_rssbreves&rub=5562','http://calenda.org/feed.php?cat=238','http://calenda.org/feed.php?cat=235','http://travailemploi.revues.org/backend?format=rssdocuments','http://calenda.org/feed.php?cat=201','http://calenda.org/feed.php?cat=258','http://calenda.org/feed.php?cat=251','http://calenda.org/feed.php?cat=260','http://calenda.org/feed.php?cat=264','http://calenda.org/feed.php?cat=283','https://www.cairn.info/rss/rss_all.xml','http://lectures.revues.org/backend?format=rssdocuments&idcontainer=1430&class=noticesbiblios&descriptionlength=800','http://nouveautes-editeurs.bnf.fr/rss.html?type=livre','http://nouveautes-editeurs.bnf.fr/rss.html?type=cartographique','http://app.parisdescartes.fr/gedfs/rss/Auteurs/1123/mediatheque.xml','https://www.amazon.fr/gp/rss/new-releases/books/ref=zg_bsnr_books_rsslink','http://www.seuil.com/rss/nouveaute','http://www.seuil.com/rss/a-paraitre','http://www.horizon2020.gouv.fr/rid4190/societes-inclusives.rss','http://www.cnam.fr/adminsite/webservices/export_rss.jsp?objet=actualite&CODE_RUBRIQUE=med_cnam&TRI_DATE=DATE_DESC&mp;SELECTION=0007&NOMBRE=30&DESCRIPTION=M%E9dia%20cnam','http://www.irdes.fr/rssEspaceDoc.xml','https://editions.scienceshumaines.com/rss/','http://www.livredepoche.com/books/collection/71/feed','http://www.livredepoche.com/books/genre/73/feed','http://www.esprit.presse.fr/flux-rss/revue','https://www.sas-revue.org/?format=feed&type=rss');

$a=0;

for ($nbflux = 0; $nbflux < count($lien); $nbflux++) {
$rss = simplexml_load_file($lien[$nbflux]);

foreach ($rss->channel->item as $item){
$titre = trim($item ->title);
$url = trim($item ->link);
$datetime = date_create($item->pubDate);
$date = date_format($datetime, 'Y-m-d');
$delai = date("Y-m-d", mktime(0, 0, 0, $mois -2, 0, date('Y')));
$description = trim($item ->description);


	$reference = new Reference();
	$test_db = $reference->verif_ref($url,$titre);
	
	if(($test_db[0]['CONTROLE'])<1) {

	//filtrage en fonction du mot clef
	foreach($recup_theme as $itheme) {
		$nwth = $itheme['Nom_theme'];
		$nwthid = $itheme['IDtheme'];
		

		if (((preg_match("/\b$nwth\b/i", $description)) || (preg_match("/\b$nwth\b/i", $titre)))&&($date>$delai)) {
			
				$result_flux[$a]['titre'] = $titre;
				$result_flux[$a]['url'] = $url;
				$result_flux[$a]['date'] = $date;
				$result_flux[$a]['description'] = $description;
				$result_flux[$a]['idtheme'] = $nwthid;
				$result_flux[$a]['nmtheme'] = $nwth;
				$a++;
				}
		
			}
		}

	}
}



$cpt = count($result_flux);
for ($b=0;$b<$cpt;$b++) { // pour éviter les doublons
	$c = $b + 1;
	if ($result_flux[$c]['titre']===$result_flux[$b]['titre']) {
		unset($result_flux[$c]);
	}
}
usort($result_flux, 'datcomp');
$cpt = count($result_flux);

echo "<span style='color : red;'>$cpt</span> ref à insérer<br>";

function datcomp($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t2 - $t1;
}


?>