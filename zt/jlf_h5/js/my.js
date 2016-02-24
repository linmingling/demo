var yt = yt || {};

//加载图片
yt.loadImg = function ($imgs, time) {
    var _time = 0;
    time = time || 200;

    $imgs.each(function () {
        var $that = $(this);
        if ($that.data('hasload')) {
            return false;
        }
        setTimeout(function () {
            $that.fadeOut(0);
            $that.attr('src', $that.data('src'));
            $that.attr('data-hasload', 'true');
            $that.fadeIn(500);
        }, _time);
        _time += time;
    });
};

//wap端环境
yt.isWap = function () {
    var s = navigator.userAgent.toLowerCase();
    var ipad = s.match(/ipad/i) == "ipad"
		, iphone = s.match(/iphone os/i) == "iphone os"
		, midp = s.match(/midp/i) == "midp"
		, uc7 = s.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"
		, uc = s.match(/ucweb/i) == "ucweb"
		, android = s.match(/android/i) == "android"
		, ce = s.match(/windows ce/i) == "windows ce"
		, wm = s.match(/windows mobile/i) == "windows mobile";
    if (iphone || midp || uc7 || uc || android || ce || wm || ipad) { return true; }
    return false;
};

//滑动绑定
yt.app = function () {
   
    var $swiperContainer = $("#swiper-container1"),
        $pages = $("#wrapper").children(),
        $as = $("#nav li a"),
        $lis = $("#nav li"),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper;

    var params = {
        selectorClassName: "swiper-container",
        animationClassName: acn,
        animationElm: $("." + acn)
    };
    var setCssText = function (prop, value) {
        return prop + ': ' + value + '; ';
    };

    /*
	 * insertCss(rule)
	 * 向文档<head>底部插入css rule操作
	 * rule: 传入的css text
	 * */
    var insertCss = function (rule) {
        var head = document.head || document.getElementsByTagName('head')[0],
			style;

        if (!!head.getElementsByTagName('style').length) {
            style = head.getElementsByTagName('style')[0];
   
            if (style.styleSheet) {
                style.styleSheet.cssText = rule;
            } else {
                style.innerHTML = '';
                style.appendChild(document.createTextNode(rule));
            }
        } else {
            style = document.createElement('style');

            style.type = 'text/css';
            if (style.styleSheet) {
                style.styleSheet.cssText = rule;
            } else {
                style.appendChild(document.createTextNode(rule));
            }

            head.appendChild(style);
        }
    };

    var setAnimationStyle=function() {
        var cssText = '';

        cssText += '.' + params.animationClassName + '{' +
			setCssText('display', 'none') +
			'}' +
			'.touchstart .' + params.animationClassName + '{' +
			setCssText('-webkit-animation-duration', '0 !important') +
			setCssText('-webkit-animation-delay', '0 !important') +
			setCssText('-webkit-animation-iteration-count', '1 !important') +
			'}';
   
        var index = mySwiper.activeIndex,
            _index = index + 1,
            $ans = $pages.eq(index).find('.' + params.animationClassName);
        $ans.each(function () {
            var obj = $(this);
         
            _className = obj.attr('data-item'),
            _animation = obj.attr('data-animation'),
            _duration = ((obj.attr('data-duration') / 1000) || 1) + 's',
            _timing = obj.attr('data-timing-function') || 'ease',
            _delay = ((obj.attr('data-delay') || 0) / 1000) + 's',
            _count = obj.attr('data-iteration-count') || 1;

    
            var _t = '.' + params.selectorClassName +
                ' .page-' + _index +
                ' .' + _className;

            cssText += _t + '{' +
                setCssText('display', 'block !important') +
                setCssText('-webkit-animation-name', _animation) +
                setCssText('-webkit-animation-duration', _duration) +
                setCssText('-webkit-animation-timing-function', _timing) +
                setCssText('-webkit-animation-delay', _delay) +
                setCssText('-webkit-animation-fill-mode', 'both') +
                setCssText('-webkit-animation-iteration-count', _count) +
                '}';

        });

        return cssText;

    };

    //设置动画
    var setAms = function () {
        insertCss(setAnimationStyle());
    };

    //设置布局
    var setLayout = function () {
        var $wrapers = $("#swiper-container1 .wraper"),
            $wraper1 = $("#wraper1"),
       
            isWap=yt.isWap(),
            w = 720,
            h = 1135;
        var sl = function () {
            var _w = $wraper1.width(),
                h = $win.height(),
                _h = isWap && _w<h?$win.height():_w * 1135 / 720;
            $wrapers.height(_h);
			if($win.height()<300){
				$(".cn-slidetips").hide();
			}else{
				$(".cn-slidetips").show();
			}
        };
        sl();
        $win.resize(sl);
    };

    //滑动绑定函数
    var onSlideChangeTime = 0;

    var onSlideChange = function () {
        if (onSlideChangeTime>1) {
            return;
        }

        var index = mySwiper.activeIndex;
        if (nowIndex == index && mySwiper.touches['abs'] < 50) {
            return;
        }
        onSlideChangeTime = 20;
        setAms();
        nowIndex = index || 0;
        //history.pushState(null, null, "index.html?p=" + (nowIndex + 1));
        //执行动画
        var timer=setInterval(function () {
            onSlideChangeTime -= 1;
            if (onSlideChangeTime == 0) {
                clearInterval(timer);
            }
        },1);
    };




    //触摸结束绑定
	
    var onTouchEnd = function () {

        var index = mySwiper.index;
		
        if (nowIndex == slideCount-1 && +mySwiper.touches['diff'] <-50) {
            return mySwiper.swipeTo(0);
        }
	   
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
        if(mySwiper.activeIndex==12||mySwiper.activeIndex==1||mySwiper.activeIndex==11)
        {
            $('.next').hide();
        }
        else{
            $('.next').show();
        }
        onSlideChange();

    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
			//mousewheelControl:true,
            mode: 'vertical',
            noSwiping : true,
            noSwipingClass : 'stop',
        });
    };

    //滚到下一个屏  
    var bindNext = function () {
        $(".next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
       
            mySwiper.swipeTo(index);
        });
    };
    $('#btn-tg').bind('click',function(){
        mySwiper.swipeTo(12);
    })
	
   //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();

    //数字动态变化
    function num_change(c_price,origin_price,id,times,waste_time){

        //每次变化数
        var i,n;
        i = 0;
        n = (c_price - origin_price) /times;
        var ycss=$('#'+id).css('font-size');
        var time = setInterval(function(){
            if (i<=times) {
                var current = (origin_price+i*n);
                $('#'+id).html(current);
                if(times<=5)
                {
                    $('#'+id).css('font-size',parseInt(ycss)+i/2+'px');
                }
                else if(times>5&&times<=10){
                    $('#'+id).css('font-size',parseInt(ycss)+i/4+'px');
                }
                else{
                    $('#'+id).css('font-size',parseInt(ycss)+i/5+'px');
                }
                i++;
            } else {
                clearInterval(time);
            }
        },waste_time/times);
    }
    
    // 数据提交
    $('#btntj').bind('click',function(){

        var _answer1='',_answer2='',_answer3='',_answer4='',_answer5='',_answer6='',_answer7='',_answer8='',_answer9='',_answer10='';
        var _group1='',_group2='',_group3='',_group4='',_group5='',_group6='',_group7='',_group8='',_group9='',_group10='';

        //第一题
        $('.q-answer').eq(0).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer1=$(this).text();
                if(index==0){_group1=3}
                else if(index==1){_group1=2}
                else if(index==2){_group1=1}
                else{_group1=0}
                return;
            }

        })
        if(_answer1==''||_answer1==null){ mySwiper.swipeTo(2);return;}


        //第二题
        $('.q-answer').eq(1).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer2=$(this).text();
                if(index==0){_group2=3}
                else if(index==1){_group2=2}
                else if(index==2){_group2=1}
                else{_group2=0}
                return;
            }
        })
        if(_answer2==''||_answer2==null){ mySwiper.swipeTo(3);return;}

        //第三题
        $('.q-answer').eq(2).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer3=$(this).text();
                if(index==0){_group3=3}
                else if(index==1){_group3=2}
                else if(index==2){_group3=1}
                else{_group3=0}
                return;
            }
        })
        if(_answer3==''||_answer3==null){ mySwiper.swipeTo(4);return;}

        //第四题
        $('.q-answer').eq(3).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer4=$(this).text();
                if(index==0){_group4=3}
                else if(index==1){_group4=2}
                else if(index==2){_group4=1}
                else{_group4=0}
                return;
            }
        })
        if(_answer4==''||_answer4==null){ mySwiper.swipeTo(5);return;}

        //第五题
        $('.q-answer').eq(4).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer5=$(this).text();
                if(index==0){_group5=3}
                else if(index==1){_group5=2}
                else if(index==2){_group5=1}
                else{_group5=0}
                return;
            }
        })
        if(_answer5==''||_answer5==null){ mySwiper.swipeTo(6);return;}

        //第六题
        $('.q-answer').eq(5).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                if(index==3)
                {
                    _answer6='其他('+$('#qs-6-oth').val()+')';
                }
                else{
                    _answer6=$(this).text();
                }
                if(index==0){_group6=3}
                else if(index==1){_group6=2}
                else if(index==2){_group6=1}
                else{_group6=0}
                return;
            }
        })
        if(_answer6==''||_answer6==null){ mySwiper.swipeTo(7);return;}

        //第七题
        $('.q-answer').eq(6).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer7=$(this).text();
                if(index==0){_group7=3}
                else if(index==1){_group7=2}
                else if(index==2){_group7=1}
                else{_group7=0}
                return;
            }
        })
        if(_answer7==''||_answer7==null){ mySwiper.swipeTo(8);return;}

        //第八题
        $('.q-answer').eq(7).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer8=$(this).text();
                if(index==0){_group8=3}
                else if(index==1){_group8=2}
                else if(index==2){_group8=1}
                else{_group8=0}
                return;
            }
        })
        if(_answer8==''||_answer8==null){ mySwiper.swipeTo(9);return;}

        //第九题
        $('.q-answer').eq(8).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer9=$(this).text();
                if(index==0){_group9=3}
                else if(index==1){_group9=2}
                else if(index==2){_group9=1}
                else{_group9=0}
                return;
            }
        })
        if(_answer9==''||_answer9==null){ mySwiper.swipeTo(10);return;}

        //第十题
        $('.q-answer').eq(9).find('p').each(function(index){
            if($(this).css('color')=='rgb(20, 163, 209)'){
                _answer10=$(this).text();
                if(index==0){_group10=3}
                else if(index==1){_group10=2}
                else if(index==2){_group10=1}
                else{_group10=0}
                return;
            }
        })
        if(_answer10==''||_answer10==null){ mySwiper.swipeTo(11);return;}
        // console.log(_answer1+','+_answer2+','+_answer3+','+_answer4+','+_answer5+','+_answer6+','+_answer7+','+_answer8+','+_answer9+','+_answer10+',');
        // console.log(_group1+','+_group2+','+_group3+','+_group4+','+_group5+','+_group6+','+_group7+','+_group8+','+_group9+','+_group10+',');
        
        
        // 数据提交
        var _ansStr = 
    		{
    			"1":_answer1,
    			"2":_answer2,
    			"3":_answer3,
    			"4":_answer4,
    			"5":_answer5,
    			"6":_answer6,
    			"7":_answer7,
    			"8":_answer8,
    			"9":_answer9,
    			"10":_answer10
    	  	};// 答案json
    	var _scoreStr = 
    		{
    			"1":_group1,
    			"2":_group2,
    			"3":_group3,
    			"4":_group4,
    			"5":_group5,
    			"6":_group6,
    			"7":_group7,
    			"8":_group8,
    			"9":_group9,
    			"10":_group10
    	  	};// 分数json
    	console.log('123');

		_sex=$("input[name='sex']:checked").val();
        _marry=$("input[name='marry']:checked").val();
        _come=$("input[name='come']:checked").val();
    	$.ajax({
        	async:false,
        	url: 'server.php',
        	data:{
            	act:'mobSubmit',
            	type:'mobile',
    			sex:_sex,
    			marital:_marry,
    			income:_come,
    			scoreStr:_scoreStr,// 分数json串
    			ansStr:_ansStr// 答案json串
            	},
        	type: "post",
        	dataType:'json',
        	success:function(result){
                    console.log(result);
                 // 成功
                    switch(result.resType){
                        case 1:
                            $('#pop .pop-title').text('随性而为型');
                            $('#pop .pop-con').text('主要依照自己的性格而定，装修时不一定会严格控制金额或者过分追求品牌，注重的还是个人的兴趣爱好。比较不拘泥于小节，一些决定性的选择上虽然会参考他人的意见，最终还是坚持自己的选择。这一类人希望自己装饰的墙面在当下是自己非常满意的。');
                            break;

                        case 2:
                            $('#pop .pop-title').text('文艺青年型');
                            $('#pop .pop-con').text('文艺情结较为严重，比起价格，更注重于产品的质量。于装修而言，会选择一些口碑较好的品牌来进行装饰。这一类人，在追求质量的同时，更注重其外观感受，整体的协调性。如果条件允许，找一个专业的设计师对自己的小空间进行科学的规划，整体营造一个符合自己气质的小天地也是不错的一个选择。');
                            break;
                    
                        case 3:
                            $('#pop .pop-title').text('务实生活型');
                            $('#pop .pop-con').text('生活型的人注重的是生活本身，于品牌、价格、质量中，会选择最为经济实惠的。装修的时候，考虑问题更为全面，会进行多方比较从而得出最为有利于自己的选择。时尚与否、品牌的大小都不会是最后作于决定的关键，关键在于自身的综合利益。');
                            break;

                        case 4:
                            $('#pop .pop-title').text('时尚享受型');
                            $('#pop .pop-con').text('走在时尚的前沿是最重要的，质量不要太差即可，品牌一定要响亮。这一类人会时常关注各类时尚动态，装修时更注重整体的艺术感是否走在时尚的前沿，营造的整体氛围是否符合个人的生活体验。所以在选购材料的时候，会根据店家的推荐来辨别哪一款是流行款，而后再作出抉择。');
                            break;  
                        default:
                            alert('参数错误！');
                    }
                    $('.bg').fadeIn();
                    $('.pop-bg').fadeIn();   
        	}
    	});
        
    })

    // 开始测试
	var _sex='';
	var _marry='';
	var _come='';
    $('#btn-cs').bind('click',function(){
        _sex=$("input[name='sex']:checked").val();
        _marry=$("input[name='marry']:checked").val();
        _come=$("input[name='come']:checked").val();
        //参数判断
        if(_sex==''||_sex==null)
        {
            alert('请填写性别！');
            return;
        }
        if(_marry==''||_marry==null)
        {
            alert('请填写婚否！');
            return;
        }
        if(_come==''||_come==null)
        {
            alert('请填写收入！');
            return;
        }
        //成功后
        mySwiper.swipeNext();
    })
    //跳转到转盘
    $('.pop-btn,#pop-close').bind('click',function(){
        $('.bg').fadeOut();
        $('.pop-bg').fadeOut();
        mySwiper.swipeNext();
    })
};



function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=")
	  if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1 
		c_end=document.cookie.indexOf(";",c_start)
		if (c_end==-1) c_end=document.cookie.length
		return unescape(document.cookie.substring(c_start,c_end))
		} 
	  }
	return ""
}
var mySwiper1;
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);	
        new Marquee({
                MSClassID: "cn-run",
                ContentID: "ul-run",
                Direction: "top",
                Step: 2,
                Width: 280,
                Height: 30,
                Timer: 100,
                DelayTime: 1000,
                WaitTime: 0,
                AutoStart: 1
            });
    };

 
};
yt.init();

$("[name='sex']").bind('click',function(){
    $("[name='sex']").parent('.ad').removeClass('zf-h').addClass('zf');
    $(this).parent('.ad').removeClass('zf').addClass('zf-h');
})

$("[name='marry']").bind('click',function(){
    $("[name='marry']").parent('.ad').removeClass('zf-h').addClass('zf');
    $(this).parent('.ad').removeClass('zf').addClass('zf-h');
})

$("[name='come']").bind('click',function(){
    $("[name='come']").parent('.ad').removeClass('zf-h').addClass('zf');
    $(this).parent('.ad').removeClass('zf').addClass('zf-h');
})

$('.q-answer p').bind('click',function(){
    $(this).parent('.q-answer').find('p').removeClass('add');
    $(this).addClass('add');
    if($(this).find('input').length==0){
        $('#qs-6-oth').css('border-bottom','1px solid #fff');
        $('#qs-6-oth').css('color','#fff');
    }
    else{
        $('#qs-6-oth').css('border-bottom','1px solid #1ea0c9');
        $('#qs-6-oth').css('color','#1ea0c9'); 
    }
    
})

$('#popfx').bind('click',function(){
    $('.bg').fadeIn();
    $('.pop-qrcode').fadeIn();
})
$("#popgz").bind('click',function(){
    $('.bg').fadeIn();
    $('.pop-gz').fadeIn();
})
$("#popyd").bind('click',function(){
    $('.bg').fadeIn();
    $('.pop-yd').fadeIn();
})
$('.bg').bind('click',function(){
    if($('.pop-qrcode').css('display')=='block')
    {
        $('.bg').fadeOut();
        $('.pop-qrcode').fadeOut();
    }
    else if($('.pop-gz').css('display')=='block')
    {
        $('.bg').fadeOut();
        $('.pop-gz').fadeOut();
    }
    else if($('.pop-yd').css('display')=='block')
    {
        $('.bg').fadeOut();
        $('.pop-yd').fadeOut();
    }
    else{}
})

//抽奖


//var count=3;//次数
var vv=true;
    $('#zd').bind("click",function(){
        $.ajax({
            	async:false,
            	url: 'server.php',
            	data:{
                	act:'start'
                	},
            	type: "post",
            	dataType:'json',
            	success:function(result){
                    console.log(result);
                    if(result.errcode !=0)
                    {
                        alert(result.errmsg);
			    		return false;
                    }
                    else
                    {
                        if(vv){
                            switch (result.prize) {
                                case 1: 
                                    rotateFunc(0,0,'');
                                    count=count-1;
                                    break;
                                case 2: 
                                    rotateFunc(1,45,'空气净化器');
                                    count=count-1;
                                    break;
                                case 3: 
                                    rotateFunc(0,90,'');
                                    count=count-1;
                                    break;
                                case 4: 
                                    rotateFunc(2,135,'除螨机');
                                    count=count-1;
                                    break;
                                case 5: 
                                    rotateFunc(0,180,'');
                                    count=count-1;
                                    break;
                                case 6: 
                                    rotateFunc(3,225,'智能运动手环');
                                    count=count-1;
                                    break;
                                case 7: 
                                    rotateFunc(0,270,'');
                                    count=count-1;
                                    break;
                                default:
                                    rotateFunc(4,315,'扫地机');
                                    count=count-1;
                            }
                            vv=false;
                                
                         }
                         return false;
                    }
            		
            	}
        	});
            
    });

    setInterval(function(){ 
            vv=true;
     },6000);

    function rotateFunc(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
        $('#zd').stopRotate();
        $('#zd').rotate({
            angle: 0,
            duration: 5000,
            animateTo: angle + 1440,  //angle是图片上各奖项对应的角度，1440是让指针固定旋转4圈
            callback: function(){
                if(awards==0){
                    zj(awards,'');//第一个为奖项，第二个为奖品名
                }
                else{
                    zj(awards,text);
                }
            }
        });
    }
var price='';
function zj(type,text){
        
    if(type==0){//未中奖
        $('#pop2 .pop2-title').html('<p class="cu">谢谢参与！</p><p class="cu" style="padding-left:20px">再接再厉！</p>');
        $('#pop2 .pop2-title').css('padding-top','100px');
        $('#pop2 .pop2-con').hide();
        $('#pop2 .pop2-con2').show();
        $('#pop2 .pop2-btn p').text('确定');
    }
    else{
        $('#pop2 .pop2-title').text('恭喜你，中奖了！');
        $('#pop2 .pop2-con2').hide();
        $('#pop2 .pop2-con').show();
        price=text;
        $('#pop2 .pop2-btn p').text('提交');
    }
    $('.bg').fadeIn();
    $('.pop2-bg').fadeIn();
}
//姓名等信息提交
$('.pop2-btn').bind('click',function(){
    if($(this).text()=='提交'){
        var _name=$('#name').val();
        var _mobile=$('#mobile').val();
        var _address=$('#address').val();
        var _price=price;
        console.log(_price);
        if(_name==''||_mobile==''||_address==''){
            alert('信息不能未空！');
            return;
        }


		$.ajax({
                async:false,
                url: 'server.php',
                data:{
                    act:'add',
					name:_name,
                    address:_address,
                    phone:_mobile
                    },
                type: "post",
                dataType:'json',
                success:function(result){
                    console.log(result);
                    if(result.errcode !=0)
                    {
                        alert(result.errmsg);
                    }
                    else
                    {
                        //成功后
						$('#name').val('');
						$('#mobile').val('');
						$('#address').val('');


						$('.bg').fadeOut();
						$('.pop2-bg').fadeOut();
                    }
                    
                }
            });
        
    }
    else{
        $('.bg').fadeOut();
        $('.pop2-bg').fadeOut();
    }
    
})

$('#pop2-close').bind('click',function(){
    $('.bg').fadeOut();
    $('.pop2-bg').fadeOut();
})






























