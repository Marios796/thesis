<?php

function pageBeginning($loadprocess=0){
	session_start();
	
?>
	<!doctype html>
	<html lang='el'>
	<head>	
		<title>Σύστημα πτυχιακών εργασιών</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		
		<script src='js/loader.js'></script>
		<script src='js/captcha.js'></script>
		<script src='js/validatepassword.js'></script>
		<script src='js/validateusername.js'></script>
		<script src='js/charts.js'></script>
	</head>
	<?php 
	if ($loadprocess==0){
		echo  "<body>";
	}
	else if ($loadprocess==1){
		echo "<body onload='ajax();'>";
	}
	else{
		echo "<body onload='process();'>";
	}
	//	ECHO $chat;
		echo "<header id='header'>";
		echo "<a href='index.php'><img src='logo.jpg' id='logo' alt='Aegean university logo.' width='100px' height='100px'></a>";
		echo "Πτυχιακές εργασίες Πανεπιστημίου Αιγαίου";
		echo "</header>";
		?>
		<div id="container">
<?php
}
function mainBeginning(){
	echo "<main id='center' class='column'>";
}
function mainEnd(){
	echo "</main>";
}
function setTitle($title){
	echo "<h1>$title</h1>";
}
function setSubtitle($title){
	echo "<h2>$title</h2>";
}
	
function leftMenu($connect){
	echo "<nav id='left' class='column'>";
	if (isset($_SESSION[ "username" ])){
		$username = $_SESSION[ "username" ];
		$select_query = "select * from users where username = '$username' ";
		$result = $connect->query($select_query);
		$row = mysqli_fetch_array($result);
		
		$role = htmlspecialchars(stripcslashes($row["role"]));
		if ($role == "teacher"){
			echo "<h3>Καθηγητής</h3>";
			echo "<ul>";
				echo "<li><a href='teachernewthesis.php'>Νέα Διπλωματική</a></li>";
				echo "<li><a href=viewthesis.php?term=teacher&name=".$username."&filter=all>Εμφάνιση Διπλωματικών</a></li>";
				echo "<li><a href='viewrequests.php'>Τρέχουσες Αιτήσεις</a></li>";
				echo "<li><a href='files.php'>Αρχεία</a></li>";
				echo "<li><a href='chat.php'>Συνομιλία</a></li>";
				echo "<li><a href='statistics.php'>Στατιστικά</a></li>";
			echo "</ul>";
		}
		else{
			echo "<h3>Φοιτητής</h3>";
			echo "<ul>";
				echo "<li><a href='viewthesis.php'>Διπλωματικές</a></li>";
				echo "<li><a href='viewrequests.php'>Αιτήσεις</a></li>";
				echo "<li><a href='chat.php'>Συνομιλία</a></li>";
				echo "<li><a href='files.php'>Αρχεία</a></li>";
				echo "<li><a href='studentinfo.php?studentname=".$username."'>Στοιχεία</a></li>";
				echo "<li><a href='statistics.php'>Στατιστικά</a></li>";
			echo "</ul>";
		}
	}
	else{
	}
	echo "</nav>";
}
function rightMenu($connect){
	echo "<div id='right' class='column'>";
	if (isset($_SESSION[ "username" ])){
		echo "<h3>".$_SESSION[ "username" ]."</h3>";
		echo "<p><a href='process_logout.php'>Αποσύνδεση</a>";
	}
	else{
		
			echo "<h3>Επισκέπτης</h3>";
			echo "<p><a href='login.php'>Σύνδεση</a>|<a href='signup.php'>Εγγραφή</a></p>";
		
	}
	echo "</div>";
}
function pageEnd(){
	echo "</div>"; // τελειώνει το <div id="container">
	echo "<div id='footer-wrapper'>";
		echo "<footer id='footer'><p>&copy; Ντάφλος Γεώργιος icsd 12134 | Κωνσταντίνου Μάριος icsd 13091 | Γούλας Χρήστος icsd 11033</p></footer>";
	echo "</div>";
	echo "</body></html>";
}
function notConnected(){
	echo "<p>Δεν θα έπρεπε να βρίσκεστε σε αυτήν την σελίδα. Παρακαλώ <a href='login.php'>συνδεθείτε</a> ή <a href='signup.php'>εγγραφείτε</a>.</p>";
}
// Δέχεται το username του χρήστη και επιστρέφει το όνομά του.
function getName($connect,$username){
	$select_query = "select * from users where username = '$username'";
	$select_result = $connect->query($select_query);
	
	$select_num_results = mysqli_num_rows($select_result);
	if ($select_num_results==1){
		$select_row = mysqli_fetch_array($select_result);
		$name = $select_row["name"];
		return $name;
	}
	else {
		echo "<div>Δεν υπάρχει χρήστης με όνομα χρήστη:".$username." στην πλατφόρμα.</div>";
		return null;
	}
}
// Δέχεται το όνομα του χρήστη και επιστρέφει τον ρόλο του, teacher ή student
function getRole($connect,$username){
	
	$select_query = "SELECT * FROM users WHERE username = '$username'" ;
	$select_result = $connect->query($select_query);
	//$select_result = mysql_query($select_query);
	
	$select_row = mysqli_fetch_array($select_result);
	$role = $select_row["role"]; 
	return $role;
}
// Δέχεται το id της διπλωματικής και επιστρέφει τον τίτλο της
function getThesisTitle($connect,$id){
	$select_query = "select * from thesis where id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$title = $select_row["title"]; 
	return $title;
}
// Δέχεται το id του μαθήματος και επιστρέφει τον τίτλο του
function getCourseTitle($connect,$id){
	$select_query = "select * from courses where id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$title = $select_row["title"]; 
	return $title;
}
// Δέχεται το id του μαθήματος και επιστρέφει το εξάμηνό του
function getCourseSemester($connect,$id){
	$select_query = "select * from courses where id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$semester = $select_row["semester"]; 
	return $semester;
}
// Δέχεται το id της διπλωματικής και επιστρέφει την ημερομηνία έκδοσης
function getThesisPublishDate($connect,$id){
	$select_query = "select * from thesis where id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$date = $select_row["publishdate"]; 
	return $date;
}
// Δέχεται το id της τρέχουσας διπλωματικής και επιστρέφει τηκατάστασή της
function getCurrentThesisStatus($connect,$id){
	$select_query = "select * from currentthesis where thesis_id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$status = $select_row["status"]; 
	return $status;
}
// Δέχεται το id της διπλωματικής και επιστρέφει τον συνολικό αριθμό φοιτητών
function getThesisStudents($connect,$id){
	$select_query = "select * from thesis where id = '$id'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	$select_row = mysqli_fetch_array($select_result);
	$noofstudents = $select_row["noofstudents"]; 
	return $noofstudents;
}
// Επιστρέφει τον αριθμό των φοιτητών που έχουν αιτηθεί (και εγκριθεί ) για το id της πτυχιακης
function getWaitingStudents($connect,$id){
	$select_query = "select * from request where (thesisid = '$id' and status= 'waiting') ";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	return $select_num_results;
}
// δέχεται ένα query και επιστρέφει λίστα με requests σύμφωνα με αυτό
function viewRequestsList($connect, $select_query){
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	// Η λίστα ανάλογα με το αποτελέσμα των παραπάνω ερωτημάτων
		echo "<ol>";
		for($i=0;$i<$select_num_results;$i++){
			$select_row = mysqli_fetch_array($select_result);
			$id = $select_row["id"]; 
			$teachername = $select_row["teachername"]; 
			$studentname = $select_row["studentname"]; 
			$thesisid = $select_row["thesisid"];
			//echo "<a href=viewthesis.php?term=teacher&name=".$teachername."&filter=all>";
			echo "<li>";
			echo "<a href=viewthesis.php?action=view&id=".$thesisid.">";
			echo getThesisTitle($connect,$thesisid);
			echo "</a>";
			echo ",";
			echo getName($connect,$teachername).",";
			echo "<a href=studentinfo.php?studentname=".$studentname.">";
			echo getName($connect,$studentname);
			echo "</a>";
			
				$request_query = "select * from request where id = '$id'; ";
				$request_result = $connect->query($request_query);
				$request_row = mysqli_fetch_array($request_result);
				$status = $request_row["status"];
				if ($status == "pending" && $teachername == $_SESSION[ "username" ]){
					echo "<form method='post' action='process_approve.php' enctype='multipart/form-data' style='display:inline'>";
						echo "<input type='hidden' name='requestid' value='".$id."'>";
						echo "<input type='hidden' name='teachername' value='".$teachername."'>";
						echo "<input type='hidden' name='studentname' value='".$studentname."'>";
						echo "<input type='hidden' name='thesisid' value='".$thesisid."'>";
					echo "<input type='submit' value='Έγκριση' id='submit_button' /> ";
				}
				else if ($status == "pending"  && $teachername != $_SESSION[ "username" ]){
					echo " Σε αναμονή έγκρισης.";
				}
				else if ($status == "waiting"){
					echo " Αναμονή άλλων φοιτητών.";
				}
				else if ($status == "approved"){
					echo "Εγκεκριμένη.";
				}
				else{
					echo "Ακυρωμένη.";
				}
			echo "</form>";
			echo "</li>";			
		}
		echo "</ol>";
}
?>
