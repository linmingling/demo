/**
 *@author borey
 *@date 2016/1/3
 *@QQ 475773037
 */
window.onload = init;
var mSwiper;
var isSound;
function init() {
    OnElementFun("Sound_bg", function () {
        isSound = true;
        document.getElementById("Sound_bg").play();
    })
    mSwiper = new Swiper(".swiper-container", {
        direction: "vertical",
        updateOnImagesReady: true,
        onImagesReady: onLoadComplete,
        onInit: initScene,
        onSlideChangeEnd: onChangeEnd,
        onSlideChangeStart:onChangeStart
    });
}

function initScene(swiper) {
    initEvent();
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
}

function onLoadComplete() {
    $("#LoadModule").hide();
}

function onChangeStart(swiper){
    if(swiper.activeIndex!=0){
        $("#ColorModule").fadeIn();
    }else{
        $("#ColorModule").fadeOut();
    }
}

function onChangeEnd(swiper) {
    swiperAnimate(swiper);
    $(".Btn_bg").removeClass("BgAni");
    if(swiper.activeIndex==9){
        window.setTimeout(function(){
            $(".Btn_bg").addClass("BgAni");
        },1800);
    }
}

function initEvent() {
    $("#Btn_back").on("click", onMenuHandler);
    $("#Btn_law").on("click", onMenuHandler);
    $("#Mc_QRcode2").on("click", onMenuHandler);
    $("#Btn_sound").on("click", onMenuHandler);
}

function onMenuHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_back":
            window.location.href = "http://zt.jia360.com/qmjjg_zj/index.php?from=timeline&isappinstalled=0";
            break;
        case "Btn_law":
            $("#Mc_QRcode2").fadeIn();
            break;
        case "Mc_QRcode2":
            $("#Mc_QRcode2").fadeOut();
            break;
        case "Btn_sound":
            if (isSound) {
                isSound = false;
                $("#Sound_bg")[0].pause();
                $("#Btn_sound").removeClass("SoundAni");
                $("#Btn_sound").attr({src: "images/Btn_sound2.png"});
            } else {
                isSound = true;
                $("#Sound_bg")[0].play();
                $("#Btn_sound").addClass("SoundAni");
                $("#Btn_sound").attr({src: "images/Btn_sound1.png"});
            }
            break;
    }
}

function OnElementFun(obj, fun) {
    document.getElementById(obj).addEventListener('click', function () {
        fun();
    })
    var e = document.createEvent("MouseEvents");
    e.initEvent('click', true, true);
    document.getElementById(obj).dispatchEvent(e);
}