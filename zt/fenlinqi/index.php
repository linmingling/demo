<?php
    require_once "../data/jssdk.php";
    require_once "server.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    //活动结束时间
    if(time() > strtotime('2015-12-16')){
        $is_end = 1;
    } else {
        $is_end = 0;
    }
    
    if(!$_POST['openid']){
        $openId = $_SESSION['flq_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=flq';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['flq_openid'] = $_POST['openid'];
        $_SESSION['flq_wechaname'] = base64_decode($_POST['wechaname']);
        $_SESSION['flq_headimgurl'] = urldecode($_POST['headimgurl']);
    }
    
//     $_SESSION['flq_openid'] = '1111qw11';
//     $_SESSION['flq_wechaname'] = '222222';
    $sql = "SELECT id,surplus_num,last_time,phone,prize,sn FROM fenlinqi WHERE openid='".$_SESSION['flq_openid']."'";
    $res = mysqli_query($db, $sql);
    $info = $res->fetch_assoc();
    if(!$info){
        $sql = "INSERT INTO fenlinqi(openid, wechaname, headimgurl, surplus_num, add_time) VALUES('".$_SESSION['flq_openid']."','".$_SESSION['flq_wechaname']."','".$_SESSION['headimgurl']."','3','".date('Y-m-d H:i:s')."')";
        $url = mysqli_query($db, $sql);
        if(!$url){
            echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
        }
    } else {
        if((strtotime(date('Y-m-d', time())) - strtotime(date('Y-m-d', strtotime($info['last_time'])))) >= 86400){
            $up_sql = "UPDATE fenlinqi SET surplus_num=3 WHERE openid='".$_SESSION['flq_openid']."'";
            mysqli_query($db, $up_sql);
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
        <meta http-equiv="expires" content="-1">
        <title>芬琳漆“最强色” 比比谁更色（测试版）</title>

        <link type="text/css" href="css/m.css?v=2.0"  rel="stylesheet">
        <link type="text/css" href="css/common.css" rel="stylesheet">
        <script src="js/jquery-1.8.3.min.js"></script>
        <script src="js/common.js"></script>
  
<style>

</style>

    </head>
    <body>
		<img src="images/logo.png" style="width:1px;height:1px;" id="shareImg" />
        <div class="grid">
            <div class="page hide" id="loading">
                loading...
            </div>
            <div class="page hide index" id="index" >
				<div class="bg">
					<h1 class="hide">芬琳漆“最强色” 比比谁更色</h1>
					<img src="images/logo.png" class="logo" />
					<img src="images/title.png" class="title" />
					<?php if($is_end != 1){?>
						<div class="btns">
							<span class="btn play-btn">
								开始游戏
							</span>
							<span class="btn help-btn">
								help
							</span>
						</div>
					<?php }else{?>
                        <div class="btns">
							<span style="font-size: 24px;font-weight: bolder;">活动已结束</span>
                        </div>
					<?php }?>
					<img src="images/p1.png" class="p1" />
						<div style="text-align: center;margin-top: 2px;">
						<?php if($info['phone'] && $info['sn']){?>
							<span>我的获奖记录</span><br/>
							<span><?php echo $info['prize']?>&nbsp;&nbsp;兑奖码：<?php echo $info['sn']?></span><br/>
						<?php }?>
						</div>
                </div>
            </div>
            <div class="page room hide" id="room">
				<div class="bg">
					<header>
						<span class="lv">
							<em id="score">
								0
							</em>
						</span>
						<span class="time">
						</span>
						<span class="btn btn-pause">
							暂停
						</span>
					</header>
					<div id="box" class="lv1">
					</div>
                </div>
            </div>
            <div class="page hide" id="dialog">
                <div class="inner">
					<img src="images/logo.png" class="logo" />
                    <div class="content gameover">
						<img src="images/text.png" class="text" />
						<h3></h3>
						<span style="font-size: 12px;color: #000;">点击top10，看看你离minipad还有多远</span><br/>
						
							<div id="lotteryContainer"></div>
						
							<span style="font-size: 16px;" class="tips"></span>
						
                        <div class="btn-wrap">
                            <span class="btn btn-restart">
                                再来一次
                            </span>
							<span class="btn btn-rank">
                                排行榜
                            </span>
                        </div>
                        
							<div class="form-wrap hide" id="form-wrap">
								<img src="images/bg7.png" class="formBg" />
								<span class="btn btn-close"></span>
								<div class="form" id="form">
									<p class="nameP"><input type="text" class="name" value=""/></p>
									<p class="telP"><input type="text" class="tel" value=""/></p>
									<p class="addP"><input type="text" class="add" value=""/></p>
									<span class="btn btn-ok">
										确定
									</span>
								</div>
							</div>
						
						<div class="rankBox hide" id="rankBox">
							<img src="images/bg9.png" class="formBg" />
							<span class="btn btn-close"></span>
							<div class="rankList">
							<p>做第一名，拿ipadmini！</p>
							</div>
						</div>
                    </div>
                    <div class="content pause">
                        <h3>
                            游戏暂停
                        </h3>
                        <div class="btn-wrap">
                            <span class="btn btn-resume">
                                继续游戏
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		<div class="helpBox hide" id="helpBox">
			<div class="bg">
				<span class="btn btn-close"></span>
				<p class="helpTitle"></p>
				<div class="helpMain">
					<div class="helpBlock">
						<p class="helpSTitle">游戏说明</p>
						<p>(活动时间2015年3月10日00:00--20日24:00)</p>
						<ol>
							<li>在规定时间内找到的“不同色”越多，分数越高，中奖几率也越高哦，每天3次刮奖机会!</li>
							<li>活动结束后可点击TOP10查看玩家排行榜前十名，活动结束后，得分最高者可获得苹果minipad一台，如有最高分同分者，以先取得最高分者获奖。活动结束后请及时查看”芬琳漆“官方微信公布的获奖名单。</li>
							<li>中奖的小伙伴一定要立即填写准确的个人信息，否则中奖无效哦（这一点切记呀），因为活动结束后，主办方需要通过填写的手机号联系中奖用户。</li>
						</ol>
					</div>
					<div class="helpBlock">
						<p class="helpSTitle">奖项设置</p>
						<p>
							<img data-src="images/help1.jpg" /><br/>
							<img data-src="images/help2.jpg" /><br/>
							<img data-src="images/help3.jpg" /><br/>
							<img data-src="images/help4.jpg" /><br/>
							<img data-src="images/help5.jpg" /><br/>
							<img data-src="images/help6.jpg" /><br/>
						</p>
					</div>
					<div class="helpBlock">
						<p class="helpSTitle">兑奖方式</p>
						<ol>
							<li>“芬琳漆”官方微信将在活动结束后公布获奖名单，敬请关注，以便及时认领奖品，其中“参与奖”可在活动期间（3月10—20日）凭兑奖码到芬琳漆全国店面兑换（最终解释权归芬琳漆所有），全国店面地址请关注微信号“芬琳漆”回复“专卖店”查询。</li>
						</ol>
					</div>
					<div class="helpBlock">
						<p class="helpSTitle">免责条款</p>
						<ol>
							<li>用户知悉互联网存在诸多不确定性因素，因此请理解并同意，如因不可抗力、网络、通讯路线故障或活动中存在大面积作弊行为等非主办方芬琳漆原因致使本次活动出现异常情况或难以继续开展的，主办方有权采取包括通过各种方式消除异常情况或调整、暂停、取消本活动等措施，因此造成用户损失的，主办方不承担任何责任；</li>
							<li>请保证手机网络使用正常，若因手机网络等用户原因导致奖品领取失败的情况，芬琳漆将不做任何补偿。</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<img src="images/gua.png" class="hide" />
		
	<script type="text/javascript">
		btGame.onlyVScreen();
		btGame.playLogoAdv();
	</script>
	<script src="js/libs.min.js"></script>
	<script src="js/main.min.js?v=2.0"></script>
	<script src="js/Lottery.js"></script>
		<script>
		$(function(){
			$("#form .btn-ok").click(function(){
				var name = $("#form .name").val();
				var tel = $("#form .tel").val();
				var city = $("#form .add").val();
				var isMobile = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
				var isPhone=/^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;  
				if(name == ""){
					alert("请填写姓名！");
				}else if(!isMobile.test(tel) && !isPhone.test(tel)){
					alert("请填写正确的电话号码！");
				}else if(city == ""){
					alert("请填写地址！");
				}else{
					$.ajax({
			            async:true,
			            url:'server.php',
			            data:{act:'submit', name:name, tel:tel, city:city},
			            type: 'post',
			            dataType:'json',
			            success:function(result){
				            if(result.errcode){
					            alert(result.errmsg)
					        } else {
					        	$("#form-wrap").fadeOut();
					        	alert(result.errmsg);
						    }
			            }
			        });
				}
			});
			$("#form-wrap .btn-close").click(function(){
				$("#form-wrap").fadeOut();
			});
			//排行榜
			$(".btn-rank").click(function(){
				$("#rankBox").fadeIn();
				$.ajax({
		            async:true,
		            url:'server.php',
		            data:{act:'ranking'},
		            type: 'post',
		            dataType:'json',
		            success:function(result){
		            	$(".rankList").empty();
						for(i=0;i<result.length;i++){
							$(".rankList").append("<p><span>"+result[i]['ranking']+"</span><span class='name'><img src='"+result[i]['headimgurl']+"'>"+result[i]['wechaname']+"</span><span>"+result[i]['score']+"分</span>");
						}
		            }
		        });
			});
			$("#rankBox .btn-close").click(function(){
				$("#rankBox").fadeOut();
			});
			$(".help-btn").click(function(){
				$("#helpBox img").each(function(){
					$(this).attr("src",$(this).attr("data-src"));
				});
				$("#helpBox").fadeIn();
			});
			$("#helpBox .btn-close").click(function(){
				$("#helpBox").fadeOut();
			});
			$(".btn-restart").click(function(){
				location.reload();
			});
		});
		
		function lottery_hje(){
				var isScrape = 0;
				var jp = "images/bg.png";
				var sn = ""
				var thank  = "";
				var is_hide = 1;
				var lottery = new Lottery('lotteryContainer', 'images/gua.png', 'image', 190, 93, drawPercent);
				setTimeout(function(){
					if(jp){
						lottery.init(jp, 'image');
						$("#lotteryContainer canvas").before("<img src="+jp+" style='width:100%;height:100%;position:absolute;top:0;left:0' />");
					} else {
						lottery.init(thank, 'image');
						$("#lotteryContainer canvas").before("<img src="+thank+" style='width:100%;height:100%;position:absolute;top:0;left:0' />");
					}
				},100);

				function drawPercent(percent) {
				   if(percent>50){
						$("#lotteryContainer canvas").fadeOut();
						if(!isScrape){
							isScrape = 1;
    						$.ajax({
    				            async:true,
    				            url:'server.php',
    				            data:{act:'start'},
    				            type: 'post',
    				            dataType:'json',
    				            success:function(result){
    					            if(result.errcode){
    						            alert(result.errmsg)
    						        } else {
    							        jp = "images/jp"+result.prize_id+".png";
    						        	lottery.init(jp, 'image');
    									$("#lotteryContainer canvas").before("<img src="+jp+" style='width:100%;height:100%;position:absolute;top:0;left:0' />");
    								    $('.tips').html("今天还有"+result.num+"次抽奖机会！")
    								    if(result.sn){
    								        $("#lotteryContainer canvas").eq(0).before("<p>兑奖序列号："+result.sn+"</p>");
    								        $("#form-wrap").fadeIn();
    								    }
    							    }
    				            }
    				        });
						}
				   }
			}
		}
		
		function ajax_score(a){
			$.ajax({
	            async:true,
	            url:'server.php',
	            data:{act:'score', score:a},
	            type: 'post',
	            dataType:'json',
	            success:function(result){
		            if(result.errcode){
			            alert(result.errmsg)
			        }
	            }
	        });
		}
    </script>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	//微信分享控制
	wx.config({
		  debug: false,
	      appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
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
			"imgUrl":'http://zt.jia360.com/fenlinqi/images/share.png',
			"link":'http://zt.jia360.com/fenlinqi/index.php',
			"desc":"芬琳漆测试版",
			"title":"芬琳漆测试版",
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
</script>
</html>