/**
 * js网页雪花效果jquery插件 
 */
(function($){
	
	$.fn.snow = function(options){
	
			var documentHeight 	= $(document).height(),
				documentWidth	= $(document).width(),
				defaults		= {
									minSize		: 20,		//雪花的最小尺寸
									maxSize		: 80,		//雪花的最大尺寸
									newOn		: 800,		//雪花出现的频率
									flakeColor: "#FFFFFF",//雪花的颜色
									snowflake: '&#10052;',//雪花 字符串
									imgUrl: '',//雪花的图片地址
									isImg: true,//雪花是否为图片
								},
				options			= $.extend({}, defaults, options);
			
			var $flake = $('<div id="snowbox" />').css({ 'position': 'absolute', 'top': '-50px' }).html(options.isImg ? '<img width="100%" height="100%" src="' + options.imgUrl + '" />' : options.snowflake);
			
			    var interval = setInterval(function () {
				var startPositionLeft 	= Math.random() * documentWidth - 100,
				 	startOpacity		= 0.5 + Math.random(),
					sizeFlake			= options.minSize + Math.random() * options.maxSize,
					endPositionTop		= documentHeight - 40,
					endPositionLeft		= startPositionLeft - 100 + Math.random() * 500,
					durationFall = documentHeight * 10 + Math.random() * 5000;

				var $fladex = $flake.clone(),
                    cssObj = {
				    left: startPositionLeft,
				    opacity: startOpacity,
				    color: options.flakeColor
				};
				if (options.isImg) {
				    cssObj.width = sizeFlake;
				    cssObj.height = sizeFlake;
				}
				else {
				    cssObj['font-size']= sizeFlake;
				}

			    $fladex.appendTo('body').css(cssObj).animate({
							top: endPositionTop,
							left: endPositionLeft,
							opacity: 0.2
						},durationFall,'linear',function(){
							$(this).remove()
						}
					);
					
			}, options.newOn);
	
	};
	
})(jQuery);