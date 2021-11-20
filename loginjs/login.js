
$(document).ready(function (){
    $("#show_got_password").hide();
    $("#showlogin").on("click", function (){
        $("#show_got_password").hide();
        $("#show_login").show();
    });
    $("#showforgetpassword").on("click", function (){
        $("#show_got_password").show();
        $("#show_login").hide();
    });



    document.getElementById("recover-password").addEventListener("submit", function (e){
        e.preventDefault();
        let useremail = getIdValues("useremail");
        alert("user email: "+useremail);
    });

});
function getIdValues(id){
    return document.getElementById(id).value;
}