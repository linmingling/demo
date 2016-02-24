// $(document).ready(function(){
//     alert()
// })
$(function(){
    $('nav li').hover(function() {
        var index=$(this).index()
        $(this).addClass('current').siblings().removeClass()
        $(".main ul").children('li').eq(index).addClass('current').siblings().removeClass()
   
        


        // if(index=1){
        //    $(".main ul li").eq(1).children().show() 

        // }


        if(index==0){
            $('.bg').css({"background-image":"url(img/bg1.jpg)"
            });
        }
        else{
            $('.bg').css({"background-image":"url(img/bg2.jpg)"
            });
        }


        


        

    });

    // $('nav li').click(function(event) {
    //     var index=$(this).index()
    //     $(this).addClass('current').siblings().removeClass()
    //     $(".main ul").children('li').eq(index).addClass('current').siblings().removeClass()
    //     console.log($(".main ul").children().html())
    //     if(index=1){
    //        $(".main ul li").eq(1).children().show() 
    //     }
    // });



    // 第二页的轮播图
    var sx=0
    $(".second .turnright").click(function(event) {
        sx++
        if(sx>3){sx=3}
        $('.second ol').stop().animate({left:-1140*sx},1000) 
    });

    $(".second .turnleft").click(function(event) {
        sx--
        if(sx<0){sx=0}
        $('.second ol').stop().animate({left:-1140*sx},1000) 
    });

    // 第三页
    $(".third_left ul li").hover(function(){
        var index3=$(this).index()
        $(".third_left ul li").children('img').removeClass('current')
        $(this).children().addClass('current')

        $('.third_left ol li').eq(index3).addClass('current').siblings().removeClass()
        $('.third_right ul li').eq(index3).addClass('current').siblings().removeClass()

    });

    // 第四页
        var ssss=0
    $('.fourth .prev').click(function(event) {
        ssss--
        if(ssss<0){ssss=11}
        var n=ssss+1
        if (n<0) {n=11};
        var n2=n+1
        if(n2<0){n2=11}
        var p=ssss-1
        if(p<0){p=11}
        var p2=p-1
        if(p2<0){p2=11}
        $('.fourth ol li').eq(ssss).removeClass().addClass('one').siblings().removeClass('one')
        $('.fourth ol li').eq(n).removeClass().  addClass('second_r').siblings().removeClass('second_r')
        $('.fourth ol li').eq(n2).removeClass().  addClass('third_r').siblings().removeClass('third_r')
        $('.fourth ol li').eq(p).removeClass().  addClass('second_l').siblings().removeClass('second_l')
        $('.fourth ol li').eq(p2).removeClass().addClass('third_l').siblings().removeClass('third_l')
        
        $(".fourth ul li").eq(ssss).addClass('current').siblings().removeClass()
    });


    // $('.fourth .next').click(function(event) {
    //     ssss++
    //     if(ssss>11){ssss=0}
    //     var n=ssss+1
    //     if (n>11) {n=0};
    //     var n2=n+1
    //     if(n2>11){n2=0}
    //     var p=ssss-1
    //     if(p>11){p=0}
    //     var p2=p-1
    //     if(p2>11){p2=0}
    //     $('.fourth ol li').eq(ssss).removeClass().addClass('one').siblings().removeClass('one')
    //     $('.fourth ol li').eq(n).removeClass().  addClass('second_r').siblings().removeClass('second_r')
    //     $('.fourth ol li').eq(n2).removeClass().  addClass('third_r').siblings().removeClass('third_r')
    //     $('.fourth ol li').eq(p).removeClass().  addClass('second_l').siblings().removeClass('second_l')
    //     $('.fourth ol li').eq(p2).removeClass().addClass('third_l').siblings().removeClass('third_l')
    // });

    $('.fourth .next').click(function(event) {
        ssss++
        if(ssss>11){ssss=0}
        var n=ssss+1
        if (n>11) {n=0};
        var n2=n+1
        if(n2>11){n2=0}
        var p=ssss-1
        if(p>11){p=0}
        var p2=p-1
        if(p2>11){p2=0}
        $('.fourth ol li').eq(ssss).removeClass().addClass('one').siblings().removeClass('one')
        $('.fourth ol li').eq(n).removeClass().  addClass('second_r').siblings().removeClass('second_r')
        $('.fourth ol li').eq(n2).removeClass().  addClass('third_r').siblings().removeClass('third_r')
        $('.fourth ol li').eq(p).removeClass().  addClass('second_l').siblings().removeClass('second_l')
        $('.fourth ol li').eq(p2).removeClass().addClass('third_l').siblings().removeClass('third_l')
        $(".fourth ul li").eq(ssss).addClass('current').siblings().removeClass()

    });

    $('.fourth ol li').click(function() {
        ssss=$(this).index()
        if(ssss>11){ssss=0}
        var n=ssss+1
        if (n>11) {n=0};
        var n2=n+1
        if(n2>11){n2=0}
        var p=ssss-1
        if(p>11){p=0}
        var p2=p-1
        if(p2>11){p2=0}

        $('.fourth ol li').eq(ssss).removeClass().addClass('one').siblings().removeClass('one')
        $('.fourth ol li').eq(n).removeClass().  addClass('second_r').siblings().removeClass('second_r')
        $('.fourth ol li').eq(n2).removeClass().  addClass('third_r').siblings().removeClass('third_r')
        $('.fourth ol li').eq(p).removeClass().  addClass('second_l').siblings().removeClass('second_l')
        $('.fourth ol li').eq(p2).removeClass().addClass('third_l').siblings().removeClass('third_l')
        $(".fourth ul li").eq(ssss).addClass('current').siblings().removeClass()

    });




    // 首页屏幕滑动效果
    // $(window).on('mousemove', function(e) {
    // var w = $(window).width();
    // var h = $(window).height();
    // var offsetX = 0.5 - e.pageX / w;
    // var offsetY = 0.5 - e.pageY / h;
     
       
    // // $(".parallax").each(function(i, el) {
    // //     var offset = parseInt($(el).data('offset'));
    // //     var translate = "translate3d(" + Math.round(offsetX * offset) + "px," + Math.round(offsetY * offset) + "px, 0px)";
         
    // //     $(el).css({
    // //         '-webkit-transform': translate,
    // //         'transform': translate,
    // //         'moz-transform': translate
    // //     });
    // // });
    // $(".parallax").animate({
    //     left: offsetX"+"w,
    //     },
        
    //     /* stuff to do after animation is complete */
    // });

    // });


    
})


$(window).on('mousemove', function(e) {
    var w = $(window).width();
    var h = $(window).height();
    var offsetX = 0.5- e.pageX / w;
    var offsetY = 0.6 - e.pageY / h;
        
    $(".parallax").each(function(i, el) {
        var offset = parseInt($(el).data('offset'));
        var translate = "translate3d(" + Math.round(offsetX * offset) + "px," + Math.round(offsetY * offset) + "px, 0px)";
         
        $(el).css({
            '-webkit-transform': translate,
            'transform': translate,
            'moz-transform': translate
        });
    });
});