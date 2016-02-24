/**
 *@author borey
 *@date 2015/12/7
 *@QQ 475773037
 */
var mSwiper;
var isSound;
window.onload = init();
function init() {
    OnElementFun("Sound_bg", function () {
        isSound = true;
        document.getElementById("Sound_bg").play();
    })
    mSwiper = new Swiper('.swiper-container', {
        direction: "vertical",
        updateOnImagesReady: true,
        onImagesReady: onLoadComplete,
        onInit: initScene,
        onSlideChangeEnd: onChangeEnd
    });
    var mSwiper2 = new Swiper("#P2_swiper", {
        direction: "horizontal",
        updateOnImagesReady: true,
        resistanceRatio: 0,
        prevButton: "#P2_swiper .swiper-button-prev",
        nextButton: "#P2_swiper .swiper-button-next"
    });
    var mSwiper3 = new Swiper("#P3_swiper", {
        direction: "horizontal",
        updateOnImagesReady: true,
        resistanceRatio: 0,
        prevButton: "#P3_swiper .swiper-button-prev",
        nextButton: "#P3_swiper .swiper-button-next"
    });
    var mSwiper4 = new Swiper("#P5_swiper", {
        direction: "horizontal",
        updateOnImagesReady: true,
        resistanceRatio: 0,
        prevButton: "#P5_swiper .swiper-button-prev",
        nextButton: "#P5_swiper .swiper-button-next"
    });
}

function initScene(swiper) {
    initEvent();
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
}

function initEvent() {
    $("#Btn_sound").on("click", onClickHandler);
    $("#Btn_jd").on("click", onMenuHandler);
    $("#P9_show").on("click", onMenuHandler);
    $("#Mc_law").on("click",onMenuHandler);
}

function onMenuHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_jd":
            window.location.href = "http://landbond.jd.com/";
            break;
        case "P9_show":
            window.location.href = "http://item.jd.com/1693285502.html";
            break;
        case "Mc_law":
            if($("#Mc_code").css("display")=="none"){
                $("#Mc_code").fadeIn();
            }else{
                $("#Mc_code").fadeOut();
            }
            break;
    }
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

function onLoadComplete() {
    $("#LoadModule").hide();
}

function onChangeEnd(swiper) {
    swiperAnimate(swiper);
}

function OnElementFun(obj, fun) {
    document.getElementById(obj).addEventListener('click', function () {
        fun();
    })
    var e = document.createEvent("MouseEvents");
    e.initEvent('click', true, true);
    document.getElementById(obj).dispatchEvent(e);
}