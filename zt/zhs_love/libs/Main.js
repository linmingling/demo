/**
 *@author borey
 *@date 2015/11/26
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */
var mSwiper;
var isSound;
if (MenuIndex > 0 && MenuIndex < 5) {
    //$("#Mc_bg_content").attr("src", "images/Mc_bg_content" + MenuIndex + ".jpg");
    //$("#Mc_tit img").attr("src", "images/Mc_tit" + MenuIndex + ".png");
    //$("#Mc_txt_Fir img").attr("src", "images/Mc_txt_Fir" + MenuIndex + ".png");
    //$("#Mc_txt_Sec img").attr("src", "images/Mc_txt_Sec" + MenuIndex + ".png");
    //$("#Mc_txt_Thr img").attr("src", "images/Mc_txt_Thr" + MenuIndex + ".png");
    //$("#Mc_txt_Fou img").attr("src", "images/Mc_txt_Fou" + MenuIndex + ".png");
}
$("#Txt_user").html(UserName + "的礼物");
var cutY = window.innerHeight - 1136;
$("#Mc_logo").css({top: Math.ceil(50+cutY / 8) + "px"});
$("#Ani_arrow").css({top: Math.ceil(985 + cutY / 1.8) + "px"});
$("#Mc_gift_p4").css({top:Math.ceil(cutY / 1.8) + "px"});
$("#PrintBox").css({top: Math.ceil(880 + cutY / 1.8) + "px"});
$("#RuleBox").css({height:Math.ceil(770*(1+cutY/1136))+"px"});
$("#Btn_share").css({top: Math.ceil(955 + cutY / 1.8) + "px"});
$("#MenuBox").css({top:Math.ceil(cutY / 5) + "px"});
window.onload = init();
function init() {
    OnElementFun("Sound_bg", function () {
        isSound = true;
        $("#Sound_bg")[0].play();
    })
    mSwiper = new Swiper('.swiper-container', {
        direction: 'horizontal',
        updateOnImagesReady: true,
        onImagesReady: onLoadComplete,
        onInit: initStage,
        noSwiping: true,
        onSlideChangeEnd: onChangeEnd,
        onSlideChangeStart: onChangeStart
    });
}

function initStage(swiper) {
    initEvent();
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
}

function initEvent() {
    $("#Btn_menu1").on('click', onClickHandler);
    $("#Btn_menu2").on('click', onClickHandler);
    $("#Btn_menu3").on('click', onClickHandler);
    $("#Btn_menu4").on('click', onClickHandler);
    $("#Btn_fingerprint").on('click', onClickHandler);
    $("#Btn_share").on('click', onClickHandler);
    $("#ShareModule").on('click', onClickHandler);
    $("#Btn_sound").on("click", function () {
        if (isSound) {
            isSound = false;
            $("#Sound_bg")[0].pause();
            $("#Btn_sound").removeClass("SoundAni");
        } else {
            isSound = true;
            $("#Sound_bg")[0].play();
            $("#Btn_sound").addClass("SoundAni");
        }
    })
}

function onClickHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_menu1":
            $("#bgid").val(1);
            $("#ShareModule").css({display: "block"});
            break;
        case "Btn_menu2":
            $("#bgid").val(2);
            $("#ShareModule").css({display: "block"});
            break;
        case "Btn_menu3":
            $("#bgid").val(3);
            $("#ShareModule").css({display: "block"});
            break;
        case "Btn_menu4":
            $("#bgid").val(4);
            $("#ShareModule").css({display: "block"});
            break;
        case "Btn_fingerprint":
            if (mSwiper) {
                mSwiper.slideNext();
            }
            break;
        case "Btn_share":
            if (mSwiper) {
                mSwiper.slideNext();
            }
            break;
        case "ShareModule":
            $("#ShareModule").css({display: "none"});
            break;
    }
}

function onLoadComplete() {
    $("#LoadModule").css({display: "none"});
}

function onChangeEnd(swiper) {
    swiperAnimate(swiper);
}

function onChangeStart(swiper) {
    if (swiper.activeIndex == 7) {
        $("#RuleBox").animate({scrollTop: 0});
    }
    if (swiper.activeIndex == 6) {
        $("#Btn_fingerprint").bind("animationend", function () {
            $("#Mc_light").css({opacity: 1});
        });
    }
    if (swiper.activeIndex < 6) {
        $("#Ani_arrow").show();
    } else {
        $("#Ani_arrow").hide();
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

