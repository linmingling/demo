<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../data/config.php');
	require_once(ROOT_PATH .'../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage(); 
    
    $agent = $_SERVER['HTTP_USER_AGENT'];
     if(!strpos($agent,"MicroMessenger")){
    	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    
    /* $_SESSION['jlf2_openid'] = '76576';
    $_SESSION['jlf2_wechaname'] = 'dsghgdad';
    $_SESSION['jlf2_headurl'] = 'baidu.com'; */
    
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['jlf2_openid'];
    	$wechaname = $_SESSION['jlf2_wechaname'];
    	$headurl = $_SESSION['jlf2_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=jlf2';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['jlf2_openid'] = $openId;
    	$_SESSION['jlf2_wechaname'] = $wechaname;
    	$_SESSION['jlf2_headurl'] = $headurl;
    }
    
    //是否第一次进入
    $jlf_weixin = 'jlf_weixin_info';
    $mem_sql = "select * from $jlf_weixin where openid='{$openId}' and disting='1'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //第一次进入
    {
    	$sql = "insert into $jlf_weixin (openid,nickname,add_time,disting) values ('{$openId}','{$wechaname}','" . date('Y-m-d H:i:s') . "','1')";
    	mysqli_query($db, $sql);
    }

    //是否已填资料
    $check_sql = "select * from $jlf_weixin where openid='{$openId}' and person is not null and disting='1'";
    $check_res = mysqli_query($db, $check_sql);
    $check_row = $check_res->fetch_assoc();
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
			
			<?php if(empty($check_row)){?>
			var wxDesc = '你的装修个性，是《琅琊榜》中的谁呢？';
			var wxTitle = '快来测一测你是琅琊榜中的谁？';
			var wxImgUrl = 'http://zt.jia360.com/jlf2_h5/img/tou/share.jpg';
			<?php }else{?>
			var wxDesc = '嘉力丰有奖问卷调查，快来参与抽取大奖！';
			var wxTitle = '我在琅琊榜中的人物：<?php echo $check_row['person']?>';
			var wxImgUrl = 'http://zt.jia360.com/jlf2_h5/img/tou/<?php echo $check_row['perNum']?>.jpg';
			<?php }?>
			var wxLink = 'http://zt.jia360.com/jlf2_h5/index.php';
			var isOne =  <?php if(empty($check_row)){?> '0' <?php }else{?> '1' <?php }?>;
		</script>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/layout.css" />
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<title></title>
	</head>

	<body>
		<!--main_md-->
		<div class="main_md common_md">
			<div class="n_wrapper relative">
				<img src="img/main/logo.png" class="logo" />
				<div class="main_bot">
					<h1 class="t_center">测测你的<strong>装修个性是</strong></h1>
					<p><img src="img/main/maintit.png" id="mainBtn"/></p>
					<p class="t_center ued">@腾讯家居UED出品</p>
				</div>
			</div>
		</div>
		<!--main_md-->
		<!--qa_md-->
		<div class="qa_md common_md">
			<div class="n_wrapper relative">

				<!--answerInfo-->
				<div class="answerCon answerInfo">
					<div class="n_wrapper relative">
						<p class="t_center qa_tit"><img src="img/main/logo.png" /></p>
						<div class="answerpos">
							<!--user_sex-->
							<div class="user_sex">
								<strong class="user_strong">性别</strong>
								<div class="inline_block user_sex_list">
									<span>男</span>
									<span>女</span>
								</div>
							</div>
							<!--user_sex-->
							<!--user_age-->
							<div class="user_age relative">
								<strong class="user_strong">年龄</strong>
								<div class="inline_block user_age_list">
									<span>25岁以下</span>
									<span>26-35岁</span>
									<span>36-45岁</span>
									<span>46-55岁</span>
									<span>55岁及以上</span>
								</div>
							</div>
							<!--user_age-->
							<!--user_hun-->
							<div class="user_hun">
								<strong class="user_strong">婚否</strong>
								<div class="inline_block user_hun_list">
									<span>是</span>
									<span>否</span>
								</div>
							</div>
							<!--user_hun-->
							<!--user_earn-->
							<div class="user_earn relative">
								<strong class="user_strong">收入状况</strong>
								<div class="inline_block user_earn_list">
									<span>1500-3500</span>
									<span>3501-6000</span>
									<span>6000以上</span>
								</div>
							</div>
							<!--user_earn-->
							<div class="t_center">
								<img src="img/qa/dengji.png" id="dengji"/>
							</div>
						</div>
					</div>
				</div>
				<!--answerInfo-->
				<!--answerTiku-->
				<div class="answerCon answerTiku">
					<div class="n_wrapper relative">
						<p class="t_center qa_tit"><img src="img/main/logo.png" /></p>
						<div class="answerpos" id="tikuCon">
								<div class="n_wrapper relative">
								<h1>如果你生活于《琅琊榜》中，最希望生活的场所是哪里？</h1>
								<div id="tiku">
									<p class="t_center"><strong>A、</strong><span>苏宅</span></p>
									<p class="t_center"><strong>B、</strong><span>琅琊阁</span></p>
									<p class="t_center"><strong>C、</strong><span>皇宫</span></p>
									<p class="t_center"><strong>D、</strong><span>靖王府</span></p>
								</div>
								<div class="clear"></div>
								</div>
						</div>
						
					</div>
				</div>
				<!--answerTiku-->
			</div>
		</div>
		<!--qa_md-->
		<!--end_md-->
		<div class="end_md common_md">
			<div class="n_wrapper relative">
				<img src="img/main/logo.png" class="logo" style="top:10px"/>
				<div class="end_bot relative">
					<img src="" width="640" height="579" style="position: absolute;top: -400px;z-index: -1;" id="endImg"/>
					<div class="whiteDiv"></div>
					<p class="t_center end_bot_1">测试结果得出你最像剧中人物：</p>
					<div class="end_resultName" id="end_resultName">
							
					</div>
					<div class="hor">
						<div id="end_resultTxt" style="width: 300px;padding: 2px;"></div>
						<div class="sureCon"><img src="img/end/sure.png" id="sureBtn"/></div>
					</div>
					<p class="t_center ued">@腾讯家居UED出品</p>
				</div>
			</div>
		</div>
		<!--end_md-->
		<!--chou_md-->
		<div class="chou_md common_md">
			<div class="n_wrapper ver relative">
				<div class="aniCon">
					<div class="n_wrapper relative">
						<div class="leftBg"></div>
						<div class="rightBg"></div>
					</div>
				</div>

				<div class="win_md">
					<div class="n_wrapper relative ver">
						<div class="win_mes">
							<p class="t_center"><img src="img/chou/0.png" width="301" height="303" id="win_Img"/></p>
							<p class="t_center"><img src="img/chou/gongxi.png"/></p>
							<p class="t_center win_txt"><?php if(!empty($mem_row) && $mem_row['prize']==4 || $mem_row['prize']==6){?>微信名：<span id="win_weinm"></span></br><?php }?>获得了<span id="win_lv">三</span>等奖，<span id="win_name">除螨机</span>一个</p>
							<p class="t_left" style="color: #FFFFFF;">温馨提示：活动结束后我们工作人员会与您取得联系，请耐心等待！</p>
						</div>
					</div>
				</div>
				<div class="lose_md">
					<div class="n_wrapper relative ver">
						<div class="lose_mes">
							<p class="t_center"><img src="img/chou/thx.png"/></p>
							<p class="t_center" style="font-size: 2rem;color: #FFFFFF;margin-top: 40px;">分享朋友圈再得<strong style="color: #ffd200;font-size: 3rem;">1</strong>次机会</p>
							<p class="t_center" style="font-size: 2rem;color: #FFFFFF;">(关注此微信号可以提高中奖率)</p>
							<p class="t_center" style="margin-top: 10px;"><img src="img/chou/shareBtn.png" id="shareBtn"/></p>
						</div>
					</div>
				</div>
				<div class="choubg relative">
					<div id="chouBtn"></div>
					<img src="img/chou/qrBtn.png" id="qrBtn"/>
				</div>
			</div>
		</div>
		<!--chou_md-->
		<!--share_md-->
		<div class="share_md common_md">
			<div class="n_wrapper relative">
				<img src="img/chou/sharetips.png"/>
			</div>
		</div>
		<!--share_md-->
		<div class="qr_md common_md">
			<div class="n_wrapper relative ver">
				<div>
					<p class="t_center"><img src="img/chou/qr.png" id="qr"/></p>
					<p class="t_center"><img src="img/chou/qrtips.png"/></p>
				</div>
			</div>
		</div>		
		
		 <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		
		<script>
			document.documentElement.style.height = window.innerHeight + 'px';
			(function() {
	
				
				$("#mainBtn").bind("touchstart",function(){
					
					if(isOne==1){
						$(".main_md").hide();
						$(".chou_md").show();
					}
					else{
						$(".qa_md").show();
					}
				});
				var user_sex, user_age, user_hun, user_earn;
					
				function setSelect(obj, type) {
					obj.bind("touchstart", function() {
						obj.each(function() {
							$(this).css("background-image", "none")
						});
						$(this).css("background-image", "url(img/qa/selected.png)");
						switch (type) {
							case "sex":
								user_sex = $(this).html();
								break;
							case "age":
								user_age = $(this).html();
								break;
							case "hun":
								user_hun = $(this).html();
								break;
							case "earn":
								user_earn = $(this).html();
								break;
							default:
								break;
						}
					});
				}
				setSelect($(".user_sex_list span"), "sex");
				setSelect($(".user_age_list span"), "age");
				setSelect($(".user_hun_list span"), "hun");
				setSelect($(".user_earn_list span"), "earn");
				$("#dengji").bind("touchstart",postInfo);
				function postInfo(){
					if(user_sex==null||user_age==null||user_hun==null||user_earn==null){
						alert("填写完成信息");
						return false;
					}
					
					$.ajax({
                    	async:false,
                        url: 'server.php',
                        data:{act:'dengji',sex:user_sex,marital:user_hun,income:user_earn,age:user_age},
                        type: "post",
                        dataType:'json',
                        success:function(result){
							$(".answerInfo").hide();
							$(".answerTiku").show();
                        }
                    });
					
					//提交以上数据
				}
			})();
			(function(){
				var tikuJson={
					"0":["如果你生活于《琅琊榜》中，最希望生活的场所是哪里？","苏宅","琅琊阁","皇宫","靖王府"],
					"1":["如果你是苏宅的主人，装修的时候你会选择什么材料？","乳胶漆","墙纸","硅藻泥","其他"],
					"2":["如果有一个机会，你最希望加入《琅琊榜》中哪一个组织？","江左盟 ","赤焰军","富贵闲人","悬镜司"],
					"3":["有新闻报道说，杭州6名油漆工车库集体晕倒，你怎么看？","空间密闭缺氧所致","过度劳累","油漆危害大","纯属意外"],
					"4":["你的房间贴墙纸的时候，你最关注的是什么？","辅料如墙纸胶等的选择","花色花型纸质的选择","施工的技术","我不贴墙纸"],
					"5":["宅子装修好后，你最希望拥有以下哪一项？","舒适宽敞的大厅","总统级无敌大床","低调奢华质量好的墙面","其他"],
					"6":["若是宅子中已经铺贴的墙纸出现了发霉等现象，您认为是什么原因？","墙纸质量不好","墙纸胶质量不好","墙纸辅料选择不当","墙体潮湿引起"],
					"7":["你觉得辅料在墙纸装修中的作用是什么？","把墙纸粘在墙上","保护墙纸","保障墙纸使用寿命","保障工程质量"],
					"8":["如果选择墙纸辅料，你会如何选择？","大品牌","价格高的","店主推荐","参考网上评论"],
					"9":["你知道的墙纸辅料品牌有多少？","都知道","知道一些","完全不知道 ","不关心"],
				};
				var resJson={
					"0":["梅长苏、林殊","作为剧中主角，梅长苏神机妙算，步步为营，神秘莫测。其意志坚定，思维灵活，成熟稳重却也不失幽默风趣。在苏宅的选择布置上，便可以知道对于房屋格局、装饰类型、材料抉择有着自己的想法，但对于一些小细节，却不愿过多地进行干涉。"],
					"1":["靖王萧景琰","水牛萧景琰，名副其实的现实主义者，常常会陷于孤僻与苦闷的境地。做选择时会参考下他人的意见建议，但对于已经认定的事项却坚持着自己的看法。恋旧是性格中的典型代表，对于房间布置，能保持原有风格的绝不多加改变。"],
					"2":["大统领蒙挚","大统领蒙挚虽然外表强悍，却将硬汉柔情、善解人意体现得酣畅淋漓。在大是大非面前，以平稳和冷静的心态面对，虽然对于一些事项表现得后知后觉，却非常愿意参考他人的看法。在装修选择上也是如此，若是自己的抉择最后得出了很好的效果，便会去家人朋友面前献宝。"],
					"3":["随性小飞流","小飞流虽然心智不全，武功却是极好，恋家是其除呆萌外的另一特性。生活情趣在剧中乃是最佳之人选，喜欢给房子装点一些花草，可见，对于装饰房间而言，更注重一些细节上的问题。"],
					"4":["琅琊阁主蔺晨","闲云一生，野鹤江湖。看似玩世不恭，却异常重情重义。不愿过多地被条条框框所拘束，却也愿意为朋友而接受束缚。于房间装饰而言，一切按照自己的喜好而定，只要不过多违背个人的脾性，一切可按照他人的意见而来。"],
					"5":["女中英豪霓凰","虽是闺阁女子，却也英姿飒爽，不让须眉。长期的军旅生涯，打造了身上的豪迈之气；贵族的出身增添了皇室的傲气与女儿的娇态。这样的个性在装修过程中的表现便是时尚却也不失享受，总体布局统一和谐，细节上处理妥帖。"],
				}
				function ranNum(min, max) {
					return Math.floor(Math.random() * (max - min + 1) + min);
				};
				var wArr=[133,132,155,260,311,309,258,258,209,181];
				var index=0;
				setTiku(0);
				var tikuArr=[];
				$("#tiku p").bind("touchstart",function(){
						index+=1;
						if(index>9){
							$(".qa_md").hide();
							$(".end_md").show();
							setResult();
							console.log($(this).find("span").html())
							tikuArr.push($(this).find("span").html());
							return false;
						}
						tikuArr.push($(this).find("span").html());
						
						setTiku(index);
				})
				
				setResult();
				var q;
				function setResult(){
					q=ranNum(0,5);
					
					$("#endImg").attr("src","img/end/"+q+".png")
					$("#end_resultName").html(resJson[q][0]);
					$("#end_resultTxt").html(resJson[q][1]);
					
					
				}
				function setTiku(n,ali){
					$("#tikuCon h1").html(tikuJson[n][0]);
					
					$("#tiku p span").each(function(e){
						$(this).html(tikuJson[n][e+1]);		
					});
					$("#tiku").css("width",wArr[index]+35);
				}
				$("#sureBtn").bind("touchstart",function(){
//				 	确认并参加抽奖
					$.ajax({
                    	async:false,
                        url: 'server.php',
                        data:{act:'mobSubmit',person:resJson[q][0],perNum:q,ans:tikuArr},
                        type: "post",
                        dataType:'json',
                        success:function(result){
							console.log(result);
							wxTitle = "我在琅琊榜中的人物：" + resJson[q][0];
							wxDesc = "嘉力丰有奖问卷调查，快来参与抽取大奖！";
							var wxImgUrl = 'http://zt.jia360.com/jlf2_h5/img/tou/' + q +'.jpg';
							var wxData = {
								"imgUrl": wxImgUrl,
								"link": wxLink,
								"desc": wxDesc,
								"title": wxTitle,
								success: function () {
									//分享成功，增加抽奖次数
									$.ajax({
										async:false,
										url: 'server.php',
										data:{act:'share'},
										type: "post",
										dataType:'json',
										success:function(result){
											alert('分享成功');
										}
									});
								}
							};
							wx.onMenuShareAppMessage(wxData);
							wx.onMenuShareTimeline(wxData);
							
							$(".end_md").hide();
							$(".chou_md").show();
                        }
                    });
				});
			})();
			(function(){
				var isTrans=true;
				$(".chou_md .aniCon").bind("webkitAnimationEnd",function(){
					$(this).hide();
				})
	
				$("#chouBtn").bind("touchstart",function(e){
					//抽奖按钮
					$.ajax({
                    	async:false,
                        url: 'server.php',
                        data:{act:'start'},
                        type: "post",
                        dataType:'json',
                        success:function(result){
							if(result.errcode == 1005){
								alert(result.errmsg);
								return false;
							}
							if(result.errcode == 1001){
								alert(result.errmsg);
								return false;
							}							
							if(result.prize == 3){
								$(".chou_md .aniCon").show();
									showWin(result.prize,result.priJso);
							}else{
								$(".chou_md .aniCon").show();
									showLose();
							}
                        }
                    });
					

					
				});
//				<!--win_lv-->
//				<!--win_name-->
//				<!--win_Img"-->
				$(".aniCon").hide();
				
				<?php 
					if(!empty($mem_row) && $mem_row['prize']==4 || $mem_row['prize']==6){//获取中奖信息 
						if($mem_row['prize']==4){
							$priMsg = array('lv'=>"三",'name'=>"除螨机",'pic'=>2);
						}
						if($mem_row['prize']==6){
							$priMsg = array('lv'=>"四",'name'=>"智能手环",'pic'=>3);
						}
				?>				
				$(".chou_md").show();
				$("#win_weinm").html("<?php echo $mem_row['nickname']?>");
				var qq={lv:"<?php echo $priMsg['lv']?>",name:"<?php echo $priMsg['name']?>"};
				showWin(<?php echo $priMsg['pic']?>,qq);
				<?php }?>
				
				function showWin(n,obj){
					$(".win_md").show();
					$("#win_lv").html(obj.lv);
					$("#win_name").html(obj.name);
					$("#win_Img").attr("src","img/chou/"+n+".png");
				}
				function showLose(){
					$(".lose_md").show();
				}
				$("#shareBtn").bind("touchstart",function(){
					$(".share_md").show();
				})
				$(".share_md").bind("touchstart",function(){
					$(this).hide();
				});
				$(".lose_md").bind("touchstart",function(){
					$(this).hide();
				});
				$(".win_md").bind("touchstart",function(){
					$(this).hide();
				});
				$("#qrBtn").bind("touchstart",function(){
					$(".qr_md").show();
				});
				$(".qr_md ").bind("touchstart",function(e){
					if(e.target.id=="qr"){
						return false;
					}
					$(this).hide();
				});				
				
			})();
			
			
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
						"imgUrl":wxImgUrl,
						"link":wxLink,
						"desc":wxDesc,
						"title":wxTitle,
						success:function(){
							//分享成功，增加抽奖次数
							$.ajax({
								async:false,
								url: 'server.php',
								data:{act:'share'},
								type: "post",
								dataType:'json',
								success:function(result){
									alert('分享成功');
								}
							});
						}
					};
					wx.onMenuShareAppMessage(wxData);
					wx.onMenuShareTimeline(wxData);
				});
		</script>
		<!--#include virtual="/public/tongji.html"-->
	</body>

</html>