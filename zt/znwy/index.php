<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
    echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

//$_SESSION['znwy_openid'] = 'abc123123';
//$_SESSION['znwy_wechaname'] = 'hehehe';

if(!$_POST['openid'])
{
    $openId = $_SESSION['znwy_openid'];
    $wechaname = $_SESSION['znwy_wechaname'];
    $headimgurl = $_SESSION['znwy_headimgurl'];

    if(empty($openId))
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=zt_znwy';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
}
else 
{
    $openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $headimgurl = urldecode($_POST['headimgurl']);
    $_SESSION['znwy_openid'] = $openId;
    $_SESSION['znwy_wechaname'] = $wechaname;
    $_SESSION['znwy_headimgurl'] = $headimgurl;
}


$check_sql = "select openid from znwy where openid='{$openId}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if(empty($check_row))
{
    $sql = "INSERT INTO znwy(add_time, add_strtotime,last_time, openid,wechaname,headurl) VALUES('".date('Y-m-d H:i:s', time())."','".time()."','".time()."','".$openId."','" . $wechaname . "','{$headimgurl}')";
    mysqli_query($db, $sql);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>智能卫浴节</title>
	<meta name="keywords" content="智能卫浴节">
	<meta name="description" content="智能卫浴节">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.5" media="all" /> 
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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

        <div class="message-tan" id="messageid">
            <div class="message-tan-bg">
                <div class="message-tilte">
                    <p>填写资料</p>
                </div>
                <div class="message-con">
                    <div><input type="text" placeholder="姓名" id="name"/></div>
                    <div><input type="text" placeholder="联系手机" id="phone"/></div>
                    <div><input type="text" placeholder="联系地址" id="address"/></div>
                </div>
                <div class="message-btn">
                    <img src="images/btn5.png" width="50%" onclick="zh(this)">
                </div>
            </div>
        </div>

       <div class="swiper-container swiper-pages" id="swiper-container1">
            <div class="swiper-wrapper" id="wrapper">

                  <div class="swiper-slide page-1">
                      <div class="container">
                            <div class="ps ps1">
                                <img src="images/logo.png"  />
                            </div>
                            <div class="ps ps2">
                                <img src="images/ps1-bg.png"  />
                                <div class="ps ps2-1">
                                    <img src="images/ps1-title.png"  />
                                </div>
                                <div class="ps ps2-2">
                                    <img src="images/lan1.png"  />
                                    <div>
                                        <p>活动时间:08/17-08/30</p>
                                    </div>
                                </div> 
                            </div>
                            <div class="next">
                                <img src="images/flag.png"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                      <div class="container">
                            <div class="ps ps1">
                                <img src="images/logo.png"  />
                            </div>
                            <div class="ps ps2">
                                <img src="images/ps2-bg.png"  />
                            </div>
                            <div class="next">
                                <img src="images/flag.png"/>
                            </div>
                      </div>                
                  </div>
                  <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="ps ps1">
                                <div class="ps1-1">
                                    <img src="images/ps3-s.png"  />
                                </div>
                                <div class="ps1-3">
                                    <img src="images/ps3-t1.jpg">
                                    <div class="t1-sign1">
                                        <a onclick="producttag('1')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                    <div class="t1-sign2">
                                        <a onclick="producttag('2')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                    <div class="t1-sign3">
                                        <a onclick="producttag('3')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                </div>
                                <div class="ps1-4">
                                    <img src="images/ps3-t2.jpg">
                                    <div class="t2-sign1">
                                        <a onclick="producttag('5')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                    <div class="t2-sign2">
                                        <a onclick="producttag('6')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                    <div class="t2-sign3">
                                        <a onclick="producttag('4')"><img src="images/jia.png" class="myfalg"></a>
                                    </div>
                                </div>
                                <div class="ps1-5">
                                    <img src="images/ps3-e.png"  />
                                </div>
                            </div>
                            
                            
                      </div>                
                  </div>

                  <div class="swiper-slide page-4">
                      <div class="container">
                            <div class="ps ps1">
                                <img src="images/lan2.png"  />
                            </div>
                            <div class="ps ps2">
                                <img src="images/zp.png?vid=1.0"  />
                                <div class="ps2-1" id="zd">
                                    <img src="images/zhen.png"  />
                                </div>
                            </div>
                            <div class="ps ps3">
                                <img src="images/btn.png"  id="zp"/>
                            </div>
                            <div class="ps ps4">
                                <div class="bt" id="my1" style="border-top-left-radius: 10px;">
                                    <a onclick="qie(this)">活动规则</a> 
                                </div>
                                <div class="bt" id="my2" style="border-top-right-radius: 10px;background-color:#e1e1e1">
                                    <a onclick="qie(this)">奖品展示</a>
                                </div>
                                <div class="gz">
                                    <div id="jpgz">
                                        <div class="mysj"><p>抽奖时间：8月15日-8月28日</p></div>
                                        <p>1、抽奖规则：分享箭牌卫浴体验微信给好友即可再获得1次抽奖机会，<font style="color:red">每天最多可抽奖3次；</font></p>
                                        <p>2、请您务必填写真实信息，以便中奖后我们与您联系；</p>
                                        <p>3、在法律允许范围内，本活动最终解释权归深圳市亚太传媒网络技术开发有限公司所有</p>
                                    </div>
                                    <div id="jpzs" style="display:none">
                                        <div class="jp">
                                            <img src="images/jp1.png" width="100%" zdy="jp1"/>
                                        </div>
                                        <div class="left">
                                            <a onclick="jpqh('left')"><img src="images/left.png"  /></a>
                                        </div>
                                        <div class="right">
                                            <a onclick="jpqh('right')"><img src="images/right.png"  /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>                
                  </div>
            </div>
        </div>
        <div class="bg"></div>
        <div class="fxbg"></div>
        <div class="tan">
            <div class="tan-img">
                <img src="images/fx-tu.png" width="100%" id="fximg">
            </div>
            <div class="tan-con">
                <p>你的次数已经用完了哦，您还可以</p>
                <img src="images/fx-btn.png" width="15%" >
                给好友增加1次抽奖机会哦!
            </div>
        </div>
        

        <div class="product-tan" id="tanprd">
            <div class="product-tan-bg">
                <div class="product-tilte">
                    
                </div>
                <div class="product-con">
                    
                </div>
                <div class="product-btn">
                    
                </div>
            </div>
        </div>
        <div class="product-tan" id="tanprd2">
            <div class="product-tan-bg">
                <div class="product-tilte">
                    
                </div>
                <div class="product-con">
                    
                </div>
                <!-- <div class="product-count">
                
                </div> -->
                <div class="product-btn">
                    
                </div>
            </div>
        </div>
        <div class="prd-tag" id="tag">
            <div class="prd-tag-pic">
                <img  width="100%">
            </div>
            <div class="prd-tag-title">
                
            </div>
            <div class="prd-tag-icon">
                <img src="images/heng.png" width="100%">
            </div>
            <div class="prd-tag-ud">
                <div class="prd-tag-con">
                    
                </div>
                <div class="prd-tag-type">
                    
                </div>
            </div>
            <div class="prd-tag-close">
                <img src="images/close.png" width="100%">
            </div>
            <!-- <div class="prd-tag-up">
                <img src="images/up.png" width="100%">
            </div>
            <div class="prd-tag-down">
                <img src="images/down.png" width="100%">
            </div> -->
        </div>
    <input type="hidden" id="count">
    <input type="hidden" id="zdxz">
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
    <script src="js/awardRotate.js"></script>
    <script src="js/my.js?v=1.5"></script>
    
</body>
    
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
                "imgUrl":'http://zt.jia360.com/znwy/images/fx.jpg',
                "link":'http://zt.jia360.com/znwy/index.php',
                "desc":"邂逅箭牌 让智能走近你的生活",
                "title":"箭牌家 智能＋",
                success:function(result){
                    $.ajax({
                        async:false,
                        url: 'server.php',
                        data:{act:'addtimes'},
                        type: "post",
                        dataType:'json',
                        success:function(result){
                            //数据返回后执行
                            //alert('分享成功！');
                            $('.fxbg').fadeOut();
                        }
                    });
                }
                
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>

</html>
