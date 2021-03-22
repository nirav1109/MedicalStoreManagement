<?php
session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
 require "assets/function.php" ;
require 'assets/db.php';              


require_once('PHPMailer-master/PHPMailerAutoload.php');


$medicines = unserialize(base64_decode($_POST["input_name1"]));
$userinfo = unserialize(base64_decode($_POST["input_name2"]));
$totalbill = unserialize(base64_decode($_POST["input_name3"]));
$quantity = unserialize(base64_decode($_POST["input_name4"]));


$m = "";
foreach ($medicines as $k) {
	$m.=$k;
	$m="\n";
}
$m = implode("\n", $medicines);
$q = "";
foreach ($quantity as $j) {
	$q.=$j;
	$q="\n";
}
$q = implode("\n", $quantity);

$gt = $totalbill[0]-$totalbill[1];

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
  
  $mail->addAddress($userinfo[0]);

  
  $mail->isHTML(true);
 
  $mail->Subject = "Medicine bill";
   $mail->Body .= "<h3>Hii ".$userinfo[1].", This Is Medicines Bill From  ".siteName().  " for your medicines. We will send you reminder regarding your medicines due date. if you need to continue your medication, You can visit our shop.</h3><br><br><i> Thank you, <br>". siteName(). " 
    <h3>Address:</h3><br> <<Address>><br> ";

	
  	$mail->Body .= "<table border='1' width='200px'><tr><td><h2>";	
  	$mail->Body .= 'Medicines</td>';	
  	$mail->Body .= '<td><h2>Quantity</td></h2></tr>';	
     $mail->Body .= '<tr><td><pre><h2>'.print_r($m, true).'</pre></td></h2>';
       $mail->Body .= '<td><h2><pre>'.print_r($q, true).'</pre></td></h2></tr>';
    $mail->Body .= "<tr><td colspan='2'><h2 style='color:red;'><pre> Total :".$totalbill[0]."</pre></h2></td></tr>";	
      $mail->Body .= "<tr><td colspan='2'><h2 style='color:red;'><pre> Discount :".$totalbill[1]."</pre></h2></td></tr>";
  	  $mail->Body .= "<tr><td colspan='2'><h2 style='color:red;'><pre>Gross Total :".$gt."</pre></h2></td></tr></table><br>";
      $mail->Body .="<i style='color:green;'><h3><center> Your Health And Wellness <br> Is Our Priorit  </center></h3></i>";

  $mail->AltBody = "This is the plain text version of the email content";
  if(!$mail->send())
  {?>

    
    <script>
      alert('Email Address Is Not Valid ...!');
      
    </script>
    <?php
    
  }
  else
  {?>

    
    
    <?php
    header("location:index.php");
    
  }



  ?>