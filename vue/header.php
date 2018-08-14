<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta name="google-site-verification" content="iUbx-jklHtaDp8aMNcEpVUfkTtkPQ30nAjzlVamSk54" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="robots" content="index">
		<meta name="description" content="ERMSS est un espace de ressources juridico-institutionnelles sur le secteur sanitaire, médico-social et social. Ils s'adressent aux travailleurs sociaux, futurs professionnels de l'action sociale." />

		<meta name="Keywords" content="emploi,social,emploisocial,travail,social,educateur,specialise,education,specialisee,sportif,technique,animateur,sociale,moteur,recherche,index,thematique,information,magazine,annonces,offres,d'emploi,demploi,social,education,educateur,educatif,educative,specialisee,assistant,assistante,sociale,maternelle,immigration,delinquance,pedagogie,action,enfants,enfance,jeune,jeunes,adolescent,adolescence,auxiliaire,puericulture,directeur,chef de service,conseiller,economie,familiale,animateur,aide medico,psychologique,animation,sdf,prevention,drogue,toxicomanie,addictions,conduites,addictives,handicap,handicape,medico,maltraite,maltraitance,aide,aides,mineur,moniteur,moniteur-educateur,placement,psychologue,psychomotricien,psychomotricite,reeducateur,atelier,formateurs,formation,formations,droit,justice,penal,defense,prestations,tutelles,exclusion,immigration,insertion,logement,allocations,reseau,reseaux,ville,developpement,urbain,institutions,pedagogie,troisieme,age,famille,familles,maltraitance,maltraitances,mediation,mediations,banlieues,quartiers,insecurite,judiciarisation,judiciaire,controle,psychologie,psychotherapie,psychanalyse,assistance,cafme,dees,deas,deje,dsts,irts,creai,amp,cafad,cadfdes,du,cadre,territoires,politiques,conseil,general,diss,ddiss,ase,asef,aemo,aed,segpa,rased,sessad,cv,curriculum,vitae,creai,ancreai,anpf,mnets,societe">

		<meta name="reply-to" content="ermss.leglou@gmail.com">
		<?php ini_set("display_errors",0); ?>
		<title>ERMSS Ressources en travail social</title>
		<link rel="icon" href="web/image/favicon.ico" type="image/x-icon" /> <link rel="shortcut icon" href="web/image/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="web/css/style.css" />
		<script src="web/js/jquery-3.2.1.min.js"></script>
		
		<!--Google analytics-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-78606590-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</head>
	<header>
	
	<?php include('entete.php'); ?>
	
	<?php 

	if(($donnees['fichier']=="accueil")||(empty($donnees['fichier']))) {
	include('bandeau_suggestion.php'); 
	}
	elseif($donnees['fichier']=="organisation") {
	include('bandeau_suggestion_orga.php'); 
	}
	elseif(($donnees['fichier']=="contact")||($_POST["envoimail"])) {
	include('bandeau_suggestion_contact.php'); 
	}
	elseif($donnees['fichier']=="resultat") {
	include('bandeau_resultat.php');  
	}
	elseif($donnees['fichier']=="outil") {
	include('bandeau_outil.php');  
	}
	elseif($donnees['fichier']=="juridique") {
	include('bandeau_juridique.php');  
	}
	elseif($donnees['fichier']=="erreur") {
	include('bandeau_erreur.php');  
	}
	else { // a defaut on affiche le bandeau de suggestion
	include('bandeau_suggestion.php'); 
	}

	?>
	
	<div id="progression"></div>
	
	<?php include('menu.php'); ?>
	
	</header>
	<body>
	

		
