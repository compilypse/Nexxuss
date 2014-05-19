<html>
<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$fileid=$_POST['notes'];
$result = mysqli_query($con,"SELECT * FROM Notes WHERE id_of_file = '$fileid' ORDER BY note_time DESC");
echo "Note List";
echo "<table border='1'>
<tr>
<th> Note ID #</th>
<th> File ID #</th>
<th>Note Date</th>
<th>Note By</th>
<th>Note</th>
</tr>";
while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['id_of_file'] . "</td>";
  echo "<td>" . $row['note_time'] . "</td>";
  echo "<td>" . $row['note_by'] . "</td>";
  echo "<td>" . $row['note'] . "</td>";  
  echo "</tr>";
  }
echo "</table>";
mysqli_close($con);

?>
</html>