<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$requestid=  $_POST['delivered'];
$fileid= $_POST['idoffile'];
$filefound=$_POST['filefound'];
//echo $fileid;
$requestedfor = $_POST['requestedfor'];  
//echo $requestedfor;

$sql="SELECT * FROM The_Xistence WHERE id= '$fileid'";
//echo $sql;
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result))
  {
    $status=$row['status'];
  }
mysqli_close($con);
if($status=='1'){
$con2=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql2= "UPDATE requestedfiles SET file_found ='1', found_date = CURDATE(), delivered_time = NOW()  WHERE id='$requestid'";
//echo $sql2;
//echo"      ";
if (!mysqli_query($con2,$sql2))
{
  die('Error: ' . mysqli_error($con));
}
mysqli_close($con2);
$con3=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql3= "UPDATE The_Xistence SET status = '2' WHERE id='$fileid'";
//echo $sql3;
//echo"      ";

if (!mysqli_query($con3,$sql3))
  {
  die('Error: ' . mysqli_error($con3));
  }
mysqli_close($con3);     
}
else{
$con2=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");    
$sql2= "UPDATE requestedfiles SET returned_date = CURDATE() WHERE id='$requestid'";  
//echo $sql2;
//echo"      ";

 if (!mysqli_query($con2,$sql2))
{
  die('Error: ' . mysqli_error($con2));
}   
mysqli_close($con2);    
$con3=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql3= "UPDATE The_Xistence SET status = '0' WHERE id='$fileid'";  
//echo $sql3;
//echo"      ";

if (!mysqli_query($con3,$sql3))
{
  die('Error: ' . mysqli_error($con3));
} 
mysqli_close($con3);  
}

header('Location: adminpanel.php');
?>