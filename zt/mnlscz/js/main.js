
//$(function() {

	$("#hor_swiper").css("height",$(window).height()-$("#botColum").height()+55);
	var t = 0;
	$("#yinyueBtn").bind("touchend", function() {
		if (t == 0) {
			$(this).attr({
				"src": "img/close.png"
			});
			document.getElementById("bgSound").pause();
			t = 1;
		} else {
			$(this).attr({
				"src": "img/open.png"
			});
			document.getElementById("bgSound").play();
			t = 0;
		}
	});

	function Audio(obj, cb) {
		document.getElementById(obj).addEventListener("touchstart", function() {
			cb();
		})
		var e = document.createEvent("MouseEvents");
		e.initEvent("touchstart", true, true);
		document.getElementById(obj).dispatchEvent(e);
	};
	Audio("bgSound",function(){
		document.getElementById("bgSound").play();
	});
	function loadImages(sources, process, callback) {
		var count = 0;
		var images = {};
		var imgNum = 0;
		for (src in sources) {
			imgNum++;
			if (process) {
				process(imgNum);
			}
			images[src] = new Image();
			images[src].onload = function() {
				if (++count >= imgNum) {
					if (callback) {
						callback(images);
					}
				}
			}
			images[src].src = sources[src];
		}
	}
	document.addEventListener("touchstart",function(e){
		e.preventDefault();
	})
	
	loadImages(imgList, null, function() {
		$("img").each(function() {
			$(this).attr({
				"src": $(this).attr("_src")
			});
		});
		//加载完成后
		var myverSwiper = new Swiper('#ver_swiper', {
			direction: 'vertical',
			resistanceRatio: 0,
			loop: false,
			followFinger: false,
			onInit: function(swiper) {
				swiperAnimateCache(swiper);
				swiperAnimate(swiper);
				$("#ver_swiper").css("visibility","visible");
				$("#yinyueBtn").show();
				$("#bottom").show();
			},
			onSlideChangeStart: function(swiper) {
				swiperAnimate(swiper);
			}
		});
		var mySwiper = new Swiper('#hor_swiper', {
			direction: 'horizontal',
			loop: true,
			pagination: '.swiper-pagination',
			followFinger: false,
			onTouchEnd: function(swiper) {
				$("#btnList").find("li").each(function() {
					$(this).find("img").eq(0).hide();
					$(this).find("img").eq(1).show();
				});
				$("#btnList").find("li").eq(0).find("img").eq(0).show();
				$("#btnList").find("li").eq(0).find("img").eq(1).hide();
			},
			onTransitionStart:function(){
				var name=$("#horInner .swiper-slide-active").attr("name");
				$("#horInner .swiper-slide-active").find("div").each(function(){
					$(this).hide()
				});
				$("#horInner").find(".swiper-slide-active").find("div").eq(0).show();
				$("#tile_name").attr("src", "img/select/" +name+ "/name.png");
				$("#tile_tit").attr("src", "img/select/" +name + "/tit.png");
			}
		});
		$("#btnList li").bind("touchstart", function() {
			$("#btnList").find("li").each(function() {
				$(this).find("img").eq(0).hide();
				$(this).find("img").eq(1).show();
			});
			$("#horInner .swiper-slide-active").find("div").each(function(){
				if($(this).css("display")=="block"){
					$(this).hide();
					return false;
				}
			});
			$("#horInner .swiper-slide-active").find("div").eq($(this).index()).show();
			
			
			$("#horInner .swiper-slide").find("div").eq($(this).index()).show();
			$(this).find("img").eq(0).show();
			$(this).find("img").eq(1).hide();
		});
		$("#knowBtn").bind("touchend", function() {
			window.location.href = "http://www.jia360.com/zx/cizhuan/20150901/1441078606161.html";
		});
		$("#shareBtn").bind("touchend", function() {
			$("#shareCon").show();
			$("#sharetip").addClass("animated");
			$("#sharetip").addClass("flash");
		});
		$("#shareCon").bind("touchend", function() {
			$("#shareCon").hide();
			$("#sharetip").removeClass("animated");
			$("#sharetip").removeClass("flash");
		});

	});
//})

