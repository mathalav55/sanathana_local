<?php
include('config.php');
include('dblayer.php');

$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);
$rcvData=$data['load'];
//$date = date('Y-m-d H:i:s');

if($rcvData == "loadallMemdata")
{
  $page = $data['page'];
  $chapters = $data['chapters'];
  $groups = $data['groups'];
  $categories = $data['categories'];
	load_allMembusinessdata($conn);
}
else if($rcvData == "loadbynumber")
{
  $id = $data['id'];
  load_singlemembusinessdata($conn);
}
else if($rcvData == "loadmemcontacts")
{
  $id = $data['id'];
  $category = $data['category'];
  load_memcontacts($conn);
}
else if($rcvData == "addmemcontacts")
{
  $id = $data['id'];
  $contactdetails = $data['contactdetails'];
  $contacttype = $data['contacttype'];
  $category = $data['category'];
  insert_memcontacts($conn);
}
else if($rcvData == "clearmemcontacts")
{
  $id = $data['id'];
  $category = $data['category'];
  clear_memcontacts($conn);
}
else if($rcvData == "addproducts")
{
  $id = $data['id']; 
  $category = $data['category'];
  $prodname = $data['prodname'];
  $prodDesc = $data['prodDesc'];
  $prodbroucher = $data['prodbroucher'];
  $prodvideo = $data['prodvideo'];
  insert_products($conn);
}
else if($rcvData == "loadproducts")
{
  $id = $data['id'];
  $category = $data['category'];
  load_products($conn);
}
else if($rcvData == "delproducts")
{
  $id = $data['id']; 
  $category = $data['category'];
  $prodname = $data['prodname'];
  $prodDesc = $data['prodDesc'];
  $prodbroucher = $data['prodbroucher'];
  $prodvideo = $data['prodvideo'];
  clear_products($conn);
}
else if($rcvData == "delprofile"){
  $id = $data['id'];
  delete_businessprofile($conn);
}
else if($rcvData == "addEntry")
{
  $id = $data['id'];
  $Name = $data['Name'];
  $desc = $data['desc'];
  $Address = $data['Address'];
  $pincode = $data['pincode'];
  $City = $data['City'];
  $category = $data['category'];
  $status = $data['status'];  
  $logo = $data['logo'];
  $banner = $data['banner'];
  $country = $data['country'];
  $state = $data['state'];
  insert_businessprofile($conn);
}
else
{
  $id = $data['id'];
  $Name = $data['Name'];
  $desc = $data['desc'];
  $Address = $data['Address'];
  $pincode = $data['pincode'];
  $City = $data['City'];
  $category = $data['category'];
  $status = $data['status'];  
  $logo = $data['logo'];
  $banner = $data['banner'];
  $country = $data['country'];
  $state = $data['state'];
  update_businessprofile($conn);
}

function load_allMembusinessdata($conn)
{
  global $page,$chapters,$groups,$categories;
  //starting record according to page numer
  $recordsPerPage = 25;
  $startingRecord = ( $page - 1) * $recordsPerPage;
  
  $baseQuery = "Select `memberlogin`.`userid`,`businessprofile`.`Name` AS `BusinessName`, `businessprofile`.`Description`, `businessprofile`.`Address`, `businessprofile`.`pincode`, `businessprofile`.`city`, `businessprofile`.`country`,`businessprofile`.`state`, `businessprofile`.`status`, `businessprofile`.`logo`, `businessprofile`.`banner`, `memberprofile`.`Name`, `memberprofile`.`Surname`, `memberprofile`.`Dob`,`memberprofile`.`gender`, `memberprofile`.`gothram`, `memberprofile`.`photo`, `memberprofile`.`privilige`, `acessconfig`.`ContentName` FROM `businessprofile` JOIN `memberprofile` ON `businessprofile`.`Memberid` = `memberprofile`.`id` JOIN `acessconfig` ON `businessprofile`.`categories` = `acessconfig`.`id` JOIN `memberlogin` ON `memberlogin`.`memberid` = `memberprofile`.`id`";
  $countQuery = "Select count(*) AS `count` FROM `businessprofile` JOIN `memberprofile` ON `businessprofile`.`Memberid` = `memberprofile`.`id` JOIN `acessconfig` ON `businessprofile`.`categories` = `acessconfig`.`id` JOIN `memberlogin` ON `memberlogin`.`memberid` = `memberprofile`.`id`";
  //filtered queries
  $flag = false; //decide whether to add "and" or "where"
  //categories filter
  if(strlen($categories) > 0){
    if(!$flag){
     //append where to string 
     $baseQuery  = $baseQuery . " WHERE ";
     $countQuery = $countQuery . " WHERE ";
     $flag = true;
    }else{
      //append and to string
      $baseQuery  = $baseQuery . " and";
      $countQuery = $countQuery . " and";
    }
    //append fiter to string
    $baseQuery = $baseQuery . "`businessprofile`.`categories` in ($categories)";
    $countQuery = $countQuery . "`businessprofile`.`categories` in ($categories)";
  }
  //groups filter
  if(strlen($groups) > 0){
    if(!$flag){
      //append where to string
      $baseQuery  = $baseQuery . " WHERE ";
      $countQuery = $countQuery . " WHERE "; 
      $flag = true;
     }else{
       //append and to string
      $baseQuery  = $baseQuery . " and ";
      $countQuery = $countQuery . " and ";
     }
     //append fiter to string
     $baseQuery = $baseQuery . "`businessprofile`.`memberid` in (SELECT DISTINCT `membergroups`.`memberid` FROM `membergroups` WHERE `GroupId` in ($groups))";
     $countQuery = $countQuery . "`businessprofile`.`memberid` in (SELECT DISTINCT `membergroups`.`memberid` FROM `membergroups` WHERE `GroupId` in ($groups))";
  }
  //chapters filter
  if(strlen($chapters) > 0){
    if(!$flag){
      //append where to string
      $baseQuery  = $baseQuery . " WHERE ";
      $countQuery = $countQuery . " WHERE ";
      $flag = true;
     }else{
       //append and to string
      $baseQuery  = $baseQuery . " and ";
      $countQuery = $countQuery . " and ";
     }
     //append fiter to string
    $baseQuery  = $baseQuery . "`businessprofile`.`memberid` in (SELECT distinct `memberchapters`.`memberid` FROM `memberchapters` WHERE chapter in ($chapters))";
    $countQuery  = $countQuery . "`businessprofile`.`memberid` in (SELECT distinct `memberchapters`.`memberid` FROM `memberchapters` WHERE chapter in ($chapters))";
  }
  //add limit to the base query
  $baseQuery = $baseQuery . "LIMIT $startingRecord, $recordsPerPage";
  //run count query and select query
  $data = getdata($conn,$baseQuery);
  $count = getdata($conn,$countQuery);
  $count[0]['count'] = ceil($count[0]['count'] / $recordsPerPage);
  array_unshift($data,$count[0]);
  echo json_encode($data);
  //calucuate page count
  //send it as and object in the result array
}

function load_singlemembusinessdata($conn)
{
  global $id;
  $sqlQuery = "Select `businessprofile`.`Name`, `businessprofile`.`Name` AS `BusinessName` , `businessprofile`.`Description`, `businessprofile`.`Address`, `businessprofile`.`pincode`, `businessprofile`.`city`, `businessprofile`.`country`,`businessprofile`.`state`,`businessprofile`.`status`, `businessprofile`.`logo`, `businessprofile`.`banner`, `acessconfig`.`ContentName` AS `category` FROM `businessprofile` JOIN `acessconfig` ON `businessprofile`.`categories` = `acessconfig`.`id` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '500', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function load_memcontacts($conn)
{
  global $id,$category;
  $sqlQuery = "Select `membercontacts`.`contactdetails`, `acessconfig`.`ContentName` FROM `membercontacts` JOIN `acessconfig` ON `membercontacts`.`contacttype` = `acessconfig`.`id` WHERE `businessprofileid` = (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category'))";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '500', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function insert_memcontacts($conn)
{
  global $id,$contactdetails,$contacttype,$category;
  $sqlQuery = "Insert INTO `membercontacts`(`contactdetails`, `contacttype`, `businessprofileid`) VALUES ('$contactdetails',(select `id` from `acessconfig` where `ContentName` = '$contacttype'), (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category')))";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Added Successfully');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function clear_memcontacts($conn)
{
  global $id,$category;
  $sqlQuery = "Delete FROM `membercontacts` WHERE `businessprofileid`= (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category'))";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Data Cleared');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Cleared');
    echo json_encode($jsonresponse);
  }
}

function load_products($conn)
{
  global $id,$category;
  $sqlQuery = "Select `Name`, `Description`, `broucher`, `video` FROM `products`  WHERE `businessprofileid` = (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category'))";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '500', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function insert_products($conn)
{
  global $id, $category, $prodname, $prodDesc, $prodbroucher, $prodvideo;
  $sqlQuery = "Insert INTO `products`(`Name`, `Description`, `broucher`, `video`, `businessprofileid`) VALUES ('$prodname','$prodDesc','$prodbroucher','$prodvideo', (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category')))";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Added Successfully');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function clear_products($conn)
{
  global $id,$category, $prodname, $prodDesc, $prodbroucher, $prodvideo;
  $sqlQuery = "Delete FROM `products` WHERE `Name` = '$prodname' AND `Description` = '$prodDesc' AND `broucher` = '$prodbroucher' AND `video` = '$prodvideo' AND `businessprofileid` = (SELECT `id` FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category'))";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Data Cleared');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function insert_businessprofile($conn)
{
  global $id,$Name,$desc,$Address,$pincode,$City,$category,$status,$logo,$banner,$country,$state;
  $insertUpdateQuery = "Insert INTO `businessprofile`(`Name`, `Description`, `Address`, `pincode`, `city`, `country` , `state` , `Memberid`, `categories`, `status`, `logo`, `banner`)  VALUES ('$Name', '$desc','$Address','$pincode','$City', '$country', '$state' ,(SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id'),(select `id` from `acessconfig` where `ContentName` = '$category'),'$status','$logo','$banner')";
  $returndata = setData($conn, $insertUpdateQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Added Successfully');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}
function delete_businessprofile($conn){
  global $id;
  $sqlQuery = "Delete  FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $jsonresponse = array('code' => '200', 'status' => 'Data Cleared');
    echo json_encode($jsonresponse);
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Cleared Data');
    echo json_encode($jsonresponse);
  }
}
function update_businessprofile($conn)
{
  global $id,$Name,$desc,$Address,$pincode,$City,$category,$status,$logo,$banner,$country,$state;

  $slqry = "Select * FROM `businessprofile` WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category')";
  $tempdata = getdata($conn, $slqry);
  if(count($tempdata) >0)
  {
    $insertUpdateQuery = "Update `businessprofile` SET `Name`='$Name',`Description`='$desc',`Address`='$Address',`pincode`='$pincode',`city`='$City', `country` = '$country', `state` = '$state',`status`='$status',`logo`='$logo',`banner`='$banner' WHERE `Memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id') and `categories` = (select `id` from `acessconfig` where `ContentName` = '$category')";
    $returndata = setData($conn, $insertUpdateQuery);
    if($returndata == "Record created")
    {
      $jsonresponse = array('code' => '200', 'status' => 'Updated Succesfully');
      echo json_encode($jsonresponse);
    }
    else
    {
      $jsonresponse = array('code' => '500', 'status' => 'Updated Failure');
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