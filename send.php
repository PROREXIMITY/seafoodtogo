<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
// require 'vendor/autoload.php'

if(isset($_POST["send"])){
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username='xhdarcen@gmail.com';
  $mail->Password='vxotoamrplquoobu';
  $mail->SMTPSecure='ssl';
  $mail->Port= 465;

  $mail->setFrom('xhdarcen@gmail.com');

  $mail->addAddress($_POST["email"]);

  $mail->isHTML(true);

  $mail->Subject= $_POST["subject"];
  $mail->Body = $_POST["message"];

  $mail->send();

  echo "<script> alert('Sent Successfully'); document.location.href = 'index.html';";
}
?>