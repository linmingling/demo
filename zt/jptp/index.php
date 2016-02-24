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

// $_SESSION['jptp_openid'] = 'abc123123';
// $_SESSION['jptp_wechaname'] = 'hehehe';
// $openId = $_SESSION['jptp_openid'];
// $wechaname = $_SESSION['jptp_wechaname'];

if(!$_POST['openid'])
{
    $openId = $_SESSION['jptp_openid'];
    $wechaname = $_SESSION['jptp_wechaname'];

    if(empty($openId))
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=jptp';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
}
else 
{
    $openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $_SESSION['jptp_openid'] = $openId;
    $_SESSION['jptp_wechaname'] = $wechaname;
}

$check_sql = "select openid,vote_time from jptp where openid='{$openId}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if(empty($check_row))
{
    $sql = "INSERT INTO jptp(add_time, add_strtotime, openid, wechaname) VALUES('".date('Y-m-d H:i:s', time())."','".time()."','".$openId."','" . $wechaname . "')";
    mysqli_query($db, $sql);
} else {
    $vote_time = strtotime(date('Y-m-d',$check_row['vote_time']));
    $new_time = strtotime(date('Y-m-d',time()));
    if($new_time - $vote_time >= 86400){
        $vote_sql = "UPDATE jptp SET is_vote=0 WHERE openid='".$_SESSION['jptp_openid']."'";
        mysqli_query($db, $vote_sql);
    }
}

$vote_sum_sql = "select sum(vote) as s from jptp";
$vote_sum_res = mysqli_query($db, $vote_sum_sql);
$vote_sum_row = $vote_sum_res->fetch_assoc();

$vote_count_sql = "select count(*) as c from jptp where type>0";
$vote_count_res = mysqli_query($db, $vote_count_sql);
$vote_count_row = $vote_count_res->fetch_assoc();

$p_sql = "select count(*) as c from jptp";
$p_res = mysqli_query($db, $p_sql);
$p_row = $p_res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金牌卫浴2015年十佳店长选拔网投</title>
	<meta name="keywords" content="金牌卫浴2015年十佳店长选拔网投">
	<meta name="description" content="金牌卫浴2015年十佳店长选拔网投">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=2.0" media="all" /> 
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
                            <img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
                        </div>
                        <div class="am am2">
                            <img src="images/page1-title.png"  class="animation an2" data-item="an2" data-delay="200" data-animation="bounceInUp"/>
                        </div>
                        <div class="am am3">
                            <img src="images/page1-1.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInLeft"/>
                        </div>
                        <div class="am am4">
                            <img src="images/page1-2.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceInLeft"/>
                        </div> 
                        <div class="am am5">
                            <img src="images/page1-3.png"  class="animation an5" data-item="an5" data-delay="800" data-animation="bounceInRight"/>
                        </div> 
                        <div class="am am6">
                            <img src="images/page1-4.png"  class="animation an6" data-item="an6" data-delay="1000" data-animation="bounceIn"/>
                        </div> 
                        <div class="am am7">
                            <img src="images/page1-5.png"  class="animation an7" data-item="an7" data-delay="1200" data-animation="bounceIn"/>
                        </div> 
                        <div class="am am8">
                            <img src="images/page1-6.png"  class="animation an8" data-item="an8" data-delay="1400" data-animation="bounceInUp"/>
                        </div> 
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                    <div class="container">
                        <div class="am am1">
                            <img src="images/all-title.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceDown"/>
                        </div>
                        <div class="am am2">
                            <div>
                                <p class="black">已报名</p>
                                <p class="red"><?php echo $vote_count_row['c'];?></p>
                            </div>
                            <div>
                                <p class="black">投票人数</p>
                                <p class="red"><?php echo $vote_sum_row['s'];?></p>
                            </div>
                            <div style="border: none;">
                                <p class="black">访问量</p>
                                <p class="red"><?php echo ($vote_count_row['c']+$vote_sum_row['s']+$p_row['c'])*3;?></p>
                            </div>
                        </div>
                        <div class="am am3">
                            <div class="page2-text">
                                <input type="text"  placeholder="请输入参赛者姓名或编号进入投票">
                            </div>
                            <div class="page2-button">搜索</div>
                        </div>
                        <div style="display:inline" id="page2-d1">
                            <div class="am am4" id="page2-tag">
                                <div style="background-color: #cc230d;color: #fff;" data='1'>
                                    十佳店长
                                </div>
                                <div data='2'>
                                    销售明星
                                </div>
                                <div data='3'>
                                    最佳辅导员
                                </div>
                            </div>
                            <div class="am am5">
                                <hr style="width:85%;color:#fff">
                            </div>
                            <div class="am am6" id="page2-tag-sj">
                                
                            </div>
                        </div>

                        <div style="display:none" id="page2-d2">
                            <div class="page2-xq">
                                <div class="page2-xq-1"><img src="" id="page2-d2-img"></div>
                                <div class="page2-xq-all">
                                    <div class="page2-xq-2">
                                        <p>姓名 <span id="page2-d2-name"></span></p>
                                        <p>编号 <span id="page2-d2-no"></span></p>
                                    </div>
                                    <div class="page2-xq-3" id="page2-d2-fan"><img src="images/fan.png"></div>
                                    <!-- <div class="page2-xq-4">
                                        <p>参赛宣言</p>
                                    </div> -->
                                    <div class="page2-xq-5">
                                    <p>参赛宣言</p>
                                        <p id="page2-d2-con"></p>
                                    </div>
                                </div>
                                <div class="page2-xq-6">
                                    <hr style="width:100%;color:#fff">
                                </div>
                                <div class="page2-sj">
                                    <div style="width: 50%;float: left;">
                                        <!-- <div class="page2-sj-bg"><img src="images/icon.png"></div> -->
                                        <div class="page2-sj-1">
                                            <p><span style="float:left;padding-left: 5%;">当前票数 </span>
                                                <span style="padding-left: 19%;color:#e72e16" id="page2-d2-ps"></span>
                                                <span style="padding-left: 2%;color:#5a5a5a">票</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div style="width: 50%;">
                                        <!-- <div class="page2-sj-bg" style="padding-left: 5%;"><img src="images/icon.png"></div>
 -->                                        <div class="page2-sj-2">
                                            <p><span style="float:left;padding-left: 5%;">当前排名 </span>
                                                <span style="padding-left: 20%;color:#e72e16" id="page2-d2-pm"></span>
                                                <span style="padding-left: 2%;color:#5a5a5a">名</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="page2-top">
                                    <p>离上一名还差 <span class="red" id="page2-d2-to"></span> 票，朋友们快帮我投票啊！</p>
                                </div>
                                <div class="page2-btn-ly">
                                    <div class="page2-btn-ly-1" id='voteFor'>为TA投票</div>
                                    <div class="page2-btn-ly-2" style="margin-left:10%" id="wybm">我要报名</div>
                                </div>
                            </div> 
                        </div>


                    </div>
                  </div>

                  <div class="swiper-slide page-3" data-animation="bounceDown">
                    <div class="container">
                        <div class="am am1">
                            <img src="images/all-title.jpg"  class="animation an1" data-item="an1" data-delay="0" />
                        </div>
                        <div class="am am2">
                            <div>
                                <p class="black">已报名</p>
                                <p class="red"><?php echo $vote_count_row['c'];?></p>
                            </div>
                            <div>
                                <p class="black">投票人数</p>
                                <p class="red"><?php echo $vote_sum_row['s'];?></p>
                            </div>
                            <div style="border: none;">
                                <p class="black">访问量</p>
                                <p class="red"><?php echo ($vote_count_row['c']+$vote_sum_row['s'])*3;?></p>
                            </div>
                        </div>
                        <div class="am am3">
                            <div class="page2-text">
                                <input type="text"  placeholder="请输入参赛者姓名或编号进入投票">
                            </div>
                            <div class="page2-button">搜索</div>
                        </div>
                        <div class="am am4" id="page3-tag">
                            <div style="background-color: #cc230d;color: #fff;" data='1'>
                                十佳店长
                            </div>
                            <div data='2'>
                                销售明星
                            </div>
                            <div data='3'>
                                最佳辅导员
                            </div>
                        </div>
                        <div class="am am5">
                            <hr style="width:85%;color:#fff">
                        </div>
                        <div class="am am6">
                            <table border="0" id="pm">

                            </table>
                        </div>
                    </div>
                  </div>

                  <div class="swiper-slide page-4" data-animation="bounceDown">
                    <div class="container">
                        <div class="am am1">
                            <img src="images/all-title.jpg"  class="animation an1" data-item="an1" data-delay="0" />
                        </div>
                        <div class="am am2">
                            <div>
                                <p class="black">已报名</p>
                                <p class="red"><?php echo $vote_count_row['c'];?></p>
                            </div>
                            <div>
                                <p class="black">投票人数</p>
                                <p class="red"><?php echo $vote_sum_row['s'];?></p>
                            </div>
                            <div style="border: none;">
                                <p class="black">访问量</p>
                                <p class="red"><?php echo ($vote_count_row['c']+$vote_sum_row['s'])*3;?></p>
                            </div>
                        </div>
                        <div class="am am3">
                            <div class="page2-text">
                                <input type="text"  placeholder="请输入参赛者姓名或编号进入投票">
                            </div>
                            <div class="page2-button">搜索</div>
                        </div>
                        <div class="am am4">
                            <div class="content">
                                <p class="fontcenter">参赛规则</p>
                                <p>1、金牌卫浴专卖店员工和总公司员工。</p>
                                <p>2、禁止刷票，刷票者取消资格，票数最高者将获得神秘大奖。</p>
                                <p>3、报名时间：09.12-9.24     投票时间：09.18-10.20</p>
                                <p>注意：一个微信号只能报名一次</p>
                                <p class="fontcenter">比赛奖金</p>
                                <p>最佳辅导员（前3名）</p>
                                <p>第一名   1500元/名</p>
                                <p>第二名   1000元/名</p>
                                <p>第三名   800元/名</p>
                                <p>全国十佳店长（前10名）</p>
                                <p>第一名   10000元</p>
                                <p>第二名   8000元</p>
                                <p>第三名   6000元</p>
                                <p>第四名   5000元</p>
                                <p>第五名   4000元</p>
                                <p>第六-第十名  3000元/人</p>
                                <p>全国销售明星（前5名）</p>
                                <p>第一~第五名  2000元/人</p>
                            </div>
                            <div class="icon">
                                <img src="images/page4-ud.png"/>
                            </div>
                        </div>
                        <div class="am am5" id="btn-bm">点击报名</div>
                    </div>
                  </div>
            </div>
        </div>
        
        <div class="navmeau">
            <nav class="active">投票首页</nav>
            <nav>参赛选手</nav>
            <nav>排行榜</nav>
            <nav>我要报名</nav>
        </div>
        
        <div class="bg">
            <p>点击空白处退出</p>
        </div>
        <div class="pop-cj">
            <div class="pop-cj-title"><p>填写资料</p></div>
            <div class="pop-cj-content">
                <div class="name"><input type="text" placeholder="姓名" id="bm-name"></div>
                <div class="chk" id="bm-sex">
                    <div style="width:46%">性别</div>
                    <div style="width:27%" class="sex bg-blue">男</div>
                    <div style="width:27%" class="sex">女</div>
                </div>
                <div class="prgcn" id="bm-type">
                    <div style="width:25%">项目选择</div>
                    <div style="width:25%" class="prg bg-blue" data='1'>十佳店长</div>
                    <div style="width:25%" class="prg" data='2'>销售明星</div>
                    <div style="width:25%" class="prg" data='3'>最佳辅导员</div>
                </div>
                <div class="shop"><input type="text" placeholder="所在门店" id="bm-shop"></div>
                <div class="imgfile">
                    <a href="javascript:;" class="a-upload">
                        <input type="file" name="fileToUpload" id="fileToUpload"><span id="filecon">上传图片...</span>
                        <input type="hidden" id="bm-img">
                    </a>
                    
                </div>
                <div class="csxy">
                    <textarea maxlength="80" placeholder="参赛宣言(40字内)" id="bm-xy"></textarea>
                </div>
            </div>
            <div class="pop-cj-btn" id="bmtj">提交报名</div>
        </div>
        <div class="pop-sc">
            <div class="pop-sc-title"><p>提示</p></div>
            <div class="pop-sc-content">
                <p>您的信息提交成功，谢谢您的参与！</p>
            </div>
            <a href="index.php"><div class="pop-sc-btn">返回首页</div></a>
        </div>

        
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
    <script src="js/ajaxfileupload.js"></script>
    <script src="js/my.js?v=2.0"></script>
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
                "imgUrl":'http://zt.jia360.com/jptp/images/fx.jpg',
                "link":'http://zt.jia360.com/jptp/index.php',
                "desc":"主动出击，服务为赢",
                "title":"金牌卫浴2015年十佳店长选拔网投"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
</body>
</html>