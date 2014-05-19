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
                    <script>
                    function getData(str) {
                    if (str=="") {
                    document.getElementById("controlcenter").innerHTML="";
                    return;
                    } 
                    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                    } else { // code for IE6, IE5
                     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                     document.getElementById("controlcenter").innerHTML=xmlhttp.responseText;
                     }
                    }
                    xmlhttp.open("GET","filedata.php?q="+str,true);
                    xmlhttp.send();
                    }
                    
                    function submitForm(action)
                    {
                        document.getElementById('f1').action = action;
                         document.getElementById('f1').submit();
                    }

                </script>
                    
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
<div id = "tables" style = "width:100%">
<div id ="left" style = "float: left;">
<?php
$con=mysqli_connect("mysql.compilypse.com", "bakerbrandon", "bakerpassword","nexxuss");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql="SELECT a.id, a.file_type,a.loan_number,a.file_name,b.requested_by,b.requested_date, b.file_found FROM The_Xistence a,requestedfiles b WHERE a.id=b.id_of_file AND b.requested_by = '$name' AND b.returned_date = '0000-00-00' AND (a.status='2' OR a.status='1') ORDER BY b.requested_date DESC;";
//"SELECT * FROM requestedfiles WHERE requested_by = 'April' AND found='0' ORDER BY requesteddate DESC"
$result = mysqli_query($con,$sql);
echo "Requested Files";
echo "<table border='1'>
<tr>
<th>ID #</th>
<th>File Type</th>
<th>File Number</th>
<th>Control Center</th>
<th>Date Requested</th>
<th>Return File</th>

</tr>";
//echo "<form action=\"filetoreturn.php\" method=\"post\" class=\"input\"   >";
//echo "<form method = \"get\">";
while($row = mysqli_fetch_array($result))
  {
  if($row['file_found']==0){echo "<tr style=background-color:#ff0000>";}
  else{echo "<tr style=background-color:#38FC4F>";}
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['file_type'] . "</td>";
  echo "<td>" . $row['loan_number'] . "</td>";
  ?>
    <td> <button type="submit" class="button" onClick="getData(this.value)" name = "fielid" value ='<?php echo $row['id']; ?>'><?php echo $row['file_name'] ?></button></td>
    <!--        echo "<td>" . $row['file_name'] . "</td>";                  -->
  
  <?php
  echo "<td>" . $row['requested_date'] . "</td>";
  ?>
    <form action="filereturned.php" method="post" class="input">
    <td> <button type="submit" class="button" name = "returned" value ='<?php echo $row['id']; ?>'>Back To DC</button></td>
    </form>
  <?php
  //echo "<td>" .'<input type="button" name = "fileid" onclick="getData(this.value)" value = ' . $row['id'] . '>'. '</td>';
  echo "</tr>";
  }
echo "</table>";
//echo "</form>";
//mysqli_close($con);
?>
    
</div>
    
    
    
    
  
       
<div id ="controlcenter" style = "float: right;">
stuff should be here
</div>
<div class="clear"></div> 
</body>

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
