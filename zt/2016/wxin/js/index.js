
$(document).ready(function(){
 



    /*分屏滚动开始*/
    var num=0;
    var timer=null;
    var page=0;
    var nnum=0
    
    $(document).mousewheel(function(index,d){
        
        num=num-d
        
        if(num>5){num=5}
        if(num<0){num=0}
        
        $(".bigbox").animate({"top":-num*100+'%'},500)
        $(".sidenav li").eq(num).addClass('current').siblings().removeClass()
        $("nav ul li a").removeClass('current')
        $("nav ul li a").eq(num).addClass('current').siblings().removeClass('current')
        page=num
        
      $(".page").eq(page).removeClass('out').siblings().addClass('out')
      

    });
       

    // 点击侧导航出效果
    $(".sidenav li").click(function(event) {
        num=$(this).index()
        $(".bigbox").animate({"top":-num*100+'%'},500)
        $(".sidenav li").eq(num).addClass('current').siblings().removeClass()
        $("nav ul li a").removeClass('current')
        $("nav ul li a").eq(num).addClass('current').siblings().removeClass()

        page=num
        
      $(".page").eq(page).removeClass('out').siblings().addClass('out')
    });
     
    $('.detail').click(function(event) {
        $('.open').show()
    });
    $('.close').click(function(event) {
        $('.open').hide()
    });


    $(".openjm1").click(function(event) {
        $(".jiemi li").eq(0).show();
    });
    $(".openjm2").click(function(event) {
        $(".jiemi li").eq(1).show();
    });
    $(".openjm3").click(function(event) {
        $(".jiemi li").eq(2).show();
    });
    $(".openjm4").click(function(event) {
        $(".jiemi li").eq(3).show();
    });

   $('.tpjiemi1').click(function(event) {
        $(".jiemi li").eq(0).hide()
   });
   $('.tpjiemi2').click(function(event) {
        $(".jiemi li").eq(1).hide();

   });
   $('.tpjiemi3').click(function(event) {
        $(".jiemi li").eq(2).hide();

   });
   $('.tpjiemi4').click(function(event) {
        $(".jiemi li").eq(3).hide();

   });
    
    
})