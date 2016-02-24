var index = 0;
var timer = 0;
var ulist = $('.page2-2-2 ul');
var list = ulist.find('li');
var llength = list.length;//li的个数，用来做边缘判断
var lwidth = $(list[0]).width();//每个li的长度，ul每次移动的距离
var uwidth = llength * lwidth;//ul的总宽度


function init(){
	$('.link').bind('click', function(event) {
		var elm = $(this);
		doMove(elm.attr('id'));
		return false;
	});

	auto();
}
function auto(){
	//定时器
	timer = setInterval("doMove('toRight')",3000);

	$('.page2-2-2 li').hover(function() {
		clearInterval(timer);
	}, function() {
		timer = setInterval("doMove('toRight')",3000);
	});
}
function doMove(direction){
	
	//向右按钮
	if (direction =="toRight") {
		index++;
		if ( index< llength) {
			uwidth = lwidth *index;
			ulist.css('left',-uwidth);
			//ulist.animate({left: -uwidth}, 1000);

		}else{
			ulist.css('left','0px');
			index = 0;
		}; 
	//向左按钮           
	}else if(direction =="toLeft"){
		index--;
		if ( index < 0) {
			index = llength - 1;                
		}
		uwidth = lwidth *index;
		ulist.css('left',-uwidth);
		//ulist.animate({left: -uwidth}, "slow");    
	//点击数字跳转  
	}else{
		index = direction;
		uwidth = lwidth *index;
		ulist.css('left',-uwidth);
	};
	

}
init();

//----------------华丽的分割线---------------------------
var index2 = 0;
var timer2 = 0;
var ulist2 = $('.page3-2-2 ul');
var blist2 = $('.page3-3 ul');
var list2 = ulist2.find('li');
var llength2 = list2.length;//li的个数，用来做边缘判断
var lwidth2 = $(list2[0]).width();//每个li的长度，ul每次移动的距离
var uwidth2 = llength2 * lwidth2;//ul的总宽度
function init2(){

	$('.link2').bind('click', function(event) {
		var elm = $(this);
		doMove2(elm.attr('id'));
		return false;
	});

	addBtn2(list2);
	auto2();
}
function auto2(){
	//定时器
	timer2 = setInterval("doMove2('toRight2')",3000);

	$('.page3-2-2 li, .page3-3 li').hover(function() {
		clearInterval(timer2);
	}, function() {
		timer2 = setInterval("doMove2('toRight2')",3000);
	});
}
function changeBtn2(i){
	blist2.find('li').eq(i).addClass('on').siblings().removeClass('on');
}
function addBtn2 (list){
	for (var i = 0; i < list.length; i++) {
		var imgsrc = $(list[i]).find('img').attr('src');            
		var listCon = '<li><img src="'+imgsrc+'""></li>';         
		$(listCon).appendTo(blist2);
		//隐藏button中的数字
		//list.css('text-indent', '10000px');
	};
	blist2.find('li').first().addClass('on');
	blist2.find('li').hover(function(event) {
		var _index = $(this).index();            
		doMove2(_index);
	}, function(event){
	    
	} );
}
function doMove2(direction){
	//向右按钮
	if (direction =="toRight2") {
		index2++;
		if ( index2< llength2) {
			uwidth2 = lwidth2 *index2;
			ulist2.css('left',-uwidth2);
			//ulist.animate({left: -uwidth}, 1000);

		}else{
			ulist2.css('left','0px');
			index2 = 0;
		}; 
	//向左按钮           
	}else if(direction =="toLeft2"){
		index2--;
		if ( index2 < 0) {
			index2 = llength2 - 1;                
		}
		uwidth2 = lwidth2 *index2;
		ulist2.css('left',-uwidth2);
		//ulist.animate({left: -uwidth}, "slow");    
	//点击数字跳转  
	}else{
		index2 = direction;
		uwidth2 = lwidth2 *index2;
		ulist2.css('left',-uwidth2);
	};
	changeBtn2(index2);
}
init2();


//----------------华丽的分割线---------------------------
var index3 = 0;
var timer3 = 0;
var ulist3 = $('.page8-2-2 ul');
var blist3 = $('.page8-3 ul');
var list3 = ulist3.find('li');
var llength3 = list3.length;//li的个数，用来做边缘判断
var lwidth3 = $(list3[0]).width();//每个li的长度，ul每次移动的距离
var uwidth3 = llength3 * lwidth3;//ul的总宽度
function init3(){

	$('.link3').bind('click', function(event) {
		var elm = $(this);
		doMove3(elm.attr('id'));
		return false;
	});

	addBtn3(list3);
	auto3();
}
function auto3(){
	//定时器
	timer3 = setInterval("doMove3('toRight3')",3000);

	$('.page8-2-2 li, .page8-3 li').hover(function() {
		clearInterval(timer3);
	}, function() {
		timer3 = setInterval("doMove3('toRight3')",3000);
	});
}
function changeBtn3(i){
	blist3.find('li').eq(i).addClass('on').siblings().removeClass('on');
}
function addBtn3 (list){
	for (var i = 0; i < list.length; i++) {
		var imgsrc = $(list[i]).find('img').attr('src');            
		var listCon = '<li><img src="'+imgsrc+'""></li>';         
		$(listCon).appendTo(blist3);
		//隐藏button中的数字
		//list.css('text-indent', '10000px');
	};
	blist3.find('li').first().addClass('on');
	blist3.find('li').hover(function(event) {
		var _index = $(this).index();            
		doMove3(_index);
	}, function(event){
	    
	} );
}
function doMove3(direction){
	//向右按钮
	if (direction =="toRight3") {
		index3++;
		if ( index3< llength3) {
			uwidth3 = lwidth3 *index3;
			ulist3.css('left',-uwidth3);
			//ulist.animate({left: -uwidth}, 1000);

		}else{
			ulist3.css('left','0px');
			index3 = 0;
		}; 
	//向左按钮           
	}else if(direction =="toLeft3"){
		index3--;
		if ( index3 < 0) {
			index3 = llength3 - 1;                
		}
		uwidth3 = lwidth3 *index3;
		ulist3.css('left',-uwidth3);
		//ulist.animate({left: -uwidth}, "slow");    
	//点击数字跳转  
	}else{
		index3 = direction;
		uwidth3 = lwidth3 *index3;
		ulist3.css('left',-uwidth3);
	};
	changeBtn3(index3);
}
init3();

$(function(){
   //亚太传媒
    var yt = yt || {};

    //头部模块
    yt.header = function () {

        //下拉菜单
        var bindHyChannel = function () {
            var $hy = $("#hychannel"),
                $p = $hy.find('p'),
                $ul = $hy.find('ul');

            $hy.hover(function () {
                $p.toggleClass('up');
                $ul.toggleClass('tg');
            });
        };
        
        //init
        bindHyChannel();
        

    };
    yt.init = function () {
       yt.header();
    };

    yt.init();
})


