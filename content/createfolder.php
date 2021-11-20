<?php
?>
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Folders</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Manage</li>
                <li class="breadcrumb-item active">Folders</li>
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
            <h3><i class="fa fa-folder"></i> Manage Folders</h3>
        </div>

        <div class="card-body">
            <form id="createFolderForm" method="post">
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foldername">Folder Name</label>
                    <input type="text" name="foldername" id="foldername" class="form-control form-control-sm">
                </div>
                <div class="form-group col-md-6">
                    <label for="folderdesc">Folder Description</label>
                    <input type="text" name="folderdesc" id="folderdesc" class="form-control form-control-sm">
                </div>
                </div>
                <div class="form-group text-center">
                    <button type="button" id="savefolder" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Create Folder</button>
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
            <h3><i class="fa fa-folder"></i> Manage Folders</h3>
        </div>

        <div class="card-body" id="showfolder">

        </div>
        <div class="card-footer small text-muted">

        </div>
    </div><!-- end card-->
</div>
</div>
<script>
    // Create and save folder
    $("#savefolder").on("click", function (){
        let foldername = getIdValues('foldername'),
            folderdesc = getIdValues('folderdesc');
        if (foldername.length < 1){
            $("#foldername").focus();
            swal("Required!", "Folder Name is required!", "error");
        }else{
            $.ajax({
                url: "folderfiles/savefolder.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    res: 1,
                    foldername: foldername,
                    folderdesc: folderdesc
                },
                success: function (feedback){
                    if (feedback.result === "success") {
                        showFolders();
                        swal("Success!", feedback.msg, "success");
                    }else if (feedback.result === "error"){
                        swal("Error!", feedback.msg, "error");
                    }else if (feedback.result === "exist"){
                        swal("File exist!", feedback.msg, "error");
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
    function showFolders(){
        $.ajax({
            url: "folderfiles/loadfolder.php",
            type: "POST",
            success: function (feedback){
                $("#showfolder").html(feedback);
            }
        })
    }
    (function ($) {
        showFolders();
    })(jQuery);
</script>