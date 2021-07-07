<?php
include('config.php');
include('dblayer.php');

$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);
$rcvData=$data['load'];
//$date = date('Y-m-d H:i:s');
// echo $rcvData;
if($rcvData == "loadall")
{
	load_allmasterdata($conn);
}
else if($rcvData == "loadbyparent")
{
  $id = $data['id'];
  load_masterdatabyparent($conn);
}
else if($rcvData == "creatememid"){
  $id = $data['id'];
  $chapter = $data['chapter'];
  create_membershipid($conn);
}
else if($rcvData == "loadbyname")
{
  $id = $data['id'];
  load_masterdatabyname($conn);
}
else if($rcvData == "addEntry")
{
  $ContentName = $data['ContentName'];
  $Alias_Name = $data['Alias_Name'];
  $parent_id = $data['parent_id'];
  $access_to = $data['access_to'];
  $urlredirection = $data['urlredirection'];
  $iconpath = $data['iconpath'];
  $header = $data['header'];
  $content = $data['content'];
  $imagepath = $data['imagepath'];
  $videopath = $data['videopath'];
  $createdby = $data['createdby'];
  $createddate = $data['createddate'];
  $updatedby = $data['updatedby'];
  $updateddate = $data['updateddate'];
  $status = $data['status'];
  $emptystateimg = $data['emptystateimg'];
  $hexcolor = $data['hexcolor'];
  $sequenceid = $data['sequenceid'];
  insert_masters($conn);
}
else
{
  $id = $data['id'];
  $ContentName = $data['ContentName'];
  $Alias_Name = $data['Alias_Name'];
  $parent_id = $data['parent_id'];
  $access_to = $data['access_to'];
  $urlredirection = $data['urlredirection'];
  $iconpath = $data['iconpath'];
  $header = $data['header'];
  $content = $data['content'];
  $imagepath = $data['imagepath'];
  $videopath = $data['videopath'];
  $createdby = $data['createdby'];
  $createddate = $data['createddate'];
  $updatedby = $data['updatedby'];
  $updateddate = $data['updateddate'];
  $status = $data['status'];
  $emptystateimg = $data['emptystateimg'];
  $hexcolor = $data['hexcolor'];
  $sequenceid = $data['sequenceid'];
  update_masters($conn);
}

function load_allmasterdata($conn)
{
  $sqlQuery = "select * FROM `acessconfig`";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '200', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}
function create_membershipid($conn){
  global $id,$chapter;
  $sqlQuery = "select `count`, `Alias_Name` from `acessconfig` where `ContentName` = '$chapter'";
  $tableData = getdata($conn,$sqlQuery);
  $countValue = $tableData[0]['count'];
  $Alias_Name = $tableData[0]['Alias_Name'];

  $countValue = $countValue + 1; // value to be updated in the access config
  $membershipId = $Alias_Name . '/' . $countValue;//id to be stored in the member profile table
  // echo $membershipId;

  //query to update the chapter count
  $updateCountQuery = "update acessconfig set `count` = '$countValue' WHERE ContentName = '$chapter'";
  $countResult = setData($conn,$updateCountQuery);
  if(mysqli_affected_rows($conn)>0){
    //query to set member id in memberprofile
    $setMembershipIdQuery = "update `memberprofile` set `memberprofile`.`membershipid` = '$membershipId' WHERE `id` = (SELECT `memberid` from `memberlogin` WHERE `userid` ='$id')";
    setData($conn,$setMembershipIdQuery);
    if(mysqli_affected_rows($conn)>0){
      $jsonresponse = array('code' => '200', 'status' => 'Updated Succesfully' , "memershipid" => $membershipId);
      echo json_encode($jsonresponse);
    }else{
      $jsonresponse = array('code' => '400', 'status' => 'Updated Failure');
      echo json_encode($jsonresponse);
    }
    
  }else{
      $jsonresponse = array('code' => '400', 'status' => 'Updated Failure');
      echo json_encode($jsonresponse);
  }
}
function load_masterdatabyparent($conn)
{
  global $id;
  $sqlQuery = "select `id` from `acessconfig` where `ContentName` = '$id'";
  $dtt = getdata($conn, $sqlQuery);
  $pID=$dtt[0]['id'];  
  $sqlQuery = "select * FROM `acessconfig` WHERE `parent_id` = '$pID'";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '200', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function load_masterdatabyname($conn)
{
  global $id;
  $sqlQuery = "select * from `acessconfig` where `ContentName` = '$id'";
  $datatable = getdata($conn, $sqlQuery);

  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '200', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function insert_masters($conn)
{
  global $ContentName,$Alias_Name,$parent_id,$access_to,$urlredirection,$iconpath,$header,$content,$imagepath,$videopath,$createdby,$createddate,$updatedby,$updateddate,$status,$emptystateimg,$hexcolor,$sequenceid;
  $insertUpdateQuery = "insert INTO `acessconfig`(`ContentName`, `Alias_Name`, `parent_id`, `access_to`, `urlredirection`, `iconpath`, `header`, `content`, `imagepath`, `videopath`,`status`,`createdby`, `createddate`, `updatedby`, `updateddate`,`emptystateimg`,`hexcolor`, `sequenceid`) VALUES ('$ContentName','$Alias_Name','$parent_id','$access_to','$urlredirection','$iconpath','$header','$content','$imagepath','$videopath','$status','$createdby','$createddate','$updatedby','$updateddate','$emptystateimg','$hexcolor','$sequenceid')";
  $returndata = setData($conn, $insertUpdateQuery);
  //echo json_encode("Added Succesfully");
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Added Successfully');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '200', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function update_masters($conn)
{
  global $id,$ContentName,$Alias_Name,$parent_id,$access_to,$urlredirection,$iconpath,$header,$content,$imagepath,$videopath,$createdby,$createddate,$updatedby,$updateddate,$status,$emptystateimg,$sequenceid,$hexcolor;

  $slqry = "select * FROM `acessconfig` WHERE `id` = '$id'";
  $tempdata = getdata($conn, $slqry);
  if(count($tempdata) >0)
  {
    $insertUpdateQuery = "Update `acessconfig` SET `ContentName`='$ContentName' ,`Alias_Name`='$Alias_Name',`parent_id`='$parent_id',`access_to`='$access_to',`urlredirection`='$urlredirection',`iconpath`='$iconpath',`header`='$header',`content`='$content',`imagepath`='$imagepath',`videopath`='$videopath',`status` = '$status',`createdby`='$createdby',`createddate`='$createddate',`updatedby`='$updatedby',`updateddate`='$updateddate',`emptystateimg` = '$emptystateimg', `hexcolor` = '$hexcolor', `sequenceid` = '$sequenceid' WHERE `id` = '$id'";
    $returndata = setData($conn, $insertUpdateQuery);
    if($returndata == "Record created")
    {
      $jsonresponse = array('code' => '200', 'status' => 'Updated Succesfully');
      echo json_encode($jsonresponse);
    }
    else
    {
      $jsonresponse = array('code' => '200', 'status' => 'Updated Failure');
      echo json_encode($jsonresponse);
    }
  }
  else
  {
    $jsonresponse = array('code' => '200', 'status' => 'Check If Content Exists');
    echo json_encode($jsonresponse);
  }
}
?>