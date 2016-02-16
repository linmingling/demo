<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../../data/config.php');

$sql = "select * from festival2016_ld,festival2016_ld_user where festival2016_ld.user_id = festival2016_ld_user.user_id and festival2016_ld_user.is_prize = '0'";
$res = mysqli_query($db, $sql);

$tmp = array();
$str = '';
while($row = $res->fetch_assoc()) {
	$str .= '{"index":"'.$row['user_id'].'","src":"'.$row['head_icon'].'","wxname":"'.$row['name'].'"},';	
}

//json字符串
$str = substr($str,0,strlen($str)-1); 
$str = '['.$str.']';
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/global.css" />
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/jquery.easing.min.js"></script>
		<script type="text/javascript" src="js/jquery.nailthumb.1.1.min.js"></script>
		<script>
$.extend({
	ranNum: function(min, max) {
		return Math.floor(Math.random() * (max - min + 1) + min);
	},
	ranArr: function(min, max, length) {
		var arr = [];
		var bol = true;
		var o = 0;
		var isPush = true;
		var isCheck = true;
		while (bol) {
			if (o > length - 1) {
				return arr;
				break;
			}
			bol = false;
			count = 0;
			isCheck = true
			var d = $.ranNum(min, max);
			for (var x in arr) {
				if (arr[x] == d) {
					isCheck = false;
					break;
				}
			}
			if (isCheck) {
				isPush = true;
			} else {
				isPush = false;
				bol = true;
			}
			if (isPush) {
				arr.push(d);
				o += 1;
				bol = true;
			}
		}
	},
});
			var  imgArr= <?php echo $str;?>;
		</script>
		<style>
			* {
				-webkit-user-select: none;
			}
			html,body{overflow: hidden;background: url(img/bg.jpg) no-repeat;background-size: 100% 100%;width: 100%;height: 100%;}
			.sqaure {
				color: #ffffff;
				overflow: hidden;
			}
			
			.small {
				font-size: 30px;
				text-align: center;
				background-color: #505050;
				position: absolute;
				-webkit-transition: width .4s, height .4s;
				-ms-transition: width .4s, height .4s;
				-moz-transition: width .4s, height .4s;
				transition: width .4s, height .4s;
				overflow: hidden;
			}
			
			.small img {
				width: 100%;
			}
			#resultsBtn{position:fixed;z-index: 9999;top: 50%;left: 50%;margin-top: -97px;margin-left: -107px;display: none;}
			.mesModule{display:none;position: fixed;z-index: 9999;width: 770px;height: 440px;left: 50%;top: 50%;margin-left:-385px;margin-top: -220px;}
			.mesModule h1{text-align: center;font-size: 40px;}
			.mesDivWra{margin: 0 auto;}
			.mesDivWra div{width: 150px;text-align: center;font-size: 30px;text-align: center;line-height: 31px;font-weight: bold;float: left;margin-bottom:10px}
		</style>
		<title>三等奖</title>
	</head>

	<body>
		<img src="img/resultsBtn.png" id="resultsBtn"/>
		<div class="mesModule">
			<h1>三等奖</h1>
			<div class="mesDivWra" style="width: 300px;">
				
			</div>
			
		</div>
		<div class="sqaure">

		</div>

		<script>(function() {
	$(".sqaure").css({
		"width": $(window).width(),
		"height": $(window).height(),
	})

	function Game(obj) {
		this.user_options = obj;
		
		this.margin= this.user_options.margin;
		this.row = this.user_options.row;
		this.col = this.user_options.col;
		this.row=10;
		this.col=20;
		this.mode = this.user_options.mode;
		this.remove = this.user_options.remove;
		this.spd = this.user_options.spd;
		this.delay = this.user_options.delay;
		this.width = this.user_options.width;
		this.height = this.user_options.height;
		this.total = 200;
		this.scaleWidth = this.user_options.scaleWidth;
		this.scaleHeight = this.user_options.scaleHeight;
		this.minWidth = 0;
		this.maxWidth = $(window).width() - this.width;
		this.minHeight = 0;
		this.maxHeight = $(window).height() - this.height;
		this.father = $(".sqaure");
		this.animateArr = [];
		this.createDiv();
		this.queueArr = [];
		this.count = 0;
		this.winObj = [];
		this.cirArr();
	};
	Game.prototype.createDiv = function() {
		var self = this;
		var count=0;
		var maxWidth=self.width*(self.col-1)+(self.col-1)*self.margin+self.width;
		var maxHeight=self.height*(self.row-1)+(self.row-1)*self.margin+self.height;
		var ml=($(window).width()-maxWidth)/2;
		var mt=($(window).height()-maxHeight)/2;
		for(var i=0;i<self.col;i++){
			for(var j=0;j<self.row;j++){	
					var smallDiv = $("<div class='small'></div>");
					var left=self.width*i+i*self.margin+ml;
					var top=self.height*j+j*self.margin+mt;
					smallDiv.css({
						"left": left,
						"top": top,
						"width": self.width,
						"height": self.height
					});
					if(imgArr[count]==undefined){
						var userImg = $("<img src='img/defult.png'/>");
						smallDiv.append(userImg);
//						smallDiv.attr("index",parseInt(Math.random()*1000000));	
										
					}
					else{
						var userImg = $("<img />");
						userImg.attr("src", imgArr[count].src);
						smallDiv.append(userImg);
						smallDiv.attr("index", imgArr[count].index);	
						smallDiv.attr("wxname",imgArr[count].wxname);
//						this.father.append(smallDiv);
					}		
					this.father.append(smallDiv);			
					count+=1;	
			}
		}
		jQuery('.small').nailthumb({
			width: self.width,
			height: self.height,
		});
		this.childList = $(".sqaure .small");
	};
	Game.prototype.pushAnimateDiv = function(n) {
		var self = this;
		this.changNum =this.total - n;
		$(".sqaure div").each(function(i) {
			if ($(this).attr("isWin") == "1") {
				self.winObj.push($(this));			
				return true;
			} else {
				var index=$(this).attr("index");
				var obj=$(this);
				self.animateArr.push(obj);
			}
		});
		this.ws=n;
		
		self.animateDiv();
	};
	Game.prototype.animateDiv = function() {
		var self = this;
		if (this.mode == "multiply") {
			this.remove += this.remove;
		}
		for (var i = 0; i < self.remove; i++) {
			var num = $.ranNum(0, self.animateArr.length - 1);
			var animateDiv = self.animateArr.splice(num, 1);
			if (animateDiv[0]){
				animateDiv[0].delay(self.delay).fadeOut(self.spd, function() {				
					self.count += 1;
					if (self.count == self.changNum) {
						self.animateEnd(self.winObj)
						return false;
					}
					self.queueArr.push(1);
					if (self.queueArr.length == self.remove) {
						self.animateArr.remove($(this).attr("index"));
						$(this).remove();
						self.queueArr = [];
						self.animateDiv();
					}
				});
			}
		}
	};
	Game.prototype.cirArr = function() {
		var self = this;
		var centerX = $(window).width() / 2 - (self.scaleWidth / 2);
		var centerY = $(window).height() / 2 - (self.scaleHeight / 2);
		this.moveArr = [];
		var degree = 0;
		var winLength = this.ws;
		var radius = $(window).height() / 2 - (self.scaleWidth / 2);
		var avenge = 360 / winLength;

		for (var i = 0; i < winLength; i++) {
			var q = [];
			q[0] = centerX + radius * Math.cos(degree * Math.PI / 180);
			q[1] = centerY + radius * Math.sin(degree * Math.PI / 180);
			this.moveArr.push(q);
			degree += avenge;
		}
	}
	Game.prototype.animateEnd = function(obj) {
			this.cirArr();
			var d = obj;
			var self = this;
			var oneFade=true;
			var winName=[];
			for (var x =0;x<20;x++) {
				if(d[x].attr("wxname")){
					winName.push(d[x].attr("wxname"));
				}
				d[x].delay(600).animate({
					"left": self.moveArr[x][0],
					"top": self.moveArr[x][1],
					"border-radius":"50em"
				}, 800, 'easeInOutBack',function(){
					if(oneFade==false){return false;}
					oneFade=false;

					$("#resultsBtn").fadeIn();
					for(var i=0;i<winName.length;i++){
						$(".mesDivWra").append("<div>"+winName[i]+"</div>")
					}
				}).css({
					"width": self.scaleWidth,
					"height": self.scaleHeight,
				})
			}
			jQuery('.small').nailthumb({
				width: self.scaleWidth,
				height: self.scaleHeight,
				replaceAnimation: null
			});
		}
		//multiply 累加消除
		//normal 正常消除
	var game = new Game({
		"mode": "multiply",
		"margin":5,
		"remove": 1,
		"total":imgArr.length,
		"spd": 800,
		"delay": 450,
//		"spd": 100,
//		"delay": 100,
		"width": 70,
		"height": 70,
		"scaleWidth": 100,
		"scaleHeight": 100
	});
	$("#resultsBtn").one("click",function(){
		$("#resultsBtn").fadeOut();
		$(".sqaure").fadeOut();
		$(".mesModule").fadeIn();
	});
Array.prototype.indexOf = function(val) {              
    for (var i = 0; i < this.length; i++) {  
        if (this[i] == val) return i;  
    }  
    return -1;  
};  
Array.prototype.remove = function(val) {  
    var index = this.indexOf(val);  
    if (index > -1) {  
        this.splice(index, 1);  
    }  
};  
	$(document).one("click", function() {
		$.ajax({
			async: false,
			url: '../draw.php',
			data: {
				act: 'draw',
				priNum:20,
				priRank: "三等奖"
			},
			type: "post",
			dataType: 'json',
			success: function(result) {
				if (result.errcode == 0) {
					var d = eval(result.result);
					var win = [];
					for(var x=0;x<d.length;x++){
						win.push(d[x].index);
					}
					$(".small").each(function() {
						for(var j=0;j<win.length;j++){
							if (parseInt($(this).attr("index")) == win[j]) {
								$(this).attr("isWin", "1");
								return true;
							}							
						}
					});
					console.log(win)
					game.pushAnimateDiv(win.length);
				}
			},
			error: function(XMLHttpRequest) {
				if (XMLHttpRequest.readyState != '4') {
					alert("网络异常,请稍后重试");
				}
			}
		});
	});
})();</script>
	</body>

</html>