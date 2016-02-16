<?php
	date_default_timezone_set('PRC');
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../../data/config.php');
	require_once(ROOT_PATH .'../../../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage(); 
	
	$qmfl_weixin = 'qmfl_weixin_info';
	
	$agent = $_SERVER['HTTP_USER_AGENT'];
		if(!strpos($agent,"MicroMessenger")){
			echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }


	$openId = $_SESSION['qmfl_openid'];
	if(empty($openId)){
		$userinfo = $jssdk->getOauth();
		$_SESSION['qmfl_openid'] = $userinfo['openid'];
		$_SESSION['qmfl_nickname']	= $userinfo['wechaname'];
		$_SESSION['qmfl_headimgurl'] = $userinfo['headimgurl'];
	}

		// 调试	    
		/* $_SESSION['qmfl_openid'] = '78798';
		$_SESSION['qmfl_nickname'] = 'dsghgdad';
		$_SESSION['qmfl_headurl'] = 'baidu.com'; */

	
	// 获取系统当前时间
	$nowDate = date('y-m-d h:i:s',time());
	
	$timeQua = array("2016-02-06 00:00:00","2016-02-07 00:00:00","2016-02-08 00:00:00","2016-02-09 00:00:00");
	$day = ''; // 几号
	$surTimes = 0;  //抽奖次数
	$isPriBol = 0; // 中奖状态 0未中 1已中
	
	// 返回几号
	if(strtotime($timeQua[0]) > strtotime($nowDate)){
		$day = 5;
	}elseif(strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) > strtotime($nowDate)){
		$day = 6;
	}elseif(strtotime($timeQua[1]) <= strtotime($nowDate) && strtotime($timeQua[2]) > strtotime($nowDate)){
		$day = 7;
	}elseif(strtotime($timeQua[2]) <= strtotime($nowDate) && strtotime($timeQua[3]) > strtotime($nowDate)){
		$day = 8;
	}elseif(strtotime($timeQua[3]) <= strtotime($nowDate)){
		$day = 9;
	}
		
	// 6,7,8号每天3次机会
	if($day == 6 || $day == 7 || $day == 8){
				
		//是否第一次进入
		$mem_sql = "select * from $qmfl_weixin where openid='{$_SESSION['qmfl_openid']}'";
		$mem_res = mysqli_query($db, $mem_sql);
		$mem_row = $mem_res->fetch_assoc();
		
		if(empty($mem_row)) //第一次进入
		{
			$sql = "insert into $qmfl_weixin (openid,nickname,add_time,times,day{$day}) values ('{$_SESSION['qmfl_openid']}','{$_SESSION['qmfl_nickname']}','" . date('Y-m-d H:i:s') . "','3','1')";
			mysqli_query($db, $sql);
			
			$isPriBol = 0;
			$surTimes = 3;
		}
		else
		{		
			// 查询活动期间用户信息
			$sar_sql = "select * from $qmfl_weixin where openid='{$_SESSION['qmfl_openid']}'";
			$sar_res = mysqli_query($db, $sar_sql);
			$sar_row = $sar_res->fetch_assoc();
			
			if(empty($sar_row)){
				die("Error");
			}	
			// 查询剩余次数以及中奖状态
			else{				
				$surTimes = $sar_row['times'];
				switch($day)
				{
					case 6: if($sar_row['day6'] == 0) {
								$sql = "update $qmfl_weixin set times=3,day{$day}=1 where openid='{$_SESSION['qmfl_openid']}'";
								mysqli_query($db, $sql);
								$surTimes = 3;
							}
							break;
					case 7: if($sar_row['day7'] == 0) {
								$sql = "update $qmfl_weixin set times=3,day{$day}=1 where openid='{$_SESSION['qmfl_openid']}'";
								mysqli_query($db, $sql);
								$surTimes = 3;
							}
							break;
					case 8: if($sar_row['day8'] == 0) {
								$sql = "update $qmfl_weixin set times=3,day{$day}=1 where openid='{$_SESSION['qmfl_openid']}'";
								mysqli_query($db, $sql);
								$surTimes = 3;
							}
							break;
				}
				if($sar_row['is_prize'] == 1){
					$isPriBol = 1;
				}
			}
		}
	}
    
	
	
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no, email=no" />
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="HandheldFriendly" content="true">
		<meta name="MobileOptimized" content="640">
		<meta name="screen-orientation" content="portrait">
		<meta name="x5-orientation" content="portrait">
		<meta name="full-screen" content="yes">
		<meta name="x5-fullscreen" content="true">
		<meta name="browsermode" content="application">
		<meta name="x5-page-mode" content="app">
		<meta name="msapplication-tap-highlight" content="no">
		<meta name="viewport" content="width=640,target-densitydpi=device-dpi,maximum-scale=1.0, user-scalable=no">
		<script type="text/javascript">
			function setWidth(a) {
				if (/Andriod/i.test(navigator.userAgent)) {
					var c, b = window.innerWidth;
					(b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function() {
						var d = document.getElementsByTagName("body")[0];
						d.style.webkitTransformOrigin = "left top";
						d.style.webkitTransform = "scale(" + c + ")";
					}, !1)
				}
			}
			setWidth(640);
		</script>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/layout.css?v=3" />
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/wx_common.js"></script>
		<script type="text/javascript" src="js/load.js?v=3" ></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
			var SoundPlayer
			window.onload = function() {
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
				};
				loadImages(imgList,null,function(){
					WxLoadAudio(soundRes,null,function(){
						$(".loadMd").hide();
					});
				});
				var soundRes = [{
					name: "bg",
					src: "sound/bg.mp3",
					loop: true,
					autoplay: true
				},{
					name: "siye",
					src: "sound/siye.mp3",
					loop: false,
					autoplay:false				
				}];
				SoundPlayer = {
					total: soundRes.length,
					count: 0,
					autoplayArr:[],
					play: function(res) {
						SoundPlayer[res].play();
					},
					pause: function(res) {
						SoundPlayer[res].pause();
					},
					replay: function(res) {
						SoundPlayer[res].currentTime = 0;
						SoundPlayer[res].play();
					},
					onLoop: function(res) {
						SoundPlayer[res].loop = true;
					},
					noLoop: function(res) {
						SoundPlayer[res].loop = false;
					}
				};
				
				function WxLoadAudio(res, progress, complete) {
					var first = res.shift();
					if (first == undefined) {
						if (complete) {
							complete();
						}
						SoundPlayer.autoplayArr[0].play();
						return false;
					}
					var audioElement = new Audio(first.src);
					audioElement.loop = first.loop;
					document.body.appendChild(audioElement);
					audioElement.play();
					audioElement.addEventListener("loadedmetadata", loadedmetadataFn);
					audioElement.addEventListener("canplaythrough", canplaythroughFn);
					function loadedmetadataFn() {
						audioElement.pause();
						audioElement.currentTime = 0;
					}
					function canplaythroughFn() {
						audioElement.removeEventListener("loadeddata", loadedmetadataFn);
						audioElement.removeEventListener("canplaythrough", canplaythroughFn);
						SoundPlayer.count += 1;
						SoundPlayer[first.name] = audioElement;
						if(first.autoplay){
							SoundPlayer.autoplayArr[0]=audioElement;
						}
						if (progress) {
							progress(SoundPlayer.count, SoundPlayer.total);
						}
						WxLoadAudio(res, progress, complete);
					}
				};	
			}
		</script>
		<title>新年有福到</title>
	</head>

	<body>
		<div class="container n_wrapper">
			<!--loadMd-->
			<div class="loadMd">
				<div class="n_wrapper ver">
					<img src="img/load/loading.gif"/>
				</div>
			</div>
			<!--loadMd-->
			<!--commonMd-->
			<div class="commonMd">
				<div class="n_wrapper relative">
					<img src="img/common/head_tit.png" />
					<img src="img/common/paperBg.png" class="paperBg" />
					<img src="img/common/on.png" id="audioBtn" class="on"/>
				</div>
			</div>
			<!--commonMd-->
			<!--homeMd-->
			<div class="homeMd mdAbs">
				<div class="relative">
					<img src="img/home/homeBg.png" width="591" />
					<img src="img/home/ani.gif" class="homeAni"/>
				</div>
			</div>
			<!--homeMd-->
			<!--sixMd-->
			<div class="sixMd_1 mdAbs paperAffectBg">
				<div class="relative">
					<img src="img/day6/six_2.png" />
					<div class="playerAni">
						<div class="n_wrapper relative">
							<div style="background: url(img/day6/cir.png) no-repeat center center;opacity: 0;" class="endAni">
								<img src="img/day6/ani.gif" />
							</div>
							<div style="position: absolute;top: 0;left: 0;" class="initAni">
								<img src="img/day6/6.png" />
							</div>
							
						</div>		
					</div>
					
					<img src="img/common/fudai.png" class="fudai" />
					<img src="img/common/dianwo.png" class="dianwo" />
				</div>
			</div>
			<!--sixMd-->
			<!--sevenMd-->
			<div class="sevenMd_1 mdAbs paperAffectBg">
				<div class="relative">
					<img src="img/day7/seven_2.png" />
					<div class="playerAni">
						<div class="n_wrapper relative">
							<div style="background: url(img/day6/cir.png) no-repeat center center;opacity: 0;" class="endAni">
								<img src="img/day7/ani.gif" />
							</div>
							<div style="position: absolute;top: 0;left: 0;" class="initAni">
								<img src="img/day7/7.png" />
							</div>
							
						</div>		
					</div>
					<img src="img/common/fudai.png" class="fudai" />
					<img src="img/common/dianwo.png" class="dianwo" />
				</div>
			</div>
			<!--sevenMd-->
			<!--eightMd-->
			<div class="eightMd_1 mdAbs paperAffectBg">
				<div>
					<img src="img/day8/eight_2.png" />
					<div class="playerAni">
						<div class="n_wrapper relative">
							<div style="background: url(img/day6/cir.png) no-repeat center center;opacity: 0;" class="endAni">
								<img src="img/day8/ani.gif" />
							</div>
							<div style="position: absolute;top: 0;left: 0;" class="initAni">
								<img src="img/day8/8.png" />
							</div>
							
						</div>		
					</div>
					<img src="img/common/fudai.png" class="fudai" />
					<img src="img/common/dianwo.png" class="dianwo" />
				</div>
			</div>
			<!--eightMd-->
			<!--endMd-->
			<div class="endMd mdAbs paperAffectBg">
				<img src="img/end/endBg.png" />
			</div>
			<!--endMd -->
			<!--chouMd-->
			<div class="chouMd mdAbs paperAffectBg">
				<div class="relative">
					<img src="img/chou/chouBg.png" />
					<img src="img/chou/zhizhen.png" class="zhizhen" />
				</div>
			</div>
			<!--chouMd-->
			<!--resultMd-->
			<div class="resultMd">
				<div class="n_wrapper relative">
					<div class="resultBg">
						<div class="n_wrapper relative">
							<div class="result_aniCon">
								<div class="n_wrapper ver">
									<img id="result_AniImg" />
								</div>
							</div>
							<p class="resultText">
								<span></span>
								<br />
								<strong></strong>
							</p>
							<p class="resultDetial"></p>
							<div class="commnResult commnTishi">
								<!--resultWin-->
								<div class="resultWin n_wrapper">
									<div class="mes commonRed">
										<p>请填写电话号码</p>
										<input type="tel" name="" id="user_phone" value="" />
									</div>
									<div class="mesBtn commonBtn">
										我填好了√
									</div>
								</div>
								<!--resultWin-->
								<!--resultLose-->
								<div class="resultLose n_wrapper">
									<div class="commonRed commonShow">
										<p>您还可以...</p>
										<div class="commonTwoBtnCon">
											<div class="commonTwoBtn goHomeBtn">
												返回首页
											</div>
											<div class="commonTwoBtn shareBtn">
												好友齐享
											</div>
											<div class="clear"></div>
										</div>
									</div>
									<div class="guanzhuBtn commonBtn">
										关注全民家居购√
									</div>
								</div>
								<!--resultLose-->

							</div>
						</div>
					</div>
				</div>
			</div>
			<!--resultMd-->
			<!--tishiMd-->
			<div class="tishiMd">
				<div class="tishiBg">
					<div class="n_wrapper relative">
						<img class="user_state" width="129" height="134" />
						<div class="tishiText">

						</div>
						<div class="commnTishi">
							<div class="n_wrapper">
								<div class="commonRed commonShow">
									<p>您还可以...</p>
									<div class="commonTwoBtnCon">
										<div class="commonTwoBtn goHomeBtn">
											<!--返回首页-->
										</div>
										<div class="commonTwoBtn shareBtn">
											好友齐享
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div class="guanzhuBtn commonBtn">
									关注全民家居购√
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!--tishiMd-->
			<!--tipsMd-->
			<div class="tipsMd">
				<div class="n_wrapper relative">
					<img src="img/tips/tips.png" class="tipsMd_tips" />
				</div>
			</div>
			<!--tipsMd-->
			<!--shareMd-->
			<div class="shareMd">
				<p class="t_right"><img src="img/shareMd/shareImg.png" /></p>
			</div>
			<!--shareMd-->
			
		</div>
		</div>
		<script>

			var audioOn=true;
			$("#audioBtn").bind(Event.MOUSEDOWN,function(){
				if(audioOn){
					$("#audioBtn").attr("src","img/common/off.png");
					SoundPlayer.pause("bg");
					audioOn=false;
				}
				else{
					$("#audioBtn").attr("src","img/common/on.png");
					SoundPlayer.play("bg");
					audioOn=true;					
				}
			});
			function slideDown(obj, cb) {
				var sp, ep;
				obj.bind(Event.MOUSEDOWN, function(e) {
					sp = e.originalEvent.touches[0].pageY
				});
				obj.bind(Event.MOUSEMOVE, function(e) {
					ep = e.originalEvent.touches[0].pageY
				});
				obj.bind(Event.MOUSEUP, function() {
					if (ep > sp) {
						sp = null;
						ep = null;
						obj.off();
						SoundPlayer.replay("siye");
						cb();
						
					}
				});
			};
			$(document).bind(Event.MOUSEMOVE, function(e) {
				e.preventDefault();
			})


			function paperDown(obj) {
				obj.css({
					"-webkit-transition": "-webkit-transform 1s ease-in-out",
					"-webkit-transform": "translateY(1500px) skewY(40deg) rotateY(50deg)"
				});
				obj.bind("webkitTransitionEnd",function(){
					obj.hide();
					startAni();
				});
			};

			function showDayMd(obj) {
				obj.show();
				slideDown(obj, function() {
					paperDown(obj);	
				});
			};
			function startAni(){
				$(".initAni").css({
					"-webkit-transition": "opacity .5s ease-out .5s",
					"opacity":0
				})
				$(".endAni").css({
					"-webkit-transition": "opacity 1s ease-in .5s",
					"opacity":1					
				})
			}
			function setResult(n) {
				$(".resultMd").show();
				$("#result_AniImg").attr("src", "img/resultMd/" + n + ".gif");
				if (n != 2) {
					$(".resultDetial").css("top", "410px");
					$(".resultWin").show();
					$(".resultDetial").html("*奖品将在活动结束后10个工作日内存到<br />您的电话号码上或有工作人员通知您,<br />关注官方微信可了解活动详情。");
				} else {
					$(".resultLose").show();
					$(".resultDetial").html("*很遗憾您没有中奖哦，不过也不要灰心！<br />还有很多机会等着您的哦！");
					$(".goHomeBtn").html("返回首页");
					$(".goHomeBtn").one(Event.MOUSEUP, function() {
						window.location.href = "http://zt.jia360.com/2016/qmjjg/youfuli/"
					});
					$(".shareMd").bind(Event.MOUSEUP, function() {
						$(".shareMd").hide();
						$(".chouMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".chouMd").hide();
						$(".resultMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".resultMd").hide();
						$(".tishiMd").hide();
						$(".shareMd").show();
					});
				}
				var textArr = {
					"0": ["猴赛雷!恭喜您获得了", "1G流量"],
					"1": ['行"虾"好义!恭喜您获得了', "50M流量"],
					"2": ["哎哟~恭祝您", "猴年大吉，猴运连连!"],
					"3": ["心想事成!恭喜您获得了", "QQ公仔"],
					"4": ["如鱼得水!恭喜您获得了", "100M流量"],
					"5": ["闻鸡起舞!恭喜您获得了", "500M流量"],
					"7": ["牛气冲天!恭喜您获得了", "扫地机"]
				};
				$(".resultText").find("span").html(textArr[n][0]);
				$(".resultText").find("strong").html(textArr[n][1]);
				$(".mesBtn").bind(Event.MOUSEUP, mesSubmit);
			};

			function tishiMd(n) {
				$(".resultMd").hide();
				$(".tishiMd").show();
				var textJson = {
					"0": ["您填写的信息有误...", "img/tishiMd/fail.png"],
					"1": ["您的信息提交成功!", "img/tishiMd/sucess.png"],
					"2": ["您今天的次数已经用完啦!", "img/tishiMd/nocount.png"],
					"3": ["很抱歉活动已经结束咯", "img/tishiMd/nocount.png"],
					"4": ["活动时间2月6-8日,准备中...", "img/tishiMd/nocount.png"],
					"5": ["很抱歉，您已经中过奖了", "img/tishiMd/nocount.png"]
				};
				$(".tishiText").html(textJson[n][0]);
				$(".user_state").attr("src", textJson[n][1]);
				if (n == 2) {
					$(".goHomeBtn").html("返回首页");
					$(".goHomeBtn").one(Event.MOUSEUP, function() {
						window.location.href = "http://zt.jia360.com/2016/qmjjg/youfuli/"
					});
					$(".shareMd").bind(Event.MOUSEUP, function() {
						$(".shareMd").hide();
						$(".chouMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".chouMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
						$(".shareMd").show();
					});
				} 
				else if(n==5){
					$(".goHomeBtn").html("返回首页");
					$(".goHomeBtn").one(Event.MOUSEUP, function() {
						window.location.href = "http://zt.jia360.com/2016/qmjjg/youfuli/"
					});
					$(".shareMd").bind(Event.MOUSEUP, function() {
						$(".shareMd").hide();
						$(".chouMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".chouMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
						$(".shareMd").show();
					});					
				}
				else if (n == 0) {
					$(".goHomeBtn").html("返回填写");
					$(".goHomeBtn").one(Event.MOUSEUP, function() {
						$(".resultMd").show();
						$(".tishiMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".tishiText").html("您还没填写完信息哦!");
					});
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiText").html("您还没填写完信息哦!");
					});
				} else if (n == 1) {
					$(".goHomeBtn").html("返回首页");
					$(".goHomeBtn").one(Event.MOUSEUP, function() {
						//返回首页
						window.location.href = "http://zt.jia360.com/2016/qmjjg/youfuli/";
					});
					$(".shareMd").one(Event.MOUSEUP, function() {
						$(".shareMd").hide();
						$(".chouMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".chouMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
						$(".shareMd").show();
					});
				}
				else if(n==3){
					$(".goHomeBtn").hide();
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
						$(".shareMd").show();
					});
					$(".tishiMd").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".homeMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareMd").bind(Event.MOUSEUP, function() {
						$(".shareMd").hide();
					});
				}
				else if(n==4){
					$(".goHomeBtn").hide();
					$(".shareBtn").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
						$(".shareMd").show();
					});
					$(".tishiMd").bind(Event.MOUSEUP, function() {
						$(".tishiMd").hide();
					});
					$(".guanzhuBtn").one(Event.MOUSEDOWN, function() {
						$(".homeMd").hide();
						$(".tishiMd").hide();
					});
					$(".shareMd").bind(Event.MOUSEUP, function() {
						$(".shareMd").hide();
					});					
				}
			}

			function ajaxResult(n) {
				var degArr = [];
				for (var i = 0; i < 8; i++) {
					degArr.push(45 + 45 * i + 22.5 + 360);
				}
				$(".zhizhen").css({
					"-webkit-transform": "rotate(" + degArr[n] + "deg)"
				});
				$(".zhizhen").bind("webkitTransitionEnd", function() {
					setResult(n);
				});
			}

	function initAll(n,count,bol) {
				var dayNum = n; //传678
				if(parseInt(dayNum)<6){
					tishiMd(4);
					$(".shareBtn").css({
						"float":"inherit",
						"margin":"0 auto"
					});
				}
				else if(parseInt(dayNum)>8){
					tishiMd(3);
					$(".shareBtn").css({
						"float":"inherit",
						"margin":"0 auto"
					});					
				}
				slideDown($(".homeMd"), function() {
					paperDown($(".homeMd"));			
					var mdObj = {
						"6": ".sixMd_1",
						"7": ".sevenMd_1",
						"8": ".eightMd_1"
					}
					if (dayNum == 6) {
						showDayMd($(".sixMd_1"));
					} else if (dayNum == 7) {
						showDayMd($(".sevenMd_1"));
					} else if (dayNum == 8) {
						showDayMd($(".eightMd_1"));
					}
					$(".fudai").bind(Event.MOUSEDOWN, function() {
						$(mdObj[dayNum]).hide();
						$(mdObj[dayNum]).off();
						chouMd(count,bol); //传玩家剩余次数进去
					});
				});
			}

			function chouMd(n,bol) {
				//				n代表检测剩余抽奖次数
				if(bol==true){
					$(".chouMd").show();
					tishiMd(5);
					return false;					
				}
				if (n == 0) {
					$(".chouMd").show();
					tishiMd(2);
					return false;
				}
				$(".chouMd").show();
				$(".tipsMd").show();
				$(".tipsMd").bind(Event.MOUSEDOWN, function() {
					$(".tipsMd").hide();
				});
				$(".zhizhen").one(Event.MOUSEUP, function() {
					getPriceNum();
				});
			};

			function mesSubmit() {
				var val = $("#user_phone").val();
				if (val == "") {
					tishiMd(0); //信息填写错误调用tishiMd(0)
				} else {
					// 登记手机号码
					$.ajax({
						async:false,
						url: 'server.php',
						data:{act:'dengji',phone:val},
						type: "post",
						dataType:'json',
						success:function(result){
							if(result.errcode == 1005 || result.errcode == 1006 || result.errcode == 1007){
								// 手机号空或已登记
								alert(result.errmsg);
							}
							if(result.errcode == 0){
								tishiMd(1); //信息填写正确调用tishiMd(1)
							}
							if(result.errcode == 1000){
								//参数异常
								alert(result.errmsg);
							}
						},
						error: function(XMLHttpRequest) {
							if(XMLHttpRequest.readyState == '0'){
								alert("网络异常");
							}
						}
					});
					
				}
			}

			function getPriceNum() {
				$.ajax({
					async:false,
					url: 'server.php',
					data:{act:'draw'},
					type: "post",
					dataType:'json',
					success:function(result){
						//var n = 7;
						if(result.errcode == 0){
							ajaxResult(result.prize); //请求中奖结果的方法
						}
						else if(result.errcode == 1000){
							//参数异常
							alert(result.errmsg);
						}
					},
					error: function(XMLHttpRequest) {
						if(XMLHttpRequest.readyState == '0'){
							alert("网络异常");
						}
					}
				}); 	
			}
			
			initAll(<?php echo $day;?>,<?php echo $surTimes;?>,<?php echo $isPriBol;?>); //第一个值传几号 第二个值玩家抽奖次数,第三个值传是否中过奖的布尔值 中过传true
			
			
			//微信分享控制
			  wx.config({
			  debug: false,
			  appId: '<?php echo $signPackage["appId"];?>',
			  timestamp: '<?php echo $signPackage["timestamp"];?>',
			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			  signature: '<?php echo $signPackage["signature"];?>',
			  jsApiList: [
				'checkJsApi',
				'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'onMenuShareQQ',
				'onMenuShareWeibo'
			  ]
		  });
			wx.ready(function () {
				var wxData = {
					"imgUrl":'http://zt.jia360.com/2016/qmjjg/youfuli/img/shareMd/share.jpg',
					"link":'http://zt.jia360.com/2016/qmjjg/youfuli/',
					"desc":'万事如意喜临门，一帆风顺有福到，撕旧迎新，让你有钱有礼又有福！',
					"title":'新年有福到'
				};
				wx.onMenuShareAppMessage(wxData);
				wx.onMenuShareTimeline(wxData);
			});
		</script>
		<!--#include virtual="/public/tongji.html"-->
	</body>

</html>