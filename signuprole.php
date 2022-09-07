<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
setTitle("Εγγραφή χρήστη");
if (isset($_SESSION[ "username" ])){
	echo "Είστε ήδη εγγεγραμένος με όνομα χρήστη ",$_SESSION[ "username" ];
}
else{
	if (isset($_GET["username"])){
		$username = $_GET["username"];
		echo "Το όνομα χρήστη ".$username." χρησιμοποιείται ήδη.";
	}
	echo "<div id='signupform'>";
	echo "<form method='post' action='process_signuprole.php' enctype='multipart/form-data'>";
		
		echo "<label for='role'>Ρόλος:</label>";
		echo "<select>";
		echo "<option value='teacher'>Καθηγητής</option>";
		echo "<option value='student'>Φοιτητής</option>";
		echo "</select>";
		echo "<input type='submit' value='Εγγραφή' id='submit_button' /> ";
		
	echo "</form>";	
	echo "</div>";
}
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>
