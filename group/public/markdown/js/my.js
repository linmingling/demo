
    $('.bg2 .Top').css('height',$(window).height()*0.3);
// countdown
function showTime(deadline,dom) {
    var countdown = new Date(deadline) - new Date();
    
    var restDays = dom.find(".days");
    var restHours = dom.find(".hours");
    var restMinutes = dom.find(".minutes");
    var restSeconds = dom.find(".seconds");

    var timer = setInterval(function() {
        if(countdown<0){
            clearInterval(timer);
            return false;
        }
        var days = Math.floor(countdown / 86400000) < 0 ? 0 : Math.floor(countdown / 86400000);
        var hours = Math.floor((countdown - days * 86400000) / 3600000) < 0 ? 0 : Math.floor((countdown - days * 86400000) / 3600000);
        var minutes = Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000);
        var seconds = Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000);          
        days < 10 ? days = "0" + days : days = days;
        hours < 10 ? hours = "0" + hours : hours = hours;
        minutes < 10 ? minutes = "0" + minutes : minutes = minutes;
        seconds < 10 ? seconds = "0" + seconds : seconds = seconds;

        //alert(days+", "+hours+", "+minutes+", "+seconds);
        restDays.html(days);
        restHours.html(hours);
        restMinutes.html(minutes);
        restSeconds.html(seconds);
        countdown -= 1000;
    }, 1000)
    
}
// pre
$(function(){
    $(".fore").each(function(){
        showTime($(this).attr("djs"),$(this));
    });
});   

// ing
// $(function(){
//     $(".ing").each(function(){
//         showTime($(this).attr("djs"),$(this));
//     });
// }); 

$(function(){
    $(".bk-fore").each(function(){
        showTime($(this).attr("djs"),$(this));
    });
});  


// 弹窗

// 活动规则
$(function(){
    $('.r-btn').click(function(){
        $(".rule").show();
    })

    $('.cls').click(function(){
        $(".rule").hide();
    })
})



// 商品详情跳转

// $(function(){
//     $('.goods').click(function(){

// })






// 帮砍滚动条


     //窗口大小发生改变时,iphone横屏情况
    $(window).resize(function() {
      $('.tiaoGray').css('background-size',$('.tiaoColor').width());
      if ($(window).height()<$(window).width()){
        $('.tiaoGray').css('top','7.5px');
      } else {
        $('.tiaoGray').css('top','0');
      }
      
    });


    /* ajax jsonp请求操作   */
    function ajax_jsonp(p_url, p_data, p_type) {
        $.ajax({
            url:p_url,
            data:p_data,
            type: p_type,
            dataType:'jsonp',
            jsonp:'callback', 

            success:function(result){
                return result;
            }       
        });
    }
    

    //当前价格动态变化
    function pricechange(c_price,origin_price,times){
        //每次变化数
        var i,n;
        i = 0;
        n = (origin_price - c_price) /times;
        var time = setInterval(function(){
            if (i<=times) {
                var current = (origin_price -i*n).toFixed(2);
                $('.Bargain').html(current);
                i++;
            } else {
                clearInterval(time);
            }
        },1000/times);
    }
    //进度条动态变化
    function jingduwidth(prefer,current){
        return eval(0.24 + (prefer-current)/prefer*0.658);
    }
    function jingduleft(prefer,current){
        return eval(0.54 - (prefer-current)/prefer*0.658);
    }

