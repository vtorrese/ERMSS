<?php

require_once('../../modele/Visite.php');

$visite = new Visite();
$visite->supprime_visite($_GET['IP']);

require("visites.php");
?>