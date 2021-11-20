<?php
include "../config/config.php";
$conn = Database::getConnection();

if (isset($_POST['res'])){
    $email = ($_POST['userlogin'] ?? '');
    $pass = ($_POST['userpass'] ?? '');

    $checkEmail = $conn->query("select * from useraccount where email = '$email'");
    if ($checkEmail->num_rows < 1){
        echo json_encode(['result'=>'emailerror','msg'=>'Wrong Email entered!']);
    }else{
        $checkPassword = $conn->query("select * from useraccount where password = '$pass'");
        if ($checkPassword->num_rows < 1){
            echo json_encode(['result'=>'passerror','msg'=>'Wrong Password entered!']);
        }else{
            $bothlogin = $conn->query("select * from useraccount where email = '$email' and password = '$pass'");
            if ($bothlogin->num_rows < 1){
                echo json_encode(['result'=>'botherror','msg'=>'Email and Password entered mismatched!']);
            }else{
                $row = $bothlogin->fetch_array();
                $userid = $row['uid'];

                $url = 'dashboard.html';
                echo json_encode(['result'=>'success','url'=>$url,'userid'=>$userid]);
            }
        }
    }

}
