<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
$folderid = ($_POST['id'] ?? '');
$userid = $_SESSION['userId'];

$select = $conn->query("select foldername from folders where uid = '$userid' and id = '$folderid'");
if ($select->num_rows < 1){
    $foldername = "";
}else{
    $row = $select->fetch_array();
    $foldername = $row['foldername'];
}

?>
<div class="large"><?php if (!empty($foldername)) {
        echo $foldername;
    } ?></div>
<table class="table table-sm">
    <thead>
    <tr>
        <th>Name</th>
        <th>Date modified</th>
        <th>Type</th>
        <th>Size</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $findfiles = $conn->query("select * from files where folderid = '$folderid'");
    if ($findfiles->num_rows < 1){
        ?>
    <tr>
        <td colspan="5">No file available</td>
    </tr>
    <?php
    }else{
    while($rows = $findfiles->fetch_array()){
        $fileid = $rows['id'];
        $filename = $rows['filename'];
        $filesize = $rows['filesize'];
        $uploaddate = $rows['uploaddate'];
        $ext = $rows['extension'];
        $path = "../directory/".$foldername."/".$filename;
        $imgpath = "../dms/directory/".$foldername."/".$filename;
    ?>
    <tr>
        <td><?php echo $filename; ?></td>
        <td><?php echo $uploaddate; ?></td>
        <td><?php if ($ext == "doc" or $ext == "docx"){ echo 'Microsoft Word'; }else if ($ext == "xls" or $ext == "xlsx"){ echo 'Microsoft Excel'; }else if ($ext == "ppt" or $ext == "pptx"){ echo 'Microsoft PowerPoint'; }else if ($ext == "pdf"){ echo $ext.' File'; }else if ($ext == "jpg" or $ext == "jpeg" or $ext == "JPG" or $ext == "JPEG" or $ext == "gif" or $ext == "GIF" or $ext == "png" or $ext == "PNG" or $ext == "bmp" or $ext == "BMP"){ echo $ext.' FIle'; }else{ echo $ext." File"; } ?></td>
        <td><?php echo $filesize; ?></td>
        <td>
            <?php
            if ($ext == "doc" or $ext == "docx" or $ext == "xls" or $ext == "xlsx" or $ext == "ppt" or $ext == "pptx"){}else{
            ?>
            <a role="button" href="javascript:open('../dms/folderfiles/previewfolderitem.php?folderid=<?php echo $folderid; ?>&fileid=<?php echo $fileid; ?>','PREVIEW DOCUMENT','width=960,height=650,screenX=200,screenY=200')" class="text-secondary p-1 previewitemss" id="<?php echo $folderid; ?>" name="<?php echo $folderid; ?>" ><i class="fa fa-eye"></i></a>
            <?php
            }
            if($ext == "jpg" or $ext == "jpeg" or $ext == "JPG" or $ext == "JPEG" or $ext == "gif" or $ext == "GIF" or $ext == "png" or $ext == "PNG" or $ext == "bmp" or $ext == "BMP"){
            ?>
            <a role="button" href="<?php  echo $imgpath; ?>" id="<?php  echo $imgpath; ?>" name="<?php echo $ext; ?>" class="text-primary p-1"><i class="fa fa-download"></i></a>
                <?php
            }else{
                ?>
                <a role="button" href="#" id="<?php echo $path; ?>" name="<?php echo $ext; ?>" class="text-primary p-1 downloadfile"><i class="fa fa-download"></i></a>
                    <?php
            }
                ?>
<!--            <a role="button" href="#" class="text-danger p-1"><i class="fa fa-trash"></i></a>-->
        </td>
    </tr>
    <?php
    }
    }
    ?>
    </tbody>
</table>
<script>
    $(document).ready(function (){
        $(".previewitems").on("click", function (){
            let id = $(this).attr("id"),
                folderid = $(this).attr("name");
            $.ajax({
                url: "folderfiles/previewfolderitem.php",
                type: "POST",
                data: {
                    res: 1,
                    id: id,
                    folderid: folderid
                },
                success: function (feedback){
                    $("#showfolderitems").html(feedback);
                }
            })
        })

        $(".downloadfile").on("click", function () {
            let path = $(this).attr("id"),
                ext = $(this).attr("name");
            $.ajax({
                url: "folderfiles/downloadfile.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    res: 1,
                    path: path,
                    ext: ext
                },
                success: function (feedback){

                }
            })
        })

    })
</script>