(function($){
    // #initial
    $("#content").load("content/dashboard.php");
    // handle menu clicks
    $("ul li.submenu a").click(function(){
        //e.preventDefault();
        let page = $(this).attr("href");
        $("#content").load("content/" + page + ".php");
        return false;
    });

})(jQuery);








