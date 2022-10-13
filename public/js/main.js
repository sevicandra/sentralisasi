$('#content-toggle').click(function(){
    if ($('.content-toggle').css('display')=== "none") {
        $('.content-toggle').css("display","grid");
        $('#content-aside-toggle-ico').attr("src", "/img/ico/toggle-active.png");
    }else{
        $('.content-toggle').css("display","none");
        $('#content-aside-toggle-ico').attr("src", "/img/ico/toggle-inactive.png");
    }
});

$('#content-toggle-offzone').click(function(){
        $('.content-toggle').css("display","none");
        $('#content-aside-toggle-ico').attr("src", "/img/ico/toggle-inactive.png");

});

window.addEventListener('resize', function(event){
    $(window).resize(function() {
        $('.content-toggle').css("display","none");
        $('#content-aside-toggle-ico').attr("src", "/img/ico/toggle-inactive.png");
    });
    
});