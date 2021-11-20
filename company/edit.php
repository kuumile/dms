<?php
include "../config/config.php";
$conn = Database::getConnection();

$editid = $_POST['editid'];

$getme = $conn->query("select * from company where id = '$editid'");
if ($getme->num_rows < 1){}else{
    $row = $getme->fetch_array();
    $id = $row['id'];
    $institute = $row['institute'];
    $city = $row['city'];
    $location = $row['location'];
    $address = $row['address'];

    echo json_encode(['institute'=>$institute, 'city'=>$city, 'location'=>$location, 'address'=>$address]);
}