<br>
<?php
require_once('../../web/librairie/simple_html/simple_html_dom.php');
require_once('../../modele/Theme.php');
require_once('../../modele/Rss.php');

$theme = new Theme();
$recup_theme = (array)$theme->recup_theme();


// flux rss ressources
$lien =array('http://www.ash.tm.fr/rss.xml', 'http://www.tsa-quotidien.fr/rss-all', 'http://www.connexite.fr/flux-rss-theme/40',  'http://www.liens-socio.org/spip.php?page=backend&id_rubrique=21', 'http://calenda.org/feed.php?cat=209' , 'http://calenda.org/feed.php?cat=266', 'http://www2.assemblee-nationale.fr/feeds/detail/documents-parlementaires', 'http://www2.assemblee-nationale.fr/feeds/detail/ID_420120/(type)/instance','http://www.justice.gouv.fr/rss/actualites.xml','http://www.horizon2020.gouv.fr/rid4190/societes-inclusives.rss', 'http://www.anesm.sante.gouv.fr/?page=flux_rss', 'http://www.psppaca.fr/spip.php?page=backend','http://social-sante.gouv.fr/spip.php?page=backend','http://www.espt.asso.fr/component/ninjarsssyndicator/?feed_id=1&format=raw','https://www.psychoactif.org/forum/rss.php','https://www.insee.fr/fr/flux/2','https://www.insee.fr/fr/flux/3','https://www.insee.fr/fr/flux/4','https://www.insee.fr/fr/flux/5','https://www.insee.fr/fr/flux/6');
$a = 0;



for ($nbflux = 0; $nbflux < count($lien); $nbflux++) {
$rss = simplexml_load_file($lien[$nbflux]);


foreach ($rss->channel->item as $item){
$titre = ($item ->title);


$lienx = ($item ->link);
$datetime = date_create($item->pubDate);
$date = date_format($datetime, 'Y-m-d');
$delai = date("Y-m-d", mktime(0, 0, 0, $mois -2, 0, date('Y')));
	foreach($recup_theme as $itheme) {
		$nwth = $itheme['Nom_theme'];
		$nwthid = $itheme['IDtheme'];
		if  ((preg_match(" /$nwth/i ",$titre))&&($date>$delai)){
			
				$rss = new Rss();
				$test_db = $rss->verif_rss($lienx,$titre);
				if(($test_db[0]['CONTROLE'])<1) {
				$premTabRss[$a] = array('titre'=>$titre, 'date'=>$date,'url'=>$lienx,'IDtheme'=>$nwthid, 'Nomth'=>$nwth);
					$a++;
				}
			}
	}


}


}

usort($premTabRss, 'datcompare');

//suppression doublon par titre
$tabrssx = enlev_db($premTabRss);

$cpt = count($tabrssx);
echo "<span style='color : red;'>$cpt</span> rss à insérer<br>";


function datcompare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t2 - $t1;
} 

function enleve_doublon($premTabRss) {
	$tabtemp = array();
	foreach($premTabRss as $itm) {
		
		if(in_array(trim($itm['titre']),$tabtemp)) {
			unset($premTabRss[0]);
		}
		array_push($tabtemp,trim($itm['titre']));
	}
	return $premTabRss;
}

function enlev_db($tab) {
	$cpt = count($tab);
	for ($b=0;$b<$cpt;$b++) {
	$c = $b + 1;
		if ($tab[$c]['titre']===$tab[$b]['titre']) {
			unset($tab[$c]);
		}
	}
	$tab = enleve_doublon($tab);
	return $tab;
}

?>