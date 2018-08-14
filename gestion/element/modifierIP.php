<?php
if(isset($_GET['new'])) {
$index = fopen('../../IPG.txt','w');
fputs($index,$_GET['new']);
fclose($index);
}
require("visites.php");
?>