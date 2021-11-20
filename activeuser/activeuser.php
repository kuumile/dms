<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
if (isset($_POST['res'])){
    $userid = ($_POST['userid'] ?? '');
    $_SESSION['userId'] = $userid;
    $select = $conn->query("select * from useraccount where uid = '$userid'");
    if($select->num_rows < 1){
        echo json_encode(['result'=>'expired','msg'=>'User Session Expired. Login again.','url'=>'index.html']);
    }else{
        while ($row = $select->fetch_array()){
            $fname = $row['fname'];
            $lname = $row['lname'];
            $role = $row['role'];
            $img = $row['image'];

            $prifix = "../";
            if (substr($img,0,strlen($prifix)) == $prifix){
                $img = substr($img,strlen($prifix));
            }
                $uimg = "<img src='".$img."' alt='Profile image' class='avatar-rounded'>";
            echo json_encode(['result'=>'success','fullname'=>$fname,'userrole'=>$role,'userimage'=>$uimg]);
        }
    }
}