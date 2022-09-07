<?php
include 'header.php';
pageBeginning();
mainBeginning();
	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	setTitle("Τρέχουσες Αιτήσεις");
}
else{
	echo "<div>";
		notConnected();
	echo "</div>";
}
	
mainEnd();
leftMenu();
rightMenu();
pageEnd();
?>		