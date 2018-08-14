<?php

$titre_page = "Test Python";

require ("header.php");

$tabresult = array();

	exec("python recherche.py", $tabresult);
	/*foreach($variable as $element) {
		$val = utf8_encode($element);
		var_dump($val);
		array_push($tabresult, $val);
	}*/


var_dump($tabresult);

?>