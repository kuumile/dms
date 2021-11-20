<div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder">
													<h1 class="main-title float-left">User Account</h1>
													<ol class="breadcrumb float-right">
														<li class="breadcrumb-item">Manage</li>
														<li class="breadcrumb-item active">User Account</li>
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
												<h3><i class="fa fa-user-secret"></i> Add New User</h3>
											</div>

											<div class="card-body">
                                        <form id="user_form" method="post" enctype="multipart/form-data">
                                            <input type="hidden" id="userid" name="userid">
                                            <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="userfname">First Name</label>
                                                <input type="text" name="userfname" id="userfname" class="form-control form-control-sm">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="userlname">Last Name</label>
                                                <input type="text" name="userlname" id="userlname" class="form-control form-control-sm">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="useremail">Valid Email</label>
                                                <input type="text" name="useremail" id="useremail" class="form-control form-control-sm">
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="userpassword">Password</label>
                                                <input type="password" name="userpassword" id="userpassword" class="form-control form-control-sm">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="userrole">Role</label>
                                                <select class="form-control form-control-sm" id="userrole" name="userrole">
                                                    <option value="">Select Role</option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="User">User</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="active">Active</label>
                                                <select class="form-control form-control-sm" id="active" name="active">
                                                    <option value="">Select Role</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="file">Passport Image</label>
                                                <input type="file" name="file" id="file" class="form-control form-control-sm">
                                            </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" id="saveuser" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Create Account</button>
                                                <button type="submit" id="updateuser" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Update Account</button>
                                                <button type="reset" onclick="ResetForm()" class="btn btn-secondary btn-sm"><i class="fa fa-refresh"></i> Reset Account</button>
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
												<h3><i class="fa fa-list"></i> List of Registered Accounts</h3>
											</div>

											<div class="card-body table-responsive" id="showusers">



											</div>
											<div class="card-footer small text-muted"></div>
										</div><!-- end card-->
									</div>

							</div>
							<!-- end row -->

<script>

        $("#updateuser").hide();

    // Save user records to database table
    $("#user_form").on("submit", function (e){
        e.preventDefault();
        let fname = getIdValues('userfname'),
            lname = getIdValues('userlname'),
            email = getIdValues('useremail'),
            userpass = getIdValues('userpassword'),
            role = getIdValues('userrole'),
            active = getIdValues('active');
        if (fname.length < 1){
            $("#userfname").focus();
            swal("Required!", "First Name is required!", "error");
        }else if (lname.length < 1){
            $("#userlname").focus();
            swal("Required!", "Last Name is required!", "error");
        }else if(email.length < 1){
            $("#useremail").focus();
            swal("Required!", "Email is required!", "error");
        }else if (userpass.length < 1){
            $("#userpassword").focus();
            swal("Required!", "Password is required!", "error");
        }else if (role.length < 1){
            $("#userrole").focus();
            swal("Required!", "Select Role is required!", "error");
        }else if (active.length < 1){
            $("#active").focus();
            swal("Required!", "Select Active is required!", "error");
        }else{
            $.ajax({
                url: "useraccount/saveaccount.php",
                type: "POST",
                dataType: "JSON",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (feedback){
                    if (feedback.result === 'success'){
                        getUserData();
                        swal("Success!", feedback.msg, "success");
                    }else if (feedback.result === 'userexist'){
                        swal("Infomation!", feedback.msg, "info");
                    }else if (feedback.result === 'error'){
                        swal("Error!", feedback.msg, "error");
                    }else if (feedback.result === 'exist'){
                        swal("Information!", feedback.msg, "info");
                    }

                }
            })
        }
    })

// get form values by id from user form
    function getIdValues(id){
        return document.getElementById(id).value;
    }

// Fetch Data from user table
    function getUserData(){
        $.ajax({
            url: "useraccount/loadusers.php",
            type: "POST",
            async: "true",
            success: function (feedback){
                $("#showusers").html(feedback);
            }
        });
    }

    (function ($) {

        getUserData();
    })(jQuery);

function ResetForm() {
    $("#updateuser").hide();
    $("#saveuser").show();
}


    // START CODE Show / hide columns dynamically DATA TABLE
    $(document).ready(function() {
         $('#example3').DataTable( {
            "scrollY": "350px",
            "paging": false
        } );


    } );
    // END CODE Show / hide columns dynamically DATA TABLE
</script>