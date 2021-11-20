<?php
include "../config/config.php";
$conn = Database::getConnection();

if (isset($_POST['editid'])){
    $editid = $_POST['editid'];
    $select = $conn->query("select * from useraccount where uid = '$editid'");
    if ($select->num_rows < 1){}else{
        while($row = $select->fetch_array()){
            $uid = $row['uid'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $password = $row['password'];
            $role = $row['role'];
            $active = $row['active'];
        }
        echo json_encode(['uid'=>$uid,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'pass'=>$password,'role'=>$role,'active'=>$active]);
    }
}