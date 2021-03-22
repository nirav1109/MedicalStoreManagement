<?php

session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
require "assets/function.php" ;
require "assets/db.php";

echo "jfhydyg";

$med_name="dolo";
$qt=1;
if(isset($_POST['print']))
{
 echo "string";
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

                echo $q;

                $sql="update inventeries set unit=".$q." where name="."'$med_name'";
                echo $sql;
  
                   if ($con->query($sql)) {
                  echo "done";

                }
                else{
                  $notice ="<div class='alert alert-danger'>Error is:".$con->error."</div>";
                }

              }
            }
          }
                   
}
?>

