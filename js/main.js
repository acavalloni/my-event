$(document).ready(function() {

/* date picker */
	
		$( ".datepicker" ).datetimepicker({ 	
			dateFormat: 'dd/mm/yy'
		});
}); 

/* fonction pour faire apparaitre les champs supplémentaire quand on selectionne cadeau */


function cadeau_check(ok_checked){
	if(ok_checked){
		document.getElementById("div_check").style.display = "block";
		}
	else{
		document.getElementById("div_check").style.display = "none";
		}

}	