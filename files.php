<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	setTitle("Αρχεία");
	if (isset($_POST['sendername'])){
		if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
			echo "Λάθος κατά τη φόρτωση του αρχείο με κωδικό: " . $_FILES['file']['error'];
		}
		else{
			$receivername = $_POST['receivername'];
			$insert_query = "insert into files (sender,receiver) values ('$username','$receivername')";
			$insert_result = $connect->query($insert_query);
			$id = mysqli_insert_id($connect);
			move_uploaded_file($_FILES['file']['tmp_name'], "files/".$id.".pdf");
			
		}
		
	}
	//Αποστολή αρχείου
	
		echo "<form name='chatform' method='post' action='files.php' enctype='multipart/form-data'> ";
			//echo "<div style='width:100%;'>";
			echo "<input type='hidden' name='sendername' value='".$username."'>";
			echo "<input type='file' name='file' id='file' accept='application/pdf'>";
			//  Το Dropdown με τα ονόματα για αποστολή
			echo "<span style='float:left;'>Παραλήπτης:</span><select name='receivername' style='display:inline;float:left;'>";
			$select_query = "select * from users ";
			$select_result = $connect->query($select_query);
			$select_num_results = mysqli_num_rows($select_result);
			for($i=0;$i<$select_num_results;$i++){
				$select_row = mysqli_fetch_array($select_result);
				$receivername = htmlspecialchars(stripcslashes($select_row["username"])); 
				$name = htmlspecialchars(stripcslashes($select_row["name"])); 
				
				if ($receivername != $username){
					echo "<option value='$receivername'>$name</option>";
				}
			}
			echo "</select> ";
			
			echo "<input name='submit' type='submit' value='Αποστολή' style='display:inline;float:left;'/>";
			//echo "</div>";
		echo "</form>";
	setTitle("Εμφάνιση Αρχείων");
	$select_query = "select * from files where sender = '$username' or receiver = '$username'";
	$select_result = $connect->query($select_query);
	$select_num_results = mysqli_num_rows($select_result);
	if ($select_num_results==0){
		echo "Δεν έχετε λάβει ή στείλει μηνύματα";
	}
	echo "<ol>";
	for($i=0;$i<$select_num_results;$i++){
		$select_row = mysqli_fetch_array($select_result);
		$id = $select_row["id"]; 
		$sendername = $select_row["sender"]; 
		$receivername = $select_row["receiver"]; 
		
		echo "<li>";
		echo getName($connect,$sendername);
		echo "-->";
		echo getName($connect,$receivername);
		
		echo "<a href = 'files/".$id.".pdf' target=_blank'>Προβολή</a>";
		echo "</li>";
	}
	echo "</ol>";
}
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