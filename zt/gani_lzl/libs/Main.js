/**
 *@author borey
 *@date 2015/12/1
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */
window.onload = init();
var mSwiper;
var isSound;
function init() {
    OnElementFun("Sound_bg", function () {
        isSound=true;
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

function initEvent() {
    $("#Btn_menu1").on("click", onMenuHandler);
    $("#Btn_menu2").on("click", onMenuHandler);
    $("#Btn_menu3").on("click", onMenuHandler);
    $("#Btn_menu4").on("click", onMenuHandler);
    $("#Btn_menu5").on("click", onMenuHandler);
    $("#Btn_menu6").on("click", onMenuHandler);
    $("#Mc_content").on("click", onClickHandler);
    $("#Btn_sound").on("click", onClickHandler);
    touch.on(".InfoBox", "swipeleft", function (ev) {
        $(ev.currentTarget).find(".TxtBoxL").fadeOut();
        $(ev.currentTarget).find(".TxtBoxR").fadeIn();
        $(ev.currentTarget).find(".Btn_left img").attr({src: "images/Btn_left1.png"});
        $(ev.currentTarget).find(".Btn_right img").attr({src: "images/Btn_right2.png"});
    });
    touch.on(".InfoBox", "swiperight", function (ev) {
        $(ev.currentTarget).find(".TxtBoxR").fadeOut();
        $(ev.currentTarget).find(".TxtBoxL").fadeIn();
        $(ev.currentTarget).find(".Btn_left img").attr({src: "images/Btn_left2.png"});
        $(ev.currentTarget).find(".Btn_right img").attr({src: "images/Btn_right1.png"});
    });
}


function onClickHandler(e) {
    switch (e.currentTarget.id) {
        case "Mc_content":
            $("#Mc_content").hide();
            break;
        case "Btn_sound":
            if (isSound) {
                isSound = false;
                $("#Sound_bg")[0].pause();
                $("#Btn_sound").removeClass("SoundAni");
                $("#Btn_sound").attr({src:"images/Btn_sound2.png"});
            } else {
                isSound = true;
                $("#Sound_bg")[0].play();
                $("#Btn_sound").addClass("SoundAni");
                $("#Btn_sound").attr({src:"images/Btn_sound1.png"});
            }
            break;
    }
}

function onMenuHandler(e) {
    $("#Mc_content").css({display: "-webkit-box"});
    var mIndex = (e.currentTarget.id).substr(-1);
    $("#Mc_content img").attr({src: "images/Mc_show" + mIndex + ".jpg"})
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