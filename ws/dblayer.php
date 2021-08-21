<?php

function getData($conn, $sqlQuery) 
{
    $result = mysqli_query($conn, $sqlQuery);
    if(!$result)
    {
        die('Error in query: '. mysqli_error($conn));
    }
    $data= array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        array_push($data, $row);            
    }
    return $data;
}

function setData($conn,$insertUpdateQuery) 
{
    if( mysqli_query($conn, $insertUpdateQuery))
    {
        $status = "Record created";			
    }
    else
    {
        $status = "Record not Created";			
    }
    return $status;
}

?>