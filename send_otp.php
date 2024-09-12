<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

function sendOTP($email, $otp) 
{
  $to = $email;
  $subject = 'OTP for Attendance Management System';
  $message = 'Your OTP is: ' . $otp;
  $headers = 'From: ishsood112@gmail.com' . "\r\n" .
    'Reply-To: $email ' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

  // Use PHPMailer instead of mail()
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPAuth = true;
  $mail->Username = 'ishsood112@gmail.com';
  $mail->Password = 'ntpe edbi umiu tbhd';
  $mail->setFrom('ishsood112@gmail.com', 'ish sood');
  $mail->addAddress($to);
  $mail->Subject = $subject;
  $mail->Body = $message;
  $mail->send();

  // Hash the OTP before storing it in the session
  return hash('sha256', $otp);
}
?>