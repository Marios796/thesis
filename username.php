<?php
include 'db.php';
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
$username = $_GET['username'];
$count_query = "select count(*) as isusername from users where username = '$username'";
	$count_result = $connect->query($count_query);
	$isusername = mysqli_fetch_assoc($count_result)['isusername'];
if($isusername==1)
    echo 'Το όνομα χρήστη '.$username.' υπάρχει ήδη στη βάση μας!';
elseif (strlen($username)<=2)
    echo 'Το όνομα χρήστη θα πρέπει να είναι τουλάχιστον 3 χαρακτήρες';
else
    echo 'Δεκτό όνομα χρήστη';
echo '</response>';
?>