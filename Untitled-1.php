<?php
// send.php - simple mail fallback for contact form
header('Content-Type: text/plain; charset=utf-8');

$to = isset($_POST['to']) ? trim($_POST['to']) : 'zyntraagency@gmail.com';
$name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if(!$email || !$name || !$message){
  http_response_code(400);
  echo "Please provide name, valid email and message.";
  exit;
}

$subject = "Website contact from $name";
$body = "You have a new message from the website contact form.\n\nName: $name\nEmail: $email\n\nMessage:\n$message\n";
$headers = "From: $name <$email>\r\nReply-To: $email\r\n";

$success = mail($to, $subject, $body, $headers);

if($success){
  echo "OK";
  http_response_code(200);
} else {
  http_response_code(500);
  echo "Failed to send email. Server may not be configured to send mail. Consider using Formspree or SMTP.";
}
?>
