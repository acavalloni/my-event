<?php
// version 1.7
// editeur : Anthony Cavalloni

if($_SERVER['SERVER_NAME'] == 'localhost'){
	$db = array();
	$db['host'] = 'localhost'; 
	$db['user'] = 'gugul';
	$db['pass'] = '16021990';
	$db['base'] = 'my_event';

	define("EMAIL_SITE" , "anthonycavalloni@gmail.com");
	define("URL_SITE" , "http://localhost/levallart/");
	define("RACINE" , $_SERVER['DOCUMENT_ROOT'].'/levallart/');
	define("NAME_SITE" , "Pixelzone");
}


if($_SERVER['SERVER_NAME'] != 'localhost'){
	$db = array();
	$db['host'] = 'mysql5-10.perso'; 
	$db['user'] = 'pixelzondata';
	$db['pass'] = 'gugul27';
	$db['base'] = 'pixelzondata';

	define("EMAIL_SITE" , "anthonycavalloni@gmail.com");
	define("URL_SITE" , "http://www.my-event.pixelzone.fr/");
	define("RACINE" , $_SERVER['DOCUMENT_ROOT'].'/');
	define("NAME_SITE" , "My Event");
}

$db['link'] = database_connect($db);
mysql_query("SET NAMES UTF8");

function database_connect($db){
	$link = mysql_connect($db['host'],$db['user'],$db['pass']);
	if(!$link) die("erreur de connexion a la base de donnee".mysql_error());
	if(!mysql_select_db($db['base'])) die ("selection de la base impossible");
	return $link;
}

function database_disconnect($link){
	mysql_close($link);
}

?>