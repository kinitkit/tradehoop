var mobileWidth = 1100;

/********************************************************************************/
/* MOBILE RESPONSIVE MENU                                                       */
/********************************************************************************/

$( document ).ready(function() {
    var screenSize = $(window).width();

    if (screenSize <= mobileWidth) {
        changeToMobile();
        
    }
    else {
        changeToDesktop();
    }
});

$(window).resize(function() {
    try{
        setBtnUserPosition();
    }catch(err){
    }

    if ($(window).width() < mobileWidth) {
        changeToMobile();
    }
    else {
        changeToDesktop();
    }
});

function changeToMobile(){
    $(".topNavigation").css("display","none");
    $(".socialGroup").css("display","none");
    
    $(".topNavigationMobile").css("display","block");
}

function changeToDesktop(){
    $(".topNavigation").css("display","block");

    $(".topNavigationMobile").css("display","none");
    $(".topNavigationMobileList").css("display","none");
}



/********************************************************************************/
/* BUTTON USER                                                                  */
/********************************************************************************/


$( document ).ready(function() {
    try{
        setBtnUserPosition();
    }catch(err){
    }

    var originalListHeight;
    originalListHeight  = $(".btnUserList").css("height");


    $(".btnUser").click(function(){
        if($(".btnUserList").css("height") == "0px" || $(".btnUserList").css("display") == "none"){
            $(".btnUserList").css("display","block");
            $(".btnUserList").css("height","0px");
            $(".btnUserList").animate({"height": originalListHeight}, 'fast');
            setTimeout(function() {}, 1000);
            state = 2;
        }else{
            $(".btnUserList").animate({"height": "0px"}, 'slow');
            $(".btnUserList").css("display","none");
        }
    });

    $(".btnUserList").mouseleave(function(){
        $(".btnUserList").animate({"height": "0px"}, 'slow');
        $(".btnUserList").css("display","none");
    });
});

function setBtnUserPosition(){
    var btnUser = $( ".btnUser:first" );
    var position = btnUser.position();
    var btnLeft = position.left;
    var btnHeight = $(".topNavigation").height();
    var btnWidth = $(".btnUser").width();

    $(".btnUserList").css("top", btnHeight);
    $(".btnUserList").css("left", btnLeft);
    $(".btnUserList").css("width",);
    $(".btnUserList").css("position", "absolute");
    $(".btnUserList ul").css("width", btnWidth);
}



/********************************************************************************/
/* CANCEL ALL                                                                   */
/********************************************************************************/
var state = 1;

$( document ).ready(function() {
    $("body").click(function(){
        /*if(state == 2){
            $(".btnUserList").css("display","none");
            state = 1;
        }*/
    });
});