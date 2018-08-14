<?php

/*$url = "https://www.cairn.info/resultats_recherche.php?src1=Tx&word1=".$cat.$cible."&exact1=1&operator1=AND&src2=Year&from2=2018&to2=2018&operator2=&nparams=2&submitAdvForm=Chercher";

$result = file_get_html($url);
$cpt=0;
if(empty($cat)) {$cat="Tous types";}
foreach($result->find('a') as $article) {
	echo $article->href."<br>";
	//$tabresult[$cpt] = array("titre" => $article, "url" => $url_fin[1], "categ" => $cat);
	$cpt++;
	$adresse = $article->find('a');
	$url = explode('&',$adresse[0]->href);
	$url_fin = explode('=',$url[0]);
	$titre = utf8_encode($article->plaintext);
	$tabresult[$cpt] = array("titre" => $titre, "url" => $url_fin[1], "categ" => $cat);
	$cpt++;
    //echo $titre." : ".$url_fin[1]."<hr>";
	}*/
	

?>