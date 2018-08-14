<?php // page accueil ?>

<div id="bandeau_theme">
<!-- Affichage des panneaux des thémes  -->
<?php foreach($donnees['themes'] as $element) { 


?>
		
<div class="panelA">
<form name="theme_selection" method="POST" class="titre">
<input type="hidden" name="idtheme" value="<?php echo $element['CETheme']; ?>" >
<input type="submit" name="btn_theme" value="<?php echo $element['Nom_theme']; ?>" >
</form>
<?php 
$image = "web/image/theme".$element['CETheme'].".jpg";
if (file_exists($image)) {echo "<img src='$image' alt='image_theme'>";} ?>

<p style="font-size : small;"><?php echo substr($element['dat'],8,2)."-".substr($element['dat'],5,2)."-".substr($element['dat'],0,4); ?></p>
<p style="font-size : small;"><a href="<?php echo $element['url']; ?>" target="_blank"><?php echo substr($element['tit'],0,100)."..."; ?></a></p>

</div>
<?php	
}
?>
</div>

<?php require_once('vue/bandeau_vertical.php'); ?>
