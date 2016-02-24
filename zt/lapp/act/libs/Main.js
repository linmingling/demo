/**
 *@author borey
 *@date 2015/12/11
 *@QQ 475773037
 */
window.onload = init;
var mSwiper;
var mIndex=0;
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
        onSlideChangeEnd: onChangeEnd
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

function onChangeEnd(swiper) {
    swiperAnimate(swiper);
}

function initEvent() {
    $(".P9_show").on("click", function () {
        window.location.href = "http://group.yoju360.com/phone/zhan/fyinvite/9/index.htm?from=jiaju03";
    })
    $(".P10_show2").on("click",function(){
        window.location.href = "http://zt.jia360.com/qmjjg_zj/index.php?from=groupmessage&isappinstalled=0";
    })
    $("#Btn_sound").on("click", onClickHandler);
}

function onClickHandler(e) {
    switch (e.currentTarget.id) {
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