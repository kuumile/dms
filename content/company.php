<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Register Company</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Manage</li>
                <li class="breadcrumb-item active">Company</li>
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
                <h3><i class="fa fa-institution"></i> Register Company</h3>
            </div>

            <div class="card-body">
                <form name="companyForm" id="companyForm" action="#">
                    <div class="form-group">
                        <label for="institute">Company/Institution</label>
                        <input type="text" class="form-control form-control-sm" name="institute" id="institute">
                    </div>
                    <div class="form-group">
                        <label for="institute">Town/City</label>
                        <input type="text" class="form-control form-control-sm" name="city" id="city">
                    </div>
                    <div class="form-group">
                        <label for="institute">Location</label>
                        <input type="text" class="form-control form-control-sm" name="location" id="location">
                    </div>
                    <div class="form-group">
                        <label for="institute">Address</label>
                        <input type="text" class="form-control form-control-sm" name="address" id="address">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-institution"></i> Registered Company</h3>
            </div>

            <div class="card-body table-responsive" id="registeredcompany">

            </div>
        </div>
    </div>
</div>
<script>
    $(function (){
       displayCompany();
    });
    document.getElementById("companyForm").addEventListener("submit", function (e){
        e.preventDefault();
        let institute = getID("institute"),
            city = getID("city"),
            location = getID("location"),
            address = getID("address");
        if (institute.length < 1){
            $("#institute").focus();
            swal("Required!", "Company/Institution is required!", "error");
        }else{
            $.ajax({
                url: "company/savecompany.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    res: 1,
                    institute: institute,
                    city: city,
                    location: location,
                    address: address
                },
                success: function (feedback){
                    if (feedback.result === "success"){
                        displayCompany();
                        $("#institute").val("");
                        $("#city").val("");
                        $("#location").val("");
                        $("#address").val("");
                        swal("Success!", feedback.msg, "success");
                    }else if (feedback.result === "error"){
                        swal("Error!", feedback.msg, "error");
                    }
                }
            })
        }
    })

    function getID(id){
        return document.getElementById(id).value;
    }

    function displayCompany(){
        $.ajax({
            url: "company/registeredcompany.php",
            type: "POST",
            data: {
                res: 1
            },
            success: function (feedback){
                $("#registeredcompany").html(feedback);
            }
        })
    }
</script>