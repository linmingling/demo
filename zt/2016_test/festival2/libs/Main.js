/**
 *@author borey
 *@date 2016/1/12
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */

var sigNum = sig; 
var sX, sY, sZ, lX, lY, lZ, lUpdate;
sX = sY = sZ = lX = lY = lZ = lUpdate = 0;
var counts=0;
window.onload=init;
function init(){	
	if(sig == '-1')
	{		
        alert("您暂时不具有投票资格!");
		window.close();
	}
		
    $("#LoadModule").fadeOut();
    $("#Txt_user").html("次数:"+counts);
    $("#Btn_law").on("click", function () {
        if ($("#Mc_QR").css("display") == "none") {
            $("#Mc_QR").fadeIn();
        } else {
            $("#Mc_QR").fadeOut();
        }
    });
	
	// 测试
	window.setInterval(function(){
		counts=Math.random*100;
		$.ajax({
			async:false,
			url: 'draw.php',
			data:{
				act:'sub',
				num:counts,
				sig:sigNum
				},
			type: "post",
			dataType:'json',
			success:function(result){},
			complete:function(XMLHttpRequest, textStatus) { 
				counts = 0;
			},
			error: function(XMLHttpRequest) {
				if(XMLHttpRequest.readyState != '4'){
					//alert("网络异常,请稍后重试");
				}
			}
		});
	},2000);

    if (window.DeviceMotionEvent) {
        lUpdate = new Date().getTime();
        window.addEventListener('devicemotion', onDeviceMotionHandler, false);
    } else {
        alert("该设备不支持!");
    }
	
	// 页面提交数据--1秒
	var timer2=setInterval(function(){
		if(counts>0){
			$.ajax({
				async:false,
				url: 'draw.php',
				data:{
					act:'sub',
					num:counts,
					sig:sigNum
					},
				type: "post",
				dataType:'json',
				success:function(result){},
				complete:function(XMLHttpRequest, textStatus) { 
					counts = 0;
				},
				error: function(XMLHttpRequest) {
					if(XMLHttpRequest.readyState != '4'){
						//alert("网络异常,请稍后重试");
					}
				}
			});	
		}			
	},1000);
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
        if (speed > 1000) {
            onShakeHandler();
        }
        lX = sX;
        lY = sY;
        lZ = sZ;
    }
}

function onShakeHandler() {
    counts++;
    //if (window.DeviceMotionEvent) {
    //    window.removeEventListener('devicemotion', onDeviceMotionHandler, false);
    //}
    $("#Txt_user").html("次数:"+counts);
}