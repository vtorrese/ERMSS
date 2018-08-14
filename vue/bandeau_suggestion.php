<div id="suggestion">
<div id="suggestion_img">
<?php  // reception des données pour le bandeau suggestion
$titre_sug = array_column($donnees['suggestion'],"titre");
$url_sug = array_column($donnees['suggestion'],"url");
$editeur_sug = array_column($donnees['suggestion'],"Nom_groupe");
$support_sug = array_column($donnees['suggestion'],"Nom_Support");
$type_sug = array_column($donnees['suggestion'],"Nom_type");
$num_sug = array_column($donnees['suggestion'],"num");
$date_sug = array_column($donnees['suggestion'],"vdate");
$image = array_column($donnees['suggestion'],"lien_image");
?>
<img src="<?php echo $image[0]; ?>" alt="" title="<?php echo $titre_sug[0]; ?>">
<a href="<?php echo $url_sug[0]; ?>" target="_blank"><?php echo $type_sug[0]." ".$titre_sug[0]; ?></a><br>
<p><span><?php echo $editeur_sug[0]."  ".$support_sug[0]." ".$num_sug[0]; ?></span><br>
<?php echo substr($date_sug[0],8,2)."-".substr($date_sug[0],5,2)."-".substr($date_sug[0],0,4); ?>
<br>
<?php echo "Sur ".parse_url($url_sug[0], PHP_URL_HOST); ?></p>
</div>

<div id="suggestion_txt">
<p>
Lieu d'information, de synthèses des principaux cadres juridico-institutionnels en place dans les secteurs sanitaires, sociaux et médico-sociaux, ce site est à destination des professionnels, formateurs, étudiants et bien évidement de toutes personnes intéressées ou directement concernées par ces secteurs. <b>ERMSS</b> est un guide juridique thématique qui cherche la facilité d'utilisation.
</p>
</div>
</div>