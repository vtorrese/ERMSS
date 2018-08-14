<?php

$url = "http://www.persee.fr/search?da=2018&ta=article&l=fre&q=".$cible;

$result = file_get_html($url);
$cpt=0;
var_dump($result);
if(empty($cat)) {$cat="Tous types";}
foreach($result->find('div.doc-result') as $article) {
	$adresse = $article->find('a');
	$url = explode('&',$adresse[0]->href);
	$url_fin = explode('=',$url[0]);
	$titre = utf8_encode($article->plaintext);
	$tabresult[$cpt] = array("titre" => $titre, "url" => $url_fin[1], "categ" => $cat);
	$cpt++;
    echo $titre." : ".$url_fin[1]."<hr>";
	}

?>


