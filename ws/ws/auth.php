<?php
include('config.php');
include('dblayer.php');
    session_start();
    if( isset($_SESSION['Name'])){
        $jsonresponse = array('code' => '200', 'status' => 'Logged In' , 'name' => $_SESSION['Name'] , 'id' => $_SESSION['id'], 'surname' => $_SESSION['Surname'] , 'privilige' => $_SESSION['privilige'] , 'photo' => $_SESSION['photo'] , 'gender' => $_SESSION['gender'], 'memberId' => $_SESSION['memberId']);
        echo json_encode($jsonresponse);    
    }else{
        $jsonresponse = array('code' => '200', 'status' => 'Not Logged In');
        echo json_encode($jsonresponse);
    }
    
?>