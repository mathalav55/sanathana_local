<?php
include('config.php');
include('dblayer.php');

$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);
$rcvData=$data['load'];
//$date = date('Y-m-d H:i:s');
// echo $rcvData;
if($rcvData == "loadinbound")
{
    load_inbound($conn);
}
else if( $rcvData == "loadbynumber"){
    $id = $data['id'];
    load_bynumber($conn);
}
else if($rcvData == "loadall"){
    // $id = $data['id'];
    Load_all($conn);
}
else if ($rcvData == "loadoutbound"){
    $id = $data['id'];
    load_outbound($conn);
}
else if($rcvData == "addentry"){
    $referid = $data['referid'];
    $refferalamnt = $data['refferalamnt'];
    $finalamnt = $data['finalamnt'];
    $status = $data['status'];
    $name = $data['name'];
    insert_oppurtunity($conn);
}
else if($rcvData == "update"){
    $id = $data['id'];
    $finalamnt = $data['finalamnt'];
    $refferalamnt = $data['refferalamnt'];
    $status = $data['status'];
    $name = $data['name'];
    update_oppurtunity($conn);
}else{
    $jsonresponse = array('code' => '200', 'status' => 'Not Valid Option');
    echo json_encode($jsonresponse);
}

function load_bynumber($conn){
    global $id;
    $sqlQuery = "select `referrals_master`.`id`, `referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname`, `contactlists_master`.`id` as `masterid`  FROM `referrals_master` join `contactlists_master` on `referrals_master`.`id` = `contactlists_master`.`referralid` WHERE `type` = 0 AND `referrals_master`.`id` = '$id'";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        
        $query2 = "select `userid` as `referby` from `memberlogin` where `id` = (select `referid` from `referrals_master` where `referrals_master`.`id` = '$id')";
        $referbyid = getData($conn, $query2);
        $referdata = array_merge($referbyid[0]);
        $jsonresponse = array( 'data' => $datatable[0], 'id' => $referdata );
        echo json_encode($jsonresponse);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Refferals');
        echo json_encode($jsonresponse);
    }
}
function update_oppurtunity($conn){
    global $id,$finalamnt,$refferalamnt,$status,$name;
    $sqlQuery = "update `referrals_master` SET `referralamnt` = '$refferalamnt', `finalamnt`= '$finalamnt',`status`='$status' where `id` = '$id'";
    $result = setData($conn, $sqlQuery);
      if ($result == "Record created") 
      {
        $conQuery = "update `contactlists_master` SET `contactname`='$name' WHERE `referralid` = '$id'";
        $response = setData($conn, $conQuery);
        if($response == "Record created"){
            $jsonresponse = array('code' => '200', 'status' => 'Updated Refferal ');
            echo json_encode($jsonresponse);
        }else{
            $jsonresponse = array('code' => '200', 'status' => 'Unable to update refferal');
            echo json_encode($jsonresponse);
        }    
        
      } 
      else 
      {
          $jsonresponse = array('code' => '200', 'status' => 'Unable to update refferal');
          echo json_encode($jsonresponse);
      }
  
}

function insert_oppurtunity($conn)
{
  global  $referid, $refferalamnt, $finalamnt, $status,$name,$website;
  $insertQuery = "insert into `referrals_master` ( `type` ,`referid`, `referralamnt`, `finalamnt`, `status`) values ( 0 ,(select `id` from `memberlogin` where `userid` = '$referid'),'$refferalamnt','$finalamnt','$status')";
  $returndata = setData($conn, $insertQuery);
  //echo json_encode("Added Succesfully");
  if($returndata == "Record created")
  {
    //take id from refferal and 
    $getQuery = "select `id` from `referrals_master` order by `id` desc";
    $datatable = getdata($conn, $getQuery);
    if(count($datatable) > 0){
        $refferalid = $datatable[0]['id'];
        //write query to insert into contact master
        $conQuery = "insert into `contactlists_master` (`contactname`, `website`, `referralid`) values('$name', '$website', '$refferalid')";
        $status = setData($conn,$conQuery);
        //get contact master list id
        if($status == "Record created"){
            $query = "select `id` from `contactlists_master` order by `id` desc";
            $table = getData($conn, $query);
            if(count($table) > 0){
                $masterid = $table[0]['id'];
                //return contact master id as json response
                $jsonresponse = array('code' => '200', 'status' => 'Added Refferal Sucessfully', 'masterid' => $masterid);
                echo json_encode($jsonresponse);
            }
        }
        
    }
    
    
  }
  else
  {
    $jsonresponse = array('code' => '200', 'status' => 'Not Added Refferal');
    echo json_encode($jsonresponse);
  }
}
function load_inbound($conn){
    $sqlQuery = "select `referrals_master`.`id`,`referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname` FROM `referrals_master` JOIN `contactlists_master` on `contactlists_master`.`referralid` = `referrals_master`.`id` WHERE `referrals_master`.`type` = 0";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        echo json_encode($datatable);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Refferals');
        echo json_encode($jsonresponse);
    }
}
function load_all($conn){
    // global $id;
    $sqlQuery = "select `referrals_master`.`id`,`referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname` FROM `referrals_master` JOIN `contactlists_master` on `contactlists_master`.`referralid` = `referrals_master`.`id` WHERE `referrals_master`.`type` = 0";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        echo json_encode($datatable);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Oppurtunities');
        echo json_encode($jsonresponse);
    }
}
function load_outbound($conn){
    global $id;
    $sqlQuery = "select `referrals_master`.`id`,`referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname` FROM `referrals_master` JOIN `contactlists_master` on `contactlists_master`.`referralid` = `referrals_master`.`id` WHERE `referrals_master`.`type` = 0 AND `referrals_master`.`referid` = (select `id` from `memberlogin` where `userid` = '$id')";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        echo json_encode($datatable);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Refferals');
        echo json_encode($jsonresponse);
    }
}

?>