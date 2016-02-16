
$(document).ready(function(){
    var winH = $(window).height();
    $(".onepage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 1000}, 500)
    });
    $(".twopage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 1402}, 500)
    });
    $(".threepage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 1836}, 500)
    });
    $(".fourpage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 2448}, 500)
    });
    $(".fivepage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 3228}, 500)
    });
    $(".sixpage").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 3860}, 500)
    });
    $(".top").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 0}, 500)
    });

    $('.date li').hover(function() {
        $(this).addClass('current').siblings().removeClass('current')
    });

    $('.datect li').hover(function() {
        var index2=$(this).index()
        $('.date li').eq(index2).addClass('current').siblings().removeClass('current')
        
    });






    var sx=0;
        var timer=null;
            $(".four_l ol li").click(function(event) {
            $(this).addClass('current').siblings().removeClass()
            var index=$(this).index()
            $(".four_l ul").animate({left:-608*index},500)
            sx=index
        });
  ///////////////////
        // 自动播放模块  //
        ///////////////////
        
        function func(){            // 抽离出指令
            sx++
            if(sx>13){ sx=0 }      // 虚拟索引值，取值 0~5，如果大于5，变成0
            $('.four_l ol li').eq(sx).addClass('current').siblings().removeClass();   // 指示器工作

            $('.four_l ul').stop().animate({ left: -608*sx }, 500)
        }
        timer = setInterval(func, 3000 )  


        $('.four_l').hover(function() {
            clearInterval(timer)
        }, function() {
            clearInterval(timer)
            timer = setInterval(func, 3000 )
        });          


        $('.next').click(function(event) {
            sx++
            if(sx>13){ sx=0 }
            $(".four_l ol li").eq(sx).addClass('current').siblings().removeClass()   
            $('.four_l ul').stop().animate({ left: -608*sx}, 500)      // 注意百分比和单位。
        });

        $('.prev').click(function(event) {
            sx--
            if(sx<0){ sx=13 }
            $(".four_l ol li").eq(sx).addClass('current').siblings().removeClass() 
            $('.four_l ul').stop().animate({ left: -608*sx }, 500)       // 注意百分比和单位。
        });


   

   
   
});