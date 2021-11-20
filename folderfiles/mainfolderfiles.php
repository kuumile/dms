<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
$userID = $_SESSION['userId'];
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
        <div class="card-header">
            <h3><i class="fa fa-folder"></i> Manage Folders/Files</h3>
        </div>

        <div class="card-body">
            <div id="simpleTree">
                <ul>
                            <?php


                            $fetchFolders = $conn->query("select * from folders where uid = '$userID'");
                            if ($fetchFolders->num_rows < 1){

                            }else{
                                while($rowf = $fetchFolders->fetch_array()){
                                    $foldname = $rowf['foldername'];
                                    $folderId = $rowf['id'];
                                ?>
                                <li data-jstree='{"opened":true}'><?php echo $foldname; ?>
                                    <ul>
                                        <?php
                                $alovalfiles = $conn->query("select * from files where folderid = '$folderId'");
                                if ($alovalfiles->num_rows < 1){}else{
                                    while($rec = $alovalfiles->fetch_array()){
                                        $filename = $rec['filename'];
                                        $ext = $rec['extension'];
                                        ?>
                                        <li data-jstree='<?php if ($ext == "doc" or $ext == "docx"){ echo '{"icon":"fa fa-file-word-o","type":"file"}'; }else if ($ext == "xls" or $ext == "xlsx"){ echo '{"icon":"fa fa-file-excel-o","type":"file"}'; }else if ($ext == "ppt" or $ext == "pptx"){ echo '{"icon":"fa fa-file-powerpoint-o","type":"file"}'; }else if ($ext == "pdf"){ echo '{"icon":"fa fa-file-pdf-o","type":"file"}'; }else if ($ext == "jpg" or $ext == "jpeg" or $ext == "JPG" or $ext == "JPEG" or $ext == "gif" or $ext == "GIF" or $ext == "png" or $ext == "PNG" or $ext == "bmp" or $ext == "BMP"){ echo '{"icon":"fa fa-file-image-o","type":"file"}'; }else{ echo '{"type":"file"}'; } ?>'> <?php echo $filename; ?></li>
                                        <?php
                                    }
                                }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                                }
                            }
                            ?>
                </ul>
            </div>
        </div>
        <div class="card-footer small text-muted">

        </div>
    </div><!-- end card-->
</div>
