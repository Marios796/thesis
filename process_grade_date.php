<?php
include 'db.php';
include 'header.php';
pageBeginning();

$grade_date = trim($_POST[ 'grade_date' ]);
$thesisid = trim($_POST[ 'thesisid' ]);
$grade = trim($_POST[ 'grade' ]);
$update_query = "UPDATE `currentthesis` SET `grade_date` = '$grade_date', `status` = 'graded' WHERE thesis_id = '$thesisid';";
$update_result = $connect->query($update_query);

$update_query = "UPDATE `thesis` SET `grade` = '$grade' WHERE id = '$thesisid';";
$update_result = $connect->query($update_query);

header( "Location: viewthesis.php?action=view&id=".$thesisid);
exit();
?>