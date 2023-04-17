
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
 
if(isset($_POST["send"])){
    $email = $_POST["email"];
    $name = $_POST["name"];
    $subject = $_POST["subject"];
 
    $msg ='<!DOCTYPE html>
    <html lang="en"> 
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <p> Greetings <strong> '.$name.'! </strong></p>
        <p>Thank you for your feedback, this is truly noted, Thanks '.$name.'!</p>
        <br><br>
        Have a great day ahead!,<br>
        RomeCita Staff<br>
        <strong></b> SeafoodtoGo</strong>
 
    </body>
    </html>';
 
 
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = "true";
    $mail->Username = "xhdarcen@gmail.com";
    $mail->Password = "imavxuteciqavcro";
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
 
    $mail->setFrom("xhdarcen@gmail.com", "Seafood to Go Management");
 
    $mail->addAddress($email); 
    $mail->isHTML(true);
 
    $mail->Subject = $subject;
    $mail->Body = $msg;
 
    $mail->send();
    header('location:index.html');
}
?>
