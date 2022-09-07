<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	$role = getRole($connect,$username);
	$studentname = $_GET["studentname"];
	if (getRole($connect,$studentname)== "teacher"){
		echo "<div> Ο χρήστης ".$studentname." είναι καθηγητής.</div>";
	}
	else{
		$name = getName($connect,$studentname); 
		if (!is_null($name)){
			$query = "SELECT * FROM studentinfo WHERE username = '$studentname'" ;
			$result = $connect->query($query);
			$rows = mysqli_num_rows($result);
			$row=mysqli_fetch_assoc($result);
			if($rows == 0){
				$hasbio = false;
				$hasgrades = false;
			}
			else {
				$hasbio = $row["hasbio"]==0?false:true; 
				$hasgrades = $row["hasgrades"]==0?false:true; 
			}
			setTitle("Σελίδα Φοιτητή:".$name);
			setTitle("Στοιχεία");
			
			setSubTitle("Βιογραφικό");
			if ($role=="teacher" || $username != $studentname){
				if(!$hasbio){
					echo "<div>Ο φοιτητής δεν έχει αναρτήσει βιογραφικό</div>";
				}
				else{
					echo "<div><a href = 'bios/".$studentname.".pdf' target=_blank'>Προβολή</a></div>";
				}
			}
			else{
				if(!$hasbio){
					echo "<div>Δεν έχετε αναρτήσει βιογραφικό</div>";
				}
				else{
					echo "<div><a href = 'bios/".$studentname.".pdf' target=_blank'>Προβολή</a></div>";
				}
				echo "<form action='process_upload_bio.php' method='post' enctype='multipart/form-data'>";
					echo "<input type='file' name='file' id='bio' accept='application/pdf'>";
					echo "<input type='submit' value='Ανάρτηση Βιογραφικού' name='submit'>";
				echo "</form>";
			}
			setSubTitle("Αναλυτική Βαθμολογία");
			if ($role=="teacher" || $username != $studentname){
				if(!$hasgrades){
					echo "<div>Ο φοιτητής δεν έχει αναρτήσει αναλυτική βαθμολογία</div>";
				}
				else{
					echo "<div><a href = 'grades/".$studentname.".pdf' target=_blank'>Προβολή</a></div>";
				}
			}
			else{
				if(!$hasgrades){
					echo "<div>Δεν έχετε αναρτήσει αναλυτική βαθμολογία</div>";
				}
				else{
					echo "<div><a href = 'grades/".$studentname.".pdf' target=_blank'>Προβολή</a></div>";
				}
				echo "<form action='process_upload_grades.php' method='post' enctype='multipart/form-data'>";
					echo "<input type='file' name='file' id='grades' accept='application/pdf'>";
					echo "<input type='submit' value='Ανάρτηση Βιογραφικού' name='submit'>";
				echo "</form>";
			}
		}
	}
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