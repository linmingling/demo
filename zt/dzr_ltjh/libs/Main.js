/**
 * Created by Borey on 2015/10/19.
 */
var sX, sY, sZ, lX, lY, lZ, lUpdate;
sX = sY = sZ = lX = lY = lZ = lUpdate = 0;
window.onload = init();
function init() {
    var mSwiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        updateOnImagesReady: true,
        onImagesReady: onLoadComplete,
        onInit:initScene,
        onSlideChangeEnd: onChangeEnd
    });
}

function initScene(swiper){
    initEvent();
    swiperAnimateCache(swiper);
    swiperAnimate(swiper);
}

function initEvent() {
    $("#Btn_hand2").on('click', onClickHandler);
    $("#Btn_hand3").on('click', onClickHandler);
    $("#Btn_hand4").on('click', onClickHandler);
    $("#Btn_hand5").on('click', onClickHandler);
    $("#Btn_hand6").on('click', onClickHandler);
    $("#Btn_ok").on("click", onClickHandler);
    $("#Btn_post").on("click", onClickHandler);
    $("#Btn_share").on("click", onClickHandler);
    $("#ShareModule").on("click", onClickHandler);
}

function onClickHandler(e) {
    //console.log(e.currentTarget.id);
    switch (e.currentTarget.id) {
        case "Btn_hand2":
            onHandHandler();
            break;
        case "Btn_hand3":
            onHandHandler();
            break;
        case "Btn_hand4":
            onHandHandler();
            break;
        case "Btn_hand5":
            onHandHandler();
            break;
        case "Btn_hand6":
            onHandHandler();
            break;
        case "Btn_ok":
            $("#OverModule").hide();
            $("#InfoModule").show();
            break;
        case "Btn_post":
            onPostHandler();
            break;
        case "Btn_share":
            $("#ShareModule").show();
            break;
        case "ShareModule":
            $("#ShareModule").hide();
            break;
    }

}

function onHandHandler() {
    $("#PlayModule").show();
    if(is_winning){
    	$("#PlayModule").on("click", onShakeHandler());
    } else {
	    if (window.DeviceMotionEvent) {
	        lUpdate=new Date().getTime();
	        window.addEventListener('devicemotion', onDeviceMotionHandler, false);
	    } else {
	        alert("该设备不支持!");
	    }
    }
}


function onDeviceMotionHandler(eventData) {
    var acceleration = eventData.accelerationIncludingGravity;
    var curTime = new Date().getTime();
    var diffTime = curTime - lUpdate;
    if (diffTime > 100) {
        lUpdate = curTime;
        sX = acceleration.x;
        sY = acceleration.y;
        sZ = acceleration.z;
        var speed = (Math.abs(sX - lX) + Math.abs(sY - lY) + Math.abs(sZ - lZ)) / diffTime * 10000;
        if (speed > 3000) {
        	onShakeHandler();
        }
        lX = sX;
        lY = sY;
        lZ = sZ;
    }
}

function onShakeHandler() {
    if (window.DeviceMotionEvent) {
        window.removeEventListener('devicemotion', onDeviceMotionHandler, false);
    }
    $.ajax({
        async:true,
        url:'server.php',
        data:{act:'winning'},
        type: 'post',
        dataType:'json',
        success:function(result){
        	if(result.errcode){
        		alert(result.errmsg);
        	} else {
        		$(".swiper-container").hide();
        	    $("#PlayModule").hide();
        	    $("#OverModule").show();
        	}
        }
    });
}

//提交资料
function onPostHandler() {
    var mReg = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
    var NameStr = $("#Txt_name").val();
    var PhoneStr = $("#Txt_phone").val();
    if (NameStr == "") {
        alert("请输入您的姓名！");
        return false;
    } else if (!mReg.test(PhoneStr)) {
        alert('请输入正确的手机号码！');
        return false;
    }
    $.ajax({
        async:true,
        url:'server.php',
        data:{act:'submit',name:NameStr,phone:PhoneStr},
        type: 'post',
        dataType:'json',
        success:function(result){
        	if(result.errcode){
        		alert(result.errmsg);
        	} else {
        		onSuccessFun();
        	}
        }
    });
}

//提交资料成功
function onSuccessFun() {
    $("#InfoModule").hide();
    $("#PopModule").show();
}

function onLoadComplete() {
    $("#loading").hide();
}

function onChangeEnd(swiper) {
    swiperAnimate(swiper);
    if (swiper.snapIndex == 7) {
        $("#Mc_arrow").hide();
    } else {
        $("#Mc_arrow").show();
    }
}