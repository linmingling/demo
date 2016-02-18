var christmas = christmas || {};
var gotoResult = null;
var showZhudan=null;
var dianqi=null;
var index = 0;
var first=false;
function mc5Audio(){
	Audio("boom",function(){
		document.getElementById("bgSound").pause();	
		document.getElementById("boom").currentTime=0;
		document.getElementById("boom").play();
	});
};
function mj(){
	Audio("mj",function(){
		document.getElementById("mj").currentTime=0;
		document.getElementById("mj").play();
	});	
};
function jiaju(){
	Audio("jiaju",function(){
		document.getElementById("jiaju").currentTime=0;
		document.getElementById("jiaju").play();
	});	
}
function shengdanMusic(){
	Audio("shengdan",function(){
		document.getElementById("shengdan").currentTime=0;
		document.getElementById("shengdan").play();
	});			
}
function aobama(){
	Audio("aobama",function(){
		document.getElementById("aobama").currentTime=0;
		document.getElementById("aobama").play();
	});		
};
function stopMcMusic(){
	document.getElementById("shengdan").pause();
	document.getElementById("aobama").pause();
	document.getElementById("jiaju").pause();
	document.getElementById("mj").pause();
	document.getElementById("chou").pause();
	Audio("bgSound",function(){
		document.getElementById("bgSound").currentTime=0;
		document.getElementById("bgSound").play();
	});	
};
function checkCount(obj,mc){
	//ajax检测用户抽奖次数
	var surplus = false;
	$.post("server.php",{act:"surplus"},function(result){
		var result = eval('(' + result + ')');
		if(result.errcode == 0) { //成功
			surplus = result.statu;
			obj.removeChild(mc);
			obj.addChild(obj.mc10);
			obj.mc10.gotoAndPlay(1);	
			document.getElementById("shengdan").pause();
			document.getElementById("chou").play();		
			return false;
		}
		else{
			$("#cishuCon").show();
			$("#alertTxt").html(result.errmsg);
			return false;
		}
	});	
}
function ajaxIsWin(obj){
	// 抽奖
	var priceType=1;
	var priceName = '';	
	$.post("server.php",{act:"start"},function(result){
		var result = eval('(' + result + ')');
		if(result.errcode == 0) { //成功
			priceType = result.prize;
			priceName = result.priJso;				
			$("#priceName").html(priceName);
			if(parseInt(priceType)==3||parseInt(priceType)==4){
				$("#adressCon").hide();
			}
			else{
				$("#adressCon").show();
			}
			obj.mc11.submit_btn.visible=true;
			obj.mc11.setChildAttr(obj.mc11.submit_btn,{visible:true});	
			obj.mc11.gotoAndPlay(1);
			var zhen=parseInt(priceType)+1;
			obj.mc11.priceCon.gotoAndStop(zhen);
		} else {
			obj.mc11.again_btn.visible=true;
			obj.mc11.setChildAttr(obj.mc11.again_btn,{visible:true});	
			obj.mc11.gotoAndPlay(1);
			obj.mc11.priceCon.gotoAndStop(5);					
		}
	});

}
function ranNum(min, max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
};
christmas.Christmas = function() {
		base(this, LSprite, []);
		this.initView();
		var self = this;
		this.mc1.mc1_savebtn.addEventListener(LMouseEvent.MOUSE_DOWN, function() {
			this.removeChild(this.mc1);
			this.addChild(this.mc2);
			self.mc2.gotoAndPlay(1);
		}.bind(this));
		this.mc2.mc2_btn.addEventListener(LMouseEvent.MOUSE_DOWN, function() {
			this.removeChild(this.mc2);
			this.addChild(this.mc3);
			self.mc3.tips_text.visible=true;
			self.mc3.gotoAndPlay(1);
		}.bind(this));

		self.mc3.addEventListener(LMouseEvent.MOUSE_DOWN,mc3mousevent);
		function zhudanAlpha(){
			self.mc3.setChildAttr(self.mc3.zhudan1,{alpha:0});
			self.mc3.setChildAttr(self.mc3.zhudan2,{alpha:0});
			self.mc3.setChildAttr(self.mc3.zhudan3,{alpha:0});
			self.mc3.setChildAttr(self.mc3.zhudan4,{alpha:0});
		}
		var normalMc=[self.mc6,self.mc8,self.mc9];
		function mc3mousevent(e){
			index += 1;
			if (index == 1) {
				self.mc3.tips_text.visible=false;
				self.mc3.mc3_ice1.alpha = 1;
				self.mc3.mc3_ice1.x=e.selfX;
				self.mc3.mc3_ice1.y=e.selfY;
				self.mc3.setChildAttr(self.mc3.mc3_ice1,{alpha:1,x:e.selfX,y:e.selfY});
				document.getElementById("click").currentTime=0;
				document.getElementById("click").play();
			} else if (index == 2) {
				self.mc3.mc3_ice2.alpha = 1;
				self.mc3.mc3_ice2.x=e.selfX;
				self.mc3.mc3_ice2.y=e.selfY;
				self.mc3.setChildAttr(self.mc3.mc3_ice2,{alpha:1,x:e.selfX,y:e.selfY});				
				document.getElementById("click").currentTime=0;
				document.getElementById("click").play();
			} else if (index == 3) {
				self.mc3.mc3_ice3.alpha = 1;
				self.mc3.mc3_ice3.x=e.selfX;
				self.mc3.mc3_ice3.y=e.selfY;
				self.mc3.setChildAttr(self.mc3.mc3_ice3,{alpha:1,x:e.selfX,y:e.selfY});		
				document.getElementById("click").currentTime=0;
				document.getElementById("click").play();
				setTimeout(function(){
					self.mc3.gotoAndPlay(19);
				},200);
			}
			showZhudan=function(){
				var d=ranNum(1,4);
				if(d==1){self.mc3.setChildAttr(self.mc3.zhudan1,{alpha:1});}
				else if(d==2){self.mc3.setChildAttr(self.mc3.zhudan2,{alpha:1});}
				else if(d==3){self.mc3.setChildAttr(self.mc3.zhudan3,{alpha:1});}
				else if(d==4){self.mc3.setChildAttr(self.mc3.zhudan4,{alpha:1});}
			}
			if (e.target.name == 'mc4_kongtiao' || e.target.name == 'mc4_yugang' || e.target.name == 'mc4_above' || e.target.name == 'mc4_chugui') {
				if(e.target.name == 'mc4_kongtiao'){
					dianqi=2;
				}
				if(e.target.name == 'mc4_yugang'){
					dianqi=4;
				}
				if(e.target.name == 'mc4_above'){
					dianqi=3;
				}
				if(e.target.name == 'mc4_chugui'){
					dianqi=1;
				}
				self.removeChild(self.mc3);		
				zhudanAlpha();
				addMc5();
			}			
		}
		function addMc5() {
				self.addChild(self.mc5);	
				self.mc5.mc_con1.gotoAndStop(dianqi);
				self.mc5.mc_con2.mc_con2_common.gotoAndStop(dianqi);
				self.mc5.gotoAndPlay(1);		
				gotoResult = function() {	
//					self.removeChild(self.mc5);//测试抽奖专用  注释下面if else
//					shengDanMan(self.mc7);//测试抽奖专用  注释下面if else
//					return false;
					if(first==false){
						self.removeChild(self.mc5);
						var mcNum=ranNum(0,2);
						addPlaySence(normalMc[mcNum]);				
						first=true;
					}
					else{					
						var gailv=Math.random();
						if(gailv>0.5){
							self.removeChild(self.mc5);
							var mcNum=ranNum(0,2);
							addPlaySence(normalMc[mcNum]);						
						}
						else{
							self.removeChild(self.mc5);
							shengDanMan(self.mc7);
						}
					};
				}
			}
		function addPlaySence(mc){
			mc.gotoAndPlay(1);
			self.addChild(mc);
			mc.addEventListener(LMouseEvent.MOUSE_DOWN,function(e){
				if(e.target.name=="again_btn"){
					self.removeChild(mc);
					self.addChild(self.mc3);
					self.mc3.gotoAndPlay(38);
					stopMcMusic();
				}
				if(e.target.name=="share_btn"){
					self.addChild(self.mc12);
					self.mc12.addEventListener(LMouseEvent.MOUSE_DOWN,function(){
						self.removeChild(self.mc12);
					});
				}
			});
		};
		function shengDanMan(mc){
			mc.gotoAndPlay(1);
			self.addChild(mc);
			mc.addEventListener(LMouseEvent.MOUSE_DOWN,function(e){
				if(e.target.name=="chou_btn"){
					checkCount(self,mc);
				}
				if(e.target.name=="baoming_btn"){
					window.location.href="http://group.yoju360.com/phone/zhan/fyinvite/9/index.htm?from=jiaju03";
				}
			});			
		};
		this.mc10.addEventListener(LMouseEvent.MOUSE_DOWN,function(e){
			if(e.target.name=="mc_shoes1"||e.target.name=="mc_shoes2"||e.target.name=="mc_shoes3"||e.target.name=="mc_shoes4"||e.target.name=="mc_shoes5"){
				self.removeChild(self.mc10);
				self.addChild(self.mc11);
				self.mc11.again_btn.visible=false;
				self.mc11.submit_btn.visible=false;
				self.mc11.setChildAttr(self.mc11.again_btn,{visible:false});
				self.mc11.setChildAttr(self.mc11.submit_btn,{visible:false});
				ajaxIsWin(self);
			}
		});
		this.mc11.again_btn.addEventListener(LMouseEvent.MOUSE_DOWN,function(e){	
			self.addChild(self.mc3);
			self.mc3.gotoAndPlay(38);
			self.removeChild(self.mc11);
			index=0;
			stopMcMusic();
		});
		this.mc11.submit_btn.addEventListener(LMouseEvent.MOUSE_DOWN,function(e){
			$("#submitCon").show();
		});
		//表单信息模块
		var user_name=document.getElementById("user_name");
		var user_phone=document.getElementById("user_phone");
		var user_adress=document.getElementById("user_adress");
		var submitBtn=document.getElementById("submitBtn");
		var playAgain=document.getElementById("playAgain");
		var shareBtn=document.getElementById("shareBtn");
		user_name.addEventListener("touchstart",function(){
			user_name.focus();
		});
		user_phone.addEventListener("touchstart",function(){
			user_phone.focus();
		});	
		user_adress.addEventListener("touchstart",function(){
			user_adress.focus();
		});
		playAgain.addEventListener("touchstart",function(){
			//提交信息成功后的再玩一次按钮
			self.addChild(self.mc3);
			self.mc3.gotoAndPlay(38);
			self.removeChild(self.mc11);
			index=0;
			stopMcMusic();
			$("#successCon").hide();
		});
		shareBtn.addEventListener("touchstart",function(){
			//提交信息成功后的再玩一次按钮
			self.addChild(self.mc12);
			self.mc12.addEventListener(LMouseEvent.MOUSE_DOWN,function(){
				self.removeChild(self.mc12);
			});
			$("#cishuCon").hide();
		});
		submitBtn.addEventListener("touchstart",function(){
//			提交信息按钮  提交信息成功后执行下面3句
			var user_name = $('#user_name').val();
			var user_phone = $('#user_phone').val();
			var user_adress = $('#user_adress').val();		
			$.post("server.php",{act:"reg","name":user_name,"phone":user_phone,"address":user_adress},function(result){
				var result = eval('(' + result + ')');
				if(result.errcode == 0) { //成功
					$("#submitCon").hide();
					$("#successCon").show();
					self.removeChild(self.mc11);					
				} else {
					alert(result.errmsg);
				}
			});
		});
	}
	//下面代码在生成显示元素时会自动替换,请勿在此函数里写代码,非常重要:请不要删除//initViewStart和//initViewEnd 这两个注释
christmas.Christmas.prototype.initView = function() {
	//initView_Start
	this.mc12=new christmas.L313247640();
	this.mc12.name="mc12";
	Flash2x.setDisplayInfo(this.mc12,320,504);
	this.mc11=new christmas.L787629674();
	this.mc11.name="mc11";
	Flash2x.setDisplayInfo(this.mc11,320,503.3);
	this.mc10=new christmas.L850257951();
	this.mc10.name="mc10";
	Flash2x.setDisplayInfo(this.mc10,320,504);
	this.mc9=new christmas.L235057340();
	this.mc9.name="mc9";
	Flash2x.setDisplayInfo(this.mc9,320,504);
	this.mc7=new christmas.L573189987();
	this.mc7.name="mc7";
	Flash2x.setDisplayInfo(this.mc7,330,495);
	this.mc8=new christmas.L409547100();
	this.mc8.name="mc8";
	Flash2x.setDisplayInfo(this.mc8,320,504);
	this.mc6=new christmas.L994048324();
	this.mc6.name="mc6";
	Flash2x.setDisplayInfo(this.mc6,320,504);
	this.mc5=new christmas.L503184118();
	this.mc5.name="mc5";
	Flash2x.setDisplayInfo(this.mc5,320,504);
	this.mc3=new christmas.L259761150();
	this.mc3.name="mc3";
	Flash2x.setDisplayInfo(this.mc3,320,504);
	this.mc2=new christmas.L567602581();
	this.mc2.name="mc2";
	Flash2x.setDisplayInfo(this.mc2,320,504);
	this.mc1=new christmas.L608162909();
	this.mc1.name="mc1";
	Flash2x.setDisplayInfo(this.mc1,320,504);
	this.addChild(this.mc1);
//	this.addChild(this.mc2);
//	this.addChild(this.mc3);
//	this.addChild(this.mc5);
//	this.addChild(this.mc6);
//	this.addChild(this.mc8);
//	this.addChild(this.mc7);
//	this.addChild(this.mc9);
//	this.addChild(this.mc10);
//	this.addChild(this.mc11);
//	this.addChild(this.mc12);
	
	//initView_End
}