<div class="row">
<?php
include "../config/config.php";
$conn = Database::getConnection();

$select  = $conn->query("select * from company");
if ($select->num_rows < 1){
    ?>
        <div class="col-md-12 text-center text-danger">No Company/Institution registered</div>
        <?php
}else{
    $row = $select->fetch_array();
    $id = $row['id'];
    $institute = $row['institute'];
    $city = $row['city'];
    $location = $row['location'];
    $address = $row['address'];
    ?>
<div class="form-group col-md-6">
    <label>Company/Institution</label>
    <div>
        <i class="fa fa-institution"></i> <?php if (!empty($institute)) {
            echo $institute;
        } ?>
    </div>
</div>
<div class="form-group col-md-6">
    <label>City/Town</label>
    <div>
        <i class="fa fa-city"></i> <?php if (!empty($city)) {
            echo $city;
        } ?>
    </div>
</div>
<div class="form-group col-md-6">
    <label>Location</label>
    <div>
        <i class="fa fa-location-arrow"></i> <?php if (!empty($location)) {
            echo $location;
        } ?>
    </div>
</div>
<div class="form-group col-md-6">
    <label>Address</label>
    <div>
        <i class="fa fa-address-book-o"></i> <?php if (!empty($address)) {
            echo $address;
        } ?>
    </div>
</div>
    <div class="form-group">
        <a role="button" id="<?php echo $id; ?>" class="btn btn-primary btn-sm editDetails"><i class="fa fa-edit"></i> Edit Details</a>
        <a role="button" id="<?php echo $id; ?>" class="btn btn-danger btn-sm deleteDetails"><i class="fa fa-trash"></i> Delete Details</a>
    </div>
<?php
}
?>
</div>
<script>
    $(function (){
        $(".editDetails").on("click", function (){
            let editid = $(this).attr("id");
            $.ajax({
                url: "company/edit.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    editid: editid
                },
                success: function (feedback){
                    $("#institute").val(feedback.institute);
                    $("#city").val(feedback.city);
                    $("#location").val(feedback.location);
                    $("#address").val(feedback.address);
                }
            });
        });

$(".deleteDetails").on("click", function (){
   let delid = $(this).attr("id");
    $.confirm({
        title: 'Delete Action',
        content: 'Are you sure you want to delete this records?',
        buttons: {
            Yes: function(){
                $.ajax({
                    url: "company/delete.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        delid: delid
                    },
                    success: function (feedback){
                        if (feedback.result === "success"){
                            displayCompany();
                            swal("Success!", feedback.msg, "success");
                        }else if (feedback.result === "error"){
                            swal("Error!", feedback.msg, "error");
                        }
                    }
                })
            },
            No: function(){

            }
        }
    })
});

    });

</script>