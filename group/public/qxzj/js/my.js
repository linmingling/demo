//初始化
$(function(){
	new Marquee({
	        MSClassID: "cn-run1",
	        ContentID: "ul-run1",
	        Direction: "top",
	        Step: 2,
	        Width: 880,
	        Height: 580,
	        Timer: 100,
	        DelayTime: 0,
	        WaitTime: 0,
	        AutoStart: true
	    });
});

$(".box2-2-tag div").eq(0).hover(
	function () {
		var _live=$('#live1');

		$('.box2-2-bg').css('display','none');
		_live.css('display','block');
		
		$(".box2-2-tag div").eq(0).removeClass('box2-tag-normal').addClass('box2-tag-hover');
		$(".box2-2-tag div").eq(1).removeClass('box2-tag-hover').addClass('box2-tag-normal');
		$(".box2-2-tag div").eq(2).removeClass('box2-tag-hover').addClass('box2-tag-normal');
		new Marquee({
	        MSClassID: "cn-run1",
	        ContentID: "ul-run1",
	        Direction: "top",
	        Step: 2,
	        Width: 880,
	        Height: 580,
	        Timer: 100,
	        DelayTime: 0,
	        WaitTime: 0,
	        AutoStart: true
	    });
	},function(){
	
	}
);
$(".box2-2-tag div").eq(1).hover(
		function () {
			if(new Date()>new Date(Date.parse('2015/08/23')))
			{
				var _live=$('#live2');

				$('.box2-2-bg').css('display','none');
				_live.css('display','block');

				$(".box2-2-tag div").eq(0).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-2-tag div").eq(1).removeClass('box2-tag-normal').addClass('box2-tag-hover');
				$(".box2-2-tag div").eq(2).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				new Marquee({
		        MSClassID: "cn-run2",
		        ContentID: "ul-run2",
		        Direction: "top",
		        Step: 2,
		        Width: 880,
		        Height: 580,
		        Timer: 100,
		        DelayTime: 0,
		        WaitTime: 0,
		        AutoStart: true
		    });
			}
			
			
		},function(){
		
		}
);
$(".box2-2-tag div").eq(2).hover(
		function () {
			if(new Date()>new Date(Date.parse('2015/08/30')))
			{
				var _live=$('#live3');

				$('.box2-2-bg').css('display','none');
				_live.css('display','block');

				$(".box2-2-tag div").eq(0).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-2-tag div").eq(1).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-2-tag div").eq(2).removeClass('box2-tag-normal').addClass('box2-tag-hover');
				new Marquee({
		        MSClassID: "cn-run3",
		        ContentID: "ul-run3",
		        Direction: "top",
		        Step: 2,
		        Width: 880,
		        Height: 580,
		        Timer: 100,
		        DelayTime: 0,
		        WaitTime: 0,
		        AutoStart: true
		    });
			}
			

		},function(){
		
		}
);

function pic(type){
	var _bg=$('#bg');
	var _tan=$("#tan");
	var _tan_img=$("#imgurl");
	
	_tan.fadeIn();
	_bg.fadeIn();
	var sj='';
	
	$.ajax({
		async:true,
		url:'/pc/qxzj/get_img',
		data:{type:type},
		type: 'post',
		dataType:'json',
		success:function(result){
			for(var $i=0;$i<result.length;$i++){
				sj += "<img src='"+result[$i]['img_url']+"'>"
			}
			_tan_img.html(sj);
			$("#imgurl img").eq(0).fadeIn();
		}
	});
};

$("#close").click(function(){
    var _bg=$('#bg');
    var _tan=$("#tan");
    _bg.fadeOut();
    _tan.fadeOut();
});
function qie(type){
	var index=0;

	for(var i=0;i<$("#imgurl img").length;i++){
		if($("#imgurl img").eq(i).css('display')=='inline')
		{
			index=i;
		}
	}

	if(type=='left'){
		index=index-1;
		if(index>=0)
		{
			$("#imgurl img").hide();
			$("#imgurl img").eq(index).show();
		}
	}
	else{
		index=index+1;
		if(index<$("#imgurl img").length)
		{
			$("#imgurl img").hide();
			$("#imgurl img").eq(index).show();
		}
	}
}

function bigpic(obj){
	var _obj=$(obj);
	var _img=$(obj).find('img').attr('src');

	var _bg=$('#bg');
	var _tan=$("#tan2");
	var _tan_img=$("#tan2_img");

	_tan.fadeIn();
	_bg.fadeIn();
	_tan_img.attr('src',_img);
}
$("#close2").click(function(){
    var _bg=$('#bg');
    var _tan=$("#tan2");
    _bg.fadeOut();
    _tan.fadeOut();
});


// *****************图片滚动***********************
window.onload=function()
{
	var oDiv=document.getElementById('box');
	mouseScroll(oDiv);
};

function mouseScroll(obj)
{
	if(!obj) return false;
	
	var oUl=obj.getElementsByTagName('ul')[0];
	var aLi=oUl.getElementsByTagName('li');
	var iLiWidth=[];
	var iUlResult=0;
	var iCurr=0;
	var iPicTarget=0;
	var iSummation=0;
	var iNow=1;
	var iCountTime=null;
	var autoTime=null;

	for(var i=0; i<aLi.length; i++){ iLiWidth.push(aLi[i].offsetWidth);	}
	iSummation=sumFn(iLiWidth);

	for(var i=0; i<iLiWidth.length; i++){ iUlResult+=iLiWidth[i]; }
	oUl.style.width=iUlResult+'px';

	function autoStyle()
	{
		obj.style.width=aLi[iCurr].offsetWidth+'px';
		obj.style.left=(document.documentElement.clientWidth-obj.offsetWidth)/2+'px';
	}
	autoStyle();
	window.onresize=function(){ autoStyle(); };

	function mouseDown()
	{
		clearInterval(autoTime);
		countTime();
		iCurr++;
		picScroll();
	}
	function mouseUp()
	{
		clearInterval(autoTime);
		countTime();
		iCurr--;
		picScroll();
	}

	document.onkeydown=function(ev)
	{
		clearInterval(autoTime);
		countTime();
		
		ev=ev||window.event;
		if(ev.keyCode==37)
		{
			iCurr--;
		}
		if(ev.keyCode==39)
		{
			iCurr++;
		}
		picScroll();
	}

	function picScroll()
	{
		if(iCurr==aLi.length)
		{
			iCurr=aLi.length-1;
		}
		if(iCurr<0)
		{
			iCurr=0;
		}
		
		

		var tmpArr=[];
		for(var i=0; i<iCurr; i++)
		{
			tmpArr.push(iLiWidth[i]);
		}
		iPicTarget=sumFn(tmpArr);
		
		startMove(oUl,{left:-iPicTarget});
		startMove(obj,{width:aLi[iCurr].offsetWidth});
	}

	function autoPlay()
	{
		clearInterval(autoTime);
		autoTime=setInterval(function(){
			if(iCurr==aLi.length-1)
			{
				iNow=-1;
			}
			if(iCurr==0)
			{
				iNow=1;
			}
			iCurr+=iNow;
			
			picScroll();
		}, 2000);
	}
	autoPlay();

	function countTime()
	{
		var iNum=10;
		clearTimeout(iCountTime);
		iCountTime=setInterval(function(){
			if(iNum==0)
			{
				
				clearInterval(iCountTime);
				autoPlay();
			}
			else
			{
				iNum--;
				
			}
		}, 1000);
	}
}

function sumFn(arr)
{
	var result=0;
	for(var i=0; i<arr.length; i++)
	{
		result+=arr[i];
	}
	return result;
}


function navposition(){
	$("#navWarp").addClass("navWarp");
}
$(function(){
	navposition();
	$(window).resize(function(){
		navposition();
	})
	var b1 = $("#b1").offset().top;
	var b2 = $("#b2").offset().top-50;
	var b3 = $("#b3").offset().top-50;
	var b4 = $("#b4").offset().top-50;
	var b5 = $("#b5").offset().top-50;
	var b6 = $("#b6").offset().top-50;

	var nav = $("#navWarp");
	var navP = $("#navWarp p");
	var win = $(window);
	win.scroll(function(){
		if(win.scrollTop()>500){
			nav.addClass("navWarpFix")
		}else{
			nav.removeClass("navWarpFix")
		}
		if(win.scrollTop()>b6-30){
			navP.removeClass("hover").eq(4).addClass("hover");
		}else if(win.scrollTop()>b5-1){
			navP.removeClass("hover").eq(3).addClass("hover");
		}else if(win.scrollTop()>b4-1){
			navP.removeClass("hover").eq(2).addClass("hover");
		}else if(win.scrollTop()>b3-1){
			navP.removeClass("hover").eq(1).addClass("hover");
		}else if(win.scrollTop()>b2-1){
			navP.removeClass("hover").eq(0).addClass("hover");
		}
		else{
			navP.removeClass("hover");
		}

	});

	//定位
	navP.each(function(){
		$(this).click(function(){
			index = $(this).index();
			//$(this).addClass('hover').siblings().removeClass('hover');
			switch(index){
				case 0: $('html,body').animate({scrollTop: b2}, 300);break;
				case 1: $('html,body').animate({scrollTop: b3}, 300);break;
				case 2: $('html,body').animate({scrollTop: b4}, 300);break;
				case 3: $('html,body').animate({scrollTop: b5}, 300);break;
				case 4: $('html,body').animate({scrollTop: b6}, 300);break;
				case 5: $('html,body').animate({scrollTop: b1}, 300);break;
			}

		});
	});
});

$(".box2-3-tag div").eq(0).hover(
	function () {
		var _contag=$('#contag1');

		$('.box2-3-bg').css('display','none');
		_contag.css('display','block');

		$(".box2-3-tag div").eq(0).removeClass('box2-tag-normal').addClass('box2-tag-hover');
		$(".box2-3-tag div").eq(1).removeClass('box2-tag-hover').addClass('box2-tag-normal');
		$(".box2-3-tag div").eq(2).removeClass('box2-tag-hover').addClass('box2-tag-normal');
	},function(){
	
	}
);
$(".box2-3-tag div").eq(1).hover(
		function () {
			if(new Date()>new Date(Date.parse('2015/08/23'))){
				var _contag=$('#contag2');

				$('.box2-3-bg').css('display','none');
				_contag.css('display','block');

				$(".box2-3-tag div").eq(0).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-3-tag div").eq(1).removeClass('box2-tag-normal').addClass('box2-tag-hover');
				$(".box2-3-tag div").eq(2).removeClass('box2-tag-hover').addClass('box2-tag-normal');
			}
		},function(){
		
		}
);
$(".box2-3-tag div").eq(2).hover(
		function () {
			if(new Date()>new Date(Date.parse('2015/08/30'))){
				var _contag=$('#contag3');

				$('.box2-3-bg').css('display','none');
				_contag.css('display','block');

				$(".box2-3-tag div").eq(0).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-3-tag div").eq(1).removeClass('box2-tag-hover').addClass('box2-tag-normal');
				$(".box2-3-tag div").eq(2).removeClass('box2-tag-normal').addClass('box2-tag-hover');
			}

		},function(){
		
		}
);



