<?php
include "../config/config.php";
$conn = Database::getConnection();

$delid = $_POST['delid'];

$delete = $conn->query("delete from company where id = '$delid'");
if ($delete){
    echo json_encode(['result'=>'success', 'msg'=>'Records deleted successfully']);
}else{
    echo json_encode(['result'=>'error', 'msg'=>'Records not deleted']);
}