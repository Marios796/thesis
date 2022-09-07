<?php
include 'db.php';
include 'header.php';

pageBeginning();
mainBeginning();
setTitle("Αρχική Σελίδα");	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	$role = getRole($connect,$username);
	echo "<div>";
		echo "<p>Καλωσόρισες στην πλατφόρμα αλληλεπίδρασης εκπονήσεων διπλωματικών εργασιών του Πανεπιστημίου Αιγαίου.  Είσαι εγγεγραμμένος με ρόλο:";
		echo "<strong>";
		if ($role == "teacher"){
			echo "Καθηγητή";
		}
		else{
			echo "Φοιτητή";
		}
		echo "</strong>";
		echo "</p>";
		echo "<p>Περιηγήσου στην πλατφόρμα μας με τη βοήθεια των επιλογών στα αριστερά.</p>";
	echo "</div>";
}
else{
	echo "<div>";
		echo "<p>Καλωσορίσατε στην πλατφόρμα αλληλεπίδρασης εκπονήσεων διπλωματικών εργασιών του Πανεπιστημίου Αιγαίου.</p>";
		echo "<p>Παρακαλώ <a href='login.php'>συνδεθείτε</a> ή <a href='signup.php'>εγγραφείτε</a> στην πλατφόρμα για να έχετε πρόσβαση σε όλες τις υπηρεσίες μας.</p>";
	echo "</div>";
}
	
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>		