<?php
include 'db.php';
include 'header.php';
pageBeginning();

$username = trim($_POST['username']);
$title = trim($_POST['title']);
$noofstudents = trim($_POST['noofstudents']);
$goal = trim($_POST['goal']);
$description = trim($_POST['description']);
$requirement = trim($_POST['requirement']);
$publishdate = trim($_POST['publishdate']);
$query = "INSERT INTO `thesis` (`id`, `title`, `username`, `noofstudents`, `goal`, `description`, `requirement`, `publishdate`,  `grade`) VALUES (NULL, '$title', '$username', '$noofstudents', '$goal', '$description', '$requirement', '$publishdate',  '');";
$result =$connect->query($query);
$id = mysqli_insert_id($connect);
$noofcourses = trim($_POST['noofcourses']);
for ($i=1;$i<=$noofcourses;$i++){
	$semester = trim($_POST['semesterselector'.$i]);
	$course = trim($_POST['courseselector'.$i.'-'.$semester]);
	$course_query = "INSERT INTO `thesis_courses` (`id`,`thesis_id`,`courses_id`) VALUES (NULL, '$id','$course');";
	$course_result =$connect->query($course_query);
}
header( "Location: viewthesis.php?action=insert&id=".$id);
exit();

?>