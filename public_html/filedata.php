<?php
$q = intval($_GET['q']);
$con = mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"nexxuss");
$sql="SELECT * FROM The_Xistence WHERE id = '".$q."'";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {

$id = $row['id'];
$loannumber = $row['loan_number'];
$filename = $row['file_name'];
}
mysqli_close($con);
$con2 = mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql2="SELECT * FROM requestedfiles WHERE id_of_file= '$id' AND (file_found='1' OR file_found='3') ORDER BY delivered_time DESC";
$result2 = mysqli_query($con2,$sql2);
$counter=0;
while($row2 = mysqli_fetch_array($result2)) {
    if($counter==0){$idofrequestforgiving=$row2['id'];}
//$returneddate = $row2['returned_date'];
if($founddate != "00-00-0000"){
    $requestid=$row2['id'];
    $lastperson = $row2['requested_by'];
    $founddate = $row2['found_date'];
    if($counter>=1){break;}
    
}
$counter= $counter+1;
}
/////WHAT ABOUT FIRST PERSON TO REQUEST FILE??????????
mysqli_close($con2);



echo '<center>';
//echo '<h3>' . $id . '</h3>';
echo '<h3>' . $filename . '</h3>';
echo '<h4>' . $loannumber . '</h4>';
echo '</center>';
echo '<table align = "center"><tr>';
echo '<td> Last Person to Have File: </td>';
if($counter>=1){echo '<td>'.$lastperson.'</td></tr>';}
else{ echo '<td>'.$lastperson.' is the first to have the file</td></tr>';}
echo '<tr><td> Date File Last Delivered: </td>';
echo '<td>'.$founddate.'</td>';
echo '</tr>';
echo '</table>';
?>
<form id=f1  method="post">
<button type="submit" class="button" onClick="submitForm('uploadform.php')" name = "upload" value ='<?php echo $id; ?>'>Upload Documents</button>

<?php
echo '<hr>';
$con3 = mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql3="SELECT * FROM filepaths WHERE parent_file = '$id' ORDER BY creation_date DESC LIMIT 5";
$result3 = mysqli_query($con3,$sql3);
echo '<center>';
echo "Document List";
echo "<table border='1'>
<tr>
<th>File Name</th>
<th>Link to Document</th>
</tr>";
while($row3 = mysqli_fetch_array($result3))
  {
  echo "<tr>";
  echo "<td>" . $row3['file_name'] . "</td>";
  echo "<td align=\"center\"> <a href=" . $row3['file_path'] .">Link</a>";
  echo "</tr>";
  }
echo "</table>";
mysqli_close($con3);
?>
<button type="submit" class="button" onClick="submitForm('downloadfileaction.php')" name = "download" value ='<?php echo $id; ?>'>View All Documents</button>
<hr>
<?php
echo '</center>';
$con4 = mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
$sql4="SELECT * FROM Notes WHERE id_of_file = '$id' ORDER BY note_time DESC LIMIT 3";
$result4 = mysqli_query($con4,$sql4);
echo '<center>';
echo "Note List";
echo "<table border='1'>
<tr>
<th>Note Date</th>
<th>Note By</th>
<th>Note</th>
</tr>";
while($row4 = mysqli_fetch_array($result4))
  {
  echo "<tr>";
  echo "<td>" . $row4['note_time'] . "</td>";
  echo "<td>" . $row4['note_by'] . "</td>";
  echo "<td>" . $row4['note'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
?>
<button type="submit" class="button" onClick="submitForm('notes.php')" name = "notes" value ='<?php echo $id; ?>'>View All Notes</button>
<br>
<button type="submit" class="button" onClick="submitForm('noteform.php')" name = "notes" value ='<?php echo $id; ?>'>Create A Note</button>
<hr>
<center>
</form>    
    
Give File To:
<br>
<?php //echo $idofrequestforgiving; ?>
</center>
<form action="givefile.php" method="post">
    <input type="hidden" name="fileid" value='<?php echo $id; ?>'>
    <input type="hidden" name="giversfilerequestid" value='<?php echo $idofrequestforgiving; ?>'>
<select name = "recip">
<option value = "April">April</option>
<option value = "Jeremy">Jeremy</option>
<option value = "Mike">Mike</option>
<option value = "Sydney">Sydney</option>
<option value = "Paloma">Paloma</option>
</select>
<br>
<input class="button" type="submit">
</form>





<?php
mysqli_close($con4);
?>