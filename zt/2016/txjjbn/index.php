<?php
	define('ROOT_PATH', dirname(__FILE__));	
	require_once(ROOT_PATH .'../../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage(); 

?>

<!DOCTYPE html>
<html lang="en">

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
		<title>腾讯家居&行业大咖齐拜年！</title>
		<script src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/wx_common.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<link rel="stylesheet" href="css/swiper.min.css">
		<link rel="stylesheet" href="css/animate.min.css">
		<link rel="stylesheet" href="css/style.css?v=1.0">
		<style>
			html,
			body {
				background: url(images/bg.jpg?v=1.0) no-repeat;
				background-size: cover;
			}
			
			.music {
				-webkit-animation: musicRo 3s infinite;
				-webkit-transform-origin: center center;
				position: fixed;
				right: 30px;
				top: 30px;
				z-index: 6;
			}
			
			@-webkit-keyframes musicRo {
				0% {
					-webkit-transform: rotate(0deg);
				}
				100% {
					-webkit-transform: rotate(360deg);
				}
			}
		</style>
		<script>
			var SoundPlayer
			window.onload = function() {
				var soundRes = [{
					name: "bg",
					src: "sound/bg.mp3",
					loop: true,
					autoplay: true
				}];
				SoundPlayer = {
					total: soundRes.length,
					count: 0,
					autoplayArr: [],
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
				WxLoadAudio(soundRes);

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
						if (first.autoplay) {
							SoundPlayer.autoplayArr[0] = audioElement;
						}
						if (progress) {
							progress(SoundPlayer.count, SoundPlayer.total);
						}
						WxLoadAudio(res, progress, complete);
					}
				};
			var isplay = true;
			$(".music").bind(Event.MOUSEDOWN, function() {
				if (isplay) {
					$(".music").css("-webkit-animation-play-state", "paused");
					isplay = false;
					SoundPlayer.pause("bg");
				} else {
					$(".music").css("-webkit-animation-play-state", "running");
					isplay = true;
					SoundPlayer.play("bg");
				}
			})
			}
		</script>
	</head>

	<body>
		<img src="images/music.png" class="music">
		<div style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 1200;background-color: #FFFFFF;" id="loadCon">
			<div class="n_wrapper ver">
				<img src="images/load.gif" />
			</div>
		</div>
		<div style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 1200;background-color:rgba(0,0,0,.8);display: none;" id="qrCon">
			<div class="n_wrapper ver">
				<div><img src="images/pageadd2.jpg" qr="0"></div>
			</div>

		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<div class="backdrop">
						<img src="images/bg.jpg" style="display: none;" />
						<div style="margin-top:80px;" class="ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"><img src="images/page1-1.png"></div>
						<div style="margin-top: 10px;margin-right: 30px;position: absolute;right: 20px;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s" swiper-animate-delay="0.5s"><img src="images/page1-2.png"></div>
						<div style="margin-top:20px;margin-left:40px;position: absolute;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.5s"><img src="images/page1-3.png"></div>
						<div style="margin-top: 110px;margin-left: 190px;position: absolute;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.5s"><img src="images/page1-4.png"></div>
						<div style="position: absolute;margin-top: 120px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="1.5s"><img src="images/page1-6.png" style="width:350px;"></div>
						<div style="position: absolute;right: 20px;margin-top: 150px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="1.5s"><img src="images/page1-6.png" style="width:300px;"></div>
						<div style="position:absolute;margin-top: 240px;left: 50%;margin-left: -291px;" class="ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s" swiper-animate-delay="1.5s"><img src="images/page1-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="margin-top:20px;" class="ani" swiper-animate-effect="shake" swiper-animate-duration="1s"><img src="images/page2-6.png" style="width:600px;"></div>
						<div style="margin-top:20px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"><img src="images/page2-1.png"></div>
						<div style="margin-top:30px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"><img src="images/page2-2.png"></div>
						<div style="margin-top:30px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"><img src="images/page2-3.png"></div>
						<div style="margin-top:10px;position: absolute;right:20px;"><img src="images/page2-4.png" style="width:304px;"></div>
						<div style="position: absolute;left: 20px;"><img src="images/page2-5.png" style="width:304px;"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top: 0;right:0" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page10-1.png"></div>
						<div style="position: absolute;left:0;bottom:480px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page10-2.png"></div>
						<div style="position: absolute;right:0;bottom: 440px;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page10-3.png"></div>
						<div style="position: absolute;bottom:0;right:0;z-index: 2;" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s" swiper-animate-delay="2s"><img src="images/page10-4.png"></div>
						<div style="position: absolute;left:0;bottom:-5px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page10-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top: 0;left: 50%;margin-left: -110px;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page11-1.png"></div>
						<div style="position: absolute;left:0;bottom:200px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page11-2.png"></div>
						<div style="position: absolute;right:0;bottom:200px;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page11-3.png"></div>
						<div style="position: absolute;bottom:190px;left:0;z-index: 2;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page11-4.png"></div>
						<div style="position: absolute;bottom:190px;right:0;z-index: 2;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page11-5.png"></div>
						<div style="position: absolute;left:0;bottom:-5px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page11-6.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top: 0;left:50px;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page12-1.png"></div>
						<div style="position: absolute;right:0;bottom:-5px;z-index:3;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration=" 1s" swiper-animate-delay="2.5s"><img src="images/page12-2.png?v=1.0"></div>
						<div style="position: absolute;left:0;bottom:250px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page12-3.png"></div>
						<div style="position: absolute;left:30px;bottom:320px;z-index:3;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page12-4.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="margin-top:20px;" class="ani" swiper-animate-effect="pulse" swiper-animate-duration="1s"><img src="images/page5-1.png"></div>
						<div style="bottom:-5px;position: absolute;left: 0;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.7s"><img src="images/page5-2.png"></div>
						<div style="bottom:-5px;position: absolute;right: 0;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s" swiper-animate-delay="0.7s"><img src="images/page5-3.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position:absolute;bottom: 90px;right: 0;z-index: 3;" class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="2s"><img src="images/page6-1.png"></div>
						<div style="position: absolute;left: 0;bottom: -5px;z-index:2" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page6-2.png"></div>
						<div style="position: absolute;top: 20px;left: 20px;z-index:1;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page6-3.png"></div>
						<div style="position: absolute;right: 0;bottom: -5px;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page6-4.png"></div>
						<div style="position:absolute;bottom: 90px;left: 0;z-index: 3;" class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="2s"><img src="images/page6-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top: 250px;z-index: 2;left: 50%;margin-left: -65px;" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page7-1.png"></div>
						<div style="position: absolute;left: 20px;top: 20px;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1.5s"><img src="images/page7-2.png"></div>
						<div style="position: absolute;top: 20px;right: 20px;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1.5s"><img src="images/page7-3.png"></div>
						<div style="position: absolute;left: 0;bottom: -5px;" class="ani" swiper-animate-effect="bounceInUp" swiper-animate-duration="1.5s"><img src="images/page7-4.png"></div>
						<div style="position:absolute;bottom: -5px;right: 0;" class="ani" swiper-animate-effect="bounceInUp" swiper-animate-duration="1.5s"><img src="images/page7-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top:0;z-index: 2;right: 0;" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s" swiper-animate-delay="1.6s"><img src="images/page8-1.png"></div>
						<div style="position: absolute;bottom: -5px;z-index: 2;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page8-2.png"></div>
						<div style="position: absolute;top: 20px;left: 20px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"><img src="images/page8-3.png"></div>
						<div style="position: absolute;right: -10px;bottom: 270px;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page8-4.png"></div>
						<div style="position: absolute;bottom: 150px;right: 80px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page8-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top: 350px;left: 50%;margin-left: -70px;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page9-1.png"></div>
						<div style="position: absolute;left:0" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page9-2.png"></div>
						<div style="position: absolute;right:0;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page9-3.png"></div>
					</div>
				</div>

				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;bottom: -5px;left:0;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page13-1.png"></div>
						<div style="position: absolute;right:0;bottom:400px;z-index:3;" class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="2s"><img src="images/page13-2.png"></div>
						<div style="position: absolute;left: 470px;bottom: 0;" class="ani" swiper-animate-effect="lightSpeedIn" swiper-animate-duration="1s" swiper-animate-delay="2.5s"><img src="images/page13-3.png"></div>
						<div style="position: absolute;right:0;z-index: 2;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page13-4.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;bottom:-5px;left:0;z-index:4;" class="ani" swiper-animate-effect="shake" swiper-animate-duration="1s"><img src="images/page14-1.png"></div>
						<div style="position: absolute;left:50%;margin-left:-130px;bottom:100px;z-index:2;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay=".5s"><img src="images/page14-2.png"></div>
						<div style="position: absolute;left:0;bottom: 100px;z-index:3;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page14-3.png"></div>
						<div style="position: absolute;bottom: 100px;right:0;z-index:3;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page14-4.png"></div>
						<div style="position: absolute;left:170px;bottom:590px;z-index:1;" class="ani" swiper-animate-effect="lightSpeedIn" swiper-animate-duration="1s" swiper-animate-delay="1.6s"><img src="images/page14-5.png"></div>
						<div style="position: absolute;right:100px;bottom:590px;z-index:1;" class="ani" swiper-animate-effect="lightSpeedIn" swiper-animate-duration="1s" swiper-animate-delay="1.6s"><img src="images/page14-5.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;bottom: 510px;left:0;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s"><img src="images/page15-1.png"></div>
						<div style="position: absolute;left:0;top:0;z-index:3;" class="ani" swiper-animate-effect="bounce" swiper-animate-duration="1s"><img src="images/page15-2.png"></div>
						<div style="position: absolute;right:0;bottom: -5px;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"> <img src="images/page15-3.png"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;right:0;bottom:-5px;z-index:2;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"><img src="images/page16-1.png"></div>
								<div style="position: absolute;bottom: 220px;left: 100px;z-index:2;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s"><img src="images/page16-2.png"></div>
								<div style="position: absolute;bottom:90px;z-index:1;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s"><img src="images/page16-3.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;left:0;bottom:-5px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page17-1.png"></div>
								<div style="position: absolute;left:50%;margin-left:-110px;top:30px;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page17-2.png"></div>
								<div style="position: absolute;bottom:-5px;right:0;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page17-3.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;left:0;bottom:0;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page20-1.png"></div>
								<div style="position: absolute;right:0;top:0;"><img src="images/page20-2.png"></div>
								<div style="position: absolute;bottom:500px;left:250px;z-index:2;" class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page20-3.png"></div>
								<div style="position: absolute;bottom:230px;right:0;z-index:1;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page20-4.png"></div>
								<div style="position: absolute;bottom:0;left:290px;z-index:3;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="1.7s"><img src="images/page20-5.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;right:0;bottom:350px;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"  swiper-animate-delay="0.5s"><img src="images/page18-1.png"></div>
								<div style="position: absolute;left:0;top:0;"><img src="images/page18-2.png"></div>
								<div style="position: absolute;bottom:-5px;left:0;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page18-3.png"></div>
								<div style="position: absolute;bottom:-5px;right:0;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"><img src="images/page18-4.png"></div>
								<div style="position: absolute;bottom:-4px;right:0;" class="ani" swiper-animate-effect="shake" swiper-animate-duration="1s"><img src="images/page18-5.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;left:50%;margin-left:-70px;top:0;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page19-1.png"></div>
								<div style="position: absolute;left:0;bottom:180px;z-index:1;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page19-2.png"></div>
								<div style="position: absolute;bottom:-5px;left:0;z-index:2;"><img src="images/page19-3.png"></div>
								<div style="position: absolute;bottom:180px;right:0;z-index:1;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page19-4.png"></div>
								<div style="position: absolute;bottom:150px;left:0;z-index:3;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page19-5.png"></div>
								<div style="position: absolute;bottom:150px;right:0;z-index:3;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page19-6.png"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;left:0;bottom:0;"><img src="images/page21-1.png"></div>
								<div style="position: absolute;left:50px;bottom:700px;" class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="1s"><img src="images/page21-2.png"></div>
								<div style="position: absolute;bottom:400px;left:0;z-index:2;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page21-3.png"></div>
								<div style="position: absolute;bottom:-5px;right:0;z-index:1;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page21-4.png"></div>
								<div style="position: absolute;bottom:500px;left:100px;z-index:3;" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s" swiper-animate-delay="1.6s"><img src="images/page21-5.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;right:0;top:0;"><img src="images/page22-1.png"></div>
								<div style="position: absolute;right:0;bottom:0;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"><img src="images/page22-2.png"></div>
								<div style="position: absolute;bottom:0;left:0;" class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="1s"><img src="images/page22-3.png"></div>
								<div style="position: absolute;bottom:0;" class="ani" swiper-animate-effect="tada" swiper-animate-duration="1s"><img src="images/page22-4.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								<div style="position: absolute;bottom:230px;right: 0;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page23-1.png"></div>
								<div style="position: absolute;"><img src="images/page23-2.png"></div>
								<div style="position: absolute;bottom:-5px;left:0;z-index:2;"><img src="images/page23-3.png"></div>
								<div style="position: absolute;bottom:230px;left:0;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page23-4.png"></div>
								<div style="position: absolute;bottom:230px;left:0;z-index:3;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s"><img src="images/page23-5.png"></div>
								<div style="position: absolute;bottom:210px;right:0;z-index:3;" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1s"><img src="images/page23-6.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div class="swiper-slide">
							<div class="backdrop">
								
								<div style="position: absolute;right:10px;bottom:800px;" class="ani" swiper-animate-effect="lightSpeedIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page24-2.png"></div>
								<div style="position: absolute;left:0;bottom:-5px;z-index:2;" class="ani" swiper-animate-effect="zoomInLeft" swiper-animate-duration="1s"><img src="images/page24-3.png?v=1.0"></div>
								<div style="position: absolute;right:0;bottom:200px;" class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s" swiper-animate-delay="1.1s"><img src="images/page24-4.png"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;top:0;left:0;"><img src="images/page4-1.png"></div>
						<div style="position: absolute;top:50%;margin-top:-200px;" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"><img src="images/pageadd1.png"></div>
						<div style="position: absolute;top:20px;left:20px;" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page3-2.png" style="width:300px;"></div>
						<div style="position: absolute;bottom: 20px;left: 50%;margin-left: -180px;" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img src="images/page4-2.png" style="width:400px;"></div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="backdrop">
						<div style="position: absolute;left: 50%;margin-left: -120px;top: 50%;margin-top: 300px;"><img src="images/pageadd0.png"></div>
						<div style="position: absolute;top: 60px;left: 50%;margin-left: -170px;opacity: 0.4;"><img src="images/pageadd3.png" style="width:350px;"></div>
						<div style="position: absolute;top: 20px;left: 0;opacity: 0.4;"><img src="images/pageadd4.png"></div>
						<div style="position: absolute;top: 20px;right: 0;opacity: 0.4;"><img src="images/pageadd5.png"></div>
						<div style="position: absolute;left:50%;margin-left:-200px;top:50%;margin-top:-200px;" class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s" swiper-animate-delay=".7s"><img id="dianwo" src="images/page25-1.png"></div>
						<div style="position: absolute;left:50%;margin-left:-220px;top:50%;margin-top:-400px;" class="ani" swiper-animate-effect="wobble" swiper-animate-duration="1s"><img src="images/page25-2.png"></div>
					</div>
				</div>
			</div>
		</div>

		<script src="js/swiper-3.3.0.jquery.min.js"></script>
		<script src="js/swiper.animate1.0.2.min.js"></script>
		<script>
			var swiper = new Swiper('.swiper-container', {
				direction: 'vertical',
				updateOnImagesReady: true,
				onImagesReady: function(swiper) {
					$("#loadCon").hide();
					swiperAnimateCache(swiper); //隐藏动画元素 
					swiperAnimate(swiper); //初始化完成开始动画
				},
				onSlideChangeStart: function(swiper) {
					swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
				}
			});

				$("#dianwo").bind(Event.MOUSEDOWN, function() {
					$("#qrCon").show();
				});
				$("#qrCon").bind(Event.MOUSEUP, function(e) {
					if(!$(e.target).attr("qr")){
						$("#qrCon").hide();
					}
				});
				
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
					"imgUrl":'http://zt.jia360.com/2016/txjjbn/images/logo.png?v=1.0',
					"link":'http://zt.jia360.com/2016/txjjbn/',
					"desc":'“羊随新风辞旧岁，猴节正气报新春”，腾讯家居携手行业大咖给各位拜年啦~！',
					"title":'腾讯家居&行业大咖齐拜年！',
					success:function(){
					}
				};
				wx.onMenuShareAppMessage(wxData);
				wx.onMenuShareTimeline(wxData);
			});
		</script>
	</body>

</html>