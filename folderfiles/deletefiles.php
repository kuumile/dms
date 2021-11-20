<?php

session_start();
include "../config/config.php";
$conn = Database::getConnection();
$userid = $_SESSION['userId'];
$delid = $_POST['delid'];
$get = $conn->query("select * from files where id = '$delid'");
if ($get->num_rows < 1){
    echo json_encode(['result'=>'exist', 'msg'=>'File Do Not Exists']);
}else{
    $rows = $get->fetch_array();
    $folderid = $rows['folderid'];
    $filename = $rows['filename'];
    $folders = $conn->query("select * from folders where id = '$folderid' and uid = '$userid'");
    $rof = $folders->fetch_array();
    $file_path = $rof['path'];
    $delfile = $file_path."/".$filename;
    if (file_exists($delfile)) {
        if (unlink($delfile)) {
            $delete = $conn->query("delete from files where id = '$delid' and uid = '$userid'");
            if ($delete) {
                echo json_encode(['result' => 'success', 'msg' => 'File Deleted Successfully']);
            } else {
                echo json_encode(['result' => 'error', 'msg' => 'File Not Deleted', 'error' => mysqli_error($conn)]);
            }
        }
    }else{
        echo json_encode(['result'=>'exist', 'msg'=>'File Do Not Exists']);
        $conn->query("delete from files where id = '$delid' and uid = '$userid'");
    }
}