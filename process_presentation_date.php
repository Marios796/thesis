<?php
include 'db.php';
include 'header.php';
pageBeginning();

$presentation_date = trim($_POST[ 'presentation_date' ]);
$thesisid = trim($_POST[ 'thesisid' ]);
$update_query = "UPDATE `currentthesis` SET `presentation_date` = '$presentation_date', `status` = 'presented' WHERE thesis_id = '$thesisid';";
$update_result = $connect->query($update_query);

header( "Location: viewthesis.php?action=view&id=".$thesisid);
exit();
?>