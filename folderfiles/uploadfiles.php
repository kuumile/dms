<?php
session_start();
include "../config/config.php";
$conn = Database::getConnection();

function convert_filesize($bytes, $decimals = 2){
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
$folderid = $_POST['foldername'];
$select  = $conn->query("select * from folders where id = '$folderid'");
if ($select->num_rows < 1){
    $folderpath = '';
}else{
    $rowz = $select->fetch_array();
        $folderpath = $rowz['path'];
}
if (isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])) {
    $file_name = $_FILES['files']['name'];
    $file_type = $_FILES['files']['type'];
    $file_size = $_FILES['files']['size'];
    $file_temp = $_FILES['files']['tmp_name'];
    $location = $folderpath."/".$file_name;
    $temporary = explode(".", $_FILES["files"]["name"]);
    $file_extension = end($temporary);
    $userid = $_SESSION['userId'];
    $folderid = $_POST['foldername'];
    //$filename = $_POST['filename'];
    $filesize = convert_filesize($file_size);
    $date = date("Y-m-d, h:i A", strtotime("+0 HOURS"));
    if(!file_exists($folderpath)){
        mkdir($folderpath);
    }
    if (file_exists($folderpath."/". $_FILES["files"]["name"])) {
        echo json_encode(['result' => 'exist', 'msg' => 'File name:'.$file_name.' is already saved']);

    }else{
        if (move_uploaded_file($file_temp, $location)) {
            $insert = $conn->query("insert into files (uid, folderid, filename, uploaddate, filetype, filesize, extension) values ('$userid','$folderid','$file_name','$date','$file_type','$filesize','$file_extension')");
            if ($insert) {
                echo json_encode(['result' => 'success', 'msg' => 'File saved successfully']);
            } else {
                echo json_encode(['result' => 'error', 'msg' => 'File not saved']);
            }
        }
    }
}else{
    echo json_encode(['result'=>'required','msg'=>'Please choose a file to upload']);
}