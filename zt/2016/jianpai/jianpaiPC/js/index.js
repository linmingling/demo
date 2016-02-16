/* 
* @Author: Marte
* @Date:   2015-11-13 15:06:00
* @Last Modified by:   Marte
* @Last Modified time: 2016-01-11 18:15:38
*/

$(document).ready(function(){
    
    // 启动fullpage
    $('#fullpage').fullpage({
    //     anchors: ['徐晓敏的个人网站首页', '案例展示', '技能', '联系方式',],
    // menu: '#myMenu',
		
		afterLoad : function(anchorLink ,index ){
            // 从1开始     
            // $('title').html(index)
            $('.section').eq(index-1).removeClass('out').siblings().addClass('out')
        },
        resize : false,
        scrollOverflow: true,
        verticalCentered: false,        // 垂直居中
        navigation: true,               // 开启指示器
        navigationPosition: 'right'     // 指示器设置为右
    });

     $('#myMenu li').click(function(event) {
       $(this).addClass('current').siblings().removeClass('current')
    });


     $(".eat").click(function(event) {
       $(".mteat").show();
     });
     $(".smell").click(function(event) {
       $(".mtsmell").show();

     });
     $(".touch").click(function(event) {
       $(".mttouch").show();
     });
     $(".look").click(function(event) {
       $(".mtlook").show();
        
     });
     $(".listing").click(function(event) {
         $(".mtlisting").show();
     });

     $(".threeclose").click(function(event) {
       $(".motai").hide();
     });

});