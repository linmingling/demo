<?php
    require_once "../data/jssdk.php";
    require_once "server.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    
    if(!$_POST['openid']){
        $openId = $_SESSION['yyys_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=com_share';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['yyys_openid'] = $_POST['openid'];
        $_SESSION['yyys_wechaname'] = base64_decode($_POST['wechaname']);
    }
    
//     $_SESSION['yyys_openid'] = '1111111';
//     $_SESSION['yyys_wechaname'] = '222222';
    $sql = "SELECT sn,is_pay from order_list WHERE openid='".$_SESSION['yyys_openid']."'";
    $res = mysqli_query($db, $sql);
    $arr = array();
    while($row = $res->fetch_array()){
        $arr = $row;
    }
    $sn = empty($arr['sn']) ? 0 :$arr['sn'];
    $is_pay = empty($arr['is_pay']) ? 0 : $arr['is_pay'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>家装陷阱终结者！</title>
	<meta name="keywords" content="家装陷阱终结者！">
	<meta name="description" content="家装陷阱终结者！">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.3" media="all" /> 
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
                  <div class="swiper-slide page-1">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page1-1.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page1-2.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page1-3.png"  class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page1-4.png?vid=1.0"  class="animation an5" data-item="an5" data-delay="1600" data-animation="bounceIn"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page1-5.png"  class="animation an6" data-item="an6" data-delay="2000" data-animation="bounceIn"/>
                            </div>
                            
                        
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1">
                                    <img src="images/page2-1.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="cn2">
                                    <img src="images/page2-2.png?vid=1.0"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"/>
                                </div>
                                <div class="cn3">
                                    <img src="images/page2-3.png"  class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                </div>
                                
                            </div>
                            <div class="am am3">
                                <img src="images/page2-4.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page2-5.png"  class="animation an6" data-item="an6" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                            
                        
                      </div>
                  </div>

                  <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1 animation an6"  data-item="an6" data-delay="0" data-animation="bounceIn">
                                    <p>从毛胚到精装 一手包办</p>
                                    <hr style="width:100%;color:#000">
                                </div>
                                <div class="cn2 animation an2" data-item="an2" data-delay="200" data-animation="bounceIn">
                                    <p>大自然家居化身家装陷阱的终结者，秉持“健康、环保、智能”的信念，为全人类实现美好家居生活而不懈奋斗。</p>
                                </div>
                                <div class="cn3 animation an3" data-item="an3" data-delay="400" data-animation="bounceIn">
                                    <p>从设计，到选材，到施工，到验收入住，大自然DFC整装一站搞定。</p>
                                </div>
                                <div class="cn4">
                                    <img src="images/page3-1.png"  class="animation an5" data-item="an5" data-delay="800" data-animation="bounceIn"/>
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-4">
                      <div class="container">
                        <div class="am am1">
                            <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                        </div>
                        <div class="am am2 animation an10" data-item="an10" data-delay="400" data-animation="bounceIn">
                            <div class="cn1">
                                <p>699/㎡ 性价比王牌</p>
                            </div>
                            <div class="cn2">
                                <p>环保主材，从源头控制环保</p>
                                <p>工厂直供，榨干价格水分</p>
                                <p>汇集大牌名品</p>
                            </div>
                            <div class="cn3">
                                <img src="images/prd-logo1.png"  class="animation an2" data-item="an2" data-delay="600" data-animation="bounceIn"/>
                                <img src="images/prd-logo2.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"/ style="padding-left: 2%;">
                                <img src="images/prd-logo3.png?vid=1.0"  class="animation an4" data-item="an4" data-delay="1000" data-animation="bounceIn"/ style="padding-left: 2%;">
                                <img src="images/prd-logo4.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceIn"/>
                                <img src="images/prd-logo5.png"  class="animation an6" data-item="an6" data-delay="1400" data-animation="bounceIn"/ style="padding-left: 2%;">
                                <img src="images/prd-logo6.png"  class="animation an7" data-item="an7" data-delay="1600" data-animation="bounceIn"/ style="padding-left: 2%;">
                                 
                            </div>
                            <div class="cn4 animation an9" data-item="an9" data-delay="1800" data-animation="bounceInLeft">
                                <p>包设计·包主材·包施工</p>
                                <!-- <hr style="width:100%;color:#000"> -->
                            </div>
                            <div class="cn5">
                               <img src="images/page4-1.png?vid=1.0"  class="animation an8" data-item="an8" data-delay="2000" data-animation="bounceInRight"/>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-5">
                      <div class="container">
                        <div class="am am1">
                            <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                        </div>
                        <div class="am am2">
                            <div class="cn1">
                                <p>699/㎡客厅效果图</p>
                            </div>
                            <div class="cn2">
                                <div style="margin: 3%;">
                                    <img src="images/page5-1.jpg?vid=1.0"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                                </div>
                            </div>
                            <div class="cn3">
                                <p>地板：大自然强化地板</p>
                                <p>天花：楚楚铝合金扣板吊顶</p>
                                <p>墙面：立邦漆</p>
                                <p>插座：西门子品宜系列</p>
                            </div>
                            <div class="cn4">
                                <p>具体配置清单请浏览</p>
                            </div>
                            <div class="cn5">
                               <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-6">
                      <div class="container">
                        <div class="am am1">
                            <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                        </div>
                        <div class="am am2">
                            <div class="cn1">
                                <p>699/㎡厨房效果图</p>
                            </div>
                            <div class="cn2">
                                <div style="margin: 3%;height: 54%;position: absolute;width: 60%;">
                                    <img src="images/page6-1.jpg"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn" height="100%"/>
                                    <div class="pz" id="pz1-close">
                                        <p style="padding: 1% 0;">查看配置▲</p>
                                    </div>
                                    <div class="pz-z" style="display:none" id="pz1-open">
                                        <p style="text-align: center;padding-top:1%">配置</p>
                                        <p>橱柜：大自然柯拉尼橱柜</p>
                                        <p>地面：东鹏陶瓷</p>
                                        <p>墙面：东鹏陶瓷</p>
                                        <p>油烟机：美的油烟机</p>
                                        <p>灶台：美的灶台</p>
                                        <p>水槽+龙头：摩恩水槽+龙头</p>
                                        <p style="text-align: center;bottom: 0;position: absolute;width: 100%;" >收起▼</p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="cn4">
                                <p>具体配置清单请浏览</p>
                            </div>
                            <div class="cn5">
                               <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                            </div> 
                        </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-7">
                      <div class="container">
                        <div class="am am1">
                            <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                        </div>
                        <div class="am am2">
                            <div class="cn1">
                                <p>699/㎡卫生间效果图</p>
                            </div>
                            <div class="cn2">
                                <div style="margin: 3%;height: 54%;position: absolute;width: 60%;">
                                    <img src="images/page7-1.jpg"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn" height="100%"/>
                                    <div class="pz" id="pz2-close">
                                        <p style="padding: 1% 0;">查看配置▲</p>
                                    </div>
                                    <div class="pz-z" style="display:none" id="pz2-open">
                                        <p style="text-align: center;padding-top:1%">配置</p>
                                        <p>墙面：东鹏陶瓷</p>
                                        <p>地面：东鹏陶瓷</p>
                                        <p>浴霸：楚楚浴霸</p>
                                        <p>洗手盆+龙头：TOTO洗手盆+龙头+淋浴花洒</p>
                                        <p>座便器：TOTO坐便器</p>
                                        <p style="text-align: center;bottom: 0;position: absolute;width: 100%;" >收起▼</p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="cn4">
                                <p>具体配置清单请浏览</p>
                            </div>
                            <div class="cn5">
                               <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                            </div> 
                        </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-8">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2 animation an10" data-item="an10" data-delay="400" data-animation="bounceIn">
                                <div class="cn1">
                                    <p>999/㎡整装套餐 主材个性可选</p>
                                </div>
                                <div class="cn2">
                                    <p>设计大师戴昆设计地板</p>
                                    <p>主材多项颜色及款式可选</p>
                                    <p>口碑品牌，打造质感生活</p>
                                </div>
                                <div class="cn3">
                                    <img src="images/prd-logo1.png"  class="animation an2" data-item="an2" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/prd-logo2.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"/ style="padding-left: 2%;">
                                    <img src="images/prd-logo3.png?vid=1.0"  class="animation an4" data-item="an4" data-delay="1000" data-animation="bounceIn"/ style="padding-left: 2%;">
                                    <img src="images/prd-logo4.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/prd-logo5.png"  class="animation an6" data-item="an6" data-delay="1400" data-animation="bounceIn"/ style="padding-left: 2%;">
                                    <img src="images/prd-logo6.png"  class="animation an7" data-item="an7" data-delay="1600" data-animation="bounceIn"/ style="padding-left: 2%;">
                                     
                                </div>
                                <div class="cn4 animation an9" data-item="an9" data-delay="1800" data-animation="bounceInLeft">
                                    <p>包设计·包主材·包施工</p>
                                    <!-- <hr style="width:100%;color:#000"> -->
                                </div>
                                <div class="cn5">
                                   <img src="images/page8-1.png?vid=1.1"  class="animation an8" data-item="an8" data-delay="2000" data-animation="bounceInRight"/>
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-9">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1">
                                    <p>999/㎡客厅效果图</p>
                                </div>
                                <div class="cn2">
                                    <div style="margin: 3%;">
                                        <img src="images/page9-1.jpg?vid=1.0"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                                    </div>
                                </div>
                                <div class="cn3">
                                    <p>地板：戴昆•设计系列大自然实木复合地板</p>
                                    <p>墙面：壁高墙纸</p>
                                    <p>天花：楚楚铝合金扣板吊顶</p>
                                    <p>插座：西门子远景系列</p>
                                </div>
                                <div class="cn4">
                                    <p>具体配置清单请浏览</p>
                                </div>
                                <div class="cn5">
                                   <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-10">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1">
                                    <p>999/㎡厨房效果图</p>
                                </div>
                                <div class="cn2">
                                    <div style="margin: 3%;height: 54%;position: absolute;width: 60%;">
                                        <img src="images/page10-1.jpg"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn" height="100%"/>
                                        <div class="pz" id="pz3-close">
                                            <p style="padding: 1% 0;">查看配置▲</p>
                                        </div>
                                        <div class="pz-z" style="display:none" id="pz3-open">
                                            <p style="text-align: center;padding-top:1%">配置</p>
                                            <p>地面：东鹏陶瓷</p>
                                            <p>墙面：东鹏陶瓷</p>
                                            <p>橱柜：大自然柯拉尼橱柜</p>
                                            <p>油烟机：方太油烟机</p>
                                            <p>灶台：方太灶台</p>
                                            <p>水槽+龙头：摩恩水槽+龙头</p>
                                            <p style="text-align: center;bottom: 0;position: absolute;width: 100%;" >收起▼</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="cn4">
                                    <p>具体配置清单请浏览</p>
                                </div>
                                <div class="cn5">
                                   <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                                </div> 
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-11">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1">
                                    <p>999/㎡卫生间效果图</p>
                                </div>
                                <div class="cn2">
                                    <div style="margin: 3%;">
                                        <img src="images/page11-1.jpg"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                                    </div>
                                </div>
                                <div class="cn3">
                                    <p>地面：东鹏陶瓷</p>
                                    <p>墙面：东鹏陶瓷</p>
                                    <p>浴霸：楚楚浴霸</p>
                                    <p>洗手盆+龙头：TOTO洗手盆+龙头+淋浴花洒</p>
                                    <p>座便器：TOTO坐便器</p>
                                </div>
                                <div class="cn4">
                                    <p>具体配置清单请浏览</p>
                                </div>
                                <div class="cn5">
                                   <a href="https://dzrdykj.m.tmall.com/?spm=a2322.7757432.1092310.56.zimDOy&shop_id=111975858"><img src="images/btn.png"  class="animation an8" data-item="an8" data-delay="0" data-animation="bounceIn"/></a>
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="swiper-slide page-12">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/logo.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am2">
                                <div class="cn1">
                                    <p>首批开放预售城市</p>
                                    <p style="font-size: 14px;">广州、杭州、佛山、昆明、北京</p>
                                    <hr style="width:100%;color:#000">
                                </div>
                                <div class="cn2">
                                    <img src="images/page12-1.png?vid=1.1"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                                </div>
                                <div class="cn3">
                                    <img src="images/qrcode.png"  class="animation an3" data-item="an3" data-delay="0" data-animation="bounceIn"/>
                                </div>
                                <div class="cn4">
                                    <p>点击关注大自然微信</p>
                                </div>
                                
                            </div>
                      </div>
                  </div>
            </div>
        </div>
        <?php if($sn && $is_pay){ ?>
            <div class="btm-buy">您的申购码是：<?php echo $sn?></div>
        <?php } else { ?>
        <a href="buy.php">
            <div class="btm-buy">点击申购</div>
        </a>
        <?php } s?>
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
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
                "imgUrl":'http://zt.jia360.com/yyys_m/images/fx.png',
                "link":'http://zt.jia360.com/yyys_m/index.php',
                "desc":"新品1元预售限量抢，1元包养设计师，1元抵999元，1元尊享见面礼。限量500名，立即报名！",
                "title":"家装陷阱终结者！"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
</body>
</html>
