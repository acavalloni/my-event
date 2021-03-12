<?php require('config/config.php');
	
	$id_crypt = $_POST['url_event'] ;	

	$sql_decrypt="SELECT id FROM my_event_event WHERE url = '$id_crypt'";
	$req_decrypt=mysql_query($sql_decrypt) or die('Erreur de base de donnée SQL !<br />'.$sql_decrypt.'<br />'.mysql_error());
	$decrypt_count = mysql_num_rows($req_decrypt); //compteur nombre de date de l'evenement
	if($decrypt_count != 1){
		header('Location:/index.php');
	}
	while($decrypt = mysql_fetch_array($req_decrypt, MYSQL_ASSOC)){
		$id_de_event = $decrypt['id'];
	}
	//print_r($id_de_event);
	

	$sql_event="SELECT * FROM my_event_event WHERE id = '$id_de_event'";
	$req_event=mysql_query($sql_event) or die('Erreur de base de donnée SQL !<br />'.$sql_event.'<br />'.mysql_error());
	$tab_event = array();
	while($event = mysql_fetch_array($req_event, MYSQL_ASSOC)){
		$tab_event[] = $event;
	}
	//print_r($tab_event);

	if($tab_event[0]['gift'] == 1){
		$sql_gift="SELECT * FROM my_event_gift WHERE fk_event = '$id_de_event' ORDER BY id";
		$req_gift=mysql_query($sql_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_gift.'<br />'.mysql_error());
		$tab_gift = array();
		while($gift = mysql_fetch_array($req_gift, MYSQL_ASSOC)){
			$tab_gift[] = $gift;
		}
	}
	//print_r($tab_gift);
	
	$sql_date="SELECT * FROM my_event_date WHERE fk_event = '$id_de_event' ORDER BY id";
	$req_date=mysql_query($sql_date) or die('Erreur de base de donnée SQL !<br />'.$sql_date.'<br />'.mysql_error());
	$date_count = mysql_num_rows($req_date); //compteur nombre de date de l'evenement
	$tab_date = array();
	while($date = mysql_fetch_array($req_date, MYSQL_ASSOC)){
		$tab_date[] = $date;
	}
	//print_r($tab_date);
	
	$sql_guest="SELECT * FROM my_event_guest WHERE fk_event = '$id_de_event' ORDER BY id";
	$req_guest=mysql_query($sql_guest) or die('Erreur de base de donnée SQL !<br />'.$sql_guest.'<br />'.mysql_error());
	$tab_guest = array();
	while($guest = mysql_fetch_array($req_guest, MYSQL_ASSOC)){
		$tab_guest[] = $guest;
	}
	//print_r($tab_guest);
	
	$sql_link_date="SELECT * FROM my_event_link_date WHERE fk_event = '$id_de_event' ORDER BY id";
	$req_link_date=mysql_query($sql_link_date) or die('Erreur de base de donnée SQL !<br />'.$sql_link_date.'<br />'.mysql_error());
	$tab_link_date = array();
	while($link_date = mysql_fetch_array($req_link_date, MYSQL_ASSOC)){
		$tab_link_date[] = $link_date;
	}
	//print_r($tab_link_date);
	
	$sql_link_gift="SELECT * FROM my_event_link_gift WHERE fk_event = '$id_de_event' ORDER BY id";
	$req_link_gift=mysql_query($sql_link_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_link_gift.'<br />'.mysql_error());
	$tab_link_gift = array();
	while($link_gift = mysql_fetch_array($req_link_gift, MYSQL_ASSOC)){
		$tab_link_gift[] = $link_gift;
	}
	//print_r($tab_link_gift);

// INSERTION BDD quand on add

if(isset($_POST['add_guest']) && isset($_POST['name_guest']) && $_POST['name_guest']!='Votre Nom'){
	
// table guest
		$guest_name= mysql_real_escape_string($_POST['name_guest']) ;
		$fk_event = $id_de_event ;
		
		$sql_add_guest = "INSERT INTO `my_event_guest` VALUES ('','$guest_name','$fk_event') ";
		$req_add_guest = mysql_query($sql_add_guest);

// Recupere l'ID de ce guest pour les fk_event 

	$sql_search_guest="SELECT * FROM my_event_guest WHERE guest_name = '$guest_name' AND fk_event = '$fk_event'";
	$req_search_guest=mysql_query($sql_search_guest);
	$tab_search_guest = array();
	while($guest = mysql_fetch_array($req_search_guest, MYSQL_ASSOC)){
		$tab_search_guest[] = $guest;
	}
	$fk_guest = $tab_search_guest[0]['id'];	

// Table link_date
	for($i=0;$i<count($tab_date);$i++){
       
	    $fk_date = $tab_date[$i]['id'] ;
		
	   	if(isset($_POST["date_".$tab_date[$i]['id']])){
		$presence=1;	
		} else{
			$presence = 0 ; 
		}
	   
	   	$sql_add_date = "INSERT INTO `my_event_link_date` VALUES ('','$presence','$fk_event','$fk_guest','$fk_date') ";
		$req_add_date = mysql_query($sql_add_date);

    } 

// Table gift

	if(isset($_POST['participation_cadeaux'])){ 
		$how =  intval($_POST['participation_cadeaux']) ;
		
		$sql_add_gift = "INSERT INTO `my_event_link_gift` VALUES ('','$how','$fk_event','$fk_guest') ";
		$req_add_gift = mysql_query($sql_add_gift);
	 }
}

// EDIT BDD quand on edit un guest

if(isset($_POST['edit_guest'])){ 
// table guest
		$guest_name= mysql_real_escape_string($_POST['name_guest']) ;
		$id_guest = $_POST['id_guest'] ;

		$sql_edit_guest = "UPDATE my_event_guest SET guest_name='$guest_name' WHERE id='$id_guest'";
		$req_edit_guest = mysql_query($sql_edit_guest);
		
// Table link_date
	for($i=0;$i<count($tab_date);$i++){
       
	   $fk_date = $tab_date[$i]['id'] ;
	   	
		if(isset($_POST["date_".$tab_date[$i]['id']])){
		  	$presence=1;	
		} else{
			$presence = 0 ; 
		}
	   
		$sql_edit_date = "UPDATE my_event_link_date SET presence='$presence' WHERE fk_guest='$id_guest' AND fk_date='$fk_date'";
		$req_edit_date = mysql_query($sql_edit_date);

    } 

// Table gift

	if(isset($_POST['participation_cadeaux'])){ 
		$how =  intval($_POST['participation_cadeaux']) ;
		
		$sql_edit_gift = "UPDATE my_event_link_gift SET how='$how' WHERE fk_guest='$id_guest'";
		$req_edit_gift = mysql_query($sql_edit_gift);
	 }
}

// delete guest

	if(isset($_GET['act'])){ 
		$id_guest =  $_GET['id_guest'] ;
		$id_crypt = $_GET['id'] ;
		
		$sql_del_guest = "DELETE FROM my_event_guest WHERE id = '$id_guest'";
		$req_del_guest = mysql_query($sql_del_guest);
		
		$sql_del_link_date = "DELETE FROM my_event_link_date WHERE fk_guest = '$id_guest'";
		$req_del_link_date = mysql_query($sql_del_link_date);
		
		$sql_del_link_gift = "DELETE FROM my_event_link_gift WHERE fk_guest = '$id_guest'";
		$req_del_link_gift = mysql_query($sql_del_link_gift);
	 }

	header('Location:event/'.$id_crypt);
?>	