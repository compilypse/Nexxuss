<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$requestid=$_POST['accept'];
//$fileid=$_POST['id'];
$sql="UPDATE requestedfiles SET file_found = '1' WHERE id='$requestid'";
$result = mysqli_query($con,$sql);
mysqli_close($con);
$con2 = mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql2="SELECT * FROM requestedfiles WHERE id= '$requestid'";
$result2 = mysqli_query($con2,$sql2);
while($row2 = mysqli_fetch_array($result2)) {
    $giversrequestid=$row2['given_rid'];
}
mysqli_close($con2);
$con3=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql3="UPDATE requestedfiles SET given_date = CURDATE() WHERE id='$giversrequestid'"; 
$result3 = mysqli_query($con3,$sql3);
mysqli_close($con3);
header('Location:panel.php');
?>