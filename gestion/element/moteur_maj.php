<?php 
require_once('../../modele/Reference.php');
require_once('../../modele/Rss.php');

//var_dump(intval(count($_POST['idrvorg'])));
if(isset($_POST['idrvorg'])) {
	$last_mail_rvo = array();
	$pt=0;
	foreach($_POST['idrvorg'] as $key => $value) {
	$decoup = explode("*",$_POST['fcrvo'][$key]);
		$vadtex = explode(" ",substr($decoup[0],1));
		$tabmois = array('janvier'=>"01",'février'=>"02",'mars'=>"03",'avril'=>"04",'mai'=>"05",'juin'=>"06",'juillet'=>"07",'août'=>"08",'septembre'=>"09",'octobre'=>"10",'novembre'=>'11','décembre'=>"12");
		$labeldate =  $vadtex[2]."-".$tabmois[$vadtex[1]]."-".$vadtex[0];
		
		$last_mail_rvo[$pt] = array('desc_rvsvo'=> " ".$decoup[2], 'url'=>substr($decoup[1],1),'date'=>$labeldate);
		$pt++;
	}
	$reference = new Reference();
	$entree = "autre";
	$reference->Insere_ref($last_mail_rvo,$entree);
}

if(isset($_POST['selection_mail'])) {$liste_archive = unserialize( base64_decode( $_POST['selection_mail'] ) );} else {$liste_archive = null;}

if($_POST['tab']) {
	$last_mail = array();
	foreach($_POST['tab'] as $id) {
		array_push($last_mail, $liste_archive[$id]); 
	}
	//$last_mail tableau à envoyer vers les méthodes de la classe reference

	$reference = new Reference();
	$entree = "archive";
	$reference->Insere_ref($last_mail,$entree);
	
}

if(isset($_POST['selection_rss'])) {$liste_rss = unserialize( base64_decode( $_POST['selection_rss'] ) );} else {$liste_rss = null;}

if($_POST['tabrss']) {
	$last_rss = array();
	foreach($_POST['tabrss'] as $id) {
		array_push($last_rss, $liste_rss[$id+1]); 
		
	}
	//$last_rss tableau à envoyer vers les méthodes de la classe reference

	$rss = new Rss();
	$rss->Insere_rss($last_rss);
}

if(isset($_POST['selection_ref'])) {$liste_ref = unserialize( base64_decode( $_POST['selection_ref'] ) );} else {$liste_ref = null;}

if($_POST['tabref']) {
	$last_ref = array();
	foreach($_POST['tabref'] as $id) {
		array_push($last_ref, $liste_ref[$id]); 
	}
	//$last_ref tableau à envoyer vers les méthodes de la classe reference
	$reference = new Reference();
	$entree = "autre";

	$reference->Insere_ref($last_ref,$entree);
	
}
	if(isset($last_ref)) {header('Location: edition.php?mode=nouveau');} else 
	{header('Location: tdb.php');}


 ?>