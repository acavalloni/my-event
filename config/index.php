<?php
	require('config.php');
	require(RACINE.'functions/functions.php');
	require(RACINE.'class/authentification.php');
	$Auth = new Auth();
	$Auth -> setMessage("Vous essayez d'acceder à un dossier qui n'est pas autorisé.","error"); 
	header('Location:../');
?>