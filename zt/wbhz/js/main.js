
/*陈兴斌[croow@aliyun.com](www.somelittle.com) 20150414*/

var yt = yt || {} || window.yt ;
   
   yt = { 
   		bindHyChannel:function () {
        var $hy = $("#hychannel"),
            $p = $hy.find('p'),
            $ul = $hy.find('ul');

        $hy.hover(function () {
            $p.toggleClass('up');
            $ul.toggleClass('tg');
        });
    },
	bindTopNav:function () {

        var $topNav = $("#topNav"),
            $doc = $(document),
            htop = 0,
            height = 36,
            isDown = false;
        $(window).scroll(function () {
            var _htop = $doc.scrollTop(),
            _isDown = !!(_htop - htop > 0),
            _top = _isDown ? -height : 0;
            htop = _htop;
            if (_isDown == isDown) {
                return;
            }
            isDown = _isDown;
            $topNav.stop().animate({ top: _top }, 500);
        });
    }
	   
}


$(function(){  
    
 	//下拉菜单
	yt.bindHyChannel();
	//浮动top
    yt.bindTopNav();	
	
	
});

$(window).load(function(){
	
	function showhead(){
		
		$('.teyue').delay(200).animate({
			top: 246+"px",
			opacity:1
		},'easeInOutBack');
		
		$('.sj1').delay(800).animate({					
			opacity:0.9
		});
					
		$('.sj2').delay(1000).animate({					
			opacity:0.6
		});					
					
		$('.sj3').delay(1200).animate({					
			opacity:0.9
		});		
		
		$('.xzml').delay(1600).animate({
			top: 409+"px",
			opacity:1
		}, 600,'easeInOutBack');
		
		
		$('.wen').delay(2400).animate({
			bottom: 160+"px",
			opacity:1
		},500,'easeInOutBack');
		
		$('.shubiao').delay(2800).animate({
			bottom: 116+"px",
			opacity:1
		}, 800,'easeInOutBack');
	
	};
	
	function hidehead(){
		$('.sj1').css({opacity:0});
		$('.sj2').css({opacity:0});
		$('.sj3').css({opacity:0});
		$('.shubiao').css({bottom:-116+"px",opacity:0});
		$('.wen').css({bottom:-116+"px",opacity:0});
		$('.xzml').css({top:-103+"px",opacity:0});
		$('.teyue').css({top:-246+"px",opacity:0});
		
			
	}
	
	showhead();
	
						
	$('#fullpage').fullpage({
		verticalCentered: false,
		anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage', '5thpage','6thpage'],
		menu: '#menu',
		/*autoScrolling: false,*/
		scrollOverflow: true,
		afterLoad: function(anchorLink, index){			
			
			if(index == 1){
				
				showhead();
			
			}else{
				hidehead();			
			}
			
			
			if(index == 2){				
				$('.tbg1').delay(500).animate({
					top: 0,
					opacity:1
				}, 500);
				
				$('#focus').delay(1200).animate({
					left: 0,
					opacity:1
				});
				$('#focusright').delay(1200).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#thetalk').delay(1200).animate({
					right: 0,
					opacity:1
				}, 500);
				

			}else {
				
				$('.tbg1').css({top:-100+"px",opacity:0});
				$('#focus').css({left:-400+"px",opacity:0});
				$('#focusright').css({top:300+"px",opacity:0});
				$('#thetalk').css({right:-400+"px",opacity:0});
				
			}
			
			if(index == 3){
				
				$('.tbg2').delay(500).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#uc1').delay(500).animate({
					top: 160+"px",
					opacity:1
				}, 500);
				$('.tlad').delay(1200).animate({
					width:"100%"
				}, 500);
				

			}else {
				
				$('.tbg3').css({top:-100+"px",opacity:0});
				$('#uc1').css({top:500+"px",opacity:0});
				$('.tlad').delay(200).animate({
					width:0
				}, 500);
				
			}
			
			
			if(index == 4){
				
				$('.tbg3').delay(500).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#uc2').delay(500).animate({
					top: 160+"px",
					opacity:1
				}, 500);
				$('#unav2').delay(1000).animate({
					right: 0+"px",
					opacity:1
				}, 800, 'easeInOutBack');

			}else {
				
				$('.tbg4').css({top:-100+"px",opacity:0});
				$('#uc2').css({top:500+"px",opacity:0});
				$('#unav2').css({right:-200+"px",opacity:0});
				
			}
			
			if(index == 5){
				
				$('.tbg4').delay(300).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#adslider').delay(400).animate({
					left: 0+"px",
					opacity:1
				}, 500);
				$('#adtxt').delay(400).animate({
					right: 0+"px",
					opacity:1
				}, 500);
				
				$('#author').delay(1500).animate({
					top: 0+"px",
					opacity:1
				}, 800, 'easeInOutBack',function(){
					
					$('.s1').delay(100).animate({
						left: 0,
						opacity:1
					});
					$('.s2').delay(400).animate({
						left: 210+"px",
						opacity:1
					});
					$('.s3').delay(600).animate({
						left: 340+"px",
						opacity:1
					});
					$('.s4').delay(700).animate({
						left: 520+"px",
						opacity:1
					});
					
				});
				
				$('.footer').delay(2000).animate({
					marginTop: 0,
					opacity:1
				}, 500);
				

			}else {
				
				$('.tbg5').css({top:-100+"px",opacity:0});
				$('#adslider').css({left:-500+"px",opacity:0});
				$('#adtxt').css({right:-400+"px",opacity:0});
				$('#author').css({top:400+"px",opacity:0}).find(">span").css({left:1200+"px",opacity:0});				
				$('.footer').css({marginTop:300+"px",opacity:0})
				
			}
			
			
			if(index == 6){
				
				$('.tbg5').delay(500).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#uc1').delay(500).animate({
					top: 160+"px",
					opacity:1
				}, 500);
				$('.tlad').delay(1200).animate({
					width:"100%"
				}, 500);
				

			
				
				
				
				$('.tbg5').delay(300).animate({
					top: 0,
					opacity:1
				}, 500);
				$('#adslider').delay(400).animate({
					left: 0+"px",
					opacity:1
				}, 500);
				$('#adtxt').delay(400).animate({
					right: 0+"px",
					opacity:1
				}, 500);
				
				$('#author').delay(1500).animate({
					top: 0+"px",
					opacity:1
				}, 800, 'easeInOutBack',function(){
					
					$('.s1').delay(100).animate({
						left: 0,
						opacity:1
					});
					$('.s2').delay(400).animate({
						left: 210+"px",
						opacity:1
					});
					$('.s3').delay(600).animate({
						left: 340+"px",
						opacity:1
					});
					$('.s4').delay(700).animate({
						left: 520+"px",
						opacity:1
					});
					
				});
				
				$('.footer').delay(2000).animate({
					marginTop: 0,
					opacity:1
				}, 500);
				

			}else {
				
				$('.tbg5').css({top:-100+"px",opacity:0});
				$('#adslider').css({left:-500+"px",opacity:0});
				$('#adtxt').css({right:-400+"px",opacity:0});
				$('#author').css({top:400+"px",opacity:0}).find(">span").css({left:1200+"px",opacity:0});				
				$('.footer').css({marginTop:300+"px",opacity:0})
				$('.tbg5').css({top:-100+"px",opacity:0});
				$('#uc1').css({top:500+"px",opacity:0});
				$('.tlad').delay(200).animate({
					width:0
				}, 500);
				
			}
			
			/*if(index == 7){
				
				$('#author').delay(300).animate({
					top: 120+"px",
					opacity:1
				}, 800, 'easeInOutBack',function(){
					
					$('.s1').delay(100).animate({
						left: 0,
						opacity:1
					});
					$('.s2').delay(400).animate({
						left: 210+"px",
						opacity:1
					});
					$('.s3').delay(600).animate({
						left: 340+"px",
						opacity:1
					});
					$('.s4').delay(700).animate({
						left: 520+"px",
						opacity:1
					});
					
				});
				
				$('.footer').delay(800).animate({
					marginTop: 0,
					opacity:1
				}, 500);

			}else {				
				
				$('#author').css({top:400+"px",opacity:0}).find(">span").css({left:1200+"px",opacity:0});				
				$('.footer').css({marginTop:300+"px",opacity:0})
				
			}*/
			
			

			
		}
	});
	
	(function(){
		
		var $this = $("#focus"),
		$showpic = $("#showpic"),
		$num = $("#num"),
		len = $showpic.find("li").length;
		dc = $("#focusshowcontent").width(),
		index = 0
		;
		
		
	$num.find("li").hover(
		function() {
			index = $(this).index();			
			showPic(index)
		},
		function() {}
	);
		
	$this.hover(function() {
			if (MyTime) {
				clearInterval(MyTime);
			}
		},
		function() {
			MyTime = setInterval(function() {
					showPic(index);
					index++;
					if (index == len) {
						index = 0;
					}
				},
				5000);
		});

	var MyTime = setInterval(function() {
			showPic(index);
			index++;
			if (index == len) {
				index = 0;
			}
		},
		5000);
	
	function showPic(i){			
		$showpic.animate({left:-dc*i+"px"},300);
		$num.find("li").eq(i).addClass("on").siblings().removeClass("on");
		
	}
		
	}());
	
	(function(){
		
		$(".unav").each(function(){
			
			var $this = $(this);
			
			$this.find(">li:even").mouseover(function(){
				
				var index = $(this).index();
				
				if(index>=2){
					index=index-1;
				}
				
				$(this).addClass("hover").siblings().removeClass("hover");
				$this.parent().find(".uc").find(".uarea").eq(index).addClass("dis").siblings().removeClass("dis");			
												 
			});
			
		});
		
		$(".uimglist").each(function(i){
									 
			var $this = $(this);
			
			if(0==i){
				$this.find(">li").mouseover(function(){
					var index = $(this).index();
					$(this).addClass("hover").siblings().removeClass("hover");
					$this.parent().parent().find(".utxt").find(".ucon").eq(index).addClass("dis").siblings().removeClass("dis");	
				});
			}
		
		});
	
	}());
	
	(function() {

        var $this = $("#manarea"),
            $prev = $this.find(">a:first"),
            $next = $this.find(">a:last"),
            $manlist = $this.find("#manlist"),
            disc = $manlist.find("li").width(),
            len = $manlist.find("li").length,
			index = 0            
        ;

        var k = Math.ceil(len/2);
		
		$manlist.width(disc * k)+20;
      

        $prev.click(function() {
            index--;
			if(index<0){
				index = 0;	
			}
			showPic(index);
        });

        $next.click(function() {
            index++;
			if(index>=Math.ceil(k/4)){
				index = 0;	
			}
			showPic(index);
        });

        function showPic(i) {
           $manlist.animate({left:-disc*i+"px"},300);
        }

    }());
	
	(function() {

        var $this = $("#adslider"),
            $prev = $this.find(">a:first"),
            $next = $this.find(">a:last"),
            $adslidercon = $this.find("#adslidercon"),
            disc = $this.find("#adslidercon").width(),
            len = $adslidercon.find("ul>li").length,
            timerID
        ;

        $adslidercon.find("ul").width(disc * len);

        var autoPlay = function() {
            timerID = setInterval(function() {
                showPic(1)
            }, 5000);
        };

        var autoStop = function() {
            clearInterval(timerID);
        };

        $prev.click(function() {
            showPic(-1);
        });

        $next.click(function() {
            showPic(1);
        });

        function showPic(i) {
            if (1 == i) {
                $adslidercon.find('ul').stop().animate({
                    left: -disc + "px"
                }, 600, function() {
                    $adslidercon.find('ul').find(">li:first").appendTo($adslidercon.find('ul'));
                    $adslidercon.find('ul').css({
                        left: 0
                    });
                });
            } else {
                $adslidercon.find('ul').find(">li:last").prependTo($adslidercon.find('ul'));
                $adslidercon.find('ul').css({
                    left: -disc + "px"
                });
                $adslidercon.find('ul').stop().animate({
                    left: 0
                }, 600, function() {
                    $adslidercon.find('ul').css({
                        left: 0
                    });
                });
            }
        }

        $this.hover(autoStop, autoPlay).mouseout();
    }());
	
});



