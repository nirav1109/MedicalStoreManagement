<?php
session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
 ?>
<?php require "assets/function.php" ?>
<?php require 'assets/db.php';?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo siteTitle(); ?></title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
  <?php include 'css/customStyle.css'; ?>

  </style>
  <?php 
  $notice="";

   ?>
</head>
<body style="background: #ECF0F5;padding:0;margin:0">

  <div class="content2">
  	<div class="well well-sm" style="width: 77%;margin:auto;margin-top: 33px;">
      <div class="well well-sm center"><h1><?php echo siteName(); ?></h1></div> 
    </div>




    <?php

if (isset($_POST['billInfo'])) 
  {

    $d=$_POST['day']." days";
    $dt = date('Y-m-d');
    $rd=date("Y-m-d", strtotime("$dt + $d"));
    $d=$_POST['discount'];
  
  
    $sql="insert into Purchaser (name,contact,email,address,days,discount,purchase_date,reminder_date) value ('$_POST[name]','$_POST[contact]','$_POST[email]','$_POST[add]','$_POST[day]','$_POST[discount]','$dt','$rd')";

    $i=$con->query($sql); 
    if($i)
    {
    
      
    }
    else
      $notice ="<div class='alert alert-danger'>Not saved Error:".$con->error."</div>";
  }

?>


    <br>
    <div class="well well-sm" style="width: 77%;margin: auto;">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Name of Purchaser</th>
          <td><?php echo $_POST['name'] ?></th>
          <th>Bill Sent To </th>
          <td><?php echo $_POST['email'] ?></th>
          <?php $b = $_POST['email'] ;$billTo="";
          ?>
        </tr>
        <tr>
          <th>Bill Generated At:</th>
          <td><?php echo date("Y-m-d"); ?></td>
          <th>Transaction made by</th>
          <td><?php echo adminName(); ?></td>

        </tr>
        <tr>
          <th colspan="4" class="center"><h3>Purchase Item Details</h3></th>
        </tr>
          <tr>
        <th>#</th>
        <th>Medicine Name</th>
        <th>Per Unit Price</th>
        <th>Quantity</th>
      </tr>
        <?php
        $i=$total=$qt=0;
        $med_name="";

      $medicines=array(""); 
      $quantity=array(""); 
      $userinfo=array($_POST['email'],$_POST['name']); 
       
        
    foreach ($_SESSION['bill'] as $row) 
    {
      $i++;
      
      echo "<tr>";
      echo "<td>$i</td>";
      echo "<td>$row[name]</td>";
      echo "<td>Rs. $row[price]</td>";
      echo "<td>$row[qty]</td>";
      array_push($medicines, $row['name']);
      array_push($quantity, $row['qty']);      

      echo "</tr>";
      $total = $total + $row['price']*$row['qty'];
      $med_name=$row['name'];
      $qt=$row['qty'];
      

    }
    

   
    
    $totalbill=array($total,$d);

  


  
echo "</div>";

 echo "<tr>
    <td colspan='3' style='text-align: right;'>Gross Total</td><th>";
     echo $total;
     echo "</th>
  </tr>
  <tr>
    <td colspan='3' style='text-align: right;'>Discount</td><th>";
    echo $_POST['discount'];
     echo "</th>
  </tr>
  <tr>
    <td colspan='3' style='text-align: right;'>Gross Total</td><th >";
    echo $total-$_POST['discount'];
    echo "</th>
  </tr>";

echo "<tr><td><center>";

    echo "<a href='index.php'><input type='button' name='Home' value=' Back To Home' class='btn btn-warning'/> </td></a></h2>";

   echo "<td colspan='2'><center><input type='button' name='p' value='Confirm And Print' class='btn btn-primary' onclick='window.print()'/> </td>"; 
   
   echo "<td><center><a href='extra.php?n=$med_name&q=$qt'><input type='button' value='Cancle Bill' class='btn btn-danger'/> </a></td></tr>";
   
 
 
   



     
  
 
 echo "</table>";
  


 $stockArray = $con->query("select * from inventeries");

            $i=0;
            while ($row = $stockArray->fetch_assoc()) 
            { 
            $i=$i+1;
            $id = $row['id'];
            if($row['name']=="$med_name")
            {
              if(($row['unit']-$qt)>=0)
              {

                $q=$row['unit']-$qt;

                

                $sql="update inventeries set unit=".$q." where name="."'$med_name'";

                $done= $con->query($sql);

                
              }
              $s=$row['sold']+$qt;
              $sql1="update inventeries set sold=".$s." where name="."'$med_name'";
                $done1= $con->query($sql1);
            }
          }
 



  ?>






<div id="billOut" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Purchaser Information</h4>
      </div>
      <div class="modal-body"> <form method="POST" action="billout.php">
        <div style="width: 77%;margin: auto;">
         
          <div class="form-group">
            <label for="some" class="col-form-label">Name</label>
            <input type="text" name="name" class="form-control" id="some" required>
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label">Contact</label>
            <input type="text" name="contact" class="form-control" id="some" required>
          </div>
       
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="safeIn">View Bill</button>
      </div>
    </form>
    </div>

  </div>
</div>
<?php 





$total = $total-$_POST['discount'];
    if (!$con->query("insert into sold (name,contact,discount,amount,item,userId) values ('$_POST[name]','$_POST[contact]','$_POST[discount]','$total','$i','$_SESSION[userId]')")) 
    {
      echo "Error is:".$con->error;
    }
 if (isset($_POST['billInfo'])) 
  {
   
    unset($_SESSION['bill']);
    $_SESSION['bill'] = array();
  }
 
 ?>
 <form method="post" action="SendBillToMail.php">
 <INPUT TYPE='hidden' NAME='input_name1' VALUE='<?= base64_encode(serialize($medicines)); ?>'>
<INPUT TYPE='hidden' NAME='input_name2' VALUE='<?= base64_encode(serialize($userinfo)); ?>'>
<INPUT TYPE='hidden' NAME='input_name3' VALUE='<?= base64_encode(serialize($totalbill)); ?>'>
<INPUT TYPE='hidden' NAME='input_name4' VALUE='<?= base64_encode(serialize($quantity)); ?>'>
<input type='submit' class='btn btn-success'  value='Confirm And Mail'>
</form>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){$(".rightAccount").click(function(){$(".account").fadeToggle();});});
</script>

 