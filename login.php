<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
setTitle("Σύνδεση μελών");	
if (!isset($_SESSION[ "username" ])){
echo "<div style='width:40%; margin-left:auto;margin-right:auto;'>";
		echo "<form name='form1' method='post' action='process_login.php'> ";
		echo "<div>";
				echo "<div style='float:left;vertical-align:middle;margin-left:auto;'>Όνομα χρήστη:</div>";
				echo "<div style='margin-left:180px'><input type='text' name='username' /></div><br/>";
			echo "</div>";
			echo "<div style='display: block;float:left;'>";
				echo "<div style='float:left;vertical-align:middle;margin-left:auto;'>Κωδικός Πρόσβασης:</div>";
				echo "<div style='margin-left:180px'><input type='password' name='password' /></div><br/> ";
			echo "</div>";
			echo "<div style='display:block;float:right;margin-right:50px'>";
				echo "<input type='submit' value='Σύνδεση' class='submit'/>";
			echo "</div>";
		echo "</form>";

echo "</div>";
}
else{
	echo "Είστε ήδη συνδεδεμένοι με όνομα χρήστη ".$_SESSION[ "username" ]."<a href='process_logout.php'> αποσυνδεθείτε</a> για να συνδεθείτε σαν διαφορετικός χρήστης.";
}
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>
