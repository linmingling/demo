
$(document).ready(function(){

    $(".nav ul li").eq(0).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 814}, 500)
    });
    $(".nav ul li").eq(1).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 1498}, 500)
    });
    $(".nav ul li").eq(2).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 1948}, 500)
    });
    $(".nav ul li").eq(3).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 2604}, 500)
    });
    $(".nav ul li").eq(4).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 3222}, 500)
    });
    $(".nav ul li").eq(5).click(function(event) {
        $('html,body').stop().animate({ scrollTop: 3760}, 500)
    });
    $(".backtop").click(function(event) {
        $('html,body').stop().animate({ scrollTop: 0}, 500)
    });

     // $('html,body').stop().animate({ scrollTop: 1900}, 500)
    /////////////////////////////
    /////////贺岁的轮播图///////
    /////////////////////////////
    var sx=0;
    var timer=null;
    $(".four_l ol li").click(function(event) {
        $(this).addClass('current').siblings().removeClass()
        var index=$(this).index()
        $(".four_l ul").animate({left:-678*index},500)
        sx=index
    });
    // 自动播放模块  //
    function func(){            // 抽离出指令
        sx++
        if(sx>13){ sx=0 }       /////////按照实际图片张数设置数字大小
        $('.four_l ol li').eq(sx).addClass('current').siblings().removeClass();  
        $('.four_l ul').stop().animate({ left: -678*sx }, 500)
    }
    timer = setInterval(func, 3000 )  
    ///////触摸到图停止自动切换///////
    $('.four_l').hover(function() {
        clearInterval(timer)
    }, function() {
        clearInterval(timer)
        timer = setInterval(func, 3000 )
    }); 
    //////下一张///////         
    $('.next2').click(function(event) {
        sx++
        if(sx>13){ sx=0 } /////////按照实际图片张数设置数字大小
        $(".four_l ol li").eq(sx).addClass('current').siblings().removeClass()   
        $('.four_l ul').stop().animate({ left: -678*sx}, 500)     
    });
    ////////前一张///////
    $('.prev2').click(function(event) {
        sx--
        if(sx<0){ sx=13 } /////////按照实际图片张数设置数字大小
        $(".four_l ol li").eq(sx).addClass('current').siblings().removeClass() 
        $('.four_l ul').stop().animate({ left: -678*sx }, 500)      
    });

        /////////////////////////////
        /////////甩单的轮播图///////
        /////////////////////////////
    var sx2=0;
    var timer2=null;
    /////点击原点进行切换图/////////
    $(".four_l2 ol li").click(function(event) {
        $(this).addClass('current').siblings().removeClass()
        var index2=$(this).index()
        $(".four_l2 ul").animate({left:-678*index2},500)
        sx2=index2
    });
    //////自动播放模块 //////
    function func2(){            // 抽离出指令
        sx2++
        if(sx2>13){ sx2=0 }       /////////按照实际图片张数设置数字大小
        $('.four_l2 ol li').eq(sx2).addClass('current').siblings().removeClass();  
        $('.four_l2 ul').stop().animate({ left: -678*sx }, 500)
    }
    timer2 = setInterval(func2, 3000 )  
    ///////触摸到图停止自动切换///////
    $('.four_l2').hover(function() {
        clearInterval(timer2)
    }, function() {
        clearInterval(timer2)
        timer2 = setInterval(func2, 3000 )
    });          
    //////下一张////////
    $('.next3').click(function(event) {
        sx2++
        if(sx2>13){ sx2=0 } /////////按照实际图片张数设置数字大小
        $(".four_l2 ol li").eq(sx2).addClass('current').siblings().removeClass()   
        $('.four_l2 ul').stop().animate({ left: -678*sx2}, 500)      
    });
    ////////前一张///////
    $('.prev3').click(function(event) {
        sx2--
        if(sx2<0){ sx2=13 } /////////按照实际图片张数设置数字大小
        $(".four_l2 ol li").eq(sx2).addClass('current').siblings().removeClass() 
        $('.four_l2 ul').stop().animate({ left: -678*sx2 }, 500)       
    });



    ////////////////////
    ///starbook/////////
    ///////////////////
    sx3=0
    $(".prev").click(function(event) {
        sx3--
        if(sx3<0){ sx3=5 }  /////////按照实际图片张数设置数字大小
        $(".book").stop().animate({ left: -326*sx3 }, 500)   
    });
    $(".next").click(function(event) {
        sx3++
        if(sx3>5){ sx3=0 }   /////////按照实际图片张数设置数字大小
        $(".book").stop().animate({ left: -326*sx3 }, 500)   
    });




    //////////////////
    ////城市切换//////
    //////////////////
    var timer3=null;
    var sx4=0;
    // var cityji=["北京","天津","上海","沧州","承德","秦皇岛","邢台","石家庄","衡水","邯郸","唐山","张家山","廊坊","保定","哈尔滨","佳木斯","齐齐哈尔","绥化","济南","济南","济南","济南","济南","济南","济南","德州","潍坊","泰安","烟台"，"太原","朔州","离石","晋城","临汾","忻州","阳泉","乐山加盟商","绵阳加盟商","南充加盟商","自贡加盟商","常州","黄山","昆明"];
    var cityji=["北京","天津","上海","沧州","承德","秦皇岛","邢台","石家庄","衡水","邯郸","唐山","张家山","廊坊","保定","哈尔滨","佳木斯","齐齐哈尔","绥化","济南","青岛","淄博","东营","滨州","聊城","菏泽","德州","潍坊","泰安","烟台","太原","朔州","离石","晋城","临汾","忻州","阳泉","乐山","绵阳","南充","自贡","常州","黄山","昆明"]
    console.log(cityji[4])

    var sx4=0

     function func3(){
        total1=sx4
        total2=parseInt(total1)+1 
        total3=parseInt(total2)+1
        total4=parseInt(total3)+1
        total5=parseInt(total4)+1
        total6=parseInt(total5)+1
        total7=parseInt(total6)+1
        total8=parseInt(total7)+1
        total9=parseInt(total8)+1
        total10=parseInt(total9)+1
        total11=parseInt(total10)+1
        $("#cityname li").eq(0).text(cityji[total1])
        $("#cityname li").eq(1).text(cityji[total2])
        $("#cityname li").eq(2).text(cityji[total3])
        $("#cityname li").eq(3).text(cityji[total4])
        $("#cityname li").eq(4).text(cityji[total5])
        $("#cityname li").eq(5).text(cityji[total6])
        $("#cityname li").eq(6).text(cityji[total7])
        $("#cityname li").eq(7).text(cityji[total8])
        $("#cityname li").eq(8).text(cityji[total9])
        $("#cityname li").eq(9).text(cityji[total10])
        sx4++
        if(sx4>33){
        sx4=0
        }
     }
     timer3=setInterval(func3, 2000)
});