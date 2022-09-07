<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
// To script για τα προαπαιτούμενα μαθήματα
	?>
<script>
function viewCourses(i){
	var semesterelementid =  'semesterselector'+i;
	var semesterelement = document.getElementById(semesterelementid);
	var semester = parseInt(semesterelement.options[semesterelement.selectedIndex].value);
	for (j=1;j<=9;j++){
		var elementid =  'courseselector'+i+'-'+j;
		var courseselement = document.getElementById(elementid);
		if (j==semester){
			courseselement.setAttribute("style", "display:inline;");
		}
		else{
			courseselement.setAttribute("style", "display:none;");
		}
	}
		
}
var counter = 1;
var limit = 10;
function addInput(){
	if (counter == limit)  {
		alert("Μέχρι " + counter + " μαθήματα");
	}
	else {
		var courseselement = document.getElementById('course'+counter);
		courseselement.setAttribute("style", "display:block;");
		var noofcourseselement = document.getElementById('noofcourses');
		noofcourseselement.setAttribute("value",counter);
		counter++;
		
	}
}
function removeInput(){
	if (counter == 1){
		alert("Δεν υπάρχουν μαθήματα για αφαίρεση");
	}
	else {
		counter--;
		var courseselement = document.getElementById('course'+counter);
		courseselement.setAttribute("style", "display:none;");	
		var noofcourseselement = document.getElementById('noofcourses');
		noofcourseselement.setAttribute("value",counter-1);
	}
}

</script>
	
	<?php
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	setTitle("Νέα Διπλωματική");
	echo "<form name='newthesisform' method='post' action='process_newthesis.php'>";
		echo "<div>";
		echo "<label for='title'>Τίτλος προτεινόμενης διπλωματικής εργασίας: <span class='required'>*</span></label>";
		echo "<textarea name='title' rows='10' cols='80' placeholder='Στο πεδίο αυτό γράφετε το όνομα της διπλωματικής εργασίας'></textarea>";
		echo "</div>";
		echo "<input type='hidden' name='username' value='".$username."'>";
		echo "<div>";
		echo "<label for='title'>Αριθμός φοιτητών: <span class='required'>*</span></label>";
		echo "<input type='number' name='noofstudents' min='1' max='3'>";
		echo "</div>";
		
		echo "<div>";
		echo "<label for='goal'>Στόχος διπλωματικής εργασίας:</label>";
		echo "<textarea name='goal' rows='10' cols='80' placeholder='Στο πεδίο αυτό γράφετε το στόχο της διπλωματικής εργασίας'></textarea>";
		echo "</div>";
		
		echo "<div>";
		echo "<label for='description'>Συνοπτική περιγραφή εργασίας:</label>";
		echo "<textarea name='description' rows='10' cols='80' placeholder='Σημειώστε μία περιγραφή της εργασίας'></textarea>";
		echo "</div>";
		echo "<div>";
		echo "<label for='requirement'>Προαπαιτούμενες γνώσεις:</label>";
		echo "<textarea name='requirement' rows='10' cols='80' placeholder='Γράψτε τυχόν γνώσεις που απαιτούνται για την εκπόνηση της διπλωματικής'></textarea>";
		echo "</div>";
		echo "<div id='courses'>";
			echo "<input type='hidden' value='0' name='noofcourses' id = 'noofcourses'>";
			echo "<label for='courses'>Προαπαιτούμενα μαθήματα:</label>";
			echo "<input type='button' value='Προσθήκη Μαθήματος' onClick='addInput();'>";
			for ($i=1;$i<=10;$i++){
				echo "<div id='course".$i."'  style='display:none;'>";
					echo "<span>Μάθημα:".$i."</span>";
					echo "<select name = 'semesterselector".$i."' id='semesterselector".$i."' onchange='viewCourses($i)'>";
					for ($j=1;$j<=9;$j++){
						if ($j==1){
							echo "<option value='$j' selected>Εξάμηνο:".$j."</option>";
						}
						else{
							echo "<option value='$j'>Εξάμηνο:".$j."</option>";
						}
					}
					echo "</select>";
					for ($j=1;$j<=9;$j++){
						if ($j==1){
							echo "<select id='courseselector".$i.'-'.$j."' name= 'courseselector".$i.'-'.$j."' style='display:inline;'>";
						}
						else{
							echo "<select id='courseselector".$i."-".$j."' name= 'courseselector".$i.'-'.$j."' style='display:none;'>";
						}
						$select_query = "select * from courses where semester= '$j' ";
						$select_result = $connect->query($select_query);
						$select_num_results = mysqli_num_rows($select_result);
						// Η λίστα ανάλογα με το αποτελέσμα των παραπάνω ερωτημάτων
							for($k=0;$k<$select_num_results;$k++){
								
								echo "<option value='$id'>";
								$select_row = mysqli_fetch_array($select_result);
								$id = $select_row["id"];
								$title = $select_row["title"];
								echo $id."-".$title;
								echo "</option>";
							}
						echo "</select>";
					}
				echo "</div>";
			}
			echo "<input type='button' value='Αφαίρεση Μαθήματος' onClick='removeInput();'>";
		echo "</div>";
		echo "<div>";
		echo "<label for='requirement'>Ημερομηνία δημοσιοποίησης θέματος:</label>";
		echo "<input type='date' name='publishdate'>";
		echo "<div>";
		echo "<input type='submit' value='Υποβολή'>";
		echo "</div>";
	echo "</form>";
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