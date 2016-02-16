	
    



			   // 头部菜单
			   $(function(){
			   		$('.title .menu').click(function(){
						if($(".title .title-row").hasClass("m-box")){
							var div = $(".title .m-box");
							if ( div.hasClass("hide") ) {
								div.removeClass("hide");
							} else {
								div.addClass("hide");
							}
						}else{
							var div = $(".title .m-box1");
							if ( div.hasClass("hide") ) {
								div.removeClass("hide");
							} else {
								div.addClass("hide");
							}
						}

					});

               });

			   // 活动规则弹窗
			   $(function(){
			   		$('.rule-btn').click(function(){
			   			$(".rule").show();
			   	    $('.rule').bind("touchmove",function(e){  
                      e.preventDefault();  
                }); 
			   		});

			   		$('.r-box .cls').click(function(){
			   			$(".rule").hide();
			   			$('body').css('overflow','auto');
			   		});

			   });


   			   	// 不是从朋友圈进来的点击我的提醒时弹出

			   	$(function(){
			   		$('.notice .n-btn').click(function(){
			   			$(".share").show();
			   			$(".notice").hide();
						$('.share').bind("touchmove",function(e){  
                      e.preventDefault();  
                }); 
			   		 
			   		});

			   		$('.share').click(function(){
			   			$(".share").hide();
			   			$('body').css('overflow','auto');
			   		});

			   });



		    // gototop
			$(function(){
			    $(window).scroll(function(){
			        if($(window).scrollTop()>4){
			            $(".top").show();
			        }else{
			            $(".top").hide();
			        }
			    });
			    $(".top").click(function(){
			        if(scroll=="off") return;
			        $("html,body").animate({scrollTop: 0}, 100);
			    });
		    });