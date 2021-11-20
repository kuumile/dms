<?php
include "../config/config.php";
$conn = Database::getConnection();

if (isset($_POST['editid'])){
    $delid = $_POST['editid'];
    $getimg = $conn->query("select * from useraccount where uid = '$delid'");
    if ($getimg->num_rows < 1){}else {
        $row = $getimg->fetch_array();
        $location = $row['image'];
        if(unlink($location)) {
            $delete = $conn->query("delete from useraccount where uid = '$delid'");
            if ($delete) {
                echo json_encode(['result' => 'success', 'msg' => 'User Account Deleted Successfully']);
            } else {
                echo json_encode(['result' => 'error', 'msg' => 'User Account Not Deleted']);
            }
        }
    }
}