<?php 
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();

setTitle("Εγγραφή");

$username = trim($_POST[ 'username' ]);
$password = trim($_POST[ 'password' ]);
$role = trim($_POST[ 'role' ]);
$activation = trim($_POST[ 'activation' ]);
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' and activation_code = '$activation '" ;
$result = $connect->query($query);

$rows = mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($rows == 1){
	$update_query = "UPDATE `users` SET `role` = '$role', `active` = '1' WHERE `username` = '$username'";
	$update_result = $connect->query($update_query); 
	echo "<div><p>Έχετε εγγραφεί επιτυχώς και έχετε ενεργοποιήσει τον λογαριασμό σας. Μπορείτε τώρα να <a href = 'login.php'>συνδεθείτε</a>.</p></div>";
}
else{
	echo "<div><p>Έχετε κάνει κάποιο λάθος στο Username, στο password ή στον κωδικό ενεργοποίησης. Ξαναδοκιμάστε</p></div>";
}


	

mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>