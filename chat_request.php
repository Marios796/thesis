<?php
include 'db.php';
$username = $_GET['username'];
		$select_query = "select * from chat where sendername = '$username' or receivername = '$username' order by id desc ";
		//$select_query = "select * from chat order by id desc ";
		$select_result = $connect->query($select_query);
		$select_num_results = mysqli_num_rows($select_result);
		for($i=0;$i<$select_num_results;$i++){
			echo "<div>";
				$select_row = mysqli_fetch_array($select_result);
				$sendername = $select_row["sendername"]; 
				$receivername = $select_row["receivername"];
				$message = $select_row["message"]; 
				$posted = $select_row["posted"]; 
				echo "<span style='font-weight:bold;'>".$sendername."-->".$receivername."</span>: ";
				echo "<span >".$message."</span>";
				echo "<span style='float:right;'>".$posted."</span>";
				echo "<hr>";
			echo "</div>";
		}
		?>