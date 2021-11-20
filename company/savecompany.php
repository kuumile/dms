<?php
include "../config/config.php";
$conn = Database::getConnection();

$institute = $_POST['institute'];
$city = $_POST['city'];
$location = $_POST['location'];
$address = $_POST['address'];

$select  = $conn->query("select * from company");
if ($select->num_rows < 1){
    $insert = $conn->query("insert into company (institute, city, location, address) values ('$institute','$city','$location','$address')");
    if ($insert){
        echo json_encode(['result'=>'success', 'msg'=>'Company/Institution registered successfully']);
    }else{
        echo json_encode(['result'=>'error', 'msg'=>'Company/Institution not registered']);
    }
}else{
    $update = $conn->query("update company set institute = '$institute', city = '$city', location = '$location', address = '$address'");
    if ($update){
        echo json_encode(['result'=>'success', 'msg'=>'Company/Institution updated successfully']);
    }else{
        echo json_encode(['result'=>'error', 'msg'=>'Company/Institution not updated']);
    }
}