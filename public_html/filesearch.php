<?php
/*** begin the session ***/

session_start();
if(!isset($_SESSION['user_id']))
{
    $message = 'You must be logged in to access this page';
    
}
else
{
    try
    {
        /*** connect to database ***/
        /*** mysql hostname ***/
        $mysql_hostname = 'mysql.compilypse.com';
        /*** mysql username ***/
        $mysql_username = 'bakerbrandon';
        /*** mysql password ***/
        $mysql_password = 'bakerpassword';
        /*** database name ***/
        $mysql_dbname = 'nexxuss';
        /*** select the users name from the database ***/
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/
        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /*** prepare the insert ***/
        $stmt = $dbh->prepare("SELECT user_name FROM user_pass
        WHERE id = :id");
        
        /*** bind the parameters ***/
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        /*** execute the prepared statement ***/
        $stmt->execute();
        /*** check for a result ***/
        $user_name = $stmt->fetchColumn();
        $stmt2= $dbh->prepare("SELECT name FROM user_pass
        WHERE id = :id");
        $stmt2->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt2->execute();
        $name= $stmt2->fetchColumn();
        /*** if we have no something is wrong ***/
        if($user_name == false)
        {
            $message = 'Access Error';
            echo $message;
        }
        else
        {
            ?>
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
                <body id="singletable">
<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$filename=$_POST['filename'];
$filenumber=$_POST['filenumber'];
$filetype=$_POST['filetype'];
$requestedfor=$_POST['lender'];
if($filename !=NULL && $filenumber== NULL && $filetype==NULL){
    $sql="SELECT * FROM The_Xistence WHERE file_name = '$filename'";
}else if($filename ==NULL && $filenumber!= NULL && $filetype==NULL){
    $sql="SELECT * FROM The_Xistence WHERE loan_number = '$filenumber'";
}else if($filename ==NULL && $filenumber== NULL && $filetype==NULL){
    $sql="SELECT * FROM The_Xistence";
}else if($filename ==NULL && $filenumber== NULL && $filetype!=NULL){
    $sql="SELECT * FROM The_Xistence WHERE file_type = '$filetype'";
}else if($filename !=NULL && $filenumber!= NULL && $filetype==NULL){
    $sql="SELECT * FROM The_Xistence WHERE file_name = '$filename' AND loan_number = '$filenumber'";
}else if($filename !=NULL && $filenumber== NULL && $filetype!=NULL){
    $sql="SELECT * FROM The_Xistence WHERE file_name = '$filename' AND file_type = '$filetype'";
}else if($filename ==NULL && $filenumber!= NULL && $filetype!=NULL){
    $sql="SELECT * FROM The_Xistence WHERE loan_number = '$filenumber' AND file_type = '$filetype'";
}else{
    $sql="SELECT * FROM The_Xistence WHERE file_name = '$filename' AND loan_number = '$filenumber' AND file_type = '$filetype'";
}


$result = mysqli_query($con,$sql);
echo '<center>';
echo "<div id =\"left\">";
echo "<center>";
echo "Search Results";
echo "<table border='1'>
<tr>
<th> File ID #</th>
<th>File Name</th>
<th>File Number</th>
<th>File Type</th>
<th>Upload Docs</th>
<th>View Docs</th>
<th>Request File</th>
</tr>";
echo "<form id=f1  method=\"post\">";
echo "<input type=\"hidden\" name=\"requestedfor\" value=$requestedfor>";
while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['file_name'] . "</td>";
  echo "<td>" . $row['loan_number'] . "</td>";
  $filedigit=$row['file_type'];
  if($filedigit==1){$fileword="Collateral";}
    elseif ($filedigit==2) {$fileword="Consumer";}
    elseif ($filedigit==3) {$fileword="Credit";}
    else {$fileword="Mortgage";}
  echo "<td>" . $fileword . "</td>";
  echo "<td>".'<button type="submit" class="button" style="text-align:left" onClick="submitForm(\'uploadform.php\')" name = "upload"  value = ' . $row['id'] . '>Upload File</button>'."</td>";
  echo "<td>" .'<button type="submit" class="button" style="text-align:right" onClick="submitForm(\'downloadfileaction.php\')" name = "download"  value = ' . $row['id'] . '>View Docs</button>'. "</td>";
  echo "<td>" .'<button type="submit" class="button" style="text-align:center" onClick="submitForm(\'filerequested.php\')" name = "requested"  value = ' . $row['id'] . '>Request File</button>'. "</td>";
  echo "</tr>";
  }
echo "</table>";
echo"</form>";
echo '</center>';

echo"</div>";
echo '</center>';

echo"</body>";
mysqli_close($con); 
?>  
<script>
    function submitForm(action)
    {
        document.getElementById('f1').action = action;
        document.getElementById('f1').submit();
    }
</script>     
</html>
<?php 
        }
    }
    catch (Exception $e)
    {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
        echo $message;
    }
}
//header('Location: login.html');
?>