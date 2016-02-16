<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>

<html>
    <head>
        <title>洁净品质 智领未来 安华卫浴新品发布会</title>
        <link rel="stylesheet" href="css/jquery.mobile-1.4.2.min.css" />
        <script src="js/jquery.js"></script>
        <script src="js/jquery.mobile-1.4.2.min.js"></script>
        <script src="js/my.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <link rel="stylesheet" href="css/layout.css?vid=2.0" />
        
    </head>

    <body>
        
        <div data-role="page" id="home" class="home">
            <div dat-role="content" class="home-content">

                <div class="jtcom">
                    <a href="#about"  data-transition="slideup">
                        <img src="images/jiantou.png" width="100%" height="100%">
                    <a>
                </div>
            </div>
            
        </div>

        
        
        <div data-role="page" id="about" class="about">
            <div dat-role="content" class="about-content">
                <div class="about-content-1">
                    <p style="text-indent:2em">2015年7月，安华卫浴携手最有态度的权威媒体，开启线上线下战略合作模式，借助大数据以及多方采样，专注消费者对卫浴产品的使用需求 ，领衔谱写“中国卫浴文化白皮书” 。</p>

                    <p style="text-indent:2em">同期，安华卫浴第十二届卫浴文化节将在全国1500多家营销服务网点重磅推出洗悦系列智能新品等卫浴配套产品，上演品质和视觉的盛宴。</p>
                </div>
                <div class="about-content-2">
                    <a href="#list" data-transition="slideup">
                        <img src="images/btn1.png" width="100%" height="100%">
                    </a>
                </div>
            </div>
            <div class="about-content-3 jtcom">
                <a href="#list" data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div>
        </div>

        <div data-role="page" id="list" class="list">
            <div dat-role="content" class="list-content">
               <div class="list-content-left">
                    <div style="height: 33%;">
                        <a href="#prd1" data-transition="slideup" >
                            <image src="images/touming.png"  width="80px" height="100px">
                        </a>
                    </div>
                     <div style="height: 33%;">
                        <a href="#prd3" data-transition="slideup" >
                            <image src="images/touming.png"  width="80px" height="100px">
                        </a>
                    </div>
                    <div style="height: 33%;">
                        <a href="#prd5" data-transition="slideup" >
                            <image src="images/touming.png"  width="80px" height="100px">
                        </a>
                    </div> 
                </div>
               <div class="list-content-right">
                    <div style="height: 40%;">
                        <a href="#prd2" data-transition="slideup" >
                            <image src="images/touming.png"  width="100%" height="100%">
                        </a>
                    </div>
                    <div style="height: 40%;">
                        <a href="#prd4" data-transition="slideup" >
                            <image src="images/touming.png"  width="100%" height="100%">
                        </a>
                    </div>
                    <div style="height: 20%;">
                        <a href="http://shop.annwa.com.cn/topic/1212m/"  >
                            <image src="images/touming.png"  width="100%" height="100%">
                        </a>
                    </div> 
                </div>
                
                
                
            </div>
            <div class="list-content-bottom jtcom">
                <a href="#prd1"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div>
        </div>

        
        
        <div data-role="page" id="prd1" class="prd">
            <div dat-role="content" class="prd-content">
                <div class="prd-content-title">
                    <img src="images/prd1-title.png" width="100%" height="100%">
                </div>

                <div class="prd-content-img">
                    <img src="images/prd1-img.png" style="z-index:-1" width="100%" height="100%">
                    <a onclick="content('侧按键')">
                        <img src="images/tubiao.png" class="tubiao" style="top:32%;left:10%">
                    </a>
                    <a onclick="content('操作提示灯')">
                        <img src="images/tubiao.png" class="tubiao" style="top:19%;left:50%">
                    </a>
                    <a onclick="content('镀铬装饰条')">
                        <img src="images/tubiao.png" class="tubiao" style="top:24%;left:35%">
                    </a>
                </div>

                <div class="prd-content-btn1">
                    <p>即热水箱&nbsp;自动冲洗<p>
                </div>

                <div class="prd-content-btn2">
                    <a onclick="jianjie('1')"><p>点击查看产品简介<p></a>
                </div>
            </div>

            <div class="prd-content-bottom jtcom">
                <a href="#prd2"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div>  
        
        </div>


        <div data-role="page" id="prd2" class="prd">
            <div dat-role="content" class="prd-content">
                <div class="prd-content-title">
                    <img src="images/prd2-title.png" width="100%" height="100%">
                </div>

                <div class="prd-content-img">
                    <img src="images/prd2-img.png" style="z-index:-1" width="100%" height="100%">
                    <a onclick="content('遥控器')">
                        <img src="images/tubiao.png" class="tubiao" style="top:54%;left:10%">
                    </a>
                    <a onclick="content('按键')">
                        <img src="images/tubiao.png" class="tubiao" style="top:30%;left:20%">
                    </a>
                    <a onclick="content('阻尼缓冲')">
                        <img src="images/tubiao.png" class="tubiao" style="top:35%;left:35%">
                    </a>
                    <a onclick="content('不锈钢喷头自洁')">
                        <img src="images/tubiao.png" class="tubiao" style="top:22%;left:38%">
                    </a>
                    
                    <a onclick="content('手动放水')">
                        <img src="images/tubiao.png" class="tubiao" style="top:38%;left:75%">
                    </a>
                </div>

                <div class="prd-content-btn1">
                    <p>高雅大方&nbsp;贵不可言<p>
                </div>

                <div class="prd-content-btn2">
                    <a onclick="jianjie('2')"><p>点击查看产品简介<p></a>
                </div>
            </div>
            <div class="prd-content-bottom jtcom">
                <a href="#prd3"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div> 
            
        </div>

        <div data-role="page" id="prd3" class="prd">
            <div dat-role="content" class="prd-content">
                <div class="prd-content-title">
                    <img src="images/prd3-title.png" width="100%" height="100%">
                </div>

                <div class="prd-content-img">
                    <img src="images/prd3-img.png" style="z-index:-1" width="100%" height="100%">
                    <a onclick="content('超厚加料五金件')">
                        <img src="images/tubiao.png" class="tubiao" style="top:22%;left:31%">
                    </a>
                    <a onclick="content('一体铸造双色拉手')">
                        <img src="images/tubiao.png" class="tubiao" style="top:42%;left:52%">
                    </a>
                    <a onclick="content('三扇8mm钢化玻璃')">
                        <img src="images/tubiao.png" class="tubiao" style="top:17%;left:56%">
                    </a>
                    
                </div>

                <div class="prd-content-btn1">
                    <p>水晶世界&nbsp;通透瑰丽<p>
                </div>

                <div class="prd-content-btn2">
                    <a onclick="jianjie('3')"><p>点击查看产品简介<p></a>
                </div>
            </div>

            <div class="prd-content-bottom jtcom">
                <a href="#prd4"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div>  
            
        </div>


        <div data-role="page" id="prd4" class="prd2">
            <div dat-role="content" class="prd-content">
                <div class="prd-content-title">
                    <img src="images/prd4-title.png" width="100%" height="100%">
                </div>

                <div class="prd-content-img">
                    <img src="images/prd4-img.png" style="z-index:-1" width="100%" height="100%">
                    <a onclick="content('不规则浴镜')">
                        <img src="images/tubiao.png" class="tubiao" style="top:22%;left:32%">
                    </a>
                    <a onclick="content('骑马抽')">
                        <img src="images/tubiao.png" class="tubiao" style="top:50%;left:36%">
                    </a>
                    
                    
                </div>

                <div class="prd-content-btn1-1">
                    <p>高端品位风尚&nbsp;感受尊贵气息<p>
                </div>

                <div class="prd-content-btn2">
                    <a onclick="jianjie('4')"><p>点击查看产品简介<p></a>
                </div>
            </div>

            <div class="prd-content-bottom jtcom">
                <a href="#prd5"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div>  
            
        </div>


        <div data-role="page" id="prd5" class="prd">
            <div dat-role="content" class="prd-content">
                <div class="prd-content-title">
                    <img src="images/prd5-title.png" width="100%" height="100%">
                </div>

                <div class="prd-content-img">
                    <img src="images/prd5-img.png" style="z-index:-1" width="100%" height="100%">
                    <a onclick="content('多功能抽屉')">
                        <img src="images/tubiao.png" class="tubiao" style="top:53%;left:36%">
                    </a>
                    <a onclick="content('半开放式镜柜')">
                        <img src="images/tubiao.png" class="tubiao" style="top:25%;left:59%">
                    </a>
                    <a onclick="content('加高柜脚')">
                        <img src="images/tubiao.png" class="tubiao" style="top:65%;left:66%">
                    </a>
                    <a onclick="content('弧形边角')">
                        <img src="images/tubiao.png" class="tubiao" style="top:20%;left:68%">
                    </a>
                    <a onclick="content('贴心设计')">
                        <img src="images/tubiao.png" class="tubiao" style="top:45%;left:76%">
                    </a>
                    
                    
                </div>

                <div class="prd-content-btn1" >
                    <p>温柔知性&nbsp;精美柔和<p>
                </div>

                <div class="prd-content-btn2">
                    <a onclick="jianjie('5')"><p>点击查看产品简介<p></a>
                </div>
            </div>

            <div class="prd-content-bottom jtcom">
                <a href="#end"  data-transition="slideup">
                    <img src="images/jiantou.png" width="100%" height="100%">
                <a>
            </div> 
            
        </div>


        <div data-role="page" id="end" class="end">
            <div class="end-code">
                <img src="images/end-code.png" width="100%" height="100%">
            </div>
            <a></a>
        </div>

            <div id="bg"></div>
         <!-- 弹出窗1 Start -->
          
          <div class="popContent" id="popContent"> 
              <div class="popclose">
                  <img src="images/tubiao2.png" width="100%" height="100%">
              </div>
              <div class="pop1">
                  
              </div>
              
              <div style="position: absolute;width: 100%;top: 67%;">
                  <div class="poptubiao">
                      <img src="images/tubiao3.png" width="100%" height="100%">
                  </div>
                  <div class="pop2">
                      
                  </div>
              </div>
              
              <div class="pop3">
                  
              </div>
          </div>
          <!-- 弹出窗1B Start -->
          <div class="popContentB" id="popContentB"> 
              <div class="popcloseB">
                  <img src="images/tubiao2.png" width="100%" height="100%">
              </div>
              <div class="pop1B">
                  
              </div>
              <div style="position: absolute;width: 100%;top: 83%;">
                  <div class="poptubiaoB">
                      <img src="images/tubiao3.png" width="100%" height="100%">
                  </div>
                  <div class="pop2B">
                      
                  </div>
              </div>
              
              <div class="pop3">
                  
              </div>
          </div>
          <!-- 弹出窗动 End -->    

           <!-- 弹出窗2 Start -->
          
          <div class="popJianjie" id="popJianjie"> 
              <div class="popJianjie1">
                 
              </div>
              <div class="popJianjie2">
                  
               </div>

              <div class="popJianjie3">
                  <img src="images/tan2-1.png" width="100%" height="100%">
              </div>
          </div>
          <!-- 弹出窗动 End -->  

          <!-- 弹出窗2B Start -->
          
          <div class="pop2Jianjie" id="pop2Jianjie"> 
              <div class="pop2Jianjie1">
                 
              </div>
              <div class="pop2Jianjie2">
                  
               </div>

              <div class="pop2Jianjie3">
                  <img src="images/tan2-1.png" width="100%" height="100%">
              </div>
          </div>
          <!-- 弹出窗动 End -->  

          <!--音乐  -->
            <div id="music">
                <a href="javascript:void(0)" class="open musicBtn" ></a>
                <audio class="audio hide"  id="musicBox" autoplay loop="true" src="images/music.mp3"  style="height:0">
                    <source src="song.ogg" type="audio/ogg" />
                    <source src="song.mp3" type="audio/mpeg" />
                </audio>
            </div>
        
            
    </body>
    <script type="text/javascript">
    function jianjie(type){
        $.popWin2(type); 
        
    }
    </script>
    <script type="text/javascript">
    function content(type){
        $.popWin(type); 
    }
    </script>
    <script type="text/javascript">
    $(function(){
        var musicBox = $("#musicBox");
        musicBox[0].play();
    });
        //音乐播放
        $("#music .musicBtn").click(function(){
            
            if($(this).hasClass("open")){
                $(this).removeClass("open").addClass("close");
                musicBox.pause();
            }else{
                $(this).removeClass("close").addClass("open");
                musicBox.play();
            }
        }); 
    </script>
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
                "imgUrl":'http://zt.jia360.com/ahwy/images/zf.jpg',
                "link":'http://zt.jia360.com/ahwy/index.php',
                "desc":"2015年7月，安华卫浴领衔谱写“中国卫浴文化白皮书",
                "title":"洁净品质 智领未来 安华卫浴新品发布会"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>


</html>
