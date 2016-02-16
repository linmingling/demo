/**
 *@author borey
 *@date 2016/1/25
 *@QQ 475773037
 */
var sX, sY, sZ, lX, lY, lZ, lUpdate;
sX = sY = sZ = lX = lY = lZ = lUpdate = 0;
var mDir = 1;
var mSwiper;
var isOpen;
var Timer;
var isOver;
var mPer = 0;
var StartTime = 0;
var GamePer;
var GameScore = 0;
var GameCount = 0;
var bagLength = 20;
var bagInfo = {
    bag_1: {x: 40, y: 544},
    bag_2: {x: 88, y: 652},
    bag_3: {x: 98, y: 404},
    bag_4: {x: 223, y: 674},
    bag_5: {x: 164, y: 566},
    bag_6: {x: 166, y: 724},
    bag_7: {x: 213, y: 440},
    bag_8: {x: 325, y: 750},
    bag_9: {x: 337, y: 527},
    bag_10: {x: 293, y: 420},
    bag_11: {x: 412, y: 424},
    bag_12: {x: 456, y: 583},
    bag_13: {x: 378, y: 645},
    bag_14: {x: 446, y: 856},
    bag_15: {x: 386, y: 873},
    bag_16: {x: 541, y: 805},
    bag_17: {x: 552, y: 921},
    bag_18: {x: 541, y: 625},
    bag_19: {x: 500, y: 454},
    bag_20: {x: 233, y: 771}
}
var isSound;
window.onload = init;
function init() {
    if (isIOS()) {
        mDir = -1;
    }
    isOpen = false;
    OnElementFun("Sound_bg", function () {
        isSound = true;
        document.getElementById("Sound_bg").play();
    });
    mSwiper = new Swiper(".swiper-container", {
        direction: "vertical",
        updateOnImagesReady: true,
        onImagesReady: onLoadComplete,
        noSwiper: true,
        followFinger: true,
        effect: "fade",
        fade: {crossFade: false},
        noSwiping: true,
        onInit: initScene,
        //onSlideChangeEnd: onChangeEnd,
        onSlideChangeStart: onChangeStart
    });
    var parallax = new Parallax(document.getElementById('scene'));
}

function onChangeStart(swiper) {
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
    if (swiper.activeIndex == 1) {
        $("#LeafModule").css({display: "-webkit-box"});
    } else {
        $("#LeafModule").fadeOut();
    }
    if (swiper.activeIndex == 2) {
        $("#TipsModule").css({display: "-webkit-box"});
    }
}

function onLoadComplete() {
    $("#LoadModule").fadeOut();
}

function initScene(swiper) {
    window.setTimeout(function () {
        isOpen = true;
    }, 2000);
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
    setArtFont("Txt_per2", "font", 0);
    setArtFont("Txt_per1", "font", 0);
    setArtFont("Txt_per3", "fontR", 0);
    initEvent();
    initObj();
}

function initObj() {
    var blockStr = "";
    for (var i = 0; i < bagLength; i++) {
        blockStr += '<img src="images/Mc_bag' + Math.ceil(Math.random() * 2) + '.png" class="bag Mc_bag' + (i + 1) + '" style="position: absolute;left: ' + bagInfo["bag_" + (i + 1)].x + 'px;bottom: ' + bagInfo["bag_" + (i + 1)].y + 'px;"/>';
    }
    $("#BagBox").html(blockStr);
}

function fallObj(index) {
    if (index < 1 || index > bagLength)return;
    $(".Mc_bag" + index).tween({
        bottom: {
            start: bagInfo["bag_" + index].y,
            stop: -120,
            time: 0,
            units: 'px',
            duration: 2,
            effect: 'quartIn'
        }
    });
    $.play();
}

function updatePre(num) {
    if (isOver)return;
    if (GameScore == 100 || GameScore > 100)return;
    GameScore += num;
    mPer = Math.floor((GameScore / 100) * 100) + GamePer;
    setArtFont("Txt_per3", "fontR", mPer);
    if (mPer == 100 || mPer > 100) {
        fallObj(Math.ceil(Math.random() * bagLength));
        GameOver();
    }
}

function onDeviceMotionHandler(eventData) {
    var acceleration = eventData.accelerationIncludingGravity;
    var curTime = new Date().getTime();
    var diffTime = curTime - lUpdate;
    if (Math.abs(acceleration.x) < 7) {
        var mRotate = Math.floor(acceleration.x * 10) * mDir;
        $(".bag").css("-webkit-transform", "rotate(" + mRotate + "deg)");
    }
    if (diffTime > 100) {
        lUpdate = curTime;
        sX = acceleration.x;
        sY = acceleration.y;
        sZ = acceleration.z;
        var speed = (Math.abs(sX - lX) + Math.abs(sY - lY) + Math.abs(sZ - lZ)) / diffTime * 10000;
        if (speed > 500) {
            updatePre(1);
        }
        lX = sX;
        lY = sY;
        lZ = sZ;
    }
}

function GameStart() {
    if (isWeixin()) {
        if (window.DeviceMotionEvent) {
            lUpdate = new Date().getTime();
            window.addEventListener('devicemotion', onDeviceMotionHandler, false);
        } else {
            alert("改设备不支持!");
        }
    } else {
        $("#GameModule").on("click", onMenuHandler);
    }
    GameCount--;
    GameScore = 0;
    setArtFont("Txt_per3", "fontR", GamePer);
    isOver = false;
    StartTime = new Date().getTime();
    Timer = window.setInterval(updateTime, 20);
}


function GameOver() {
    isOver = true;
    if (window.DeviceMotionEvent) {
        window.removeEventListener('devicemotion', onDeviceMotionHandler, false);
    }
    if (Timer) {
        window.clearInterval(Timer);
    }
    if (mPer == 100) {
        //跳出红包代码弹层
        window.setTimeout(function () {
            $("#OverModule3").css({display: "-webkit-box"});
        }, 700);
    } else {
        if (GameCount == 0) {
            setArtFont("Txt_per2", "font", mPer);
            $("#Txt_count2").html(GameCount);
            $("#Txt_tip2 strong").html(mPer + "%");
            $("#OverModule2").css({display: "-webkit-box"});
        } else {
            setArtFont("Txt_per1", "font", mPer);
            $("#Txt_count1").html(GameCount);
            $("#OverModule1").css({display: "-webkit-box"});
        }
    }
    onPostData(mPer - GamePer);
}

function updateTime() {
    var TempTime = new Date().getTime();
    var ShowTime = Math.floor((TempTime - StartTime) / 1000);
    if (ShowTime == 5 || ShowTime > 5) {
        GameOver();
    }
}

function initEvent() {
    $("#Btn_start").on("click", onMenuHandler);
    $("#OpenModule").on("click", onMenuHandler);
    $("#Btn_rule").on("click", onMenuHandler);
    $("#RuleModule").on("click", onMenuHandler);
    $("#Btn_menu1").on("click", onMenuHandler);
    $("#Btn_menu2").on("click", onMenuHandler);
    $("#Btn_menu3").on("click", onMenuHandler);
    $("#Btn_share").on("click", onMenuHandler);
    $("#ShareModule").on("click", onMenuHandler);
    $("#Btn_again").on("click", onMenuHandler);
    $("#PopsModule").on("click", onMenuHandler);
    $("#Btn_sound").on("click", onMenuHandler);
}

function onMenuHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_start":
            $("#TipsModule").fadeOut();
            GameStart();
            break;
        case "OpenModule":
            if (isOpen) {
                $(".l_door").addClass("AniOpenL");
                $(".r_door").addClass("AniOpenR");
                window.setTimeout(function () {
                    mSwiper.slideNext();
                }, 2000);
            }
            break;
        case "Btn_rule":
            $("#RuleModule").css({display: "-webkit-box"});
            break;
        case "RuleModule":
            $("#RuleModule").fadeOut();
            break;
        case "Btn_menu1":
            onNextPage();
            break;
        case "Btn_menu2":
            onNextPage();
            break;
        case "Btn_menu3":
            onNextPage();
            break;
        case "Btn_share":
            is_show_num = 1;
            $("#ShareModule").css({display: "-webkit-box"});
            break;
        case "ShareModule":
            is_show_num = 0;
            $("#ShareModule").fadeOut();
            break;
        case "Btn_again":
            $("#OverModule1").fadeOut();
            GameStart();
            break;
        case "GameModule":
            updatePre(10);
            break;
        case "PopsModule":
            $("#PopsModule").fadeOut();
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


function setArtFont(cxt, str, num) {
    var txtBlock = "";
    var mStr = num.toString();
    for (var i = 0; i < mStr.length; i++) {
        var mIndex = mStr.substr(i, 1);
        txtBlock += '<div class="' + str + mIndex + '"></div>';
    }
    txtBlock += '<div class="' + str + '10"></div>';
    $(("#" + cxt)).html(txtBlock);
}

function isWeixin() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        return true;
    } else {
        return false;
    }
}

function isIOS() {
    var u = navigator.userAgent;
    return !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
}

function OnElementFun(obj, fun) {
    document.getElementById(obj).addEventListener('click', function () {
        fun();
    })
    var e = document.createEvent("MouseEvents");
    e.initEvent('click', true, true);
    document.getElementById(obj).dispatchEvent(e);
}
