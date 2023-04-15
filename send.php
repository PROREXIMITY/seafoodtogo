<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'seafoodtogo/src/Exception';
require 'seafoodtogo/src/PHPMailer.php';
require 'seafoodtogo/src/SMTP.php';


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

  echo "<script> alert('Sent Successfully'); document.location.href = 'index.php';";
}
?>


    <!-- $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
     
    $EmailTo = "@gmail.com"; 
    $Subject = "Portfolio CV/Resume";
     
    // prepare email body text
    
    $Body .= "Name: ";
    $Body .= $name;
    $Body .= "\n"; 
     
    $Body .= "Email: ";
    $Body .= $email;
    $Body .= "\n";
     
    $Body .= "Message: ";
    $Body .= $message;
    $Body .= "\n";
     
    
    // send email
    $success = mail($EmailTo, $Subject, $Body, "From:".$email);
     
    // redirect to success page
    if ($success){
       echo "success";
    }else{
        echo "invalid";
    }  -->
