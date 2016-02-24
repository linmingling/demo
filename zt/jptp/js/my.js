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
        //alert(mySwiper.activeIndex);
        
       


        onSlideChange();
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
			//mousewheelControl:true,
            mode: 'horizontal',
            noSwiping : true,
            noSwipingClass:'swiper-slide'
        });
    };

    $(".navmeau nav").on('touchstart mousedown',function(e){
        e.preventDefault()
        $(".navmeau nav").removeClass('active');
        $(this).addClass('active');
        mySwiper.swipeTo($(this).index());
    })
    $(".navmeau nav").click(function(e){
        e.preventDefault()
    })

    $(".sex").click(function(e){
        $(".sex").removeClass('bg-blue');
        $(this).addClass('bg-blue');
    })

    $(".prg").click(function(e){
        $(".prg").removeClass('bg-blue');
        $(this).addClass('bg-blue');
    })
    //page2 数据切换
    $("#page2-tag div").click(function(e){
        $("#page2-tag div").removeAttr("style");
        $(this).attr('style','background-color: #cc230d;color: #fff;');
        var sj=$("#page2-tag-sj");
        var type=$(this).attr('data');
        var mydata='';

		//请求后台
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'list',type:type},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					return false;
				}else{
					var test1 = result.errmsg;
					var imgurl;
	            	for(i=0;i<test1.length;i++){
						if(test1[i]['imgurl']==null) 
						{
							imgurl = 'images/demo1.jpg';
						}
						else
						{
							imgurl = 'uploads/img/' + test1[i]['imgurl'];
						}
						mydata=mydata+"<div zdy="+test1[i]['id']+"><img src="+imgurl+"><p>"+test1[i]['name']+"</p></div>"
					}
					return false;
				}
				
			}
		});

		sj.html(mydata); 
    })
    //page3 排行版切换
    $("#page3-tag div").click(function(e){
        $("#page3-tag div").removeAttr("style");
        $(this).attr('style','background-color: #cc230d;color: #fff;');
        var sj=$("#pm");
        var type=$(this).attr('data');
        var mydata='<tr><th>排名</th><th>姓名</th><th>编号</th><th>票数</th></tr>';
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'rank',type:type},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					return false;
				}else{
					var test1 = result.errmsg;
	            	for(i=0;i<test1.length;i++){
						mydata=mydata+"<tr><td>"+test1[i]['num']+"</td><td>"+test1[i]['name']+"</td><td>"+test1[i]['id']+"</td><td>"+test1[i]['vote']+"</td></tr>"
					}
					return false;
				}
				
			}
		});

		sj.html(mydata); 
        

        //排名前三显示红色
        $("#pm tr").eq(1).find('td').eq(0).css('color','red');
        $("#pm tr").eq(2).find('td').eq(0).css('color','red');
        $("#pm tr").eq(3).find('td').eq(0).css('color','red');
    })

    //page2详情页
    $("#page2-tag-sj").on("click","div",function(e){
        var id=$(this).attr('zdy');//获取id

		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'detail',id:id},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					alert(result.errmsg);
					return false;
				}else{
					var imgurl;
					if(result.errmsg.imgurl==null) 
					{
						imgurl = 'images/demo1.jpg';
					}
					else
					{
						imgurl = 'uploads/img/' + result.errmsg.imgurl;
					}
					
					//投票识别编号
					$(".page2-btn-ly-1").attr('data',result.errmsg.id);
					//姓名
					$("#page2-d2-name").text(result.errmsg.name);
					//编号
					$("#page2-d2-no").text(result.errmsg.id);
					//照片
					$("#page2-d2-img").attr('src',imgurl);
					//参赛宣言
					$("#page2-d2-con").text(result.errmsg.content);
					//当前票数
					$("#page2-d2-ps").text(result.errmsg.vote);
					//当前排名
					$("#page2-d2-pm").text(result.errmsg.vote_rank);
					//距离上一名还差票数
					$("#page2-d2-to").text(result.errmsg.bvote);
					$("#page2-d1").hide();
					$("#page2-d2").fadeIn();
					return false;
				}
				
			}
		});

        
    })

	//投票
	$("#voteFor").click(function(){
		var id = $(".page2-btn-ly-1").attr('data');
		console.log(id);
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'vote',id:id},
			type: "post",
			dataType:'json',
			success:function(result){
				console.log(result);
				//数据返回后执行
				if(result.errcode != 0){
					alert(result.errmsg);
					return false;
				}else{
					var vote = $("#page2-d2-ps").html();
					$("#page2-d2-ps").html(parseInt(vote) + 1);
					alert(result.errmsg);
					return false;
				}
				
			}
		});
		
	})

    //我要报名
    $("#wybm").click(function(e){
        e.preventDefault()
        $(".navmeau nav").removeClass('active');
        $(".navmeau nav").eq(3).addClass('active');
        mySwiper.swipeTo(3);
    })
    //返回列表
    $("#page2-d2-fan").click(function(e){
        $("#page2-d2").hide();
        $("#page2-d1").fadeIn();
    })
    //搜索
    $('.page2-button').click(function(e){
        var keyword=$(this).parent().find('input').val();//搜索内容
		
		//alert(keyword);
        var mydata='';//结果

		//请求后台
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'list',search:keyword},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					return false;
				}else{
					var test1 = result.errmsg;
					var imgurl;
	            	for(i=0;i<test1.length;i++){
						if(test1[i]['imgurl']==null) 
						{
							imgurl = 'images/demo1.jpg';
						}
						else
						{
							imgurl = 'uploads/img/' + test1[i]['imgurl'];
						}
						mydata=mydata+"<div zdy="+test1[i]['id']+"><img src="+imgurl+"><p>"+test1[i]['name']+"</p></div>"
					}
					return false;
				}
				
			}
		});

        $("#page2-tag-sj").html(mydata); 



        $(".navmeau nav").removeClass('active');
        $(".navmeau nav").eq(1).addClass('active');
        mySwiper.swipeTo(1);
        $("#page2-tag div").removeAttr("style");
        $(this).parent().find('input').val('');
        $("#page2-d2").hide();
        $("#page2-d1").fadeIn();
    })

    //参加报名
    $("#btn-bm").click(function(e){
        $('.bg').fadeIn();
        $('.pop-cj').fadeIn();
    })

    // //图片上传
    // $("#fileToUpload").click(function(){     
        
        
    // }) 
    var vv=true;
    $('#fileToUpload').on('change', function() { 
        //加载  
         $("#filecon").text('正在上传...');
		 var endTag = true;
     //    上传文件
         $.ajaxFileUpload({
             url:'upload.php',//处理图片脚本
             secureuri :false,
             fileElementId :'fileToUpload',//file控件id
             dataType : 'json',
             success : function (result){
                 if(result.errcode != 0){
                     alert(result.errmsg);
					 $("#filecon").text('上传图片...');
					 endTag = false;
					 return false;
                 }else{
					 
                     $("#filecon").text('上传成功');
					 return false;
                 }
             }
         })

		if(endTag)
		{
			$("#filecon").text('上传成功');
		}

    })


    //提交报名数据
    $("#bmtj").click(function(){ 
        if(vv){
            vv=false;
            //姓名
            var name=$("#bm-name").val();
            //性别
            var sex=$("#bm-sex .bg-blue").text();
            //项目选择
            var type=$("#bm-type .bg-blue").attr('data');
            //所在门店
            var shop=$("#bm-shop").val();
            //参赛宣言
            var content=$("#bm-xy").val();
            //请求后台
			$.ajax({
				async:false,
				url: 'server.php',
				data:{act:'addinfo',name:name,gender:sex,type:type,shop:shop,content:content},
				type: "post",
				dataType:'json',
				success:function(result){
					//数据返回后执行
					if(result.errcode != 0){
						alert(result.errmsg);
						vv=true;
						return false;
					}else{
						//数据提交成功后执行
						$("#bm-img").val('');
						$("#bm-name").val('');
						$("#bm-shop").val('');
						$("#bm-xy").val('');
						$('.pop-cj').fadeOut();
						$('.pop-sc').fadeIn();
						vv=true;
						return false;
					}
					
				}
			});
            
        }
        
    })

    $('.bg').click(function(){ 
        $('.bg').fadeOut();
        $('.pop-cj').fadeOut();
        $('.pop-sc').fadeOut();
    })

    //滚到下一个屏  
    var bindNext = function () {
        $(".next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
       
            mySwiper.swipeTo(index);
        });
    };

	
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
};
	

//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		//page2
		var p2text = '';
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'list',type:1},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					return false;
				}else{
					var test1 = result.errmsg;
					var imgurl;
	            	for(i=0;i<test1.length;i++){
						if(test1[i]['imgurl']==null) 
						{
							imgurl = 'images/demo1.jpg';
						}
						else
						{
							imgurl = 'uploads/img/' + test1[i]['imgurl'];
						}
						p2text=p2text+"<div zdy="+test1[i]['id']+"><img src="+imgurl+"><p>"+test1[i]['name']+"</p></div>"
					}
					return false;
				}
				
			}
		});
        $("#page2-tag-sj").html(p2text); 
        //page3
        var mydata='<tr><th>排名</th><th>姓名</th><th>编号</th><th>票数</th></tr>';
        $.ajax({
			async:false,
			url: 'server.php',
			data:{act:'rank',type:1},
			type: "post",
			dataType:'json',
			success:function(result){
				//数据返回后执行
				if(result.errcode != 0){
					return false;
				}else{
					var test1 = result.errmsg;
	            	for(i=0;i<test1.length;i++){
						mydata=mydata+"<tr><td>"+test1[i]['num']+"</td><td>"+test1[i]['name']+"</td><td>"+test1[i]['id']+"</td><td>"+test1[i]['vote']+"</td></tr>"
					}
					return false;
				}
				
			}
		});
        $("#pm").html(mydata); 
        //排名前三显示红色
        $("#pm tr").eq(1).find('td').eq(0).css('color','red');
        $("#pm tr").eq(2).find('td').eq(0).css('color','red');
        $("#pm tr").eq(3).find('td').eq(0).css('color','red');
    };

 
};
yt.init();













