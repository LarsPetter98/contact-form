<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "/Users/larspetterbo/Documents/PHP/vendor/autoload.php";

require "/Users/larspetterbo/Documents/PHP/vendor/phpmailer/phpmailer/src/Exception.php";
require "/Users/larspetterbo/Documents/PHP/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "/Users/larspetterbo/Documents/PHP/vendor/phpmailer/phpmailer/src/SMTP.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$SMTP_HOST = $_ENV["SMTP_HOST"];
$SMTP_PORT = $_ENV["SMTP_PORT"];
$SMTP_USERNAME = $_ENV["SMTP_USERNAME"];
$SMTP_PASSWORD = $_ENV["SMTP_PASSWORD"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];
}

try {
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->SMTPAuth = true;

  // SMTP settings
  $mail->Host = $SMTP_HOST;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = $SMTP_PORT;
  $mail->Username = $SMTP_USERNAME;
  $mail->Password = $SMTP_PASSWORD;

  // Sending email
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail->setFrom($email, $name);
    $mail->addAddress("larsp98@yahoo.no");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();
    header("Location: contact-form.html");
  }
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
}
?>