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
  mysqli_close($con);
/////////////IF to see if status is already 2 if it is dont change it back to 1
  $con2=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
  $sql2="SELECT status FROM The_Xistence WHERE id = '$fileid'";
  $result2 = mysqli_query($con2,$sql2);
  while($row = mysqli_fetch_array($result2))
  {
      $status=$row['status'];
  }
  mysqli_close($con2);
  if($status==0){
      $sql3= "UPDATE The_Xistence SET status = '1' WHERE id = '$fileid'"; 
      $con3=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
        if (!mysqli_query($con3,$sql3))
        {
        die('Error: ' . mysqli_error($con3));
        }
        mysqli_close($con3);
  }
  
//echo $sql2;

header('Location: panel.php');
?>