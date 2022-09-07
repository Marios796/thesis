<?php 
include 'db.php';
include 'header.php';
pageBeginning(2);
mainBeginning();

setTitle("Ενεργοποίηση");
echo "<form method='post' action='process_validation.php' enctype='multipart/form-data'>";
		echo "<div>";
			echo "<label for='username'>Όνομα Χρήστη: <span class='required'>*</span></label><br/>";
			echo "<input type='text' id='username' name='username' placeholder='Το όνομα χρήστη σας' required='required' autofocus='autofocus' />";
		echo "</div>";
		echo "<div>";
			echo "<label for='password'>Κωδικός: <span class='required'>*</span></label><br/>";
			echo "<input type='password' name='password' id='password' onblur='checkStrongPassword();'>";
		echo "</div>";
		
		echo "<div>";
			echo "<label for='name'>Ρόλος: <span class='required'>*</span></label><br/>";
			 echo "<select name='role'>";
				echo "<option value='student'>Student</option>";
				echo "<option value='teacher'>Teacher</option>";
			echo "</select> ";
		echo "</div>";
		echo "<div>";
			echo "<label for='activation'>Activation code: <span class='required'>*</span></label><br/>";
			echo "<input type='text' name='activation'>";
		echo "</div>";
		echo "<div>";
			echo "<input type='submit' value='Ενεργοποίηση' id='submit_button'/> ";
		echo "</div>";
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>