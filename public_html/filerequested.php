<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$fileid=  $_POST['requested'];
$requestedfor = $_POST['requestedfor'];  
//echo $requestedfor;
$sql= "INSERT INTO requestedfiles (id_of_file,file_found, requested_date, found_date, returned_date, requested_by, delivered_time)
VALUES
('$fileid','0', CURDATE(),'NULL','NULL','$requestedfor','NULL')";

//echo $sql;
if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
//echo "1 record added";
$sql2= "UPDATE The_Xistence SET status = '1' WHERE id = '$fileid'";  
if (!mysqli_query($con,$sql2))
  {
  die('Error: ' . mysqli_error($con));
  }
mysqli_close($con);
//echo $sql2;

header('Location: panel.php');
?>