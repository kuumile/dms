<?php
include "../config/config.php";
session_start();
$conn = Database::getConnection();

if (isset($_POST['res'])){
    $foldername = ($_POST['foldername'] ?? '');
    $folderdesc = addslashes($_POST['folderdesc']);
    $uid = $_SESSION['userId'];
    $date = date("Y-m-d, h:i A", strtotime("+0 HOURS"));
    if(!file_exists("../directory/".$foldername)){
        mkdir("../directory/".$foldername);
        $path = "../directory/".$foldername;
    }
    $path = "../directory/".$foldername;
    $selfld = $conn->query("select * from folders where foldername = '$foldername'");
    if ($selfld->num_rows < 1){
        $create = $conn->query("insert into folders (uid, foldername, folderdesc, path,dor) values ('$uid','$foldername','$folderdesc','$path','$date')");
        if ($create){
            echo json_encode(['result'=>'success', 'msg'=>'Folder Created Successfully']);
        }else{
            echo json_encode(['result'=>'error', 'msg'=>'Folder Not Created!']);
        }
    }else{
        echo json_encode(['result'=>'exist', 'msg'=>'Folder Already Created!']);
    }

}
