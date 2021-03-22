<?php

session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
require "assets/function.php" ;
require "assets/db.php";

$mn=$_GET['n'];
echo $mn;
$q=$_GET['q'];
echo $q;

  $stockArray = $con->query("select * from inventeries");

            $i=0;
            while ($row = $stockArray->fetch_assoc()) 
            { 
            $i=$i+1;
            $id = $row['id'];
            if($row['name']=="$mn")
            {
              if(($row['unit']-$q)>=0)
              {

                $qt=$row['unit']+$q;

                echo $q;

                $sql="update inventeries set unit=".$qt." where name="."'$mn'";
                echo $sql;
  
                   if ($con->query($sql)) {
                  header('location:index.php');

                }
                else{
                  $notice ="<div class='alert alert-danger'>Error is:".$con->error."</div>";
                }

              }
            }
          }

?>

