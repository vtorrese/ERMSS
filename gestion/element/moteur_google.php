<?php

$url = "https://www.google.fr/search?hl=fr&gl=fr&tbm=nws&authuser=0&q=".$cat.$cible."&num=".$nb;

$result = file_get_html($url);
$cpt=0;
if(empty($cat)) {$cat="Tous types";}
foreach($result->find('h3') as $article) {
	$adresse = $article->find('a');
	$url = explode('&',$adresse[0]->href);
	$url_fin = explode('=',$url[0]);
	$titre = utf8_encode($article->plaintext);
	$tabresult[$cpt] = array("titre" => $titre, "url" => $url_fin[1], "categ" => $cat);
	$cpt++;
    //echo $titre." : ".$url_fin[1]."<hr>";
	}

?>