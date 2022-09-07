<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
$username = $_SESSION[ "username" ];
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed with error " . $_FILES['file']['error']);
	mainEnd();
	leftMenu($connect);
	rightMenu($connect);
	pageEnd();
}
move_uploaded_file($_FILES['file']['tmp_name'], "grades/".$username.".pdf"); 
$query = "SELECT * FROM studentinfo WHERE username = '$username'" ;
$result = $connect->query($query);
$rows = mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($rows == 0){
	$insert_query = "insert into studentinfo (username,hasbio,hasgrades) values ('$username',b'0',b'1')";
	$insert_result = $connect->query($insert_query);
}
else{
	$update_query = "update studentinfo SET `hasgrades` = b'1' WHERE username = '$username'";
	$update_result = $connect->query($update_query);
}
header( "Location: studentinfo.php?studentname=".$username );
exit() ;
	
?>