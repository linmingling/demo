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
    
//    $_SESSION['jlf_openid'] = '123456';
//    $_SESSION['jlf_wechaname'] = 'hehe';
//    $_SESSION['jlf_headurl'] = 'baidu.com';
    
    
    if(!$_POST['openid'])
//    if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['jlf_openid'];
    	$wechaname = $_SESSION['jlf_wechaname'];
    	$headurl = $_SESSION['jlf_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=jlf';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['jlf_openid'] = $openId;
    	$_SESSION['jlf_wechaname'] = $wechaname;
    	$_SESSION['jlf_headurl'] = $headurl;
    }
    
    //是否第一次进入
    $jlf_weixin = 'jlf_weixin_info';
    $mem_sql = "select * from $jlf_weixin where openid='{$openId}'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //第一次进入
    {
    	$sql = "insert into $jlf_weixin (openid,nickname,add_time) values ('{$openId}','{$wechaname}','" . date('Y-m-d H:i:s') . "')";
    	mysqli_query($db, $sql);
    }

    //是否已填资料
    $check_sql = "select * from $jlf_weixin where openid='{$openId}' and sex is not null";
    $check_res = mysqli_query($db, $check_sql);
    $check_row = $check_res->fetch_assoc();

    //滚屏
    $prize_sql = "select * from $jlf_weixin where prize>0 limit 10";
    $prize_res = mysqli_query($db,$prize_sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>嘉力丰 测测你的个性装修类型</title>
	<meta name="keywords" content="嘉力丰 测测你的个性装修类型">
	<meta name="description" content="嘉力丰 测测你的个性装修类型">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css" media="all" /> 
    <link type="text/css" rel="stylesheet" href="css/animate.css" media="all" /> 
</head>
<body>
    <div class="cn-spinner" id="loading" style=" opacity: 1;">
        <div class="spinner">
            <div class="spinner-container container1">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container2">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container3">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
        </div>

    </div>

       <div class="swiper-container swiper-pages" id="swiper-container1">
            <div class="swiper-wrapper" id="wrapper">
                  <div class="swiper-slide page-1" >
                      <div class="container ">
                            
                      </div>
                  </div>
                  <?php if(empty($check_row)){?>
                  <div class="swiper-slide page-2 stop" >
                      <div class="container ">
                            <div class="am am1">
                                请先填写以下资料
                            </div> 
                            <div class="am am2">
                                <div class="zl" style="margin: 17% auto 0;">
                                    <p class="cu">性别 ：</p>
                                    <p>男</p><p class="ad zf"><input type="radio" value="男" name="sex"></p>
                                    <p>女</p><p class="ad zf"><input type="radio" value="女" name="sex"></p>
                                </div>
                                <div class="zl" style="margin: 5% auto 0;">
                                    <p class="cu">婚否 ：</p>
                                    <p>是</p><p class="ad zf"><input type="radio" value="是" name="marry"></p>
                                    <p>否</p><p class="ad zf"><input type="radio" value="否" name="marry"></p>
                                </div>
                                <div class="zl2" style="margin: 8% auto 0;">
                                    <div class="cu" style="text-align:center">收入状况 ：</div>
                                    <div>1500-2999<p class="ad zf fr"><input type="radio" value="1500-2999" name="come"></p></div>
                                    <div>3000-6000<p class="ad zf fr"><input type="radio" value="3000-6000" name="come"></p></div>
                                    <div>6000以上<p class="ad zf fr"><input type="radio" value="6000以上" name="come"></p></div>
                                </div>
                                <div class="zl3" id="btn-cs">开始测试</div>
                            </div> 
                            <div class="am am3 hide" id="btn-tg"><!-- 已经通过测试的，把hide样式去掉 -->
                                您已测试过，可以点击这里直接抽奖
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-3 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q1-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、上下班高峰期挤地铁公交</p>
                                <p>B、工资低</p>
                                <p>C、回南天潮湿发霉的墙壁</p>
                                <p>D、至今单身狗</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-4 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q2-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、墙纸</p>
                                <p>B、乳胶漆</p>
                                <p>C、硅藻泥</p>
                                <p>D、其他</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-5 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q3-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、专人接送上下班</p>
                                <p>B、涨工资</p>
                                <p>C、一套装修精致的单身公寓</p>
                                <p>D、其他</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-6 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q4-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、低调奢华质量好的墙面</p>
                                <p>B、总统级无敌大床</p>
                                <p>C、舒适宽敞的大厅</p>
                                <p>D、其他</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-7 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q5-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、雍容华贵艳丽系</p>
                                <p>B、简洁大方淡色系</p>
                                <p>C、时尚高端个性系</p>
                                <p>D、3D立体创新系</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-8 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q6-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、主料</p>
                                <p>B、辅料</p>
                                <p>C、施工</p>
                                <p>D、其他<span style="padding-left:5px"><input type="text" id="qs-6-oth" class="myinput" /></span></p>
                                <div class="fl" style="margin-left:60px;font-size:12px">（填写意见处）</div>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-9 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q7-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、墙基膜</p>
                                <p>B、墙纸胶</p>
                                <p>C、墙面漆</p>
                                <p>D、施工</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-10 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q8-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、保障工程质量</p>
                                <p>B、保护墙纸</p>
                                <p>C、保障墙纸使用寿命</p>
                                <p>D、把墙纸粘在墙上</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-11 q-bg" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q9-title.png" />
                            </div> 
                            <div class="am q-answer">
                                <p>A、大品牌</p>
                                <p>B、价格高的</p>
                                <p>C、店主推荐</p>
                                <p>D、参考网上评论</p>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-12 q-bg stop" >
                      <div class="container ">
                            <div class="am q-title">
                                <img src="images/q10-title.png" />
                            </div> 
                            <div class="am q-answer" id="btn-end">
                                <p>A、都知道</p>
                                <p>B、知道一些</p>
                                <p>C、完全不知道</p>
                                <p>D、不关心</p>
                            </div>
                            <div class="am am1" id="btntj">
                                <img src="images/tj-btn.gif" />
                            </div>
                      </div>
                      
                  </div>

                  <?php } ?>
                  <div class="swiper-slide page-13 stop" >
                      <div class="container ">
                            <div class="am am1">
                                <img src="images/page13-1.png" />
                            </div> 
                            <div class="am2">
                                <img src="images/zp.png" />
                                <div class="am am3" id="zd"><img src="images/zp-d.png" /></div>
                                <!-- <div class="am am7" id="popfx"><img src="images/pop-fx.png" /></div> -->
                            </div>
                            <div class="am am4">
                                <p>中奖名单</p>
                                <div class="zp-md-bg" id="cn-run">
                                    <ul id="ul-run">
                                        <?php
                                            while($prize_row = $prize_res->fetch_assoc())
                                            {
                                                echo "<li><span>" . mb_substr($prize_row['phone'],0,3) . '****' . mb_substr($prize_row['phone'],-4) . "</span><span class='pl30'>获得奖品：" . $prize_row['prize_name'] . "</span></li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="am am5"><img src="images/page13-5.png" id="popgz" /></div>
                            <div class="am am6"><img src="images/page13-6.png" id="popyd" /></div>
                      </div>
                  </div>
                  


            </div>
            <div class="next">
                <img src="images/next.gif"/>
            </div>
            <div class="bg"></div>
            <div class="pop-bg">
                <div class="pop-ly" id="pop">
                    <div class="pop-title cu">
                        
                    </div>
                    <div class="pop-con">
                        
                    </div>
                </div>
                <div class="pop-close am" id="pop-close">
                    <img src="images/icon-close.png" />
                </div>
                <div class="pop-btn"><p>确定</p></div>
            </div>
            <!-- 二维码 -->
            <div class="pop-qrcode">
                <img src="images/qrcode.jpg" />
                <p>点击空白处返回</p>
            </div>

            <!-- 活动规则 -->
            <div class="pop-gz">
                <img src="images/gz.png" />
                <p>点击空白处返回</p>
            </div>

            <!-- 分享给好友 -->
            <div class="pop-yd">
                <img src="images/yindao.png" />
            </div>

            
            <div class="pop2-bg" id="pop2">
                <div class="pop2-ly" >
                    <div class="pop2-title cu">
                        
                    </div>
                    <div class="pop2-con hide">
                        <p>姓名：<input type="text" id="name" class="myinput2"></p>
                        <p>手机：<input type="text" id="mobile" class="myinput2"></p>
                        <p>收货地址：<input type="text" id="address" class="myinput2"></p>
                        <p style="font-size:9px;text-align:right">（请填写您的正确信息，以便我们能及时联系您）</p>
                    </div>
                    <div class="pop2-con2 hide">（分享到朋友圈可以再得1次机会）</div>
                </div>
                <div class="pop2-close am" id="pop2-close">
                    <img src="images/icon-close.png" />
                </div>
                <div class="pop2-btn"><p></p></div>
            </div>
            

        </div>
        
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
    <script type="text/javascript" src="js/MSClass.js"></script>
    <script type="text/javascript" src="js/awardRotate.js"></script>
    <script src="js/my.js?v=1.3"></script>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
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
                "imgUrl":'http://zt.jia360.com/jlf_h5/images/fx.jpg',
                "link":'http://zt.jia360.com/jlf_h5/index.php',
                "desc":'嘉力丰 快来测测你的个性装修类型，我不会告诉你还能赢大奖哦~',
                "title":'嘉力丰 测测你的个性装修类型',
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
 
</body>
</html>
