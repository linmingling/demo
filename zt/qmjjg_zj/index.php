<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>全民家居购首站开门红</title>
	<meta name="keywords" content="全民家居购首站开门红">
	<meta name="description" content="全民家居购首站开门红">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.1" media="all" /> 
  <link type="text/css" rel="stylesheet" href="css/animate.css?vid=1.0" media="all" /> 
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
                  <div class="swiper-slide page-1 new1">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page1-1.png" class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page1-2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page1-3.png" class="animation an3" data-item="an3" data-delay="800" data-animation="bounceInDown"/>
                                </div>
                                <div class="am am4">
                                    <img src="images/page1-4.png"  class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInUp"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/page1-5.png" class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInUp"/>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-2 new2">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page2-1.png?vid=1.2" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="am3">
                                    <img src="images/page2-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="an an1"><img src="images/page2-2-1.png" class="animation aq4" data-item="aq4" data-delay="1200" data-animation="fadeIn"/></div>
                                    <div class="an an2"><img src="images/page2-2-2.png" class="animation aq5" data-item="aq5" data-delay="1600" data-animation="fadeIn"/></div>
                                    <div class="an an3"><img src="images/page2-2-3.png" class="animation aq6" data-item="aq6" data-delay="2000" data-animation="fadeIn"/></div>
                                    <div class="an an4"><img src="images/page2-2-4.png" class="animation aq7" data-item="aq7" data-delay="1600" data-animation="fadeIn"/></div>
                                    <div class="an an5"><img src="images/page2-2-5.png" class="animation aq8" data-item="aq8" data-delay="1200" data-animation="fadeIn"/></div>
                                    <div class="am am4">
                                        <img src="images/page2-3.png?vid=1.2" class="animation aq10" data-item="aq10" data-delay="2400" data-animation="bounceInDown"/>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <!-- <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page3-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="am3">
                                    <img src="images/page3-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="an an1"><img src="images/money.png" class="animation aq4" data-item="aq4" data-delay="1200" data-animation="fadeIn"/></div>
                                    <div class="an an2"><img src="images/money.png" class="animation aq5" data-item="aq5" data-delay="1400" data-animation="fadeIn"/></div>
                                    <div class="an an3"><img src="images/money.png" class="animation aq6" data-item="aq6" data-delay="1600" data-animation="fadeIn"/></div>
                                    <div class="an an4"><img src="images/money.png" class="animation aq7" data-item="aq7" data-delay="1800" data-animation="fadeIn"/></div>
                                    <div class="an an5"><img src="images/money.png" class="animation aq8" data-item="aq8" data-delay="2000" data-animation="fadeIn"/></div>
                                    <div class="am am4">
                                        <img src="images/page3-3.png" class="animation aq10" data-item="aq10" data-delay="2400" data-animation="bounceInDown"/>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div> -->

                  <div class="swiper-slide page-4 new3">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page4-1.png?vid=1.1" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="am3">
                                    <img src="images/page4-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="an an1"><img src="images/money2.png" class="animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn"/></div>
                                    <div class="an an2"><img src="images/money2.png" class="animation aq5" data-item="aq5" data-delay="1800" data-animation="fadeIn"/></div>
                                    <div class="am am4">
                                        <img src="images/page4-3.png?vid=1.1" class="animation aq10" data-item="aq10" data-delay="2200" data-animation="bounceInDown"/>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-5 new4">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page5-1.png?vid=1.0" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="am3">
                                    <img src="images/page5-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="an an1"><img src="images/page5-2-1.png" class="animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn"/></div>
                                    <div class="am am4">
                                        <img src="images/page5-3.png" class="animation aq10" data-item="aq10" data-delay="1800" data-animation="bounceInDown"/>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-6 new5">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page6-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceIn"/>
                                </div>
                                <div class="am3">
                                    <img src="images/page6-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="an an1"><img src="images/page6-2-1.png" class="animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn"/></div>
                                    <div class="am am4">
                                        <img src="images/page6-3.png" class="animation aq10" data-item="aq10" data-delay="1800" data-animation="bounceInDown"/>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-7 new6">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page7-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="flipInY"/>
                                </div>
                                <div class="am3">
                                    <img src="images/quan.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="img-bg an1 animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page7-img1.jpg" width="100%" /></div>
                                    </div>
                                    <div class="img-bg an2 animation aq5" data-item="aq5" data-delay="1800" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page7-img2.png" width="100%" /></div>
                                    </div>
                                    <div class="img-bg an3 animation aq6" data-item="aq6" data-delay="2200" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page7-img3.png" width="100%" /></div>
                                    </div>
                                </div>
                                <div class="am am4">
                                    <div class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B">
                                        <p><span class="font-left">21天</span><span class="font-right">的辛苦奔波</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B">
                                        <p><span class="font-left">9000人</span><span class="font-right">的执行团队</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B">
                                        <p><span class="font-left">924家</span><span class="font-right">经销商配合</span></p>
                                    </div>
                                    <!-- <div class="an1"><img src="images/page7-2.png" width="100%" class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B"/></div>
                                    <div class="an2"><img src="images/page7-3.png" width="100%" class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B"/></div>
                                    <div class="an3"><img src="images/page7-4.png" width="100%" class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B"/></div> -->
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-8 new7">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page8-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="flipInY"/>
                                </div>
                                <div class="am3">
                                    <img src="images/quan.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="img-bg an1 animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page8-img1.jpg" width="100%"/></div>
                                    </div>
                                    <div class="img-bg an2 animation aq5" data-item="aq5" data-delay="1800" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page8-img2.png" width="100%"/></div>
                                    </div>
                                    <div class="img-bg an3 animation aq6" data-item="aq6" data-delay="2200" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page8-img3.png" width="100%"/></div>
                                    </div>
                                </div>
                                <div class="am am4">
                                    <div class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B">
                                        <p><span class="font-left">500场次</span><span class="font-right">的会议</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B">
                                        <p><span class="font-left">8万次</span><span class="font-right">的电话沟通协调</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B">
                                        <p><span class="font-left">人均每天12小时</span><span class="font-right">的工作</span></p>
                                    </div>
                                    <!-- <div class="an1"><img src="images/page8-2.png" width="100%" class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B"/></div>
                                    <div class="an2"><img src="images/page8-3.png" width="100%" class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B"/></div>
                                    <div class="an3"><img src="images/page8-4.png" width="100%" class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B"/></div> -->
                                </div>

                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-9 new8">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page9-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="flipInY"/>
                                </div>
                                <div class="am3">
                                    <img src="images/quan.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="zoomIn"/>
                                    <div class="img-bg an1 animation aq4" data-item="aq4" data-delay="1400" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page9-img1.jpg" width="100%"/></div>
                                    </div>
                                    <div class="img-bg an2 animation aq5" data-item="aq5" data-delay="1800" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page9-img2.jpg" width="100%"/></div>
                                    </div>
                                    <div class="img-bg an3 animation aq6" data-item="aq6" data-delay="2200" data-animation="fadeIn">
                                        <div class="img-bg-ly"><img src="images/page9-img3.jpg" width="100%"/></div>
                                    </div>
                                </div>
                                <div class="am am4">
                                    <div class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B">
                                        <p><span class="font-left">43个</span><span class="font-right">区域联盟诚意付出</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B">
                                        <p><span class="font-left">全体人员的</span><span class="font-right">全心投入</span></p>
                                        <img src="images/icon.png" />
                                    </div>
                                    <div class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B">
                                        <p><span class="font-left">消费者的</span><span class="font-right">信任与支持</span></p>
                                    </div>
                                    <!-- <div class="an1"><img src="images/page9-2.png" width="100%" class="animation aq7" data-item="aq7" data-delay="2400" data-animation="bounceR_B"/></div>
                                    <div class="an2"><img src="images/page9-3.png" width="100%" class="animation aq8" data-item="aq8" data-delay="2800" data-animation="bounceR_B"/></div>
                                    <div class="an3"><img src="images/page9-4.png" width="100%" class="animation aq9" data-item="aq9" data-delay="3200" data-animation="bounceR_B"/></div> -->
                                </div>

                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-10 new9">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/logo.png?vid=1.0" class="animation aq1" data-item="aq1" data-delay="0" data-animation="flipInY"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page10-1.png" class="animation aq2" data-item="aq2" data-delay="400" data-animation="bounceInDown"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page10-2.png" class="animation aq3" data-item="aq3" data-delay="800" data-animation="bounceInDown"/>
                                </div>
                                <div class="am4 animation aq4" data-item="aq4" data-delay="1400" data-animation="zoomIn">
                                    <img src="images/page10-3.png" />
                                    <div class="an qrcode"><img src="images/qrcode.jpg" /></div>
                                </div>
                                <div class="am am5">
                                    <img src="images/page1-1.png" class="animation aq5" data-item="aq5" data-delay="1800" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am6">
                                    <img src="images/page1-2.png" class="animation aq6" data-item="aq6" data-delay="2200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am7">
                                    <img src="images/page10-4.png" class="animation aq7" data-item="aq7" data-delay="2600" data-animation="bounceInUp"/>
                                </div>
                            </div>
                      </div>
                  </div>

                  

                  
            </div>
        </div>
        
        <div class="next">
            <a href="javascript:void(0);" title="NEXT" id="next">
                <img src="images/next.png" />
            </a>
        </div>
        <!--音乐  -->
        <div id="music">
            <a href="javascript:void(0)" class="open musicBtn" ></a>
            <audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
        </div>
        

        
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
    <script src="js/my.js?v=1.0"></script>
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
                "imgUrl":'http://zt.jia360.com/qmjjg_zj/images/fx.jpg',
                "link":'http://zt.jia360.com/qmjjg_zj/index.php',
                "desc":"全民家居购11.7-8，那些你不知道的事",
                "title":"全民家居购首站开门红"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
   
    
</body>
    
</html>
