<?php

$conn = mysqli_connect("localhost", "root", "", "personal");

if (!$conn) {
    echo "Connection Failed";
}


use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
 //Load Composer's autoloader
 require 'vendor/autoload.php';
    
   
 $msg = "";
 $error =[];
 $insert = '';

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $subject = mysqli_real_escape_string($conn, $_POST['subject']);
     $message = mysqli_real_escape_string($conn, $_POST['message']);




     if(empty($name)){
      $error['nameErr'] = 'Name Required';
  }
  
  
 
  
  if(empty($email)){
      $error['emailErr'] = 'Email Required';
  }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $error['emailErr'] = 'Your Email Invalid';
  }



  if(empty($subject)){
    $error['subjectErr'] = 'Subject Required';
}

if(empty($message)){
  $error['messageErr'] = 'Message Required';
}


if (count($error) == 0) {
  $name = mysqli_real_escape_string($conn, $name);
  $email = mysqli_real_escape_string($conn, $email);
  $subject = mysqli_real_escape_string($conn, $subject);
  $message = mysqli_real_escape_string($conn, $message);


     $sql = "INSERT INTO contact 
(`name`,email,`subject`,`message`)VALUES ('$name','$email','$subject','$message')";
$insert = mysqli_query($conn, $sql);
// echo '<div class="alert alert-succeess">   Success full Think You </div>';
echo '<p class = "text-center">   Success full Thank you </p>';
if($sql){
  $last_id = mysqli_insert_id($conn);

}else{
  echo '<div class="alert alert-warning"> Register error</div>' ;

}
}
/// This code is to send to the manager's email
            if ($insert) {
                 echo "<div style='display: none;'>";
                 //Create an instance; passing `true` enables exceptions
                 $mail = new PHPMailer(true);

                 try {
                     //Server settings
                     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                     $mail->isSMTP();                                            //Send using SMTP
                     $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                     $mail->CharSet = "UTF-8";
                     $mail->Username   = 'rokaya.asas80@gmail.com';                     //SMTP username
                     $mail->Password   = 'tgty etwp btmv tdzu';                               //SMTP password
                     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                     //Recipients
                     $mail->setFrom('rokaya.asas80@gmail.com');
                    $mail->addAddress('rokaya.asas80@gmail.com');
                    $mail->CharSet = "UTF-8";

                     //Content
                     $mail->isHTML(true);                                  //Set email format to HTML
                     $mail->Subject = 'Contact Us Form ';
                     $mail->Body    = ' name :'.$name. '<br>  Email: '.$email.'  <br>  Subject: '.$subject.'  <br> Massage:'.$message.' ';
                    

                     $mail->send();
                     echo  "<div class='alert alert-success'>Message has been sent</div>";
                 } catch (Exception $e) {
                     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                 }
                 echo "</div>";
                 
             } else {
                 $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
             }
   



            // This code is to send to the customer's email in the form
            if ($insert) {
              echo "<div style='display: none;'>";
              $mail = new PHPMailer(true);

              try {
                  //Server settings
                  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                  $mail->isSMTP();                                            //Send using SMTP
                  $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                  $mail->CharSet    = "UTF-8";
                  $mail->Username   = 'rokaya.asas80@gmail.com';                     //SMTP username
                  $mail->Password   = 'tgty etwp btmv tdzu';                               //SMTP password
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                  //Recipients
                  $mail->setFrom('rokaya.asas80@gmail.com');
                  $mail->addAddress($email);

                  //Content
                  $mail->isHTML(true);                                  //Set email format to HTML
                  $mail->Subject = 'no reply';
                  $mail->Body    = 'Thank you your message has been sent successfully  ';

                  $mail->send();
                  echo  "<div class='alert alert-success'>Message has been sent</div>";
              } catch (Exception $e) {
                  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
              }
              echo "</div>";
              
          } else {
              $msg = "<div class='alert alert-danger'>Something wrong went</div>";
          }
        }


    ?>
