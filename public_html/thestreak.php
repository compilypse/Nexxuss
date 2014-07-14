<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <header>
        <div  class="container clearfix">
            <nav>
                <ul>
                    <li><a href="panel.php">Panel Home</a></li>
                    <li><a href="filesearchform.php">File Search</a></li>
                    <li><a href="thestreak.php">File History</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
<body>
    <center>
<div id ="left">
    <center>
    <?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql="SELECT a.id, a.file_type,a.loan_number,a.file_name,b.requested_by,b.requested_date, b.file_found FROM The_Xistence a,requestedfiles b WHERE a.id=b.id_of_file ORDER BY requested_date DESC;";
//"SELECT * FROM requestedfiles WHERE requested_by = 'April' AND found='0' ORDER BY requesteddate DESC"
$result = mysqli_query($con,$sql);
echo "Requested Files";
echo "<table border='1'>
<tr>
<th>File Type</th>
<th>File Number</th>
<th>File Name</th>
<th>Requested By</th>
<th>Date Requested</th>
</tr>";
while($row = mysqli_fetch_array($result))
  {
  if($row['file_found']==0){echo "<tr style=background-color:#ff0000>";}
  else{echo "<tr style=background-color:#38FC4F>";}
  $filedigit=$row['file_type'];
  if($filedigit==1){$fileword="Collateral";}
    elseif ($filedigit==2) {$fileword="Consumer";}
    elseif ($filedigit==3) {$fileword="Credit";}
    else {$fileword="Mortgage";}
  echo "<td>" . $fileword. "</td>";
  echo "<td>" . $row['loan_number'] . "</td>";
  echo "<td>" . $row['file_name'] . "</td>";
  echo "<td>" . $row['requested_by'] . "</td>";
  echo "<td>" . $row['requested_date'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
mysqli_close($con);

?>
    </center>
  </div>  
       </center> 
</html>