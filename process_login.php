<?php
include 'db.php';
include 'header.php';
pageBeginning();

$username = trim($_POST[ 'username' ]);
$password = trim($_POST[ 'password' ]);

$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' and active = '1'" ;
$result = $connect->query($query);

$rows = mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($rows == 1){
	$_SESSION [ "username" ] = $username;
	$_SESSION [ "passsord" ] = $password;   
	header( "Location: index.php" );
	exit() ;
}
else{
   mainBeginning();
   echo "Λάθος όνομα χρήστη, κωδικός ή δεν έχετε ενεργοποιήσει σωστά τον λογαριασμό σας. <a href='login.php'>Δοκιμάστε</a> ξανά.<br>";
   mainEnd();
leftMenu($connect);
rightMenu($connect);
	pageEnd();
   
}
?>