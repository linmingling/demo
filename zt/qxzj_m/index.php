<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>第二届七夕家装节</title>
	<meta name="keywords" content="第二届七夕家装节">
	<meta name="description" content="第二届七夕家装节">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.1" media="all" /> 
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

                            <div class="wraper">
                            
                                <div class="am am1">
                                    <img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page1-1.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page1-2.png" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInRight"/>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page2-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page2-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page2-6.png"  class="animation an6" data-item="an6" data-delay="400" data-animation="bounceInRight"/>
                                    <!-- <div>
                                        <span style="margin-top: 10%;">——</span><span class="fontbold" id='num1' ></span><span class="fontbold">万</span><span style="margin-top: 10%;">——</span>
                                    </div> -->
                                </div>
                                <div class="am am4">
                                    <img src="images/page2-3.png"  class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/page2-4.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am6">
                                    <img src="images/page2-7.png"  class="animation an7" data-item="an7" data-delay="1000" data-animation="bounceInRight"/>
                                    <!-- <div>
                                        <span style="margin-top: 10%;">——</span><span class="fontbold" id='num2' ></span><span class="fontbold">亿</span><span style="margin-top: 10%;">——</span>
                                    </div> -->
                                </div>
                                <div class="am am7">
                                    <img src="images/page2-5.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceIn"/>
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page3-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInUp"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page3-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInUp"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page3-3.png" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am4">
                                    
                                    <!-- 数字!数字!数字! -->
                                    <div style="width: 100%;height: 100%;position: relative;">
                                    <img src="images/page3-4.png" class="animation an20" data-item="an20" data-delay="500" data-animation="fadeIn"/>
                                        <div class="num n1 animation an4" data-item="an4" data-delay="500" data-animation="fadeIn" data-iteration-count="5">哈尔滨</div>
                                        <div class="num n2 animation an5" data-item="an5" data-delay="550" data-animation="fadeIn"  data-iteration-count="5">北京</div>
                                        <div class="num n3 animation an6" data-item="an6" data-delay="600" data-animation="fadeIn" data-iteration-count="5">天津</div>
                                        <div class="num n4 animation an7" data-item="an7" data-delay="650" data-animation="fadeIn" data-iteration-count="5">太原</div>
                                        <div class="num n5 animation an8" data-item="an8" data-delay="700" data-animation="fadeIn" data-iteration-count="5">济南</div>
                                        <div class="num n6  animation an9" data-item="an9" data-delay="750" data-animation="fadeIn" data-iteration-count="5">青岛</div> 
                                        <div class="num n7 animation an10" data-item="an10" data-delay="800" data-animation="fadeIn" data-iteration-count="5">西安</div>
                                        <div class="num n8 animation an11" data-item="an11" data-delay="850" data-animation="fadeIn" data-iteration-count="5">南京</div>
                                        <div class="num n9 animation an12" data-item="an12" data-delay="900" data-animation="fadeIn" data-iteration-count="5">武汉</div> 
                                        <div class="num n10 animation an13" data-item="an13" data-delay="950" data-animation="fadeIn" data-iteration-count="5">杭州</div> 
                                        <div class="num n11 animation an14" data-item="an14" data-delay="1000" data-animation="fadeIn" data-iteration-count="5">南昌</div> 
                                        <div class="num n12 animation an15" data-item="an15" data-delay="760" data-animation="fadeIn" data-iteration-count="5">长沙</div>
                                        <div class="num n13 animation an16" data-item="an16" data-delay="780" data-animation="fadeIn" data-iteration-count="5">贵阳</div>
                                        <div class="num n14 animation an17" data-item="an17" data-delay="440" data-animation="fadeIn" data-iteration-count="5">昆明</div>
                                        <div class="num n15 animation an18" data-item="an18" data-delay="480" data-animation="fadeIn" data-iteration-count="5">厦门</div>
                                        <div class="num n16 animation an19" data-item="an19" data-delay="620" data-animation="fadeIn" data-iteration-count="5">东莞</div>

                                    </div>
                                    
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-4">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page4-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page4-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page4-3.png" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am4">
                                    <img src="images/page4-4.png" class="animation an4" data-item="an4" data-delay="600" data-animation="bounceInDown"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/page4-5.png" class="animation an5" data-item="an5" data-delay="800" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am6" id="page4_yc">
                                    <div>
                                        <img src="images/logo/1.jpg"  class="animation an6" data-item="an6" data-delay="0" data-animation="bounceIn"/>
                                        <img src="images/logo/2.jpg"  class="animation an7" data-item="an7" data-delay="2400" data-animation="bounceIn"/>
                                        <img src="images/logo/3.jpg"  class="animation an8" data-item="an8" data-delay="800" data-animation="bounceIn"/>
                                        <img src="images/logo/4.jpg"  class="animation an9" data-item="an9" data-delay="2200" data-animation="bounceIn"/>
                                        <img src="images/logo/5.jpg"  class="animation an10" data-item="an10" data-delay="2000" data-animation="bounceIn"/>
                                        <img src="images/logo/6.jpg"  class="animation an11" data-item="an11" data-delay="1600" data-animation="bounceIn"/>
                                        <img src="images/logo/7.jpg"  class="animation an12" data-item="an12" data-delay="400" data-animation="bounceIn"/>
                                        <img src="images/logo/8.jpg"  class="animation an13" data-item="an13" data-delay="2600" data-animation="bounceIn"/>
                                        <img src="images/logo/9.jpg"  class="animation an14" data-item="an14" data-delay="1600" data-animation="bounceIn"/>
                                        <img src="images/logo/10.jpg"  class="animation an15" data-item="an15" data-delay="800" data-animation="bounceIn"/>
                                        <img src="images/logo/11.jpg"  class="animation an16" data-item="an16" data-delay="2800" data-animation="bounceIn"/>
                                        <img src="images/logo/12.jpg"  class="animation an17" data-item="an17" data-delay="1200" data-animation="bounceIn"/>
                                        <!-- <img src="images/logo/13.jpg"  class="animation an18" data-item="an18" data-delay="0" data-animation="bounceIn"/> -->
                                        <img src="images/logo/14.jpg"  class="animation an19" data-item="an19" data-delay="1400" data-animation="bounceIn"/>
                                        <img src="images/logo/15.jpg"  class="animation an20" data-item="an20" data-delay="2000" data-animation="bounceIn"/>
                                        <img src="images/logo/16.jpg"  class="animation an21" data-item="an21" data-delay="2400" data-animation="bounceIn"/>
                                        <img src="images/logo/17.jpg"  class="animation an22" data-item="an22" data-delay="1200" data-animation="bounceIn"/>
                                        <img src="images/logo/18.jpg"  class="animation an23" data-item="an23" data-delay="400" data-animation="bounceIn"/>
                                        <img src="images/logo/19.jpg"  class="animation an24" data-item="an24" data-delay="2200" data-animation="bounceIn"/>
                                        <img src="images/logo/20.jpg"  class="animation an25" data-item="an25" data-delay="1200" data-animation="bounceIn"/>
                                        <img src="images/logo/21.jpg"  class="animation an26" data-item="an26" data-delay="1800" data-animation="bounceIn"/>
                                        <img src="images/logo/22.jpg"  class="animation an27" data-item="an27" data-delay="1600" data-animation="bounceIn"/>
                                        <div>&nbsp;</div>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-5">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page5-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page5-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page5-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page5-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page5-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                    <img src="images/page5-3-4.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page5-3-5.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <div >
                                        <span style="color:#ffea00;font-size:24px"  id='num3' ></span>天的辛苦奔波
                                    </div>
                                    <div >
                                        <span style="color:#ffea00;font-size:24px" id='num4' ></span>人执行团队
                                    </div>
                                    <div >
                                        <span style="color:#ffea00;font-size:24px" id='num5' ></span>家经销商配合
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-6">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page6-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page6-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page6-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page6-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page6-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                    <img src="images/page6-3-4.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page6-3-5.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <div >
                                        <span style="color:#ffea00;font-size:24px"  id='num6' ></span>场次的会议
                                    </div>
                                    <div >
                                        <span style="color:#ffea00;font-size:24px" id='num7' ></span>万次的电话沟通协调
                                    </div>
                                    <div >
                                        人均每天<span style="color:#ffea00;font-size:24px" id='num8' ></span>小时的工作
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-7">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page7-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page7-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page7-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page7-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page7-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <div>
                                        利用大数据覆盖精准家装人群
                                    </div>
                                    <div>
                                        线上报名人数超<span style="color:#ffea00;font-size:24px" id='num9' ></span>万人
                                    </div>
                                    <div>
                                        占报名总人数<span style="color:#ffea00;font-size:24px" id='num10' ></span>
                                        <span style="color:#ffea00;font-size:24px">%</span>
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-8">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page8-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page8-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page8-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page8-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page8-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                    <img src="images/page8-3-4.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page8-3-5.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <div >
                                        线上线下活动总曝光量超
                                    </div>
                                    <div style="margin-top: -2%;color: #ffea00;font-size: 36px;padding-left: 10%;">
                                        <span style="font-size:40px;font-weight: 700;" id='num11' ></span>亿！
                                    </div>
                                    
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-9">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page9-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page9-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page9-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page9-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page9-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                    <img src="images/page9-3-4.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page9-3-5.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <!-- <div >
                                        蓄客<span style="color:#ffea00;font-size:28px;font-weight: 700;" id='num12' ></span>人
                                    </div> -->
                                    <div >
                                        到场<span style="color:#ffea00;font-size:30px;font-weight: 700;" id='num13' ></span>人
                                    </div>
                                    <div >
                                        成交额破<span style="color:#ffea00;font-size:30px;font-weight: 700;" id='num14' ></span>亿！
                                    </div>
                                    
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-10">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page10-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page10-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInRight"/>
                                </div>
                                <div class="am am3">
                                    <img src="images/page10-3-1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page10-3-2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
                                    <img src="images/page10-3-3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="bounceIn"/>
                                </div>
                                <div class="am am4">
                                    <img src="images/page10-4.png"  class="animation an6" data-item="an6" data-delay="2000" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/page10-5.png"  class="animation an7" data-item="an7" data-delay="2600" data-animation="bounceInLeft"/>
                                </div>
                                <div class="am am6">
                                    <img src="images/page10-6.png"  class="animation an8" data-item="an8" data-delay="3200" data-animation="bounceInLeft"/>
                                </div>
                          </div>
                      </div>
                  </div>


                  <div class="swiper-slide page-11">
                      <div class="container">
                            <div class="wraper">
                                <div class="am am1">
                                    <img src="images/page11-1.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                                </div>
                                <div class="am am2">
                                    <img src="images/page11-2.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
                                </div>
                                <!-- <div class="am am6">
                                    <img src="images/page11-6.png"  class="animation an13" data-item="an13" data-delay="200" data-animation="bounceIn"/>
                                </div> -->
                                <div class="am am3">
                                    <img src="images/logo-txjj.jpg"  class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/logo-yj.jpg"  class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>

                                    <!-- <img src="images/page11-3-xxtg.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
                                    <img src="images/page11-3-jjfh.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="bounceIn"/>
                                    <img src="images/page11-3-hlw.png" class="animation an5" data-item="an5" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page11-3-ppyx.png" class="animation an6" data-item="an6" data-delay="3000" data-animation="bounceIn"/>
                                    <img src="images/page11-3-ppyingxiang.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="bounceIn"/>
                                    <img src="images/page11-3-jjfh2.png" class="animation an8" data-item="an8" data-delay="3000" data-animation="bounceIn"/>
                                    <img src="images/page11-3-dsj.png" class="animation an9" data-item="an9" data-delay="2200" data-animation="bounceIn"/>
                                    <img src="images/page11-3-hlw2.png" class="animation an10" data-item="an10" data-delay="600" data-animation="bounceIn"/> -->
                                </div>
                                <div class="am am4">
                                    <img src="images/page11-4.png"  class="animation an11" data-item="an11" data-delay="1800" data-animation="bounceInUp"/>
                                </div>
                                <div class="am am5">
                                    <img src="images/page11-5.png"  class="animation an12" data-item="an12" data-delay="2200" data-animation="bounceInUp"/>
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
                "imgUrl":'http://zt.jia360.com/qxzj_m/images/fx.jpg',
                "link":'http://zt.jia360.com/qxzj_m/index.php',
                "desc":"第二届七夕家装节，19亿是怎么炼成的？",
                "title":"第二届七夕家装节"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
   
    
</body>
    
</html>
