<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();
$requestid = trim($_POST[ 'requestid' ]);
$thesisid = trim($_POST[ 'thesisid' ]);
$teachername = trim($_POST[ 'teachername' ]);
$studentname = trim($_POST[ 'studentname' ]);
$totalnoofstudents = getThesisStudents($connect,$thesisid);
$currentnoofstudents = getWaitingStudents($connect,$thesisid);
// Εγκρίθηκε ο τελευταίος φοιτητής για να συμπληρωθεί ο αριθμός φοιτητών. Η πτυχιακή γίνεται πλέον approved
if ($totalnoofstudents == $currentnoofstudents + 1){
	$update_thesis_query = "UPDATE `thesis` SET `status` = 'approved' WHERE `thesis`.`id` = '$thesisid';";
	$update_thesis_result = $connect->query($update_thesis_query);
	$publish_date = getThesisPublishDate($connect,$thesisid);
	$now = new DateTime();
	$insert_query = "INSERT INTO `currentthesis` (`id`, `thesis_id`, `publish_date`, `approval_date`,`status`) VALUES (NULL, '$thesisid','$publish_date', '".$now->format('Y-m-d')."','approved');";
	$insert_query_result = $connect->query($insert_query);
	$update_request_query = "UPDATE `request` SET `status` = 'approved' WHERE (status = 'waiting' and `thesisid` = '$thesisid') or
		(studentname = '$studentname' and `thesisid` = '$thesisid');";
	$update_request_result = $connect->query($update_request_query);
	$cancel_request_query = "UPDATE `request` SET `status` = 'canceled' WHERE status = 'pending' and `thesisid` = '$thesisid';";
	$cancel_request_result = $connect->query($cancel_request_query);
	$cancel_user_request_query = "UPDATE `request` SET `status` = 'canceled' WHERE status = 'pending' and `studentname` = '$studentname';";
	$cancel_user_request_result = $connect->query($cancel_user_request_query);
}
// Ο φοιτητής περιμένει και άλλον ή άλλους φοιτητές για να ξεκινήσει η πτυχιακή
else {
	$update_thesis_query = "UPDATE `thesis` SET `status` = 'assigned' WHERE `thesis`.`id` = '$thesisid';";
	$update_thesis_result = $connect->query($update_thesis_query);
	$update_request_query = "UPDATE `request` SET `status` = 'waiting' WHERE `thesisid` = '$thesisid' AND `studentname` = '$studentname';";
	$update_request_result = $connect->query($update_request_query);
}
header( "Location: viewrequests.php?action=approve&id=".$requestid);
mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>