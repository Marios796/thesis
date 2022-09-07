<?php
	// IP του server
	$host="localhost";
	// όνομα χρήστη της MySQL	
	$user = "root";	
	// κωδικός χρήστη της MySQL	
	$password = "";		
	// Όνομα της βάσης
	$db_name = "thesisplatform";
	$connect = new mysqli($host,$user,$password,$db_name);
	$connect->query("SET NAMES 'utf8'");
?>