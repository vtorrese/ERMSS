<div id="progression"></div>

<hr>
<footer>
<img src='web/image/logo.png' alt='title'>
<?php // compteur de références globales

$nbref = (int)$donnees['footer'][0]['nb'];
$nbrss = (int)$donnees['footer'][1]['nb'];
$nbtotal = $nbref + $nbrss;

?>
<span style='padding : 1%;width : 8%;float : left; color : white; font-size : x-small;border-right : 1px solid white;'>&copy; 2017 ERMSS.leglou /<br>c'est <?php echo $nbtotal; ?> références</span>
<form method="POST" name="fmfooter" id="form_footer">
	<span style='padding : 1%;width : 18%;float : left; color : white; font-size : x-small;border-right : 1px solid white;'>Outils<br>
	<input type="submit" name="out_nomenclature" value='- Nomenclature ESMSS'><br>
	<input type="submit" name="out_profession" value="- Nomenclature Métiers" ><br>
	<input type="submit" name="out_lexique" value="- Lexique" ><br>
	<input type="submit" name="juridique" value="- Veille Juridique"><br>
	<input type="submit" name="outil" value="- Chronologies">
	</span>


<?php
if($donnees['fichier']!='contact') { ?>
	<span style='padding : 1%;width : 8%;float : left; color : white; font-size : x-small;'>Contacts<br>
	
	<input type="submit" name="contact" value="- Mentions Légales"><br>
	<input type="submit" name="contact" value="- Envoyer un mail">
	
	</span>
	<span style='padding : 1%;float : right; color : white; font-size : x-small;'>Le site ermss.leglou n'utilise pas de cookies</span>
<?php	
}
?>
</form>



</footer>
</body>
</html>

