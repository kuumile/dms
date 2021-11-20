<?php
include "../config/config.php";
$conn = Database::getConnection();
session_start();
$userID = $_SESSION['userId'];
?>
<table>

<?php
$loadfolder = $conn->query("select * from folders where uid='$userID'");
if ($loadfolder->num_rows < 1){
    ?>
<tr>
    <td class="text-center" colspan="4">No records available</td>
</tr>
<?php
}else{
    //$count = 0;
    while ($row = $loadfolder->fetch_array()){
        $folderid = $row['id'];
        ?>
    <thead>
        <tr class="bg-info">
            <td><span class="fa fa-folder"></span></td>
            <th><?php echo $row['foldername']; ?></th>
            <th><?php echo $row['folderdesc']; ?></th>
        </tr>
    </thead>
        <tbody>
        <td colspan="3">
        <?php
        $fold = $conn->query("select * from files where folderid = '$folderid'");
        if ($fold->num_rows < 1){}else{
            ?>
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
            while($rox = $fold->fetch_array()){
                $ext = $rox['extension'];
                $filename = $rox['filename'];
                $filesize = $rox['filesize'];
                $date = $rox['uploaddate'];
                $fileid = $rox['id'];
            ?>
        <tr class="font-italic">
            <td>
                <?php echo $filename; ?>
            </td>
            <td>
                <?php echo $filesize; ?>
            </td>
            <td>
                <?php echo $date; ?>
            </td>
            <td>
                <a role="button" href="#" class="text-danger deletefile" id="<?php echo $fileid; ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php
            }
            ?>
                </tbody>
            </table>
                <?php
        }
    }
}

        ?>
        </td>
        </tbody>
</table>
<script>
    $(".deletefile").on('click', function (e){
        e.preventDefault();
        let delid = $(this).attr('id');
        $.confirm({
            title: 'Delete Action',
            content: 'Are you sure you want to delete this File? This will delete files permanently?',
            buttons: {
                Yes: function(){
        $.ajax({
            url: "folderfiles/deletefiles.php",
            type: "POST",
            dataType: "JSON",
            data: {
                delid: delid
            },
            success: function (feedback){
                if (feedback.result === "success"){
                    showFiles();
                    swal("Success!", feedback.msg, "success");
                }else if (feedback.result === "error"){
                    swal("Error!", feedback.msg, "error");
                }else if (feedback.result === "exist"){
                    showFiles();
                    swal("Info!", feedback.msg, "info");
                }
            }
        })
                },
                No: function(){

                }
            }
        })
    });

    // START CODE Show / hide columns dynamically DATA TABLE
    $(document).ready(function() {
        $('#foldertables').DataTable( {
            "scrollY": "350px",
            "paging": false
        } );



    } );
    // END CODE Show / hide columns dynamically DATA TABLE
</script>