<?php
include 'db.php';
include 'header.php';

pageBeginning(2);
mainBeginning();
setTitle("Εγγραφή χρήστη");
if (isset($_SESSION[ "username" ])){
	echo "Είστε ήδη εγγεγραμένος Και συνδεδεμένος με όνομα χρήστη ",$_SESSION[ "username" ];
}
else{
	if (isset($_GET["username"])){
		$username = $_GET["username"];
		echo "Το όνομα χρήστη ".$username." χρησιμοποιείται ήδη.";
	}
	echo "<div id='signupform'>";
	echo "<form method='post' action='process_signup.php' enctype='multipart/form-data'>";
		echo "<div>";
			echo "<label for='username'>Όνομα Χρήστη: <span class='required'>*</span></label><br/>";
			echo "<input type='text' id='username' name='username' placeholder='Το όνομα χρήστη σας' required='required' autofocus='autofocus' />";
			echo "<span id='validusernamemessage'></span>";
		echo "</div>";
		echo "<div>";
			echo "<label for='password'>Κωδικός: <span class='required'>*</span></label><br/>";
			echo "<input type='password' name='password' id='password' onblur='checkStrongPassword();'>";
			echo "<span id='strongpasswordmessage'></span>";
		echo "</div>";
		echo "<div>";
			echo "<label for='password_validation' > Επιβεβαίωση Κωδικού: <span class='required'>*</span></label><br/>";
			echo "<input type='password' name='password_validation' id='confirmpassword' onblur='checkConfirmedPassword(); '>";
			echo "<span id='confirmpasswordmessage'></span>";
		echo "</div>";
		echo "<div>";
			echo "<label for='name'>Ονοματεπώνυμο: <span class='required'>*</span></label><br/>";
			echo "<input type='text' name='name' id='name'>";
		echo "</div>";
		echo "<div>";
			echo "<label for='email'>Email: <span class='required'>*</span></label><br/>";
			echo "<input type='email' name='email'>";
		echo "</div>";
		echo "<div>";
       	echo "<label for='math_answer' > Απαντήστε σωστά την ερώτηση για να αποδείξετε ότι είστε άνθρωπος: <span class='required'>*</span></label><br/>";
		echo " <span>Πόσο κάνει <span id='op1'></span> και <span id='op2'></span>?</span>";
       echo "<input name='math_answer' id='math_answer'  pattern='7' placeholder='Εδώ η απάντηση' required>";
   		echo "</div>";
		echo "<div>";
			echo "<input type='submit' value='Εγγραφή' id='submit_button'/> ";
		echo "</div>";

	echo "</form>";	
	echo "</div>";
	?>
	<span id="status" style="display:none">Unsubmitted</span>


<script>placenumber();</script>
<?php
}
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>
