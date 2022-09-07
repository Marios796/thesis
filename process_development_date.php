<?php
include 'db.php';
include 'header.php';
pageBeginning();

$development_date = trim($_POST[ 'development_date' ]);
$thesisid = trim($_POST[ 'thesisid' ]);
$update_query = "UPDATE `currentthesis` SET `development_date` = '$development_date', `status` = 'developed' WHERE thesis_id = '$thesisid';";
$update_result = $connect->query($update_query);

header( "Location: viewthesis.php?action=view&id=".$thesisid);
exit();
?>