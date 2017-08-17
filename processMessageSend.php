<?php

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$time = $_POST['message'];
$subject = "New message from" + $name + " on sauravkadavath.com";

$headers = 'From: '. $email . "\r\n" .
				    'Reply-To: ' . $email . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

mail("sauravkadavath@berkeley.edu", $subject, $message, $headers);

$data = "{ \"msg_status\" : \"ok\" }";
header('Content-Type: application/json');
echo json_encode($data);


?>