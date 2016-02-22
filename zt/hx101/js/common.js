var id,index=0,winH,flag=false,liIndex,sound;
var myScroll;
var liH=[320,100,100,320,100,100,100,100,100,100,100,100,100];
// document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

var basePath = ""

var loader = new WxMoment.Loader();

//声明资源文件列表
var fileList = ['img/bg1.jpg', 'img/bg2.jpg', 'img/bg3.jpg', 'img/bg4.png', 'img/jp.jpg','img/jp2.jpg','img/p1.jpg','img/me.jpg','img/ab.jpg','img/yuan.jpg','img/mask.png','img/ewm.png'];

for (var i = 0; i < fileList.length; i++) {
    loader.addImage(basePath + fileList[i]);
}

//进度监听
loader.addProgressListener(function (e) {
    var percent = Math.round((e.completedCount / e.totalCount) * 100);
    console.log("当前加载了", percent, "%");
    //在这里做 Loading 页面中百分比的显示
	$("#loadPress span").css({width:percent+"%"});
});

//加载完成
loader.addCompletionListener(function () {
    sound=document.getElementById("sound");
	$("#loadPress span").css({width:"100%"});
	setTimeout(function(){
		$("#pageload").hide();
		dialogue(index);
	},400)
	
	myScroll = new IScroll('.main',{
		preventDefault: false
	});
});

//启动加载
loader.start();

//初始化分享组件
var share = new WxMoment.Share();
//统计
var wa = new WxMoment.Analytics({
    //projectName 请与微信商务团队确认
    projectName: "20150816oppozipai"
});
//若不支持横屏或横屏下体验不佳，请添加横屏提示
new WxMoment.OrientationTip();

$(function(){
	winH=$(window).height();
	$(".warp").height(winH);
	$(".main").height(winH-92);
	$(".bottom").on("touchstart",function(){
		if(flag){
			$(".bottom em").hide();
			$(this).addClass("on");
			flag=false;
			$(".bottom .input").html("报名请选择↓");
		}
	})
	$(".choose li").on("touchstart",function(){
		$(".bottom .input").addClass("on");
		id=$(this).index();

		$(".me .say p,.bottom .input").html("我要报名");
		$(".last").html("<img src='"+basePath+"img/yuan.jpg'><div class='say'><p>打开链接，祝你报名成功</p><p><a>http://bwmxzxjj.com</a></p></div>");
		
		/*if(id == 0){
			$(".me .say p,.bottom .input").html("杨幂");
			$(".last").html("<img src='"+basePath+"img/mi.jpg'><div class='say'><p>么么哒<i class='bq4'></i>R7家族自拍就是这么给力！</p></div>");
			$(".popBox .goto").attr("href","http://www.oppo.com/cn/product/m/r7plus/online/index.html");
		}else if(id == 1){
			$(".me .say p,.bottom .input").html("李易峰");
			$(".last").html("<img src='"+basePath+"img/feng.jpg'><div class='say'><p>R7最给力，我代表国家感谢你<i class='bq6'></i></p></div>");
			$(".popBox .goto").attr("href","http://www.oppo.com/cn/product/m/r7/online/index.html");
		}else if(id == 2){
			$(".me .say p,.bottom .input").html("鹿晗");
			$(".last").html("<img src='"+basePath+"img/han.jpg'><div class='say'><p>有了R7 Plus，从此告别葫芦娃<i class='bq6'></i></p></div>");
			
			$(".popBox .goto").attr("href","http://www.oppo.com/cn/product/m/r7plus/online/index.html");
		}*/
		$(".ren img").eq(id).show().siblings().hide();
		$(".bottom em").addClass("on").show();
		$(".enter").show();
	})
	$(".enter").on("touchstart",function(){
		$(".me,.last").show();
		myScroll.refresh();
		$(".bottom").removeClass("on");
		$(".bottom .input").removeClass("on");
		$(".bottom em").removeClass("on").hide();
		index=8;
		result(index);
		$(".enter").hide();
	})
	/*$(".pp").click(function(){
		var src=$(this).attr("data-img");
		var y=myScroll.y;
		liIndex=$(this).parents("li").index();
		var theTop=check(liIndex)+y;
		//console.log(y+"---------------"+liIndex+"---------------"+check(liIndex));
		$(".tanchu .pic img").attr("src",basePath+"img/"+src+".jpg");
		$(".tanchu .pic").css({"transform":"translate(0,"+(theTop)+"px)","-webkit-transform":"translate(0,"+(theTop)+"px)"});
		$(".tanchu .pic img").css({"transform":"scale(0.317) translate(0,0)","-webkit-transform":"scale(0.317) translate(0,0)"});
		$(".tanchu").show();
		setTimeout(function(){
			$(".tanchu").addClass("on");
			$(".tanchu .pic img").css({"transform":"scale(1) translate(-114px,"+((winH-946)/2-theTop)+"px)","-webkit-transform":"scale(1) translate(-114px,"+((winH-946)/2-theTop)+"px)"});
		},50)
	})*/
	$(".tanchu").click(function(){
		var y=myScroll.y; 
		$(this).removeClass("on");
		var theTop=check(liIndex)+y;
		$(".tanchu .pic").css({"transform":"translate(0,"+(theTop)+"px)","-webkit-transform":"translate(0,"+(theTop)+"px)"});
		$(".tanchu .pic img").css({"transform":"scale(0.317) translate(0,0)","-webkit-transform":"scale(0.317) translate(0,0)"});
		setTimeout(function(){
			$(".tanchu").hide();
		},500)
	})
})
function dialogue(index){
	var tt=(index==0)?1000:1500;
	if(index<8){
		var theli=$(".list li").eq(index);
		setTimeout(function(){
			if(index == 0||index == 3|| index == 6){
				sound.play();
			}
			theli.addClass("on");
			index++;
			
			var theH=check(index);
			if(theH>(winH-92)){
				var y=(winH-92)-theH;
				myScroll.scrollTo(0,y,300);
			}else{
				myScroll.scrollTo(0,0,300);
			}
			dialogue(index);
		},tt)
	}else{
		flag=true;
		$(".bottom em").show();
	}
}
function result(index){
	var tt=(index==10)?500:1500;
	if(index<10){
		var theli=$(".list li").eq(index);
		setTimeout(function(){
			if(index == 9){
				sound.play();
			}
			theli.addClass("on");
			index++;
			var theH=check(index);
			if(theH>(winH-92)){
				var y=(winH-92)-theH;
				myScroll.scrollTo(0,y,300);
			}
			$(".bottom div").html("");
			result(index);
		},tt)
	}else{
		setTimeout(function(){
			$(".pop").show();
			$(".bottom").hide();
		},2800)
	}
}
function check(x){
	var h=120;
	for(i=0;i<x;i++){
		h=h+liH[i];
	}
	return h;
}


