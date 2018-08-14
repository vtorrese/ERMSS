<?php
require_once('../../modele/Reference.php');

if(isset($_POST['tabart'])) {
	$list_persee = array();
	foreach($_POST['tabart'] as $ref) {
		$reference = unserialize( base64_decode( $ref ) );
		array_push($list_persee, $reference);
	}
	$reference = new Reference();
	$entree = "autre";

	$reference->Insere_ref($list_persee,$entree);
	
	header('Location: edition.php?mode=nouveau');
}
else 
{header('Location: tdb.php');}

?>