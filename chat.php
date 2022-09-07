<?php
include 'db.php';
include 'header.php';
pageBeginning(1);
// To ajax script για το chat 
?>
		<script>
			function ajax(){
		        var httpRequest = new XMLHttpRequest();
		        httpRequest.onreadystatechange = function(){
		          if (httpRequest.readyState == 4 && httpRequest.status ==200){
		            document.getElementById('chat_box').innerHTML = httpRequest.responseText;
		          }
		        }
		        var path = <?php echo '"chat_request.php?username='.$_SESSION[ "username" ].'"' ?>; 
		        //var path = "chat_request.php";
		        httpRequest.open('GET',path,true);
		        httpRequest.send();
		      }
			setInterval(function(){ajax()},1000);
		</script>
		<?php

mainBeginning();
if (isset($_SESSION[ "username" ])){
	$username = $_SESSION[ "username" ];
	setTitle("Συνομιλία");
	echo "<div id='chat' >";
		echo "<div id='chat_box' style='margin:0 auto;padding:0;width:100%;height:400px;border:2px;border-style:solid;width:90%;overflow: scroll;'>";
		
		echo "</div>";
		
		//Αποστολή μηνύματος
		echo "<div>";
			echo "<form name='chatform' method='post' action='chat.php'> ";
				echo "<div style='width:100%;'>";
				echo "<textarea class = 'chat_system' name='msg' placeholder='Γράψτε το μήνυμά σας.' style='float:left;width:80%;height:20px;'></textarea>";
				//  Το Dropdown με τα ονόματα για αποστολή
				echo "<select name='receivername' style='float:left;'>";
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
				echo "</div>";
				echo "<input name='submit' type='submit' value='Αποστολή' style='float:right;'/>";
			echo "</form>";
		echo "</div>";
		if (isset($_POST['msg'])){
		
			$message = $_POST['msg'];
			$receivername = $_POST['receivername'];
			$insert_query = "insert into chat (sendername,receivername,message) values ('$username','$receivername','$message')";
			$insert_result = $connect->query($insert_query);
			
		}
	echo "</div>";
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