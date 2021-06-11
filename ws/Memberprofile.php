<?php
include('config.php');
include('dblayer.php');

$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);
$rcvData=$data['load'];
//$date = date('Y-m-d H:i:s');

if($rcvData == "loadallMemdata")
{
	load_allMemdata($conn);
}
else if($rcvData == "loadbynumber")
{
  $id = $data['id'];
  load_singlememdata($conn);
}
else if($rcvData == "loadmemchapters")
{
  $id = $data['id'];
  load_memchapters($conn);
}
else if($rcvData == "loadmemgroups")
{
  $id = $data['id'];
  load_memgroups($conn);
}
else if($rcvData == "addmemchapters")
{
  $id = $data['id'];
  $chapter = $data['chapter'];
  $prime = $data['prime'];
  insert_memchapters($conn);
}
else if($rcvData == "addmemgroups")
{
  $id = $data['id'];
  $group = $data['group'];
  insert_memgroups($conn);
}
else if($rcvData == "updatememchapters")
{
  $id = $data['id'];
  $chapter = $data['chapter'];
  $prime = $data['prime'];
  update_memchapters($conn);
}
else if($rcvData == "updatememgroups")
{
  $id = $data['id'];
  $group = $data['group'];
  update_memgroups($conn);
}
else if($rcvData == "addEntry")
{
  $id = $data['id'];
  $Name = $data['Name'];
  $surName = $data['surName'];
  $dob = $data['dob'];
  $gender = $data['gender'];
  $Gothram = $data['Gothram'];
  $photo = $data['photo'];
  $admin = $data['admin'];
  $status = $data['status'];  
  $pwd = $data['pwd'];
  insert_member($conn);
}
else if($rcvData == "logindetchange")
{
  $id = $data['id'];  
  $newpwd = $data['newpwd'];
  logindet_change($conn);
}
else
{
  $id = $data['id'];
  $Name = $data['Name'];
  $surName = $data['surName'];
  $dob = $data['dob'];
  $gender = $data['gender'];
  $Gothram = $data['Gothram'];
  $photo = $data['photo'];
  $admin = $data['admin'];
  $status = $data['status'];
  update_memprofile($conn);
}

function load_allMemdata($conn)
{
  $sqlQuery = "Select `memberlogin`.`userid`, `memberprofile`.`Name`, `memberprofile`.`Surname`, `memberprofile`.`Dob`, `memberprofile`.`gender`, `memberprofile`.`gothram`, `memberprofile`.`photo`, `memberprofile`.`admin`, `memberprofile`.`status` FROM `memberlogin` JOIN  `memberprofile` on `memberlogin`.`memberid` = `memberprofile`.`id`";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '404', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function load_singlememdata($conn)
{
  global $id;
  $sqlQuery = "Select `memberlogin`.`userid`, `memberprofile`.`Name`, `memberprofile`.`Surname`, `memberprofile`.`Dob`, `memberprofile`.`gender`, `memberprofile`.`gothram`, `memberprofile`.`photo`, `memberprofile`.`admin`, `memberprofile`.`status` FROM `memberlogin` JOIN  `memberprofile` on `memberlogin`.`memberid` = `memberprofile`.`id` WHERE `userid` = '$id'";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '404', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function load_memchapters($conn)
{
  global $id;
  $sqlQuery = "Select `acessconfig`.`ContentName`, `memberchapters`.`prime` FROM `memberchapters` JOIN `acessconfig` ON `memberchapters`.`chapter` = `acessconfig`.`id` WHERE `memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '404', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function load_memgroups($conn)
{
  global $id;
  $sqlQuery = "Select `acessconfig`.`ContentName` FROM `membergroups` JOIN `acessconfig` ON `membergroups`.`Groupid` = `acessconfig`.`id` WHERE `memberid` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $datatable = getdata($conn, $sqlQuery);
  if (count($datatable) > 0) 
  {
    echo json_encode($datatable);
  } 
  else 
  {
    $jsonresponse = array('code' => '404', 'status' => 'Nodata');
    echo json_encode($jsonresponse);
  }
}

function insert_memchapters($conn)
{
  global $id,$chapter,$prime;
  $sqlQuery = "Insert INTO `memberchapters`(`chapter`, `prime`, `memberid`) VALUES  ((select `id` from `acessconfig` where `ContentName` = '$chapter'),'$prime',(SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id'))";
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

function insert_memgroups($conn)
{
  global $id,$group;
  $sqlQuery = "Insert INTO `membergroups`(`Groupid`, `memberid`) VALUES  ((select `id` from `acessconfig` where `ContentName` = '$group'),(SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id'))";
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

function update_memchapters($conn)
{
  global $id,$chapter,$prime;
  $sqlQuery = "Delete FROM `memberchapters` WHERE `memberid`= (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $sqlQuery1 = "Insert INTO `memberchapters`(`chapter`, `prime`, `memberid`) VALUES  ((select `id` from `acessconfig` where `ContentName` = '$chapter'),'$prime',(SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id'))";
    $returndata1 = setData($conn, $sqlQuery1);
    if($returndata1 == "Record created")
    {
      $jsonresponse = array('code' => '200', 'status' => 'Updated Successfully');
      echo json_encode($jsonresponse);
    }
    else
    {
      $jsonresponse = array('code' => '500', 'status' => 'Not Added');
      echo json_encode($jsonresponse);
    }
  }
  else
  {
    $jsonresponse = array('code' => '200', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function update_memgroups($conn)
{
  global $id,$group;
  $sqlQuery = "Delete FROM `membergroups` WHERE `memberid`= (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $returndata = setData($conn, $sqlQuery);
  if($returndata == "Record created")
  {
    $sqlQuery1 = "Insert INTO `membergroups`(`Groupid`, `memberid`) VALUES  ((select `id` from `acessconfig` where `ContentName` = '$group'),(SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id'))";
    $returndata1 = setData($conn, $sqlQuery);
    if($returndata1 == "Record created")
    {
      $jsonresponse = array('code' => '200', 'status' => 'Updated Successfully');
      echo json_encode($jsonresponse);
    }
    else
    {
      $jsonresponse = array('code' => '500', 'status' => 'Not Added');
      echo json_encode($jsonresponse);
    }
  }
  else
  {
    $jsonresponse = array('code' => '200', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}
function insert_member($conn)
{
  global $id,$Name,$surName,$dob,$gender,$Gothram,$photo,$admin,$status,$pwd;
  $insertUpdateQuery = "Insert INTO `memberprofile`(`Name`, `Surname`, `Dob`, `gender`, `gothram`, `photo`, `admin`, `status`) VALUES ('$Name','$surName','$dob','$gender','$Gothram','$photo','$admin','$status')";
  $returndata = setData($conn, $insertUpdateQuery);
  //echo json_encode("Added Succesfully");
  if($returndata == "Record created")
  {
    $memberid = "";
    $sqlQuery = "Select `id` FROM `memberprofile` ORDER BY `id` DESC";
    $datatable = getdata($conn, $sqlQuery);
    if (count($datatable) > 0) 
    {
      $memberid = $datatable[0]['id'];
      $sqlQuery = "Insert INTO `memberlogin`(`userid`, `password`, `memberid`,`status`) VALUES ('$id','$pwd','$memberid','$status')";
      $returndata1 = setData($conn, $sqlQuery);
      if($returndata1 == "Record created")
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
    else 
    {
      $jsonresponse = array('code' => '200', 'status' => 'Nodata');
      echo json_encode($jsonresponse);
    }
  }
  else
  {
    $jsonresponse = array('code' => '500', 'status' => 'Not Added');
    echo json_encode($jsonresponse);
  }
}

function update_memprofile($conn)
{
  global $id,$Name,$surName,$dob,$gender,$Gothram,$photo,$admin,$status;

  $slqry = "Select * FROM `memberprofile` WHERE `id` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
  $tempdata = getdata($conn, $slqry);
  if(count($tempdata) >0)
  {
    $insertUpdateQuery = "Update `memberprofile` SET `Name`='$Name',`Surname`='$surName',`Dob`='$dob',`gender`='$gender',`gothram`='$Gothram',`photo`='$photo',`admin`='$admin',`status`='$status' WHERE `id` = (SELECT `memberid` FROM `memberlogin` WHERE `userid` = '$id')";
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
    $jsonresponse = array('code' => '404', 'status' => 'Check If Content Exists');
    echo json_encode($jsonresponse);
  }
}

function logindet_change($conn)
{
  global  $id, $newpwd;
  $sqlQuery ="Update `memberlogin` SET `userid`='$id',`password`='$newpwd' WHERE `id` = (SELECT `id` FROM `memberlogin` WHERE `userid` = '$id' )";
  $returndata = setData($conn, $sqlQuery);
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
?>