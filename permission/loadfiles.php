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
<table class="table table-sm table-borderless">
    <thead>
    <tr>
        <th>Name</th>
        <th>Date modified</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $findfiles = $conn->query("select * from files where folderid = '$folderid'");
    if ($findfiles->num_rows < 1){
        ?>
        <tr>
            <td colspan="3">No file available</td>
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
        <td colspan="5" id="sharedWith" style="border-top-left-radius: 1em; -moz-border-top-left-radius: 1em; -o-border-top-left-radius: 1em; -ms-border-top-left-radius: 1em;border-top-right-radius: 1em; -moz-border-top-right-radius: 1em; -o-border-top-right-radius: 1em; -ms-border-top-right-radius: 1em;"></td>
    </tr>
            <tr>
                <td><?php echo $filename; ?></td>
                <td>
                    <?php echo $uploaddate; ?>
                </td>
                <td>
                    <button type="button" href="#shareFileModal" id="<?php echo $fileid ?>" name="<?php echo $folderid ?>" class="btn btn-outline-primary btn-sm text-sm shareFiles" data-target="#shareFileModal" data-toggle="modal"><i class="fa fa-share"></i> Share</button>
                </td>
            </tr>
            <tr class="bg-info">
                <td colspan="5" id="sharedWith" style="border-bottom-left-radius: 1em; -moz-border-bottom-left-radius: 1em; -o-border-bottom-left-radius: 1em; -ms-border-bottom-left-radius: 1em;border-bottom-right-radius: 1em; -moz-border-bottom-right-radius: 1em; -o-border-bottom-right-radius: 1em; -ms-border-bottom-right-radius: 1em;">
                    <?php
                    $selshare = $conn->query("select * from permission where uid = '$userid' and fileid = '$fileid'");
                    if ($selshare->num_rows < 1){}else{
                        while($rowz = $selshare->fetch_array()){
                            $person = $rowz['sharedid'];
                            $getperson = $conn->query("select * from useraccount where uid = '$person'");
                            if ($getperson->num_rows < 1){}else{
                                $rop = $getperson->fetch_array();
                                $fulln = $rop['fname']." ".$rop['lname'];
                                ?>
                    <span class="badge badge-light small"><i class="fa fa-share-alt-square"></i> <?php echo $fulln; ?></span>
                    <?php
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade custom-modal" id="shareFileModal" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <fieldset><legend>File sharing permission</legend>
                    <div class="row">
                        <input type="hidden" value="" id="sid" name="sid">
                        <input type="hidden" value="" id="fid" name="fid">
                        <div class="form-group col-md-6">
                            <label>Copy</label>
                            <span><i class="fa fa-copy"></i> <input type="checkbox" name="copy" id="copy"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Download</label>
                            <span><i class="fa fa-download"></i> <input type="checkbox" name="download" id="download"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>View</label>
                            <span><i class="fa fa-eye"></i> <input type="checkbox" name="view" id="view"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Person</label>
                        <select name="person" id="person" class="form-control form-control-sm">
                            <option value=""></option>
                            <?php
                            $getuser = $conn->query("select * from useraccount where uid != '$userid'");
                            if ($getuser->num_rows < 1){}else{
                                while($ror = $getuser->fetch_array()){
                                    $uids = $ror['uid'];
                                    $full = $ror['fname']." ".$ror['lname'];
                                    ?>
                                    <option value="<?php if (!empty($uids)) {
                                        echo $uids;
                                    } ?>"><?php echo $full; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </fieldset>

                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary colse" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary shareFile">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){

        $(".shareFiles").on("click", function (){
            let id = $(this).attr("id"),
                foldid = $(this).attr("name");
                $("#sid").val(id);
                $("#fid").val(foldid);
        })

        $(".shareFile").on("click", function (){
            let person = $("#person").val(),
                sid = $("#sid").val(),
                fid = $("#fid").val(),
                copy = $("#copy").is(":checked");
            let download = $("#download").is(":checked"),
                view = $("#view").is(":checked");
            if (person.length < 1){
                swal("Empty Field!", 'Select person to share file with', "error");
            }else {
                $.confirm({
                    title: 'Share File',
                    content: 'You are about to share this file with another person. Dow you want to continue with this?',
                    buttons: {
                        Yes: function () {
                            $.ajax({
                                url: "permission/saveshare.php",
                                type: "POST",
                                dataType: "JSON",
                                data: {
                                    res: 1,
                                    download: download,
                                    view: view,
                                    person: person,
                                    copy: copy,
                                    sid: sid,
                                    fid: fid
                                },
                                success: function (feedback) {
                                    if (feedback.result === "success") {

                                        swal("Success!", feedback.msg, "success");
                                    } else if (feedback.result === "error") {
                                        swal("Error!", feedback.msg, "error");
                                    } else if (feedback.result === "exist") {

                                        swal("Info!", feedback.msg, "info");
                                    }
                                }
                            })
                        },
                        No: function () {

                        }
                    }
                })
            }
        })



    })


</script>