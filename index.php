<?php
//Entrée dans le site

require 'controleur/Routeur.php';
require 'modele/Visite.php';

$index = fopen('IPG.txt','r');
$PublicAdress = fgets($index);
fclose($index);

if($_SERVER['REMOTE_ADDR']!=$PublicAdress) {

//Integration d'une visite	
$visite = new Visite();
$visite->Insere_visite($_SERVER['REMOTE_ADDR']);

}
$routeur = new Routeur();
$routeur->ouvrir();

?>
