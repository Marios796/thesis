<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
$username = trim($_POST[ 'username' ]);
$thesisid = trim($_POST[ 'thesisid' ]);
$teachername = trim($_POST[ 'teacher' ]);
$query = "INSERT INTO `request` (`id`, `studentname`, `teachername`, `thesisid`,`status`) VALUES (NULL, '$username', '$teachername', '$thesisid','pending')";
$result = $connect->query($query);
$id = mysqli_insert_id($connect);
header( "Location: viewrequests.php?action=insert&id=".$id);
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
