
<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
$get_pid = ($_GET['pid'] ?? '');
$fileids = ($_GET['fileid'] ?? '');
$folderid = ($_GET['folderid'] ?? '');
$userid = $_SESSION['userId'];
$select = $conn->query("select path,foldername from folders where uid = '$userid' and id = '$folderid'");
if ($select->num_rows < 1){
    $folderpath = "";
}else{
    $row = $select->fetch_array();
    $folderpath = $row['foldername'];
    $newpath = $row['path'];
}


    $findfiles = $conn->query("select * from files where id = '$fileids'");
    if ($findfiles->num_rows < 1){
    }else{
    while($rows = $findfiles->fetch_array()){
        $fileid = $rows['id'];
        $filename = $rows['filename'];
        $filesize = $rows['filesize'];
        $uploaddate = $rows['uploaddate'];
        $ext = $rows['extension'];
        $filetype = $rows['filetype'];

    }
    }
    ?>
<div class="ol-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <?php
    $npath = $newpath."/".$filename;
    $cpath = "../directory/".$folderpath."/".$filename;
    if ($ext == "pdf" or $ext == "PDF"){
    header("Content-type: ".$filetype);
    readfile($cpath);
    }else if($ext == "jpg" or $ext == "JPG" or $ext == "png" or $ext == "PNG" or $ext == "gif" or $ext == "GIF" or $ext == "jpeg" or $ext == "JPEG"){

        ?>
    <img src="<?php if (!empty($cpath)) {
        echo $cpath;
    } ?>" width="960px" height="1608px">
    <?php
    }
    ?>

</div>