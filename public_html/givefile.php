<?php
$recip=$_POST['recip'];
$fileid=$_POST['fileid'];
$giversfilerequestid=$_POST['giversfilerequestid'];
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$recip=$_POST['recip'];
$sql= "INSERT INTO requestedfiles (id_of_file,file_found, requested_date, found_date, returned_date, requested_by, delivered_time,given_date,given_rid)
VALUES
('$fileid','3', CURDATE(),'NULL','NULL','$recip','NULL','00-00-0000', '$giversfilerequestid')";
mysqli_query($con,$sql);
mysqli_close($con);
header('Location:panel.php');
?>
