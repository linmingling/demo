(function($) {
	$.fn.verPlayer = function(opt) {
		var parent = $(this);
		var bigCon = $(opt.ul);
		var creatImg = opt.imgArr;
		var max = creatImg.length;
		var index = 0;
		var preindex = 0;
		var index = 0;
		var move = 0;
		var activeIndex = 0;
		var canClick = true;
		var div1 = $("<div class='d1'></div>");
		$(this).append(div1);
		function linkA(){
			window.open("http://www.jia360.com/2015/1214/1450085239938.html")
		}
		bigCon.append("<img src='"+creatImg[0]+new Date().getTime()+"'/>");
		for (var x in creatImg) {
			var smallDiv = $("<div class='small'></div>");
			div1.append(smallDiv);
			smallDiv.append("<img src='" + creatImg[x] + "'/>");
			smallDiv.click(function(){
				linkA();
			})
		}
		bigCon.click(function(){
			linkA();
		})
		var smallHeight = $(".small").height();
		var div2 = $(div1).clone();
		$(this).append(div2);
		var public_api = {
			"next": function() {
				if (canClick == false) {
					return false;
				}
				canClick = false;
				index += 1;
				var d = parseInt(parent.css("top"));
				if (index > max) {
					index = 1;
					parent.css("top", 0);
				}
				move = parseInt(parent.css("top")) - 130;
				parent.animate({
					"top": move
				}, 300, function() {
					canClick = true;
					activeIndex = Math.abs(parseInt(parent.css("top")) / 130);
					if (activeIndex == max) {
						activeIndex = 0;
					};
					bigCon.find("img").attr("src",creatImg[activeIndex]);
					
				});
			},
			"pre": function() {
				if (canClick == false) {
					return false;
				}
				canClick = false;
				index -= 1;
				if (index < 0) {
					index = max - 1;
					parent.css("top", -130 * max);
				}
				move = parseInt(parent.css("top")) + 130;
				parent.animate({
					"top": move
				}, 300, function() {
					canClick = true;
					activeIndex = Math.abs(parseInt(parent.css("top")) / 130);
					if (activeIndex == max) {
						activeIndex = 0;
					};
					bigCon.find("img").attr("src",creatImg[activeIndex]);
				});
			}
		};
		return public_api;
	};
})(jQuery);

(function(){
	

var newsplayerArr=[];
for(var i=0;i<16;i++){
	var newsImgUrl="img/newsplayer/"+i+".jpg?v="+new Date().getTime();
	newsplayerArr.push(newsImgUrl);
	newsImgUrl=null;
}
var liveplayerArr=[];
for(var i=0;i<17;i++){
	var liveImgUrl="img/liveplayer/"+i+".jpg?v="+new Date().getTime();
	liveplayerArr.push(liveImgUrl);
	liveImgUrl=null;
}
var newsplayer = $(".newsplayer .newsplayer_smallinside").verPlayer({
	imgArr: newsplayerArr,
	ul: ".newsplayer_bigcon"
});
var liveplayer = $(".liveplayer .liveplayer_smallinside").verPlayer({
	imgArr: liveplayerArr,
	ul: ".liveplayer_bigcon"
});
jQuery('.small').nailthumb({
	width: 160,
	height: 120,
	//replaceAnimation: null,
});


$(".newsplayer .bot").click(function() {
	newsplayer.next();
});
$(".newsplayer .top").click(function() {
	newsplayer.pre();
});
$(".liveplayer .bot").click(function() {
	liveplayer.next();
});
$(".liveplayer .top").click(function() {
	liveplayer.pre();
});
$(window).bind("mousewheel", function() {
	$("html,body").stop();
});
var posArr=[];
$(".common_zhengwen_textbg").each(function(){
	if($(this).hasClass("yellow_zhengwen_textbg")){return false;}
	$(this).offset().top;
	posArr.push($(this).offset().top)
});
posArr.push(0);
var index=0;
var hudonglength=$(".hudong_qr").size();
var maxIndex=hudonglength%3;
$("#hudongR").click(function(){
	index+=1;
	if(index>maxIndex){
		index=maxIndex;
		return false;
	}
	$(".hudong_wra .hudong_qr").each(function(i){
		var shit=$(this).offset().left;
		$(this).css("left",shit-520);
	});
});
$("#hudongL").click(function(){
	index-=1;
	if(index<0){
		index=0;
		return false;
	}
	$(".hudong_wra .hudong_qr").each(function(i){
		var shit=$(this).offset().left;
		$(this).css("left",shit+105);
	});	
});
	var dis=$(".hudong_wra").width()/3;
	$(".hudong_wra .hudong_qr").each(function(i){
		$(this).css("left",dis*i+160);
	});


$(".sideNav_btn").find("li").each(function(i){
	$(this).click(function(){
		
		$("html,body").animate({
			"scrollTop": posArr[i]
		});
	})
});

})();

