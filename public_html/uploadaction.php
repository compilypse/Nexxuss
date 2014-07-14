<?php
$allowedExts = array("gif", "jpeg", "jpg", "png","pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if (
        //(($_FILES["file"]["type"] == "image/gif")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/jpg")
//|| ($_FILES["file"]["type"] == "application/pdf")
//|| ($_FILES["file"]["type"] == "image/pjpeg")
//|| ($_FILES["file"]["type"] == "image/x-png")
//|| ($_FILES["file"]["type"] == "image/png"))
//&& 
        ($_FILES["file"]["size"] < 2000000000)
&& in_array($extension, $allowedExts)
)
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      //echo "Stored in: " . "upload/" . $_FILES["file"]["name"]. "<br>";
      //echo "<a href=\"upload/" . $_FILES["file"]["name"]  . "\">Link</a>";
      }
    }
  }
else
  {
  echo "Invalid file";
  }
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else {
$fileid = $_POST['parentfile'];
$tempfilename =$_FILES["file"]["name"];
$tempfilepath ="upload/" . $_FILES["file"]["name"];
$sql= "INSERT INTO filepaths (file_path, file_name, creation_date, parent_file) VALUES ('$tempfilepath','$tempfilename', CURDATE(), '$fileid')  ";
//echo "<br>";
//echo $sql;
if (!mysqli_query($con,$sql)){
  die('Error: ' . mysqli_error($con));
}
//echo "1 record added";
mysqli_close($con);
header('Location: panel.php');
}
?>
