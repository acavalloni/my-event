<?php require('config/config.php');
	
	$id_crypt = $_GET['id'];
	
	if(isset($_GET['id_guest'])){
		$id_guest_edit = $_GET['id_guest'] ;
	} else {
		$id_guest_edit = 0;
	}
	
	$sql_decrypt="SELECT id FROM my_event_event WHERE url = '$id_crypt'";
	$req_decrypt=mysql_query($sql_decrypt) or die('Erreur de base de donnée SQL !<br />'.$sql_decrypt.'<br />'.mysql_error());
	$decrypt_count = mysql_num_rows($req_decrypt); //compteur nombre de date de l'evenement
	if($decrypt_count != 1){
		header('Location:http://my-event.pixelzone.fr');
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
	
	$sql_nb_guest="SELECT * FROM my_event_guest WHERE fk_event = '$id_de_event'";
	$req_nb_guest=mysql_query($sql_nb_guest) or die('Erreur de base de donnée SQL !<br />'.$sql_nb_guest.'<br />'.mysql_error());
	$tab_nb_guest = array();
	while($nb_guest = mysql_fetch_array($req_nb_guest, MYSQL_ASSOC)){
		$tab_nb_guest[] = $nb_guest;
	}
	//echo count($tab_nb_guest);
	//print_r($tab_nb_guest);

	if($tab_event[0]['gift'] == 1){
		$sql_gift="SELECT * FROM my_event_gift WHERE fk_event = '$id_de_event' ORDER BY id";
		$req_gift=mysql_query($sql_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_gift.'<br />'.mysql_error());
		$tab_gift = array();
		while($gift = mysql_fetch_array($req_gift, MYSQL_ASSOC)){
			$tab_gift[] = $gift;
		}
	}
	//print_r($tab_gift);
	
	$sql_date="SELECT * FROM my_event_date WHERE fk_event = '$id_de_event' ORDER BY date";
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

// INSERTION BDD 
	if(isset($_POST['add_guest'])){	
	
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
		
	   	if($POST["date_".$tab_date[$i]['id']]==1){
		$presence=1;	
		} else{
			$presence = 0 ; 
		}
	   
	   	$sql_add_guest = "INSERT INTO `my_event_link_date` VALUES ('','$presence','$fk_event','$fk_guest','$fk_date') ";
		$req_add_guest = mysql_query($sql_add_guest);

    } 

// Table gift

// on verifie que les requetes se soient bien faites	
	//	if($req_add_event && $req_add_date){
	}
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Mon événement</title>
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
		<h1><img src="../css/img/logo.png" alt="My Event"/></h1>
		<h2>Créer et suivre ses événements facilement ET gratuitement !</h2>
	</div>
	
	<div id="englob_info">
	<div id="event_description">
		<p class='titre'><?php echo $tab_event[0]['event_name']; ?></p>
        
<?php if($tab_event[0]['where']==''){
		$where="Lieu non précisée";
} else{
		$where = $tab_event[0]['where'] ;
}
?>
		<p><b> Où : <?php echo $where; ?></b></p>
        
<?php if($tab_event[0]['event_description']==''){
		$description="Détails de l'événement non précisée";
} else{
		$description = $tab_event[0]['event_description'] ;
}
?>
		<p><?php echo $description ; ?></p>
		<div class="clear"></div>
	</div>

<?php if($tab_event[0]['gift'] == 1){?>
	<div id="cadeau_description">
		<p class='titre'> Il y a un pot commun associé à cet événement ! </p>

<?php if($tab_gift[0]['gift_name']==''){
		$gift_name="Cadeau non précisé";
} else{
		$gift_name=$tab_gift[0]['gift_name'];
}
?>
		<p><b>Pour : <?php echo $gift_name ; ?></b></p>
        
 <?php if($tab_gift[0]['gift_description']==''){
		$gift_description="Description non précisée";
} else{
		$gift_description=$tab_gift[0]['gift_description'];
}  
?>     
        
		<p><?php echo $gift_description; ?></p>

<?php if($tab_gift[0]['cost']==0){
		$gift_cost="Participation demandée non précisée";
} else{
		$gift_cost= 'Il faudrait réunir '.$tab_gift[0]['cost'].'€';
}  
?>     
       
		<p>  <?php echo $gift_cost; ?> </p>
		<div class="clear"></div>
	</div>

<?php } ?>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
<!--<p>Il y a <?php echo $date_count ?> dates pour cet event</p>-->
<?php 
if($id_guest_edit == 0){ ?>
<form action="../traitement.php" method='post' id="form_add_guest">
<?php } else{ ?>
<form action="traitement.php" method='post' id="form_add_guest">
<?php } ?>
<p class="none"><input name='url_event' value='<?php echo $id_crypt ; ?>' /></p>

<div id="tableau">
<table>
	<thead> <!-- En-tête du tableau -->
		<tr>
			<th class='vide'></th>
			<?php 
				for($i=0;$i<count($tab_date);$i++){
					
					$date = explode("/", $tab_date[$i]['date']) ;
					
					switch ($date[1]) {
						case 01:
							$date[1]= 'Janvier' ;
							break;
						case 02:
							$date[1]= 'Février' ;
							break;
						case 03:
							$date[1]= 'Mars' ;
							break;
						case 04:
							$date[1]= 'Avril' ;
							break;
						case 05:
							$date[1]= 'Mai' ;
							break;
						case 06:
							$date[1]= 'Juin' ;
							break;
						case 07:
							$date[1]= 'Juillet' ;
							break;
						case 08:
							$date[1]= 'Août' ;
							break;
						case 09:
							$date[1]= 'Septembre' ;
							break;
						case 10:
							$date[1]= 'Octobre' ;
							break;
						case 11:
							$date[1]= 'Novembre' ;
							break;
						case 12:
							$date[1]= 'Décembre' ;
							break;
					}
					if($date[3] == "00:00"){
						$date[3] = "" ;		
					} else{
						$date[3] = "- ".$date[3] ;	
					}
					$date = $date[2].' '.$date[1].' '.$date[0].' '.$date[3] ;
					
					echo "<th class='date'>".$date."</th>";
				}
				if($tab_event[0]['gift'] == 1){
					echo "<th class='date'>Cadeau</th>";
				}
			?>
			<th class='vide'></th>
			<th class='vide'></th>
		</tr>
	</thead>

	<tfoot> <!-- Pied de tableau -->
		<tr>
			<th class='vide'></th>
			<?php 
			//	if($id_guest_edit == 0){ cache la derniere ligne quand on edit
				for($i=0;$i<count($tab_date);$i++){
					
					$id_de_date = $tab_date[$i]['id'];
					$sql_date_guest="SELECT SUM(presence) AS total_guest FROM my_event_link_date,my_event_date
					WHERE my_event_link_date.fk_event = '$id_de_event'
					AND my_event_link_date.fk_date = '$id_de_date'
					AND my_event_date.fk_event = '$id_de_event.'
					AND my_event_date.id = '$id_de_date'
					ORDER BY  my_event_date.id";
					$req_date_guest=mysql_query($sql_date_guest) or die('Erreur de base de donnée SQL !<br />'.$sql_date_guest.'<br />'.mysql_error());
					$nombre_date_guest = mysql_fetch_array($req_date_guest);
					if($nombre_date_guest['total_guest'] < (count($tab_nb_guest)/2)){
						echo "<th class='rouge'>".$nombre_date_guest['total_guest'].'</th>';
					}else{
						echo "<th class='vert'>".$nombre_date_guest['total_guest'].'</th>';
					}
				}	
		
				if($tab_event[0]['gift'] == 1){
					$sql_gift="SELECT SUM(how) AS total FROM my_event_link_gift
					WHERE my_event_link_gift.fk_event = '$id_de_event'
					ORDER BY id";
					$req_gift=mysql_query($sql_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_gift.'<br />'.mysql_error());
					$nombre_gift = mysql_fetch_array($req_gift);
					if($tab_gift[0]['cost'] == 0){
						echo "<th class='vert'>".$nombre_gift['total'].' €</th>';
					}elseif($nombre_gift['total'] >= $tab_gift[0]['cost']){
						echo "<th class='vert'>".$nombre_gift['total'].' / '.$tab_gift[0]['cost'].' €</th>';
					}else{
						echo "<th class='rouge'>".$nombre_gift['total'].' / '.$tab_gift[0]['cost'].' €</th>';
					}
					
				}
			//	}
			?>
			<th class='vide'></th>
			<th class='vide'></th>
		</tr>
	</tfoot>

	<tbody id='tab_guest'> <!-- Corps du tableau -->
		<?php 
		$nb_guest = count($tab_guest) ;
			for($i=0;$i<$nb_guest;$i++){
				$id_du_guest = $tab_guest[$i]['id'];
					if($id_du_guest == $id_guest_edit){ ?>
						<tr>
							<td class="form_participant"><input value="<?php echo $tab_guest[$i]['guest_name'] ; ?>" name="name_guest" /></td> 
				<?php
							$sql_link_date="SELECT my_event_guest.guest_name,date,my_event_link_date.presence,my_event_link_date.fk_date FROM my_event_guest,my_event_date,my_event_link_date 
							WHERE my_event_link_date.fk_event = '$id_de_event'
							AND my_event_guest.id = '$id_du_guest'
							AND my_event_link_date.fk_guest = my_event_guest.id
							AND my_event_link_date.fk_date = my_event_date.id	
							ORDER BY date ASC";
					
							$req_link_date=mysql_query($sql_link_date) or die('Erreur de base de donnée SQL !<br />'.$sql_link_date.'<br />'.mysql_error());
		
							
							while($link_date = mysql_fetch_array($req_link_date)){
								if($link_date['presence'] == 1){ ?>
									<td class="case_checkbox"><input type="checkbox" name="date_<?php echo $link_date['fk_date'] ?>" 
                                    value="<?php echo $link_date['fk_date'] ?>" checked /></td> <?php
								}elseif(!isset($link_date['id'])){ ?>
									<td class="case_checkbox"><input type="checkbox" name="date_<?php echo $link_date['fk_date'] ?>" 
                                    value="<?php echo $link_date['fk_date'] ?>"/></td> <?php
								}
								else{ ?>
									<td class="case_checkbox"><input type="checkbox" name="date_<?php echo $link_date['fk_date'] ?>" 
                                    value="<?php echo $link_date['fk_date'] ?>"/></td> <?php
								}
							}
							if($tab_event[0]['gift'] == 1){
								$sql_link_gift="SELECT my_event_link_gift.how FROM my_event_guest,my_event_link_gift 
								WHERE my_event_link_gift.fk_event = '$id_de_event'
								AND my_event_guest.id = '$id_du_guest'
								AND my_event_link_gift.fk_guest = my_event_guest.id
								";
								$req_link_gift=mysql_query($sql_link_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_link_gift.'<br />'.mysql_error());
								$link_gift = mysql_fetch_array($req_link_gift); ?>
								<th class="form_cadeau"><input type='text' value="<?php echo $link_gift['how'] ; ?>" name='participation_cadeaux' /></th>
								<th class='vide'></th><?php
							} ?>
						<td class="no_border">
   						<p class="none"><input name='id_guest' value='<?php echo $id_du_guest ; ?>' /></p>
				 		<input class="participer_bouton" type="submit" value="Valider mes changements" name="edit_guest" />
						</td>
						</tr> 
			
         			<?php 
					}
				else {
				echo "<tr>";
				echo "<td class='participant'>".$tab_guest[$i]['guest_name']."</td>";
				
					$sql_link_date="SELECT my_event_guest.guest_name,date,my_event_link_date.presence FROM my_event_guest,my_event_date,my_event_link_date 
					WHERE my_event_link_date.fk_event = '$id_de_event'
					AND my_event_guest.id = '$id_du_guest'
					AND my_event_link_date.fk_guest = my_event_guest.id
					AND my_event_link_date.fk_date = my_event_date.id	
					ORDER BY date ASC";
					
					$req_link_date=mysql_query($sql_link_date) or die('Erreur de base de donnée SQL !<br />'.$sql_link_date.'<br />'.mysql_error());
					
					while($link_date = mysql_fetch_array($req_link_date)){
						if($link_date['presence'] == 1){ 
						$date = explode("/", $link_date['date']) ;
						if($date[3] == "00:00"){
						$class_green = 'green' ;		
					} else{
						$class_green = 'green_large' ;		
					}
						?>
							<td class="<?php echo $class_green ; ?>"></td> <?php
						}elseif(!isset($link_date['presence'])){
							echo '<td class="red"></td>';
						}
						else{
							echo '<td class="red"></td>';
						}
					}
					if($tab_event[0]['gift'] == 1){
						$sql_link_gift="SELECT my_event_link_gift.how FROM my_event_guest,my_event_link_gift 
						WHERE my_event_link_gift.fk_event = '$id_de_event'
						AND my_event_guest.id = '$id_du_guest'
						AND my_event_link_gift.fk_guest = my_event_guest.id
						";
						$req_link_gift=mysql_query($sql_link_gift) or die('Erreur de base de donnée SQL !<br />'.$sql_link_gift.'<br />'.mysql_error());
						$link_gift = mysql_fetch_array($req_link_gift);
						if($link_gift['how'] == 0){
							echo "<th class='rouge'>".$link_gift['how'].' €</th>';						
						}else{
							echo "<th class='vert'>".$link_gift['how'].' €</th>';	
						}

					} 
					if($id_guest_edit == 0){ ?>
				<td class="no_border">
				 <a title="editer sa participation" class="edition" href="../event.php?id=<?php echo $id_crypt ; ?>&amp;id_guest=<?php echo $tab_guest[$i]['id'] ?>"></a>
				</td>
				<td class="no_border">
				 <a title="supprimer sa participation" class="supprimer" href="../traitement.php?id=<?php echo $id_crypt ; ?>&amp;id_guest=<?php echo $tab_guest[$i]['id'] ?>&amp;act=del"></a>
				</td>
				</tr>  
			 
         	<?php }
				}
			}
			if($id_guest_edit == 0){
		?>
        <tr>
    		<td class="form_participant"><input type='text' name='name_guest' id='name_guest' value="Votre Nom"  onFocus="javascript:this.value=''" onBlur="javascript:if(this.value=='')this.value='Votre Nom'" /></td>
    		<?php for($i=0;$i<count($tab_date);$i++){ ?>
        	<td class="case_checkbox"> <input type="checkbox" id="date_<?php echo $tab_date[$i]['id'] ?>" name="date_<?php echo $tab_date[$i]['id'] ?>" value="1" /></td>
    		<?php	} 
			if($tab_event[0]['gift'] == 1){ ?>
			<td class="form_cadeau"><input type='text' name='participation_cadeaux' id='participation_cadeaux' value="Participation" onFocus="javascript:this.value=''" onBlur="javascript:if(this.value=='')this.value='Participation'" /></td>
			<?php 	}  ?>
            <td class='no_border'><input class="participer_bouton" type='submit' id="submit" value='Participer' name="add_guest" /></td>
			<th class='vide'></th>
		
			<?php } ?>
	</tr> 
    <?php // if($id_guest_edit == 0){ si on veux pas afficher la deniere ligne lors de l'edit?>
		<tr>
			<?php
				echo "<td class='vide'></td>";
				//for($i=0;$i<$date_count;$i++){
					echo "<th class='blanc' colspan=$date_count>Total participants</th>";
				//}
				if($tab_event[0]['gift'] == 1){
					echo "<th class='blanc'>Total Cadeau</th>";
					
				}
			?>
			<th class='vide'></th>
			<th class='vide'></th>
		</tr>
        <?php // } ?>
	</tbody>
</table>
   
    
</div>
</form>	

<p class="share_link">Vous pouvez partager votre événement via le lien suivant : <a title="Mon événement" href="http://my-event.pixelzone.fr/event/<?php echo $id_crypt; ?>">http://my-event.pixelzone.fr/event/<?php echo $id_crypt; ?></a></p>
<p class="share_link">Ou via vos réseaux sociaux préférés :</p>

<div id="les_boutons">
	<a id="bouton_facebook" name="fb_share">Partager</a> 
	<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript">
	</script>
	
	<div class="g-plus" data-action="share" data-annotation="none"></div>

	<script type="text/javascript">
	  window.___gcfg = {lang: 'fr'};

	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	
	<a href="https://twitter.com/share" class="twitter-share-button" data-text="Voici l'événement que j'ai créé sur my-event.pixelzone.fr !" data-lang="fr" data-count="none" data-hashtags="MyEvent">Tweeter</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>

<div id="footer">
	<a href="http://my-event.pixelzone.fr/">Retour à l'accueil</a><span> - </span>
	<a href="http://my-event.pixelzone.fr/creation">Créer son événement</a>
</div>
</div>


</body>
</html>