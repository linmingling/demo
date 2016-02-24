<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>全民家居购，一起来脱“丹”</title>
	<meta name="keywords" content="全民家居购，一起来脱“丹”">
	<meta name="description" content="全民家居购，一起来脱“丹”">
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
                                <img src="images/page1-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page1-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page1-3.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceInDown"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page1-4.png"  class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInUp"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page1-5.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInUp"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page2-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInDown"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page2-2.jpg"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page2-3.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page2-4.png"  class="animation an4" data-item="an4" data-delay="1200" data-animation="fadeInUp"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page2-5.png"  class="animation an5" data-item="an5" data-delay="2000" data-animation="fadeInUp"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page2-6.png"  class="animation an6" data-item="an6" data-delay="2600" data-animation="bounceInDown"/>
                            </div>
                            <div class="am am7">
                                <img src="images/page2-7.png"  class="animation an7" data-item="an7" data-delay="2400" data-animation="bounceInUp"/>
                            </div>
                            <div class="am am8">
                                <img src="images/page2-8.png"  class="animation an8" data-item="an8" data-delay="3000" data-animation="fadeInUp"/>
                            </div>
                      </div>
                  </div>

                   <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page3-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="fadeInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page3-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page3-3.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceL_B"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page3-4.png"  class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceL_B"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page3-5.png"  class="animation an5" data-item="an5" data-delay="1600" data-animation="bounceL_B"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page3-6.png"  class="animation an6" data-item="an6" data-delay="2000" data-animation="bounceL_B"/>
                            </div>
                            <div class="am am7">
                                <img src="images/page3-7.png"  class="animation an7" data-item="an7" data-delay="2400" data-animation="bounceL_B"/>
                            </div>
                            <div class="am am8">
                                <img src="images/page3-8.png"  class="animation an8" data-item="an8" data-delay="2800" data-animation="bounceL_B"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-4">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page4-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="fadeInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page4-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page4-3.gif"  class="animation an3" data-item="an3" data-delay="800"  data-animation="people" data-timing-function="linear" data-duration="3000"/>
                            </div>
                            <div class="am4">
                                <img src="images/page4-4.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInUp"/>
                                <div class="am dm1 animation an5" data-item="an5" data-delay="1000" data-animation="fadeInUp">
                                    <img src="images/dm1.png"/>
                                </div>
                                <div class="am dm2 animation an6" data-item="an6" data-delay="1600" data-animation="fadeInUp">
                                    <img src="images/dm2.png"/>
                                </div>
                                <div class="am dm3 animation an7" data-item="an7" data-delay="2200" data-animation="fadeInUp">
                                    <img src="images/dm3.png"/>
                                </div>
                                <div class="am dm4 animation an8" data-item="an8" data-delay="2800" data-animation="fadeInUp">
                                    <img src="images/dm4.png"/>
                                </div>
                                <div class="am dm5 animation an9" data-item="an9" data-delay="3400" data-animation="fadeInUp">
                                    <img src="images/dm5.png"/>
                                </div>
                                <div class="am dm6 animation an10" data-item="an10" data-delay="4000" data-animation="fadeInUp">
                                    <img src="images/dm6.png"/>
                                </div>
                            </div>
                            <div class="am am5">
                                <img src="images/page4-5.png"  class="animation an11" data-item="an11" data-delay="4400" data-animation="bounceInDown"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page4-6.png"  class="animation an12" data-item="an12" data-delay="1200" data-animation="bounceInUp"/>
                            </div>
                            <div class="am am7">
                                
                            </div>
                            
                      </div>
                  </div>

                  <div class="swiper-slide page-5">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page5-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="fadeInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page5-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight"/>
                            </div>
                            <div class="am3 animation an3"data-item="an3" data-delay="800" data-animation="fadeIn">
                                <img src="images/page5-3.png"  />
                                <div class="am am4">
                                    <img src="images/hour.png"  class="animation hour h" data-item="h" data-delay="0" data-animation="hchange" data-timing-function="linear" data-iteration-count="infinite" data-duration="20000"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/minute.png"  class="animation minute m" data-item="m" data-delay="0" data-animation="hchange" data-timing-function="linear" data-iteration-count="infinite" data-duration="5000"/>
                                </div>
                                <div class="am am6">
                                    <img src="images/icon-2.png"  />
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-6">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page6-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="fadeInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page6-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page6-4.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="fadeIn"/>
                            </div>  
                            <div class="am am4 animation an4"  data-item="an4" data-delay="1200" data-animation="fadeIn">
                                <img src="images/page6-5.png"  />
                                <div class="flag" style="top: 18%;right: 10%;"><img src="images/flag.png" class="animation n1" data-item="n1" data-delay="1400" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 30%;right: 10%;"><img src="images/flag.png"  class="animation n2" data-item="n2" data-delay="1450" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 35%;right: 17%;"><img src="images/flag.png"  class="animation n3" data-item="n3" data-delay="1500" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 39%;right: 26%;"><img src="images/flag.png"  class="animation n4" data-item="n4" data-delay="1550" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 48%;right: 25%;"><img src="images/flag.png"  class="animation n5" data-item="n5" data-delay="1600" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 49%;right: 34%;"><img src="images/flag.png"  class="animation n6" data-item="n6" data-delay="1650" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 54%;right: 48%;"><img src="images/flag.png"  class="animation n7" data-item="n7" data-delay="1700" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 53%;right: 38%;"><img src="images/flag.png"  class="animation n8" data-item="n8" data-delay="1750" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 52%;right: 60%;"><img src="images/flag.png"  class="animation n9" data-item="n9" data-delay="1800" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 60%;right: 22%;"><img src="images/flag.png"  class="animation n10" data-item="n10" data-delay="1850" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 62%;right: 26%;"><img src="images/flag.png"  class="animation n11" data-item="n11" data-delay="1900" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 64%;right: 33%;"><img src="images/flag.png"  class="animation n12" data-item="n12" data-delay="1950" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 65%;right: 50%;"><img src="images/flag.png"  class="animation n13" data-item="n13" data-delay="2000" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 68%;right: 20%;"><img src="images/flag.png"  class="animation n14" data-item="n14" data-delay="2050" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 72%;right: 28%;"><img src="images/flag.png"  class="animation n15" data-item="n15" data-delay="2100" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 72%;right: 35%;"><img src="images/flag.png"  class="animation n16" data-item="n16" data-delay="2150" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 74%;right: 42%;"><img src="images/flag.png"  class="animation n17" data-item="n17" data-delay="2200" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 75%;right: 24%;"><img src="images/flag.png"  class="animation n18" data-item="n18" data-delay="2250" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 82%;right: 40%;"><img src="images/flag.png"  class="animation n19" data-item="n19" data-delay="2300" data-animation="fadeIn" data-iteration-count="5"/></div>
                                <div class="flag" style="top: 65%;right: 70%;"><img src="images/flag.png"  class="animation n20" data-item="n20" data-delay="2350" data-animation="fadeIn" data-iteration-count="5"/></div>
                            </div> 
                            
                            
                      </div>
                  </div>

                  <div class="swiper-slide page-7">
                      <div class="container">
                            <div class="am am1" id="dbcity">
                                <a><div class="cityly">北京</div></a>
                                <a><div class="cityly">上海</div></a>
                                <a><div class="cityly">天津</div></a>
                                <a><div class="cityly">成都</div></a>
                                <a><div class="cityly">石家庄</div></a>
                                <a><div class="cityly">哈尔滨</div></a>
                                <a><div class="cityly">南京</div></a>
                                <a><div class="cityly">济南</div></a>
                                <a><div class="cityly">太原</div></a>
                                <a><div class="cityly">邯郸</div></a>
                                <a><div class="cityly">潍坊</div></a>
                                <a><div class="cityly">青岛</div></a>
                                <a><div class="cityly">菏泽</div></a>
                                <a><div class="cityly">沧州</div></a>
                                <a><div class="cityly">唐山</div></a>
                                <a><div class="cityly">德州</div></a>
                                <a><div class="cityly">邢台</div></a>
                                <a><div class="cityly">聊城</div></a>
                                <a><div class="cityly">齐齐哈尔</div></a>
                                <a><div class="cityly">泰安</div></a>
                                <a><div class="cityly">常州</div></a>
                                <a><div class="cityly">廊坊</div></a>
                                <a><div class="cityly">衡水</div></a>
                                <a><div class="cityly">无锡</div></a>
                                <a><div class="cityly">滨州</div></a>
                                <a><div class="cityly">承德</div></a>
                                <a><div class="cityly">秦皇岛</div></a>
                                <a><div class="cityly">保定</div></a>
                                <a><div class="cityly">淄博</div></a>
                                <a><div class="cityly">张家口</div></a>
                                <!-- <a><div class="cityly">烟台</div></a> -->
                                <!-- <a><div class="cityly">黄山</div></a> -->
                                <a><div class="cityly">佳木斯</div></a>
                                <a><div class="cityly">南充</div></a>
                                <a><div class="cityly">雅安</div></a>
                                <a><div class="cityly">阳泉</div></a>
                                <a><div class="cityly">朔州</div></a>
                                <a><div class="cityly">晋城</div></a>
                                <a><div class="cityly">离石</div></a>
                                <a><div class="cityly">东营</div></a>
                                <a><div class="cityly">绥化</div></a>
                                <a><div class="cityly">临汾</div></a>
                                <a><div class="cityly">忻州</div></a>
                                <div class="am2">*请点击您所选择的城市</div>
                            </div>
                            
                      </div>
                  </div>

                  <div class="swiper-slide page-8">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page7-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page7-2.png"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page7-3.png"  class="animation an3" data-item="an3" data-delay="800" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page7-4.png"  class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page7-5.png"  class="animation an5" data-item="an5" data-delay="1600" data-animation="bounceIn"/>
                            </div>
                            <div class="am am6">
                                 <img src="images/qrcode.jpg"  class="animation an6" data-item="an6" data-delay="1600" data-animation="bounceIn"/>
                            </div>
                            <div class="am am7">
                                 <img src="images/page7-6.png"  class="animation an7" data-item="an7" data-delay="2200" data-animation="bounceInUp"/>
                            </div>
                            <a href="http://mp.weixin.qq.com/s?__biz=MzAwODcxOTczNg==&mid=400003936&idx=1&sn=e242a0226e70de95bf854359bad5f786&scene=20#rd">
                            <div class="am am8">
                                 <img src="images/page7-7.png"  class="animation an8" data-item="an8" data-delay="1600" data-animation="bounceIn"/>
                            </div>
                            </a>
                            
                      </div>
                  </div>

            </div>
            <div class="next">
                <img src="images/next.png"/>
            </div>
            <!--音乐  -->
            <div id="music">
                <a href="javascript:void(0)" class="open musicBtn" ></a>
                <audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
            </div>

        </div>
        
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
                "imgUrl":'http://zt.jia360.com/qmjj/images/fx.jpg',
                "link":'http://zt.jia360.com/qmjj/index.php',
                "desc":"11.7-8 全民家居购，一起来脱“丹”",
                "title":"全民家居购，一起来脱“丹”"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
    
</body>
</html>
