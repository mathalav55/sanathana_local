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
    $id = $data['id'];
    load_inbound($conn);
}
else if( $rcvData == "loadbynumber"){
    $id = $data['id'];
    load_bynumber($conn);
}
else if ($rcvData == "loadoutbound"){
    $id = $data['id'];
    load_outbound($conn);
}
else if ($rcvData == "addcontacts"){
    $masterid = $data['masterid'];
    $contactdetail = $data['contactdetail'];
    $contacttype = $data['contacttype'];
    add_leadcontacts($conn);
}
else if( $rcvData == "loadcontacts"){
    $id = $data['id'];
    load_contacts($conn);
}
else if($rcvData == "addentry"){
    $referto = $data['referto'];
    $referid = $data['referid'];
    $refferalamnt = $data['refferalamnt'];
    $finalamnt = $data['finalamnt'];
    $status = $data['status'];
    $name = $data['name'];
    $website = $data['website'];
    insert_refferal($conn);
}
else if($rcvData == "clearcontacts"){
    $id = $data['id'];
    clear_contacts($conn);
}
else if($rcvData == "update"){
    $id = $data['id'];
    $finalamnt = $data['finalamnt'];
    $refferalamnt = $data['refferalamnt'];
    $status = $data['status'];
    $name = $data['name'];
    update_refferal($conn);
}else{
    $jsonresponse = array('code' => '200', 'status' => 'Not Valid Option');
    echo json_encode($jsonresponse);
}
function clear_contacts($conn){
    global $id;
    $sqlQuery = "delete FROM `contactlists` WHERE `masterid` = '$id'";
    $result = setData($conn, $sqlQuery);
    if($result == "Record created"){
        $jsonresponse = array('code' => '200', 'status' => 'Cleared all contacts');
        echo json_encode($jsonresponse);
    }else{
        $jsonresponse = array('code' => '200', 'status' => 'Unable to clear contacts');
        echo json_encode($jsonresponse);
    }
}

function update_refferal($conn){
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
function load_contacts($conn){
    //get id from front end
    //get data from table where master id is equal to id
    global $id;
    $sqlQuery = "select `contactdetails`, `acessconfig`.`ContentName` as `contacttype`, `masterid` FROM `contactlists` join `acessconfig` on `contactlists`.`contacttype` = `acessconfig`.`id`  where `masterid` = '$id'";
    $datatable = getData($conn, $sqlQuery);
    if(count($datatable) > 0){
        echo json_encode($datatable);
    }else{
        $jsonresponse = array('code' => '200', 'status' => 'No Contacts Available');
        echo json_encode($jsonresponse);
    }
}
function add_leadcontacts($conn){
    //get id from front end
    global  $masterid, $contactdetail, $contacttype;
    $sqlQuery = "select `id` from `contactlists` where `contactdetails` = '$contactdetail'";
    $datatable = getData($conn, $sqlQuery);
    if(count($datatable) > 0){
        $dedupid = $datatable[0]['id'];
        $addQuery = "insert into `contactlists` (`contactdetails`, `contacttype`, `masterid`, `dedupid`) values ('$contactdetail',(select `id` from `acessconfig` where `ContentName` = '$contacttype'), '$masterid', '$dedupid')";
        $result = setData($conn, $addQuery);
        if($result == "Record created"){
            $jsonresponse = array('code' => '200', 'status' => 'Added Contact');
            echo json_encode($jsonresponse);
        }else{
            $jsonresponse = array('code' => '200', 'status' => 'Not Added Contact ddup');
            echo json_encode($jsonresponse);
        }
    }else{
        $addQuery = "insert into `contactlists` (`contactdetails`, `contacttype`, `masterid`) values ('$contactdetail',(select `id` from `acessconfig` where `ContentName` = '$contacttype'), '$masterid')";
        $result = setData($conn, $addQuery);
        if($result == "Record created"){
            $jsonresponse = array('code' => '200', 'status' => 'Added Contact');
            echo json_encode($jsonresponse);
        }else{
            $jsonresponse = array('code' => '200', 'status' => 'Not Added Contact');
            echo json_encode($jsonresponse);
        }
    }
    //send data into it each time
}
function load_bynumber($conn){
    global $id;
    $sqlQuery = "select `referrals_master`.`id`, `referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname`, `contactlists_master`.`id` as `masterid`  FROM `referrals_master` join `contactlists_master` on `referrals_master`.`id` = `contactlists_master`.`referralid` WHERE `type` = 1 AND `referrals_master`.`id` = '$id'";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
        $query1 = "select `userid` as `referto` from `memberlogin` where `id` = (select `referto` from `referrals_master` where `referrals_master`.`id` = '$id')";
        $refertoid = getData($conn, $query1);
        $query2 = "select `userid` as `referby` from `memberlogin` where `id` = (select `referid` from `referrals_master` where `referrals_master`.`id` = '$id')";
        $referbyid = getData($conn, $query2);
        $referdata = array_merge($refertoid[0], $referbyid[0]);
        $jsonresponse = array( 'data' => $datatable[0], 'id' => $referdata );
        echo json_encode($jsonresponse);
    } 
    else 
    {
        $jsonresponse = array('code' => '200', 'status' => 'No Refferals');
        echo json_encode($jsonresponse);
    }
}
function insert_refferal($conn)
{
  global  $referto, $referid, $refferalamnt, $finalamnt, $status,$name,$website;
  $insertQuery = "insert into `referrals_master` ( `type` , `referto`, `referid`, `referralamnt`, `finalamnt`, `status`) values ( 1 , (select `id` from `memberlogin` where `userid` = '$referto'),(select `id` from `memberlogin` where `userid` = '$referid'),'$refferalamnt','$finalamnt','$status')";
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
    global $id;
    $sqlQuery = "select `referrals_master`.`id`,`referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname` FROM `referrals_master` JOIN `contactlists_master` on `contactlists_master`.`referralid` = `referrals_master`.`id` WHERE `referrals_master`.`type` = 1 AND `referrals_master`.`referto` = (select `id` from `memberlogin` where `userid` = '$id')";
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
function load_outbound($conn){
    global $id;
    $sqlQuery = "select `referrals_master`.`id`,`referrals_master`.`referralamnt`, `referrals_master`.`finalamnt`, `referrals_master`.`status`, `contactlists_master`.`contactname` FROM `referrals_master` JOIN `contactlists_master` on `contactlists_master`.`referralid` = `referrals_master`.`id` WHERE `referrals_master`.`type` = 1 AND `referrals_master`.`referid` = (select `id` from `memberlogin` where `userid` = '$id')";
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