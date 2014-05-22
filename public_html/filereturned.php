<?php
$fileid=  $_POST['returned'];
$requestid=  $_POST['requestid'];
$filefound=$_POST['filefound'];
echo $filefound;
$status=$_POST['status'];
echo $status;
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  if($filefound==1){
        $sql= "UPDATE The_Xistence SET status = '3' WHERE id=$fileid";
        if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
  }else if ($filefound==0 &&$status==1)
 {
      $sql= "UPDATE The_Xistence SET status = '0' WHERE id=$fileid";
      if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
  }
if($filefound==0){
    $con2=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
    ///// file found 2 is canceled request
    $sql2= "UPDATE requestedfiles SET file_found = '2' WHERE id=$requestid";
    if (!mysqli_query($con2,$sql2))
    {
        die('Error: ' . mysqli_error($con2));
    }
    mysqli_close($con2);
  }
header('Location: panel.php');
?>