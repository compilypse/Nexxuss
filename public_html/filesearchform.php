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
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
        <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
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

<Center>
        <div>
            <center>
            <form action="filesearch.php" method="post">
            Name: <input type="text" name="filename"><br>
            Number: <input type="text" name="filenumber"><br>
            <input type="radio" name="filetype" value="1">Collateral<br>
            <input type="radio" name="filetype" value="2">Consumer<br>
            <input type="radio" name="filetype" value="3">Credit<br>
            <input type="radio" name="filetype" value="4">Mortgage<br>
            <input type="hidden" name="lender" value='<?php echo $name; ?>' >
            Lender:<?php  echo $name;?><br>
            <input type="submit">
            </form>
            </center>
        </div>
</Center>
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
?>