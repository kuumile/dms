<?php
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
session_start();
include "../config/config.php";
$conn = Database::getConnection();
$userid = $_SESSION['userId'];
$delid = $_POST['delid'];
$get = $conn->query("select * from folders where id = '$delid'");
if ($get->num_rows < 1){
    echo json_encode(['result'=>'exist', 'msg'=>'Folder Do Not Exists']);
}else{
    $rows = $get->fetch_array();
    $file_path = $rows['path'];
    $foldername = $rows['foldername'];
    if(delete_directory($file_path)) {
        $delete = $conn->query("delete from folders where id = '$delid' and uid = '$userid'");
        if ($delete) {
            $conn->query("delete from files where folderid = '$delid' and uid = '$userid'");
            echo json_encode(['result' => 'success', 'msg' => 'Folder Deleted Successfully']);
        } else {
            echo json_encode(['result' => 'error', 'msg' => 'Folder Not Deleted','error'=>mysqli_error($conn)]);
        }
    }
}