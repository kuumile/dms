<?php
session_start();
include "../config/config.php";
$conn  = Database::getConnection();
$userid = $_SESSION['userId'];
$getfolder = $conn->query("select * from folders where uid = '$userid'");
?>
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Folders/Files</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Manage</li>
                <li class="breadcrumb-item active">Folders/Files</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
    <div class="card mb-3">
        <div class="card-header">
            <h3><i class="fa fa-folder"></i> Manage Files</h3>
        </div>

        <div class="card-body">
            <form id="createFileForm" method="post" enctype="multipart/form-data">
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foldername">Folder Directory</label>
                    <select name="foldername" id="foldername" class="form-control form-control-sm">
                        <option value=""></option>
                        <?php
            if ($getfolder->num_rows < 1){}else{
                while($rows = $getfolder->fetch_array()){
                    $folderid = $rows['id'];
                    $foldername = $rows['foldername'];
                    ?>
                    <option value="<?php if (!empty($folderid)) {
                        echo $folderid;
                    } ?>"><?php echo $foldername; ?></option>
                        <?php
                }
            }
                        ?>
                    </select>
                </div>
<!--                <div class="form-group col-md-6">-->
<!--                    <label for="filename">File Name</label>-->
<!--                    <input type="text" name="filename" id="filename" class="form-control form-control-sm">-->
<!--                </div>-->
                <div class="form-group col-md-6">
                    <label for="files">Browse Files</label>
                    <input type="file" name="files" id="files" class="form-control form-control-sm">
                </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" id="savefiles" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Save File</button>
                </div>
            </form>
        </div>
        <div class="card-footer small text-muted">

        </div>
    </div><!-- end card-->
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
    <div class="card mb-3">
        <div class="card-header">
            <h3><i class="fa fa-folder"></i> Manage Files</h3>
        </div>

        <div class="card-body table-responsive" id="showFiles">

        </div>
        <div class="card-footer small text-muted">

        </div>
    </div><!-- end card-->
</div>
</div>
<script>
    // Create and save folder
    $("#createFileForm").on("submit", function (e){
        e.preventDefault();
        let foldername  = getIdValues('foldername');

        if (foldername.length < 1){
            $("#foldername").focus();
            swal("Required!", "Folder Name is required!", "error");
        }else{
            $.ajax({
                url: "folderfiles/uploadfiles.php",
                type: "POST",
                dataType: "JSON",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (feedback){
                    if (feedback.result === "required"){
                        swal("Required!", feedback.msg, "error");
                    }else if (feedback.result === "exist"){
                        showFiles();
                        swal("File exist!", feedback.msg, "error");
                    }else if (feedback.result === "success"){
                        showFiles();
                        swal("Success!", feedback.msg, "success");
                    }else if (feedback.result === "error"){
                        swal("Error!", feedback.msg, "error");
                    }
                }
            })
        }
    });
    // Get id values
    function getIdValues(id){
        return document.getElementById(id).value;
    }
    // Show created folders
    function showFiles(){
        $.ajax({
            url: "folderfiles/loadfiles.php",
            type: "POST",
            success: function (feedback){
                $("#showFiles").html(feedback);
            }
        });
    }
    (function ($) {
        showFiles();
    })(jQuery)
</script>