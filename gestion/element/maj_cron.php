<?php
require_once('../../modele/Maj.php');
$list = new Maj();
	
$tabarchive = $_POST['tabarchive'];
$tabintegre = $_POST['tabintegre'];
$intersection = array_intersect($tabintegre, $tabarchive);

// Pour eviter les doublons archie/integre, on les laisse encore dans la liste de résultats
foreach ($tabarchive as $key=>$value){
    if (in_array($value,$intersection)){
        unset($tabarchive[$key]);
    }
}
foreach ($tabintegre as $key=>$value){
    if (in_array($value,$intersection)){
        unset($tabintegre[$key]);
    }
}

// Gestion de l'archivage des références
if (count($tabarchive)>0) {
	foreach ($tabarchive as $key=>$value){
		$ssrequete .= $value.",";
	}
	$ssrequete = "(".substr($ssrequete,0,-1).")";
	$list->archive($ssrequete,1);
	
}

// Gestion de l'intégration des références
if (count($tabintegre)>0) {
	foreach ($tabintegre as $key=>$value){
		$list->integre($value);
		$idin = "(".$value.")";
		$list->archive($idin,2);
	}

}

header('Location: majx.php');
?>