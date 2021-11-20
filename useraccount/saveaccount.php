<?php
include "../config/config.php";
$conn = Database::getConnection();

// Form Data
$uid = ($_POST['userid'] ?? '');
$fname = $_POST['userfname'];
$lname = $_POST['userlname'];
$email = $_POST['useremail'];
$password = addslashes($_POST['userpassword']);
$role = $_POST['userrole'];
$active = $_POST['active'];

if (empty($uid)) {

    if (!empty($_FILES["file"]["name"])) {

        if (file_exists("../accountimg/" . $_FILES["file"]["name"])) {
            echo json_encode(['result' => 'exist', 'msg' => 'Passport photo already exist']);
        } else {
            $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
            $targetPath = "../accountimg/" . $_FILES['file']['name']; // Target path where file is to be stored
            move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
            // Compress Image
            //compressImage($sourcePath, $targetPath, 60);
            $selc = $conn->query("select email from useraccount where email = '$email'");
            if ($selc->num_rows < 1) {
                $insert = $conn->query("insert into useraccount (fname, lname, email, password, role, active, image) VALUES ('$fname','$lname','$email','$password','$role','$active','$targetPath')");
                if ($insert) {
                    echo json_encode(['result' => 'success', 'msg' => 'User Account Created Successfully']);
                } else {
                    echo json_encode(['result' => 'error', 'msg' => 'User Account Not Created']);
                }
            } else {
                echo json_encode(['result' => 'userexist', 'msg' => 'User Account already Created']);
            }

        }

    } else {
        $selc = $conn->query("select email from useraccount where email = '$email'");
        if ($selc->num_rows < 1) {
            $insert = $conn->query("insert into useraccount (fname, lname, email, password, role, active) VALUES ('$fname','$lname','$email','$password','$role','$active')");
            if ($insert) {
                echo json_encode(['result' => 'success', 'msg' => 'User Account Created Successfully']);
            } else {
                echo json_encode(['result' => 'error', 'msg' => 'User Account Not Created']);
            }
        } else {
            echo json_encode(['result' => 'userexist', 'msg' => 'User Account already Created']);
        }
    }
}else{
    if (!empty($_FILES["file"]["name"])) {

        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
        $targetPath = "../accountimg/" . $_FILES['file']['name']; // Target path where file is to be stored
        move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
        // Compress Image
        //compressImage($sourcePath, $targetPath, 60);

        $insert = $conn->query("update useraccount set fname ='$fname',lname = '$lname',email = '$email',password = '$password',role = '$role',active = '$active',image = '$targetPath' where uid = '$uid'");
        if ($insert) {
            echo json_encode(['result' => 'success', 'msg' => 'User Account Updated Successfully']);
        } else {
            echo json_encode(['result' => 'error', 'msg' => 'User Account Not Updated']);
        }

    }else{
        $insert = $conn->query("update useraccount set fname ='$fname',lname = '$lname',email = '$email',password = '$password',role = '$role',active = '$active' where uid = '$uid'");
        if ($insert) {
            echo json_encode(['result' => 'success', 'msg' => 'User Account Updated Successfully']);
        } else {
            echo json_encode(['result' => 'error', 'msg' => 'User Account Not Updated']);
        }
    }
}