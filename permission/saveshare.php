<?php
session_start();
include "../config/config.php";
$conn = Database::getConnection();
$userid = $_SESSION['userId'];
$copy = $_POST['copy'];
$download = $_POST['download'];
$view = $_POST['view'];
$person = $_POST['person'];
$sid = $_POST['sid'];
$waiting = 'yes';
$folderid = $_POST['fid'];

$check = $conn->query("select * from permission where uid = '$userid' and fileid = '$sid' and sharedid = '$person'");
if ($check->num_rows < 1){
    $insert = $conn->query("insert into permission (uid, fileid, download, view, sharedid, copy, waiting) values ('$userid','$sid','$download','$view','$person','$copy','$waiting')");
    if ($insert) {
        echo json_encode(['result' => 'success', 'msg' => 'File shared successfully','folderid'=>$folderid]);
    } else {
        echo json_encode(['result' => 'error', 'msg' => 'File not shared!']);
    }
}else{
    echo json_encode(['result'=>'exist','msg'=>'File already shared','folderid'=>$folderid]);
}
