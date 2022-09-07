<?php 
include 'db.php';
include 'header.php';
session_start();
require_once 'classes1/class.phpmailer.php';
ini_set('display_errors', 1);
$activation_code =  mt_rand(10000, 99999);
$username = trim($_POST[ 'username' ]);
$password = trim($_POST[ 'password' ]);
$name = trim($_POST[ 'name' ]);
$email = trim($_POST[ 'email' ]);
$query = "INSERT INTO `users` (`username`, `password`, `email`, `name`, `activation_code`) VALUES ('$username', '$password', '$email', '$name','$activation_code');";
$result =$connect->query($query);
$id = mysqli_insert_id($connect);
$mail             = new PHPMailer();
$mail->charSet = 'utf-8';
$mail->IsSMTP();
$mail->Host       = "smtp.aegean.gr";
$mail->SMTPAuth   = true;
$mail->Port   = 587;
$mail->AuthType = "LOGIN";
$mail->SMTPSecure = "tls";
// To usernameκαι το password στο πανεπιστήμιο Αιγαίου
$mail->Username="icsd13091";
$mail->Password="Heisenberg1^";
$mail->SMTPDebug=true;
$mail->Debugoutput="echo";
$mail->SetFrom($mail->Username."@icsd.aegean.gr", "");
$mail->AddReplyTo($mail->Username."@icsd.aegean.gr", "");
$mail->AddAddress($email, "");
$mail->Subject = "Εγγραφή στην πλατφόρμα μας";
$msg = "Εγγραφή στην πλατφόρμα αλληλεπίδρασης εκπονήσεων διπλωματικών εργασιών του Πανεπιστημίου Αιγαίου....<br> Κωδικός ενεργοποίησης:"
						.$activation_code."<br>Σελίδα:<a href='http://localhost/thesis_platform/signup_validation.php'>http://localhost/thesis_platform/signup_validation.php</a>";
$mail->IsHTML(true);
$mail->MsgHTML($msg);
$mail->Send();
//header( "Location: signup_message.php" );
echo "<script>location.href = 'signup_message.php';</script>";
php?>