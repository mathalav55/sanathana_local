<?php
include('config.php');
include('dblayer.php');


$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata);

$usrName = $data -> username;
$pwd = $data -> password;

$sqlQuery ="Select * FROM `memberprofile` WHERE `id` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$usrName' and `password` =  '$pwd') AND `status` = '1'";
$datatable = getdata($conn, $sqlQuery);
if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
    $row = $datatable[0];
    session_start();
    $_SESSION['Name'] = $row['Name'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['Surname'] = $row['Surname'];
    $_SESSION['privilige'] = $row['privilige'];
    $_SESSION['photo'] = $row['photo'];
    $_SESSION['gender'] = $row['gender'];
    $_SESSION['memberId'] = $usrName;
  } 
  else 
  {
    $jsonresponse = array('code' => '200', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
?>