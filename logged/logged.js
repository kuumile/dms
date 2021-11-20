
$(document).ready(function (){
    let userid = sessionStorage.getItem("userId");
    if (sessionStorage.getItem("userId") === null){
        window.location = "index.html";
    }else{
        $.ajax({
            url: "activeuser/activeuser.php",
            type: "POST",
            dataType: "JSON",
            data: {
                res: 1,
                userid: userid
            },
            success: function (feedback){
                $("#userimage").html(feedback.userimage);
                $("#welcomeuser").html("Hello, "+feedback.fullname);
                if (feedback.url === "index.html"){
                    window.location = feedback.url;
                }
            }
        });
    }

});