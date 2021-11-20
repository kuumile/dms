<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
$userID = ($_SESSION['userId'] ?? '');
?>
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Files permission</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Manage</li>
                <li class="breadcrumb-item active">Files permission</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->



<!-- end row -->
<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-folder"></i> Manage Files Permission</h3>
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
                                <li data-jstree='{"opened":false}' class="showitems" id="<?php echo $folderId; ?>"><?php echo $foldname; ?>
<!--                                    <ul>-->
<!--                                        --><?php
//                                        $alovalfiles = $conn->query("select * from files where folderid = '$folderId'");
//                                        if ($alovalfiles->num_rows < 1){}else{
//                                            while($rec = $alovalfiles->fetch_array()){
//                                                $filename = $rec['filename'];
//                                                $ext = $rec['extension'];
//                                                $fid = $rec['id'];
//                                                ?>
<!--                                                <li data-jstree='--><?php //if ($ext == "doc" or $ext == "docx"){ echo '{"icon":"fa fa-file-word-o","type":"file"}'; }else if ($ext == "xls" or $ext == "xlsx"){ echo '{"icon":"fa fa-file-excel-o","type":"file"}'; }else if ($ext == "ppt" or $ext == "pptx"){ echo '{"icon":"fa fa-file-powerpoint-o","type":"file"}'; }else if ($ext == "pdf"){ echo '{"icon":"fa fa-file-pdf-o","type":"file"}'; }else if ($ext == "jpg" or $ext == "jpeg" or $ext == "JPG" or $ext == "JPEG" or $ext == "gif" or $ext == "GIF" or $ext == "png" or $ext == "PNG" or $ext == "bmp" or $ext == "BMP"){ echo '{"icon":"fa fa-file-image-o","type":"file"}'; }else{ echo '{"type":"file"}'; } ?><!--'><a role="button">--><?php //echo $filename; ?><!--</a></li>-->
<!--                                                --><?php
//                                            }
//                                        }
//                                        ?>
<!--                                    </ul>-->
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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-folder"></i> Manage Folders/Files</h3>
            </div>

            <div class="card-body table-responsive" id="showfilepermission">

            </div>
            <div class="card-footer small text-muted">

            </div>
        </div><!-- end card-->
    </div>
    <script>
        $( document ).ready(function() {
            // Basic
            $('#simpleTree').jstree({
                'core' : {
                    'themes' : {
                        'responsive': false
                    }
                },
                'types' : {
                    'default' : {
                        'icon' : 'fa fa-folder-open'
                    },
                    'file' : {
                        'icon' : 'fa fa-file'
                    }
                },
                'plugins' : ['types']
            });

            // Checkbox
            // $('#checkboxesTree').jstree({
            //     'core' : {
            //         'themes' : {
            //             'responsive': false
            //         }
            //     },
            //     'types' : {
            //         'default' : {
            //             'icon' : 'fa fa-folder'
            //         },
            //         'file' : {
            //             'icon' : 'fa fa-file'
            //         }
            //     },
            //     'plugins' : ['types', 'checkbox']
            // });

            // Drag & Drop
            // $('#dragdropTree').jstree({
            //     'core' : {
            //         'check_callback' : true,
            //         'themes' : {
            //             'responsive': false
            //         }
            //     },
            //     'types' : {
            //         'default' : {
            //             'icon' : 'fa fa-folder'
            //         },
            //         'file' : {
            //             'icon' : 'fa fa-file'
            //         }
            //     },
            //     'plugins' : ['types', 'dnd']
            // });

        });
    </script>
</div>
<!-- end row -->

<script>

    $(document).ready(function () {
        $(".showitems").click("click", function (){
            let id = $(this).attr("id");
            $.ajax({
                url: "permission/loadfiles.php",
                type: "POST",
                data: {
                    res: 1,
                    id: id
                },
                success: function (feedback){
                    $("#showfilepermission").html(feedback);
                }
            })
        })


    });


    // START CODE Show / hide columns dynamically DATA TABLE
    $(document).ready(function() {
        $('#example3').DataTable( {
            "scrollY": "350px",
            "paging": false
        } );



    } );
    // END CODE Show / hide columns dynamically DATA TABLE
</script>