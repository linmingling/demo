/**
 *@author borey
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */
document.documentElement.style.height = window.innerHeight + 'px';
var mySwiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    loop: false,
    resistanceRatio: 0,
    // 如果需要分页器
    pagination: '.swiper-pagination',
    onInit: function(swiper) { //Swiper  2.x的初始化是onFirstInit
        swiperAnimateCache(swiper); //隐藏动画元素
        swiperAnimate(swiper); //初始化完成开始动画
    },
    onSlideChangeEnd: function(swiper) {
        swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
    }
});
$("#tiaoguo").bind("touchstart",function(){
    if(isLoad){
        closeModule("#firsthalf");
        mOpenScene.onOpenAni();
    }
    else{
        closeModule("#firsthalf");
        openModule("#load_module");
    }

});
$("#startBtn").bind("touchstart",function(){
    if(isLoad){
        closeModule("#firsthalf");
        mOpenScene.onOpenAni();
    }
    else{
        closeModule("#firsthalf");
        openModule("#load_module");
    }

});
$("#submit").bind("touchstart",function(){
//				表单成功的话执行下面2行  否则alert(错误信息)
    var name = $("#user_name").val();
    var phone = $("#user_phone").val();

    $.ajax({
        async:false,
        url: 'server.php',
        data:{
            act:'subInfo',
            name:name,
            phone:phone
        },
        type: "post",
        dataType:'json',
        success:function(result){
            $("#sucessmes").html("感谢您的提交，信息已经提交成功！");
            console.log(result);
            if(result.errcode != 0)
            {
                $("#sucessmes").html(result.errmsg);
            }
        },
        error: function(XMLHttpRequest) {
            if(XMLHttpRequest.readyState != '4'){
                alert("网络异常,信息提交失败");
                window.location.reload()
            }
        }
    });

    closeModule("#info_module");
    openModule("#tips_module");
});

$("#rule_res").bind("touchstart",function(){
    closeModule("#rule_module");
});
$("#win_res").bind("touchstart",function(){
    closeModule("#win_module");
});
$("#rank_res").bind("touchstart",function(){
    closeModule("#rank_module");
});
$("#tips_res").bind("touchstart",function(){
    closeModule("#tips_module");
});
$("#user_name").bind("touchstart",function(){
    $(this).focus();
    $("#user_phone").blur();
});
$("#user_phone").bind("touchstart",function(){
    $(this).focus();
    $("#user_name").blur();
});
function openModule(id){
    if(id == "#rank_module"){
        // 排行榜
        $.ajax({
            async:false,
            url: 'server.php',
            data:{act:'rank'},
            type: "post",
            dataType:'json',
            success:function(result){
                var arr = new Array();
                arr = result.paihang;
                var htmlblock = '<ul class="rank_fir hor"><li class="rank_num"><strong>名次</strong> </li><li class="rank_name"><strong>名称</strong></li><li class="rank_score"><strong>分数</strong> </li></ul>';
                for (var i=0;i<arr.length;i++) {
                    htmlblock += '<ul class="rank_nor hor"><li class="rank_num">' + arr[i]['mingci'] + '</li><li class="rank_name">' + arr[i]['wechaname'] + '</li><li class="rank_score">' + arr[i]['score'] + '</li></ul>';
                }
                $(".rank_text").html(htmlblock);
            },
            error: function(XMLHttpRequest) {
                if(XMLHttpRequest.readyState != '4'){
                    alert("网络异常");
                }
            }
        });
    }else if(id == "#win_module"){
        // 获奖名单
        /*$.ajax({
         async:false,
         url: 'server.php',
         data:{act:'award'},
         type: "post",
         dataType:'json',
         success:function(result){
         var arr = new Array();
         arr = result.prizeList;
         var htmlblock2 = '<ul class="win_fir hor"><li class="win_name"><strong>名称</strong></li><li class="win_price"><strong>奖品</strong></li></ul>';
         for (var i=0;i<arr.length;i++) {
         htmlblock2 += '<ul class="win_nor hor"><li class="win_name">' + arr[i]['wechaname'] + '</li><li class="win_price">' + arr[i]['prize'] + '</li></ul>';
         }
         $(".win_text").html(htmlblock2);
         },
         error: function(XMLHttpRequest) {
         if(XMLHttpRequest.readyState != '4'){
         alert("网络异常");
         }
         }
         });*/
        $(".win_text").html('<ul class="win_fir hor"><li class="win_name"><strong>名称</strong></li><li class="win_price"><strong>奖品</strong></li></ul><ul><div style="text-align:center">敬请期待</div></ul>');
    }
    $(id).show();
}
function closeModule(id){
    $(id).hide();
}
function onPostData() {
    //提交游戏得分GameScore
    var _0x3dd1=["\x70\x61\x72\x73\x65","\x55\x74\x66\x38","\x65\x6E\x63","\x32\x30\x31\x35\x30\x33\x31\x33\x35\x38\x34\x35\x32\x36\x39\x31","\x65\x6E\x63\x72\x79\x70\x74","\x41\x45\x53"];
    var md5_secret=CryptoJS.MD5(secret);
    var key=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](md5_secret);
    var iv=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](_0x3dd1[3]);
    var encrypted=CryptoJS[_0x3dd1[5]][_0x3dd1[4]](GameScore.toString(),key,{iv:iv});
    var scoreStr=encrypted.toString();
    $.ajax({
        async:false,
        url: 'server.php',
        data:{
            act:'add',
            score:scoreStr
        },
        type: "post",
        dataType:'json',
        success:function(result){
            console.log(result);
            if(result.errcode !=0)
            {
                alert(result.errmsg);
            }
        },
        error: function(XMLHttpRequest) {
            if(XMLHttpRequest.readyState != '4'){
                alert("网络异常,分数提交失败");
                window.location.reload()
            }
        }
    });
}