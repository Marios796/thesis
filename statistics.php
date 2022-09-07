<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	setTitle("Στατιστικά");
	// Σύνολο καθηγητών στην πλατφόρμα
	$teachers_count_query = "select count(*) as total_teachers from users where role = 'teacher'";
	$teachers_count_result = $connect->query($teachers_count_query);
	$total_teachers = mysqli_fetch_assoc($teachers_count_result)['total_teachers'];
	
	$students_count_query = "select count(*) as total_students from users where role = 'student'";
	$students_count_result = $connect->query($students_count_query);
	$total_students = mysqli_fetch_assoc($students_count_result)['total_students'];
	
	echo "<hr>";
	setSubtitle("Μέλη πλατφόρμας");
	echo "<strong>Καθηγητές:</strong>".$total_teachers;
	echo "<br><strong>Φοιτητές:</strong>".$total_students;
	
	$total_thesis_query = "select count(*) as total_thesis from thesis";
	$total_thesis_result = $connect->query($total_thesis_query);
	$total_thesis = mysqli_fetch_assoc($total_thesis_result)['total_thesis'];
	
	$graded_thesis_query = "select count(*) as graded_thesis from currentthesis where status = 'graded'";
	$graded_thesis_result = $connect->query($graded_thesis_query);
	$graded_thesis = mysqli_fetch_assoc($graded_thesis_result)['graded_thesis'];
	
	$current_thesis_query = "select count(*) as current_thesis from currentthesis where status <> 'graded'";
	$current_thesis_result = $connect->query($current_thesis_query);
	$current_thesis = mysqli_fetch_assoc($current_thesis_result)['current_thesis'];
	echo "<hr>";
	setSubtitle("Διπλωματικές στην πλατφόρμα");
	echo "<strong>Σύνολο διπλωματικών:</strong>".$total_thesis;
	echo "<br><strong>Ολοκληρωμένες διπλωματικές:</strong>".$graded_thesis;
	echo "<br><strong>Τρέχουσες διπλωματικές:</strong>".$current_thesis;
	
	// Πίνακας με τα ονόματα των καθηγητών
	$teachersname = array();
	// Πίνακας με τα username των καθηγητών
	$teachers  = array();
	$teachers_query = "select name,username from users where role = 'teacher'";
	$teachers_result = $connect->query($teachers_query);
	while($row = mysqli_fetch_assoc($teachers_result)) {
	   $teachersname[] = $row['name'];
	   $teachers[] = $row['username'];
	}
	echo "<hr>";
	setSubtitle("Γραφήματα");
	echo "<div id='teachers_total'>";
	echo "</div>";
	echo "<hr>";
	echo "<div id='teachers_graded'>";
	echo "</div>";
	echo "<hr>";
	echo "<div id='teachers_grades'>";
	echo "</div>";
	// Πίνακας με τις πτυχιακές ανά καθηγητή που έχουν κατατεθεί
	$thesis_per_teacher = array();
	foreach($teachers as $teacher){
		$tpt_query = "select count(*) as tpt from thesis where username = '$teacher'";
		$tpt_result = $connect->query($tpt_query);
		$thesis_per_teacher[] = mysqli_fetch_assoc($tpt_result)['tpt'];
	}
	
	// Πίνακας με τις ολοκληρωμένες πτυχιακές ανά καθηγητή
	$completed_thesis_per_teacher = array();
	foreach($teachers as $teacher){
		$completed_tpt_query = "select count(*) as tpt from thesis where status = 'graded' and username = '$teacher'";
		$completed_tpt_result = $connect->query($completed_tpt_query);
		$completed_thesis_per_teacher[] = mysqli_fetch_assoc($completed_tpt_result)['tpt'];
	}
// Πίνακας με τα ονόματα των καθηγητών
	$average_teachersname = array();
	// Πίνακας με τΟυς μέσου όρους καθηγητών
	$average  = array();
// Μέσοι όροι βαθμολογίας ανά καθηγητή
$teachers_average_query = "SELECT username, AVG(grade) FROM thesis where status = 'graded' GROUP BY username;";
$teachers_average_result = $connect->query($teachers_average_query);
while($teachers_average_row = mysqli_fetch_assoc($teachers_average_result)) {
	   $average_teachersname[] =getName($connect,$teachers_average_row['username']);
	   $average[] = $teachers_average_row['AVG(grade)'];
	}




$js_teachers = json_encode($teachersname);
$js_tpt = json_encode($thesis_per_teacher);
$js_completed_tpt = json_encode($completed_thesis_per_teacher);

$js_averageteachers = json_encode($teachersname);
$js_average = json_encode($average);
?>
<script>
var teachersarray = <?php echo $js_teachers; ?>;
var tpt = <?php echo $js_tpt; ?>;
var js_completed_tpt = <?php echo $js_completed_tpt; ?>;
// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(function(){drawPieChart(teachersarray,tpt);});

google.charts.setOnLoadCallback(function(){drawPie2Chart(teachersarray,js_completed_tpt);});
 
var averageteachers = <?php echo $js_averageteachers; ?>;
var average = <?php echo $js_average; ?>;
google.charts.setOnLoadCallback(function(){drawGradesChart(averageteachers,average);});
	  
</script>
<?php

	

	
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