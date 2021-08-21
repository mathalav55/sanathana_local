<?php
include('config.php');
include('dblayer.php');

$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);
$rcvData=$data['load'];
//$date = date('Y-m-d H:i:s');
// echo $rcvData;
if( $rcvData == "loadall"){
    load_all($conn);
}
else if($rcvData == "add"){
    $name = $data['name'];
    $desc = $data['desc'];
    $doc = $data['doc'];
    $status = $data['status'];
    $leftid = $data['leftid'];
    $visibility = $data['visibility'];
    $admin = $data['admin'];
    $createdby = $data['createdby'];
    $createddate = $data['createddate'];
    add_report($conn);
}
else if($rcvData == "loadbynumber"){
    $id = $data['id'];
    load_bynumber($conn);
}else if($rcvData == "changestatus"){
    $id = $data['id'];
    $status = $data['status'];
    change_status($conn);
}
else if( $rcvData == "modify"){
    $id = $data['id'];
    $name = $data['name'];
    $desc = $data['desc'];
    $doc = $data['doc'];
    $status = $data['status'];
    $leftid = $data['leftid'];
    $visibility = $data['visibility'];
    $admin = $data['admin'];
    update_report($conn);
}else{
    $jsonresponse = array('code' => '200', 'status' => 'Please Choose a valid option');
    echo json_encode($jsonresponse);
}
function change_status($conn){
    global $id, $status;
    $sqlQuery = "update `reportmaster` SET `status`='$status' WHERE `id` = '$id'";
    $result = setData($conn,$sqlQuery);
    if($result == "Record created"){
        $jsonresponse = array('code' => '200', 'status' => 'Status Updated');
        echo json_encode($jsonresponse);
    }else{
        $jsonresponse = array('code' => '200', 'status' => 'Status Not Updated');
        echo json_encode($jsonresponse);
    }
}
function load_bynumber($conn){
    global $id;
    $sqlQuery = "select `reportmaster`.`id`, `reportmaster`.`Name`, `reportmaster`.`Description`, `reportmaster`.`document`, `reportmaster`.`status`, `acessconfig`.`ContentName` as `leftmenuid`, `reportmaster`.`visibility`, `reportmaster`.`admin` FROM `reportmaster` join `acessconfig` on `reportmaster`.`leftmenuid` = `acessconfig`.`id` where `reportmaster`.`id` = '$id'";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        echo json_encode($datatable[0]);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Reports');
        echo json_encode($jsonresponse);
    }
}
function load_all($conn){
    $sqlQuery = "select `reportmaster`.`id`,`memberprofile`.`Name` as `createdby`,`reportmaster`.`createddate`, `reportmaster`.`Name`, `reportmaster`.`Description`, `reportmaster`.`document`, `reportmaster`.`status`, `acessconfig`.`ContentName` as `leftmenuid`, `reportmaster`.`visibility`, `reportmaster`.`admin` FROM `reportmaster` join `acessconfig` on `reportmaster`.`leftmenuid` = `acessconfig`.`id` join `memberlogin` on `memberlogin`.`id` = `reportmaster`.`createdby` join `memberprofile` on `memberprofile`.`id` = `memberlogin`.`memberid`";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        echo json_encode($datatable);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Reports');
        echo json_encode($jsonresponse);
    }
}
function update_report($conn){
    global $id,$name , $desc, $doc, $status, $leftid, $visibility, $admin;
    $sqlQuery = "update `reportmaster` SET `Name`='$name',`Description`='$desc',`document`='$doc',`status`='$status',`leftmenuid`=(select `id` from  `acessconfig` where `ContentName` = '$leftid'),`visibility`='$visibility',`admin`='$admin' WHERE `id` = '$id'";
    $result = setData($conn, $sqlQuery);
    if ($result == "Record created") 
    {
        $jsonresponse = array('code' => '200', 'status' => 'Report Updated');
        echo json_encode($jsonresponse);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'Report not updated');
        echo json_encode($jsonresponse);
    }
}
function add_report($conn){
    global $name , $desc, $doc, $status, $leftid, $visibility, $admin,$createdby,$createddate;
    $sqlQuery = "insert INTO `reportmaster` (`Name`, `Description`, `document`, `status`, `leftmenuid`, `visibility`, `admin`, `createdby`,`createddate`) VALUES ('$name' , '$desc', '$doc', '$status', (select `id` from  `acessconfig` where `ContentName` = '$leftid'), '$visibility', '$admin', (select `id` from `memberlogin` where `userid`='$createdby'),'$createddate')";
    $result = setData($conn, $sqlQuery);
    if ($result == "Record created") 
    {
        $jsonresponse = array('code' => '200', 'status' => 'Report Created');
        echo json_encode($jsonresponse);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'Report not created');
        echo json_encode($jsonresponse);
    }
}
?>