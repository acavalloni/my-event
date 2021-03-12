<?php require('config/config.php');

	if(isset($_POST['date_event_1']) && $_POST['date_event_1']!= NULL && $_POST['date_event_1']!= "" ){	


// INSERTION BDD
	
// on commence par la table event

		if($_POST['name_event']== 'Par ex. : Anniversaire'){
			$event_name=" Mon Evenement";
		}else{
		$event_name= mysql_real_escape_string($_POST['name_event']) ;
		}
		$where = mysql_real_escape_string($_POST['where_event']) ;
		$event_description = mysql_real_escape_string($_POST['descr_event']) ;
		$event_creator = mysql_real_escape_string($_POST['creator_event']) ;

		if(isset($_POST['cadeau_event'])){
			$gift=1;	
		} else{
			$gift=0; 
		}
		$characts    = 'abcdefghijklmnopqrstuvwxyz';
    	$characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
		$characts   .= '1234567890'; 
		$code_aleatoire = ''; 

		for($i=0;$i < 9;$i++)    //9 est le nombre de caractères
		{ 
        	$code_aleatoire .= substr($characts,rand()%(strlen($characts)),1); 
		}
		
		$sql_add_event = "INSERT INTO `my_event_event` VALUES ('','$event_name','$where','$event_description','$gift','$code_aleatoire','$event_creator') ";
		$req_add_event = mysql_query($sql_add_event);

// Recupere l'ID de cet event pour les fk_event 

	$sql_search_event="SELECT * FROM my_event_event WHERE url = '$code_aleatoire'";
	$req_search_event=mysql_query($sql_search_event);
	$tab_search_event = array();
	while($event = mysql_fetch_array($req_search_event, MYSQL_ASSOC)){
		$tab_search_event[] = $event;
	}
	$fk_event = $tab_search_event[0]['id'];		

// Table date
	
	for($i=1;$i<6;$i++){ 
    	if(isset($_POST['date_event_'.$i]) && $_POST['date_event_'.$i]!=NULL ){
			$date= $_POST['date_event_'.$i] ;
			$date= explode(" ", $date);
			$when = explode("/", $date[0]);
			$when = $when[2].'/'.$when[1].'/'.$when[0].'/'.$date[1] ;
			$sql_add_date = "INSERT INTO `my_event_date` VALUES ('','$when','$fk_event')";
			$req_add_date = mysql_query($sql_add_date);
		}
	 } 

// Table gift

	if($gift==1){
		$gift_name= mysql_real_escape_string($_POST['name_cadeau']) ;
		$gift_description = mysql_real_escape_string($_POST['descr_cadeau']) ;
		$cost = intval($_POST['prix_cadeau']) ;
		$sql_add_gift = "INSERT INTO `my_event_gift` VALUES ('','$gift_name','$gift_description','$cost','$fk_event')";
		$req_add_gift = mysql_query($sql_add_gift);
	}
	
// envois du mail


if(isset($_POST['creator_event'])){	
	
	$mail = $_POST['creator_event']; // Déclaration de l'adresse de destination.
	
	if(!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
		$passage_ligne = "\r\n";
	} else{
	$passage_ligne = "\n";
	}
	
	//=====Déclaration des messages au format texte et au format HTML.
		$message = "<h3>Bonjour,</h3>".$passage_ligne.$passage_ligne."<p>Votre événement vient d'être créé. Retrouvez le en consultant le lien suivant : http://my-event.pixelzone.fr/event/".$code_aleatoire."</p>".$passage_ligne.	$passage_ligne."<p>Commencez par vous inscrire, puis envoyez simplement le lien aux personnes que vous souhaitez inviter !</p>".$passage_ligne.$passage_ligne.$passage_ligne."<p><b>L'équipe My Event</b></p>" ;
	//==========
	 
	 
	//=====Définition du sujet.
	$sujet = $event_name." - My Event ";
	//=========
	 
	//=====Création du header de l'e-mail.
	$entete  = 'MIME-Version: 1.0' .$passage_ligne;
  	$entete .= 'Content-type: text/html; charset=UTF-8' .$passage_ligne ;
  	$entete .= 'From: My Event <no-reply@my-event.fr>'.$passage_ligne;
	//==========
	 
	
	//=====Envoi de l'e-mail.
	mail($mail,$sujet,$message,$entete);
	 
	//==========
}
// on verifie que les requetes se soient bien faites	
		if($req_add_event && $req_add_date){

			header('Location:event/'.$code_aleatoire);

		} else{
			?>
<p> Erreur de base de donnée, merci de ré-essayer plus tard. </p>
<?php
		}
	}else{ 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cr&eacute;ation d'&eacute;v&eacute;nement</title>
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

<div id="block_form">
<form action='creation' method='post' id="form_add_event">
    <p class="clear"><label for="name_event">Nom </label><input type='text' name='name_event' id='name_event' value="Par ex. : Anniversaire" 
        onFocus="javascript:this.value=''" onBlur="javascript:if(this.value=='')this.value='Par ex. : Anniversaire'"/></p>
    <p class="clear"><label for="where_event">Où </label><input type='text' name='where_event' id='where_event' /></p>
    <p class="clear"><label for="descr_event">Détails </label>
    <textarea cols="15" rows="2" name='descr_event' id='descr_event'></textarea></p>
	
	<div id="div_date">
	<?php for($i=1;$i<6;$i++){ ?>
		<p class="clear"><?php if($i==1 && isset($_POST['add_event'])) {?><span class="text_red">*</span><?php } ?>
        <label for="date_event_<?php echo $i ; ?>">Dates proposée <?php echo $i ; ?> : </label> 
		<input id="date_event_<?php echo $i ; ?>" class='datepicker' name="date_event_<?php echo $i ; ?>" type="text"></p>
	<?php } ?>
	</div>
	
<p class="clear"><input type="checkbox" value="1" id="cadeau_event" name="cadeau_event" onclick="cadeau_check(this.checked);" /> <label for='cadeau_event'>Pot commun prévu </label>
    <div id="div_check" style="display:none;" class="clear">
    	<p class="clear"><label for="name_cadeau">Nom Cadeau : </label><input type='text' name='name_cadeau' id='name_cadeau' /></p>
        <p class="clear"><label for="descr_cadeau">Description : </label>
    	<textarea cols="20" rows="2" name='descr_cadeau' id='descr_cadeau'></textarea></p>
        <p class="clear"><label for="prix_cadeau">Pot commun fixé à </label><input type='text' name='prix_cadeau' id='prix_cadeau' value="€" 
        onFocus="javascript:this.value=''" onBlur="javascript:if(this.value=='')this.value='€'" /></p>
    </div>
	<p class="clear"><label for="mail_creator">Votre email :</label> <input type='text' name='creator_event' id='mail_creator' /> (facultatif)</p>
    <p class="clear"><input type='submit' id="creer_bouton" value='Créer' name="add_event" /></p>
    <p class="text_red"><?php if(isset($_POST['add_event'])) {?>* Champs obligatoire<?php } ?> </p>
    <div class='clear'></div>
</form>
</div>
<div id="footer">
	<a href="http://my-event.pixelzone.fr/">Retour à l'accueil</a>
</div>
</div>
</body>
</html>   
                <?php
			}
	?>