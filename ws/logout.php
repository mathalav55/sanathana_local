<?php
include('config.php');
include('dblayer.php');
    session_start();
    session_destroy();
    $jsonresponse = array('code' => '200', 'status' => 'Logged Out Sucessfully');
    echo json_encode($jsonresponse);
?>