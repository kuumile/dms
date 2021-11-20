<?php
include "../config/config.php";
$conn = Database::getConnection();
?>
<table class="table table-sm" id="foldertable">
    <thead>
    <tr>
        <th></th>
        <th>Folder Name</th>
        <th>Folder Description</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
<?php
$loadfolder = $conn->query("select * from folders");
if ($loadfolder->num_rows < 1){
    ?>
<tr>
    <td class="text-center" colspan="4">No records available</td>
</tr>
<?php
}else{
    //$count = 0;
    while ($row = $loadfolder->fetch_array()){
        ?>
        <tr>
            <td><span class="fa fa-folder"></span></td>
            <td><?php echo $row['foldername']; ?></td>
            <td><?php echo $row['folderdesc']; ?></td>
            <td><a role="button" href="#" id="<?php echo $row['id']; ?>"  class="text-danger deletefolder"><i class="fa fa-trash"></i> Delete</a></td>
        </tr>
        <?php
    }
}

?>
    </tbody>
</table>
<script>
    $(".deletefolder").on('click', function (e){
        e.preventDefault();
        let delid = $(this).attr('id');
        $.confirm({
            title: 'Delete Action',
            content: 'Are you sure you want to delete this Folder? This will also delete files inside the folder?',
            buttons: {
                Yes: function(){
        $.ajax({
            url: "folderfiles/deletefolder.php",
            type: "POST",
            dataType: "JSON",
            data: {
                delid: delid
            },
            success: function (feedback){
                if (feedback.result === "success"){
                    showFolders();
                    swal("Success!", feedback.msg, "success");
                }else if (feedback.result === "error"){
                    swal("Error!", feedback.msg, "error");
                }else if (feedback.result === "exist"){
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
        $('#foldertable').DataTable( {
            "scrollY": "350px",
            "paging": false
        } );



    } );
    // END CODE Show / hide columns dynamically DATA TABLE
</script>