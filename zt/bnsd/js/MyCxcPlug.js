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
          "opacity": "0",
          "background": "#fff",
          "width":"100%",
          "height":$(document).height(), 
          "position":"absolute",
   
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
      
       window.onresize=function(){
         
       }
       $(window).scroll(function (){
        
       });
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


