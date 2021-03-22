<?php
session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
  require "assets/function.php" ;
require 'assets/db.php';



$stockArray = $con->query("select * from purchaser");

            $i=0;

            
            while ($row = $stockArray->fetch_assoc()) 
            { 
            $i=$i+1;
            
            $dt = date('Y-m-d');
            
            if($row['reminder_date']=="$dt")
            {
              


require_once('PHPMailer-master/PHPMailerAutoload.php');


$mail = new PHPMailer();
  
  //Enable SMTP debugging.
  $mail->SMTPDebug = 1;
  //Set PHPMailer to use SMTP.
  $mail->isSMTP();
  //Set SMTP host name
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
  //Set this to true if SMTP host requires authentication to send email
  $mail->SMTPAuth = TRUE;
  //Provide username and password
   $mail->Username = "Your Email(in which you want to send mail)";
  $mail->Password = "Your Password";
  //If SMTP requires TLS encryption then set it
  $mail->SMTPSecure = "false";
  $mail->Port = 587;
  //Set TCP port to connect to
  
  $mail->From = "Your Email(in which you want to send mail)";
  $mail->FromName = "Medical Store";
  
  $mail->addAddress($row["email"]);

  
  $mail->isHTML(true);
 
  $mail->Subject = "Medicine Reminder";
 
  $mail->Body = "<h3>Hii , This is just friendly reminder for your medicines. You purchased your medicine from our ".siteName(). " at  ".$row["purchase_date"]." <i>for ".$row["days"]." days. You can visit our shop if you need to continue your medication.</h3><br><br><i> Thank you, <br>". siteName(). " 
    <h3>Address:</h3><br> <<Address>><br> <i style='color:green;'><h3><center> Your Health And Wellness <br> Is Our Priorit  </center></h3></i>";
  $mail->AltBody = "This is the plain text version of the email content";
  if(!$mail->send())
  {?>

    
    <script>
      alert('Entered Email_id Is Not Valid');
      
    </script>
    <?php
    header("Location:index.php");
  }
  else
  {
    header("Location:index.php");   
    
  }
}
header("Location:index.php");
}
  ?>