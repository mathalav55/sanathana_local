<?php header("Access-Control-Allow-Origin: *");?>
<?php header('Access-Control-Allow-Headers: *');?>
<?php header('Access-Control-Allow-Methods: POST,GET');  ?>
<?php
/* Database connection start */

$servername = "localhost";
$username = "vamsi";
$password = "pass";
$dbname = "sea_app";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) 
{
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else
{
//    echo "success";
}

?>