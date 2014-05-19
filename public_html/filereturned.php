<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$fileid=  $_POST['returned'];
//$requestedf = $_POST['requestedfor'];  
//echo $fileid;
$sql= "UPDATE The_Xistence SET status = '3' WHERE id=$fileid";
//echo $sql;
if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
//echo "1 record added";

mysqli_close($con);
header('Location: panel.php');
?>