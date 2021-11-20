<?php
include "../config/config.php";
$conn = Database::getConnection();
?>
<table class="table table-hover table-bordered table-responsive-sm table-sm">
    <thead>
    <tr>
        <th>S/N</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
<?php
$select = $conn->query("select * from useraccount");
if ($select->num_rows < 1){
    ?>
    <tr><td colspan='7' class='text-center'>No user available</td></tr>
<?php
}else{
    //$rec = [];
    $count = 0;
    while($row = $select->fetch_array()){
        ?>
        <tr>
            <td><?php echo ++$count; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['active']; ?></td>
            <td>
                <a role="button" id="<?php echo $row['uid']; ?>" class="text-primary edituser"><i class="fa fa-edit"></i></a>
                <a role="button" class="text-danger deleteuser" id="<?php echo $row['uid']; ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
<?php
    }
}
?>
    </tbody>
</table>

<script>

        // Delete user account records
        $('.deleteuser').on('click',function (e) {
            e.preventDefault();
                        let editid = $(this).attr('id');
                        $.ajax({
                            url: "useraccount/deleteuser.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                editid: editid
                            },
                            success: function (feedback){
                                if (feedback.result === 'success'){
                                    getUserData();
                                    swal(feedback.msg, {
                                        icon: "success",
                                    });
                                }
                            }
                        })
        })
        // Delete user account records
        $('.edituser').on('click',function (e) {
            e.preventDefault();
                        let editid = $(this).attr('id');
                        $.ajax({
                            url: "useraccount/edituser.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                editid: editid
                            },
                            success: function (feedback){
                                $("#saveuser").hide();
                                $("#updateuser").show();
                                $("#userid").val(feedback.uid);
                                $("#userfname").val(feedback.fname);
                                $("#userlname").val(feedback.lname);
                                $("#useremail").val(feedback.email);
                                $("#userpassword").val(feedback.pass);
                                $("#userrole").val(feedback.role);
                                $("#active").val(feedback.active);
                            }
                        })
        });

</script>