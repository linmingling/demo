function bg() {
	base(this, LSprite, []);
	this.init();
}
var btnSp=null;
bg.prototype.init = function() {
	var father = new LSprite();
        var mBitmap = new LBitmap();
        var mLoader = new LLoader();
        mLoader.addEventListener(LEvent.COMPLETE, function (e) {
            mBitmap.bitmapData = new LBitmapData(e.target);
        });
        
        mLoader.load("images/resultsBtn.png", "bitmapData");
      btnSp=new LSprite();
     btnSp.addChild(mBitmap);
	var self=this;
	this.addChild(father);
	var game = new Game({
		"mode":"normal",
		"row":4,
		"col":7,
		"margin":5,
		"remove":2,
		"spd": 600,
		"delay":200,
		"width":120,
		"height":120,
		"father": father
	});
	var isFrist=true;
	document.addEventListener("mousedown", function() {
		if(isFrist==false){return false;}
		if(father.numChildren==0){return false;}
		isFrist=false;
		var str_img_data = JSON.stringify(imgArr);
		$.ajax({
			async: false,
			url: '../draw.php',
			data: {
				act:'draw2',
				arrInfo:str_img_data,
				priNum:10,
				priRank: "二等奖"
			},
			type: 'post',
			dataType: 'json',
			success: function(result) {
				if (result.errcode == 0) {
				
					var d = eval(result.result);
					var win = [];
					for (var x in d) {
						win.push([d[x].id]);
					}
					for(var i=0;i<father.numChildren;i++){
						for(var j in win){
							if(father.getChildAt(i).id==win[j]){
								father.getChildAt(i).isWin=true;
								continue;
							}
						}					
					}
//					$(".mesDivWra").fadeIn()
					for(var r=0;r<d.length;r++){
						$(".mesDivWra").append("<div>"+d[r].wxname+"</div>");
					}
					game.pushAnimateDiv(win.length);
				}
			},
			error: function(XMLHttpRequest) {
				if (XMLHttpRequest.readyState != '4') {
					alert("网络异常,请稍后重试");
				}
			}
		});
	})
}

function Game(obj) {
	base(this, LSprite, []);
	this.user_options = obj;
	this.row = this.user_options.row;
	this.col = this.user_options.col;
	this.margin= this.user_options.margin;
	this.mode = this.user_options.mode;
	this.remove = this.user_options.remove;
	this.spd = this.user_options.spd / 1000;
	this.delay = this.user_options.delay / 1000;
	this.width = this.user_options.width;
	this.height = this.user_options.height;
	this.total = this.row*this.col;
	this.scaleWidth = this.user_options.scaleWidth;
	this.scaleHeight = this.user_options.scaleHeight;
	this.minWidth = 0;
	this.maxWidth = $(window).width() - this.width;
	this.minHeight = 0;
	this.maxHeight = $(window).height() - this.height;
	this.father = this.user_options.father;
	this.path = [];
	this.an = [];
	this.animateArr = [];
	this.createDiv();
	this.queueArr = [];
	this.count = 0;
	this.winObj = [];
	
};
Game.prototype.collectImg = function() {
	this.collorArr = ["red", "blue", "yellow", "gray", "pink", "black"];
	return this.collorArr;
};
Game.prototype.createDiv = function() {
	var self = this;
	var arr = this.collectImg();
		var count=0;
		var maxWidth=self.width*(self.col-1)+(self.col-1)*self.margin+self.width;
		var maxHeight=self.height*(self.row-1)+(self.row-1)*self.margin+self.height;
		var ml=(LGlobal.width-maxWidth)/2;
		var mt=(LGlobal.height-maxHeight)/2;
		for(var i=0;i<self.col;i++){
			for(var j=0;j<self.row;j++){

		var smallDiv = new LSprite();
		smallDiv.x = self.width*i+i*self.margin+ml;
		smallDiv.y = self.height*j+j*self.margin+mt;
		smallDiv.id =mesArr[count].id;
		this.father.addChild(smallDiv);
		var arrindex=mesArr[count].id;
		var mBitmap = new LBitmap(new LBitmapData(dataList[arrindex]));
        mBitmap.scaleX =self.width/mBitmap.getWidth();
        mBitmap.scaleY = self.height/mBitmap.getHeight();
        mBitmap.x = 0;
        mBitmap.y = 0;
        smallDiv.addChild(mBitmap);
		var txt = new LTextField();
		txt.color = "red";
		txt.size = 40;
		smallDiv.addChild(txt);
		count+=1;
		}
	}
	addChild(btnSp);
	btnSp.y=maxHeight+360;
	btnSp.x=LGlobal.width/2-107;
	btnSp.visible=false;
	btnSp.alpha=0;
	btnSp.addEventListener(LMouseEvent.MOUSE_DOWN,function(){
		LTweenLite.to(self.father,1,{alpha:0})
		$(".mesModule").fadeIn();
	});

};
Game.prototype.pushAnimateDiv = function(n) {
	var self = this;
	this.changNum = this.total - n;
	for (var i = 0; i < this.father.numChildren; i++) {
		if (this.father.getChildAt(i).isWin == true) {
			self.winObj.push(this.father.getChildAt(i));
			continue;
		} else {
			self.animateArr.push(this.father.getChildAt(i));
		}

	}
	self.animateDiv();
};
Game.prototype.animateDiv = function() {
	var self = this;
	var twoObj=[];
	var path=[];
	if (this.mode == "multiply") {
		this.remove += this.remove;
	}
	for (var i = 0; i < self.remove; i++) {
		var num = $.ranNum(0, self.animateArr.length - 1);
		var animateDiv = self.animateArr.splice(num, 1);
		if (animateDiv[0]) {
			twoObj.push(animateDiv);
			LTweenLite.to(animateDiv[0],self.spd,{delay:self.delay,alpha:0,onComplete:function(e){
				e.target.remove();
				self.count += 1;
				if (self.count == self.changNum) {

					btnSp.visible=true;
					LTweenLite.to(btnSp,1,{alpha:1})
					return false;
				}
				self.queueArr.push(1);
				if (self.queueArr.length == self.remove) {
					self.queueArr = [];
					self.animateDiv();
				}			
			}})
		}
	}
	for(var r=0;r<twoObj.length;r++){
		path.push([twoObj[r][0].x+self.width/2,twoObj[r][0].y+self.height/2]);
	}
	if(path[1]==undefined||path[0]==undefined){return false;}
	var c=[path[0][0],path[1][1]];
	var shape = new LShape();
	addChild(shape);
	shape.alpha=0;
	shape.graphics.strokeStyle("#FFFFFF")
	shape.graphics.lineWidth(3);
	shape.graphics.beginPath();
	shape.graphics.moveTo(path[0][0],path[0][1]);
	shape.graphics.lineTo(c[0],c[1]);
	shape.graphics.lineTo(path[1][0],path[1][1]);
	shape.graphics.stroke();
	LTweenLite.to(shape,self.spd+0.1,{alpha:1,onComplete:function(e){
		LTweenLite.to(e.target,self.spd-0.1,{alpha:0,onComplete:function(e){
			e.target.remove();
		}})
	}})

};


Game.prototype.cirArr = function() {
	this.cirArr();
	var self = this;
	var rat = $(window).width() / $(window).height();
	var centerX = $(window).width() / 2 - (self.scaleWidth / 2);
	var centerY = $(window).height() / 2 - (self.scaleHeight / 2);
	this.moveArr = [];
	var degree = 0;
	var winLength = win.length;
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
		var d = obj;
		var self = this;
		//		for (var x in d) {
		//			d[x].delay(600).animate({
		//				"left": self.moveArr[x][0],
		//				"top": self.moveArr[x][1]
		//			}, 800, 'easeInOutBack').css({
		//				"width": self.scaleWidth,
		//				"height": self.scaleHeight,
		//			})
		//		}
		//		jQuery('.small').nailthumb({
		//			width: self.scaleWidth,
		//			height: self.scaleHeight,
		//			replaceAnimation: null
		//		});
	}
	//multiply 累加消除
	//normal 正常消除

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
			var d =$.ranNum(min, max);
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