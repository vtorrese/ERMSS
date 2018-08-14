<div id="suggestion">
<?php $image = "web/image/theme22.jpg";
if (file_exists($image)) {echo "<span class='hide'><img src='$image' style='float : right;width : 15%;height : auto;'></span>";} ?>
<h4>Autour des professions....</h4>

<?php  
	foreach($donnees['suggestion_prof'] as $itm) {
		$tit = substr($itm['titre'],0,55)."...";
		$url = $itm['url'];
		$dat = substr($itm['date'],8,2)."-".substr($itm['date'],5,2)."-".substr($itm['date'],0,4);
		echo "<div id='suggestion_prof'>";
		echo "<a href='$url' target='_blank'>$tit</a><br>";
		echo "<span style='color:red;'>$dat</span>";
		echo "</div>";
	}
?>

</div>