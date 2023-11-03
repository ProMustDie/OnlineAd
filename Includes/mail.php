<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require $_SERVER['DOCUMENT_ROOT'] . '/OnlineAd/mail/Exception.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/OnlineAd/mail/PHPMailer.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/OnlineAd/mail/SMTP.php';

function send_mail($recipient,$name,$subject,$message)
{

  $mail = new PHPMailer();
  $mail->IsSMTP();

  $mail->SMTPDebug  = 0;  
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  //$mail->Host       = "smtp.mail.yahoo.com";
  $mail->Username   = "ausca33@gmail.com";
  $mail->Password   = "owxhhoyfnaflsnhy";

  $mail->IsHTML(true);
  $mail->CharSet = "utf-8";
  $mail->AddAddress($recipient, $name);
  $mail->SetFrom("ausca33@gmail.com", "TheSunDaily");
  //$mail->AddReplyTo("reply-to-email", "reply-to-name");
  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = $subject;
  $content = $message;

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    echo "Error while sending Email.";
    echo "<pre>";
    var_dump($mail);
    return false;
  } else {
    echo "Email sent successfully";
    return true;
  }

}

?>