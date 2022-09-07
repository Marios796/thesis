<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	$role = getRole($connect,$username);
	$name = getName($connect,$username);
	
	if (isset($_GET["id"]) && isset($_GET["action"])){
		$id = $_GET["id"];
		$action = $_GET["action"];
		$select_id_query = "select * from request where id = '$id'";
		$select_id_result = $connect->query($select_id_query);
		$select_id_num_results = mysqli_num_rows($select_id_result);
		$select_id_row = mysqli_fetch_array($select_id_result);
		$teachername = $select_id_row["teachername"]; 
		$studentname =$select_id_row["studentname"];
		$thesisid = $select_id_row["thesisid"];
		$status = $select_id_row["status"];
		// Μήνυμα επιτυχούς αίτησης για διπλωματική
		if ($action=="insert"){
			echo "<p>Μόλις αιτηθήκατε για την διπλωματική: <a href=viewthesis.php?action=view&id=".$thesisid.">".getThesisTitle($connect,$thesisid)."</a></p>";;
		}
		// Μήνυμα επιτυχούς έγκρισης για διπλωματική
		else if ($action=="approve"){
			echo "<p>Μόλις εγγρίνατε την διπλωματική: <a href=viewthesis.php?action=view&id=".$thesisid.">".getThesisTitle($connect,$thesisid)."</a></p>";;
		}
		if ($select_id_num_results==1){
			setTitle("Πληροφορίες αίτησης");
			echo "<div><strong>Διπλωματική</strong>:".getThesisTitle($connect,$thesisid)."</div>";
			echo "<div><strong>Επιβλέπων</strong>:".getName($connect,$teachername)."</div>";
			echo "<div><strong>Φοιτητής</strong>:".getName($connect,$studentname)."</div>";
			echo "<div><strong>Κατάσταση</strong>:";
			if ($status == "pending"){
				echo "Σε αναμονή έγκρισης.";
			}
			else if ($status == "waiting"){
				echo "Αναμονή άλλων φοιτητών.";
			}
			else if ($status == "approved"){
				echo "Εγκεκριμένη.";
			}
			else{
				echo "Ακυρωμένη";
			}
			echo "</div>";
			
		}
		else{
			setTitle("Λίστα Αιτήσεων");
			echo "Δεν υπάρχει αίτηση με id:".$id;
		}
	
	}
	else{
		if ($role=="teacher"){
			setTitle("Λίστα αιτήσεων από Φοιτητές");
			viewRequestsList($connect,"select * from request where teachername = '$username'");
		}
		else{
			setTitle("Λίστα αιτήσεων σας");
			viewRequestsList($connect,"select * from request where studentname = '$username'");
		}
	}
}
// Μη εγκεκριμένος χρήστης
else{
	echo "<div>";
		notConnected();
	echo "</div>";
}
	
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>		