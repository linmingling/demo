/* 
* MyCxcPlug 1.0 
* Copyright (c) 2013 ChenXiaoChuan 157972671
* Date: 2013-09-15
* 多种Jquery效果集合，调用简单，转载或者修改请保存原有作者信息。
*/
;(function ($) {
   
   //弹出层
   Popuplayer=function(Pixel){
       Pixel=$.extend({
          LayerId:"",//层ID
          Masklayer:"",//遮罩层ID
          CloseID:"",//退出id
          Fun:function(){} //关闭时是否回调函数
       },Pixel);
       var File=$("#"+Pixel.LayerId);
       var Mask=$("#"+Pixel.Masklayer);
       var Close=$("#"+Pixel.CloseID);
       Mask.css({
          "filter":"alpha(opacity=40)",
          "opacity": "0.4",
          "background": "#fff",
          "width":"100%",
          "height":$(document).height(), 
          "position":"absolute",
          "top":"0",
          "left":"0",
          "z-index":"100",
          "display":"none"
       });
       Mask.show();
       File.fadeIn();
       var dialog_w=File.width();
       var dialog_h=File.height();
       var Browser_w=$(window).width();
       var Browser_h=$(window).height();
       var boxdiv_l=(Browser_w-dialog_w)/2;
       var boxdiv_t=((Browser_h-dialog_h)/2)+$(document).scrollTop();
       File.css({
          "z-index":"200",
          "position":"absolute",
          "left":100,
          "z-index":"100",

       });
       window.onresize=function(){
          var Browser_ws=$(window).width();
          var Browser_hs=$(window).height();
          var boxdiv_ls=(Browser_ws-dialog_w)/2;
          var boxdiv_ts=((Browser_hs-dialog_h)/2)+$(document).scrollTop();
          File.css({
             "z-index":"200",
             "position":"absolute",
             "left":boxdiv_ls,
             "top":boxdiv_ts
          });
       }
       /*$(window).scroll(function (){
         var offsetTop = ((Browser_h-dialog_h)/2) +$(document).scrollTop() +"px"; 
         File.animate({top : offsetTop },{ duration:600 , queue:false });  
       });*/
       Close.click(function(){
          Mask.hide();
          File.fadeOut();
          Pixel.Fun();
       });
       Mask.click(function() {
         if (File.is(":visible")) {
            Mask.hide();
            File.fadeOut();
            Pixel.Fun();
         }
      });
   }
  
})(jQuery);


