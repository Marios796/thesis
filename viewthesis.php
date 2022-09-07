<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
	
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	$role = getRole($connect,$username);
	if (isset($_GET["id"]) && isset($_GET["action"])){
		$id = $_GET["id"];
		$action = $_GET["action"];
		$select_id_query = "select * from thesis where id = '$id'";
		$select_id_result = $connect->query($select_id_query);
		$select_id_num_results = mysqli_num_rows($select_id_result);
		if ($select_id_num_results==1){
			$select_id_row = mysqli_fetch_array($select_id_result);
			$id = $select_id_row["id"]; 
			$teachername = $select_id_row["username"]; 
			$title = $select_id_row["title"];
			$goal = $select_id_row["goal"];
			$noofstudents = $select_id_row["noofstudents"];
			$description = $select_id_row["description"];
			$requirement = $select_id_row["requirement"];
			$noofstudents = $select_id_row["noofstudents"];
			$publishdate = $select_id_row["publishdate"];
			$status = $select_id_row["status"];
			$grade = $select_id_row["grade"];
			// Μήνυμα επιτυχούς δημιουργίας διπλωματικής.
			if ($action=="insert"){
				echo "<p>Μόλις προσθέσατε την διπλωματική: <a href=viewthesis.php?action=view&id=".$id.">".$title."</a></p>";;
			}
			// Εμφάνιση στοιχείων συγκεκριμμένης διπλωματικής
			else if ($action=="view"){
				setTitle("Εμφάνιση Διπλωματικής");
				echo "<div><strong>Διπλωματική</strong>:".$title."</div>";
				echo "<div><strong>Επιβλέπων</strong>:".getName($connect,$teachername)."</div>";
				echo "<div><strong>Αριθμός φοιτητών</strong>:".$noofstudents."</div>";
				echo "<div><strong>Σκοπός</strong>:".$goal."</div>";
				echo "<div><strong>Περιγραφή</strong>:".$description."</div>";
				echo "<div><strong>Προαπαιτούμενες γνώσεις</strong>:".$requirement."</div>";
				echo "<div><strong>Προαπαιτούμενα μαθήματα</strong>:</div>";
				$select_courses_query = "select * from thesis_courses where thesis_id = '$id'";
				$select_courses_result = $connect->query($select_courses_query);
				$select_courses_num_results = mysqli_num_rows($select_courses_result);
				echo "<ul>";
				for ($i=0;$i<$select_courses_num_results;$i++){
					$select_courses_row = mysqli_fetch_array($select_courses_result);
					$courses_id = $select_courses_row["courses_id"]; 
					echo "<li>".getCourseTitle($connect,$courses_id)." (".getCourseSemester($connect,$courses_id)."ου εξαμήνου)</li>";
				}
				echo "</ul>";
				
				echo "<div><strong>Ημερομηνία δημοσιοποίησης θέματος</strong>:".$publishdate."</div>";
				if ($status=="pending"){
					echo "<div><strong>Εγκεκριμένοι φοιτητές</strong>:".getWaitingStudents($connect,$id)."/".$noofstudents."</div>";
				}
				// Η διπλωματική έχει εγγριθεί. Παρουσίαση φοιτητή/ φοιτητών που την έχουν αναλάβει
				else{
					echo "<div><strong>Εγκεκριμένοι φοιτητές</strong>:</div>";
					$select_approved_query = "select * from request where thesisid = '$id' and status = 'approved'";
					$select_approved_result = $connect->query($select_approved_query);
					$select_approved_num_results = mysqli_num_rows($select_approved_result);
					echo "<ul>";
					for($i=0;$i<$select_approved_num_results;$i++){
						$select_approved_row = mysqli_fetch_array($select_approved_result);
						$studentname = $select_approved_row["studentname"]; 
						echo "<li><a href='studentinfo.php?studentname=$studentname'>".getName($connect,$studentname)."</a></li>";
					}
					echo "</ul>";
				}
				// Εάν ο ρόλος του χρήστη είναι "φοιτητής" μπορεί αυτός να στείλει αίτηση για τη συγκεκριμμένη διπλωματική ή εάν έχει ήδη αιτηθεί
				// να μπορεί να δει την αίτηση.
				
				if ($role=="student"){
					$request_query = "select * from request where thesisid = '$id' and studentname= '$username'";
					$request_result = $connect->query($request_query);
					$request_num_results = mysqli_num_rows($request_result);
					// Δεν έχει γίνει αίτηση για την διπλωματική αυτή. Ο φοιτητής μπορεί να αιτηθεί
					if ($request_num_results==0){
						echo "<form name='form1' method='post' action='process_request.php'> ";
						echo "<input type='hidden' name='username' value='".$username."'>";
						echo "<input type='hidden' name='thesisid' value='".$id."'>";
						echo "<input type='hidden' name='teacher' value='".$teachername."'>";
						echo "<input type='submit' value='Αίτηση έγκρισης' class='submit' style='background:#DAEDFF '/>";
						echo "</form>";
					}
					// Έχει γίνει ήδη αίτηση για την διπλωματική αυτή.
					else{
						$request_row = mysqli_fetch_array($request_result);
						$request_id = $request_row["id"]; 
						$status = $request_row["status"];
						echo "<div><strong>Κατάσταση αίτησης</strong>:";
						if ($status=='pending'){
							echo "Σε αναμονή έγκρισης";
						}
						else if ($status=='waiting'){
							echo "Υπο έγκριση - Σε αναμονή φοιτητών.";
						}
						else{
							echo "Εγκεκριμένη";
						}
						echo "</div>";
					}
				}
				// Εάν ο ρόλος του χρήστη είναι "καθηγητής" να μπορεί να δει αιτήσεις για τη συγκεκριμμένη διπλωματική 
				else{
					setSubtitle("Λίστα αιτήσεων διπλωματικής");
					viewRequestsList($connect,"select * from request where thesisid = '$id'");					
				}
				setSubtitle("Βήματα υλοποίησης");
				$status = getCurrentThesisStatus($connect,$id);
				if ($role="teacher"){
					if ($status == "approved"){
						echo "<strong>Κατάσταση</strong>:Εγγρίθηκε";
						echo "<form action='process_development_date.php' method='post'>";
							echo "Ημερομηνία υλοποίησης:";
							echo "<input type='date' name='development_date'>";
							echo "<input type='hidden' name='thesisid' value='".$id."'>";
							echo "<input type='submit' value = Καταχώριση>";
						echo "</form>";
					}
					else if ($status == "developed"){
						echo "<strong>Κατάσταση</strong>:Υλοποιήθηκε";
						echo "<form action='process_presentation_date.php' method='post'>";
							echo "Ημερομηνία παρουσίασης:";
							echo "<input type='date' name='presentation_date'>";
							echo "<input type='hidden' name='thesisid' value='".$id."'>";
							echo "<input type='submit' value = Καταχώριση>";
						echo "</form>";
					}
					else if ($status == "presented"){
						echo "<strong>Κατάσταση</strong>:Παρουσιάστηκε";
						echo "<form action='process_grade_date.php' method='post'>";
							echo "Ημερομηνία βαθμολόγησης:";
							echo "<input type='hidden' name='thesisid' value='".$id."'>";
							echo "<input type='date' name='grade_date'>";
							echo "<br/>";
							echo "<label for='title'>Βαθμός: <span class='required'>*</span></label>";
							echo "<input type='number' name='grade' min='5' max='10' step='.01'>";
							echo "<br/>";
							echo "<input type='submit' value = Καταχώριση>";
						echo "</form>";
					}
					else if ($status == "graded"){
						echo "<strong>Κατάσταση</strong>:Βαθμολογήθηκε";
						echo "<br><strong>Βαθμός</strong>:".$grade;
						//echo "
						//$pdf = PDF_new();
						//pdf_open_file($pdf, $id.".pdf");
					}
					
				}
				
				$current_thesis_query = "select * from currentthesis where thesis_id = '$id'";
				$current_thesis_result = $connect->query($current_thesis_query);
				$current_thesis_row = mysqli_fetch_array($current_thesis_result);
				$status = $current_thesis_row["status"];
				$publish_date = $current_thesis_row["publish_date"];
				$pda = explode("-",$publish_date);
				if ($status == "approved" or $status == "developed" or $status == "presented" or $status == "graded"){
					$approval_date = $current_thesis_row["approval_date"];
				}
				else {
					$approval_date = date('Y-m-d');
				}
				$ada = explode("-",$approval_date);
				if ($status == "developed" or $status == "presented" or $status == "graded"){
					$development_date = $current_thesis_row["development_date"];
				}
				else {
					$development_date = date('Y-m-d');
				}
				$dda = explode("-",$development_date);
				if ($status == "presented" or $status == "graded"){
					$presentation_date = $current_thesis_row["presentation_date"];
				}
				else {
					$presentation_date = date('Y-m-d');
				}
				$prda = explode("-",$presentation_date);
				if ($status == "graded"){
					$grade_date = $current_thesis_row["grade_date"];
				}
				else {
					$grade_date = date('Y-m-d');
				}
				$gda = explode("-",$grade_date);
				?>
				<script type="text/javascript">
					google.charts.load('current', {'packages':['gantt']});
					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Task ID');
						data.addColumn('string', 'Task Name');
						data.addColumn('string', 'Resource');
						data.addColumn('date', 'Start Date');
						data.addColumn('date', 'End Date');
						data.addColumn('number', 'Duration');
						data.addColumn('number', 'Percent Complete');
						data.addColumn('string', 'Dependencies');

						data.addRows([
						['2014Spring', 'Δημοσίευση', 'spring',
						 new Date (parseInt(<?php echo $pda[0]?>),parseInt(<?php echo $pda[1]?>)-1,parseInt(<?php echo $pda[2]?>)),
						 new Date(parseInt(<?php echo $ada[0]?>),parseInt(<?php echo $ada[1]?>)-1,parseInt(<?php echo $ada[2]?>)), 
						 null, 100, null],
						<?php if ($status == "approved" or $status == "developed" or $status == "presented" or $status == "graded"){ ?>
						['2014Summer', 'Ανάθεση', 'summer',
						 new Date(parseInt(<?php echo $ada[0]?>),parseInt(<?php echo $ada[1]?>)-1,parseInt(<?php echo $ada[2]?>)),
						 new Date(parseInt(<?php echo $dda[0]?>),parseInt(<?php echo $dda[1]?>)-1,parseInt(<?php echo $dda[2]?>)), null, 100, null],
						<?php } ?>
						<?php if ($status == "developed" or $status == "presented" or $status == "graded"){ ?>
						['2014Autumn', 'Υλοποίηση', 'autumn',
						 new Date(parseInt(<?php echo $dda[0]?>),parseInt(<?php echo $dda[1]?>)-1,parseInt(<?php echo $dda[2]?>)), 
						 new Date(parseInt(<?php echo $prda[0]?>),parseInt(<?php echo $prda[1]?>)-1,parseInt(<?php echo $prda[2]?>)), null, 100, null],
						<?php } ?>
						<?php if ($status == "presented" or $status == "graded"){ ?>
						['2014Winter', 'Παρουσίαση', 'winter',
						 new Date(parseInt(<?php echo $prda[0]?>),parseInt(<?php echo $prda[1]?>)-1,parseInt(<?php echo $prda[2]?>)), 
						 new Date(parseInt(<?php echo $gda[0]?>),parseInt(<?php echo $gda[1]?>)-1,parseInt(<?php echo $gda[2]?>)), null, 100, null],
						<?php } ?>
						<?php if ($status == "graded"){ ?>
						['2015Spring', 'Βαθμολόγηση', 'spring',
						 new Date(parseInt(<?php echo $gda[0]?>),parseInt(<?php echo $gda[1]?>)-1,parseInt(<?php echo $gda[2]?>)),
						 new Date(parseInt(<?php echo $gda[0]?>),parseInt(<?php echo $gda[1]?>)-1,parseInt(<?php echo $gda[2]?>)), null, 50, null]
						<?php } ?>
						]);

						var options = {
						height: 400,
						gantt: {
						  trackHeight: 30
						}
						};

						var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

						chart.draw(data, options);
					}
				</script>

<?php
		echo "<div id='chart_div'></div>";

			}
		}
		else{
			setTitle("Εμφάνιση Διπλωματικών");
			echo "Δεν υπάρχει διπλωματική εργασία με id:".$id;
		}
	}
	// Λίστα διπλωματικών
	else{
		if ($role=="student"){
				echo "<div id='search'>";		
					echo "<form method='post' action='' enctype='multipart/form-data'>";
						echo "<label for='searchlabel'>Αναζήτηση:</label>";
						echo "<input type='search' name='searchquery' id='searchquery'>";
					echo "</form>";
				echo "</div>";
		}
		// Λίστα με διπλωματικές σύμφωνα με συγκεκριμμένους όρους
		// Εάν έχει γίνει κάποια αναζήτηση
		if (isset($_POST["searchquery"])){
			$searchquery = $_POST["searchquery"];
			setTitle("Εμφάνιση Διπλωματικών με λέξη κλειδί ");
			$select_query = "select * from thesis where (title like '%$searchquery%' or description like '%$searchquery%') and status in ('notassigned','assigned')";
			$select_result = $connect->query($select_query);
			$select_num_results = mysqli_num_rows($select_result);
		}
		// Εάν έχει αναζητηθεί η λίστα συγκεκριμένου καθηγητή
		else if (isset($_GET["term"])){
			setTitle("Εμφάνιση Διπλωματικών καθηγητή");
			$teachername = $_GET["name"];
			$select_query = "select * from thesis where username = '$teachername' ";
			
			$select_result = $connect->query($select_query);
			$select_num_results = mysqli_num_rows($select_result);
		}
		// Λίστα με όλες τις διπλωματικές
		else{
			setTitle("Εμφάνιση όλων των Διπλωματικών");
			$select_query = "select * from thesis where status in ('notassigned','assigned')";
			$select_result = $connect->query($select_query);
			$select_num_results = mysqli_num_rows($select_result);
		}
		// Η ίδια η λίστα ανάλογα με το αποτελέσμα των παραπάνω ερωτημάτων
		echo "<ol>";
		for($i=0;$i<$select_num_results;$i++){
			$select_row = mysqli_fetch_array($select_result);
			$id = $select_row["id"]; 
			$teachername = $select_row["username"]; 
			$title = $select_row["title"];
			$status = $select_row["status"];
			echo "<a href=viewthesis.php?term=teacher&name=".$teachername."&filter=all>";
			echo "<li>";
			echo getName($connect,$teachername);
			echo "</a>";
			echo ",";
			echo "<a href=viewthesis.php?action=view&id=".$id.">";
			echo $title;
			echo "</a>";
			echo ",";
			if ($status=="notassigned"){
				echo "(Δεν έχει ανατεθεί)";
			}
			else if ($status=="assigned"){
				echo "(Υπο έγκριση)";
			}
			else if ($status=="approved"){
				echo "(Έχει ανατεθεί σε φοιτητή/ φοιτητές)";
			}
			echo "</li>";
		}
		echo "</ol>";
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