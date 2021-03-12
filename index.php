<?php require('config/config.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Event.fr, cr&eacute;ation et partage d'&eacute;v&eacute;nement</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Sur My event, vous pouvez créér et partager vos événements du quotidien, vos fêtes ou vous rendez vous pro en quelques clics !"/>
	<link rel="stylesheet" href="/css/style.css" type="text/css"/>
    <link rel="shortcut icon" href="/css/img/favicon.ico" >
	<link rel="stylesheet" href="/css/jquery-ui-1.8.20.custom.css" type="text/css"/>
	<script type="text/javascript" src="/js/libs/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/js/libs/jquery-ui-1.8.20.custom.min.js"></script>
	<script type="text/javascript" src="/js/libs/datepicker_fr.js"></script>
	<script type="text/javascript" src="/js/main.js"></script>
</head>

<body>
<div id="content">

	<div id="header">
		<h1><img src="css/img/logo.png" alt="My Event"/></h1>
		<h2>Créer et suivre ses événements facilement ET gratuitement !</h2>
	</div>
	
	<div id="sous_header">
		<p>Une surprise pour un ami ? Une soirée ou un rendez vous professionel ? My event vous permet de rassembler vos contacts en quelques clics !</p>
			<div class="mini">
				<img src="css/img/b.gif" alt=""/>
				<p>Rendez vous professionel</p>
			</div>
			<div class="mini">
				<img src="css/img/c.gif" alt=""/>
				<p>Séance de travail</p>
			</div>
			<div class="mini">
				<img src="css/img/f.gif" alt=""/>
				<p>Fête de famille</p>
			</div>
			<div class="mini">
				<img src="css/img/p.gif" alt=""/>
				<p>Sortie, Cinéma</p>
			</div>
			<div class="mini">
				<img src="css/img/m.gif" alt=""/>
				<p>Pot commun, Anniversaire</p>
			</div>
			<div class="clear"></div>
	</div>
	
	<div id="englob_index">
	
	<div id="haut_gauche">
		<h3>Comment cela fonctionne ?</h3>
		<p>Remplissez simplement le formulaire de création de votre évènement et invitez tous vos amis. C'est fini !</p>
		<p>Il ne vous reste plus qu'à suivre les inscriptions de vos amis en temps réel</p>
	</div>
	
	<div id="haut_droit">
		<h3>Laissez vous tenter, testez le ! </h3> 
		<a class="creation_event" href="creation">Créer mon événement !</a>
	</div>
	<div class="clear"></div>
	<div id="bas_gauche">
		<h3>My event utilise-t'il mes informations personnelles ?</h3>
		<p>Non... puisqu'il ne vous les demande pas !</p>
		<p>Vous pouvez simplement renseigner votre adresse email afin de recevoir le lien de votre événement et en garder une trace !</p>
	</div>

	<div id="bas_droit">
		<h3>Pourquoi My-event ?</h3>
		<ul>
			<li>Pas besoin de compte !</li>
			<li>Optimise votre temps !</li>
			<li>C'est gratuit !</li>
			<li>C'est simple !</li>
		</ul>
	</div>	
	<div class="clear"></div>
	</div>

<?php
/*	//AFFICHAGE DE LA LISTE DES EVENTS POUR DEBUG

	$sql_event="SELECT * FROM my_event_event";
	$req_event=mysql_query($sql_event) or die('Erreur de base de donnée SQL !<br />'.$sql_event.'<br />'.mysql_error());
	$tab_event = array();
	while($event = mysql_fetch_array($req_event, MYSQL_ASSOC)){
		$tab_event[] = $event;
	}
	
	for($i=0;$i<count($tab_event);$i++){
		echo "<a href='event/".$tab_event[$i]['url']."'>".$tab_event[$i]['event_name']."</a><br />";
	}
	*/
?>

<div id="footer">
	<a href="http://my-event.pixelzone.fr/creation">Créer son événement</a>
</div>
</div>
</body>
</html>