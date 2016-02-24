<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    $id = empty($_GET['id']) ? 0 : $_GET['id'];
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
    
    <div class="buy">
      
        <div class="am am1">
            <img src="images/logo.jpg" />
        </div>
        <div class="am am2">
            <div class="cn1">
                <p>填写资料</p>
                <hr style="width:100%;color:#000">
            </div>
            <div class="cn2">
                <div class="zl-title">姓名</div>
                <div class="zl-content"><input type="text" id="name"></div>
            </div>
            <div class="cn3">
                <div class="zl-title">联系电话</div>
                <div class="zl-content"><input type="text" id="phone"></div>
            </div>
            <div class="cn4">
                <div class="zl-title">所在城市</div>
                <div class="zl-content">
                    <select id="address">
                      <option value ="广州市">广州市</option>
                      <option value ="杭州市">杭州市</option>
                      <option value="佛山市">佛山市</option>
                      <option value="昆明市">昆明市</option>
                      <option value="昆明市">北京市</option>
                    </select>
                </div>
                <div class="zl-icon"><img src="images/icon.png" /></div>
            </div>
            <div class="cn5">
                <div class="zl-title">套餐选择</div>
                <div class="zl-content">
                    <select id="goods_name">
                      <option value ="699套餐(全屋装修)">699套餐(全屋装修)</option>
                      <option value ="999套餐(全屋装修)">999套餐(全屋装修)</option>
                    </select>
                </div>
                <div class="zl-icon"><img src="images/icon.png" /></div>

                <!-- <div class="zl-content"><input type="text" value="999套餐(客厅+餐厅)" id="goods_name" readonly></div> -->
            </div>
            <div class="cn6" id="btn">
                <p>提交信息</p>
            </div>
        </div>
    </div>
    <!-- <a>
        <div class="btm-buy">
            点击申购
        </div>
    </a> -->
       
        
    <div class="bg">
        <p>点击空白处到首页</p>
    </div>

    <div class="pop-sc">
        <div class="pop-sc-title"><p>提示</p></div>
        <div class="pop-sc-content">
            <p>恭喜您成功1元预购大自然家居999套餐。请牢记并妥善保管。</p>
            <p style="text-align: center">您的申购码<span class="red">00000000</span></p>
            <p>大自然家居DFC工作人员会15个工作日内联系您，届时请出示您的申购码。如有问题，可联系大自然家居客服：0757-22392121。</p>
        </div>
        <a href="index.php"><div class="pop-sc-btn">确定</div></a>
    </div>
        
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script type="text/javascript">
    <?php if($id){?>
        $.ajax({
            async:true,
            url:'server.php',
            data:{act:'find'},
            type: 'post',
            dataType:'json',
            success:function(result){
            	if(!result.errcode && result.pay){
                	$('.red').html(result.sn);
            		$('.bg').fadeIn();
                    $('.pop-sc').fadeIn();
            	} else if(result.errcode) {
                    alert(result.errmsg);
            	}
            }
        });
    <?php }?>
    $("#btn").bind('click',function(e){
            var name=$("#name").val();
            if(!name){
               alert("请填写姓名！"); return;
            }
            var phone=$("#phone").val();
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
            if(!mob.test(phone)){
            	alert("请填入正确的手机号码！"); return;
            }
            var address=$("#address").val();
            if(!address){
                alert("请选择城市！"); return;
            }
            var goods_name=$("#goods_name").val();
            $.ajax({
                async:true,
                url:'server.php',
                data:{act:'submit', name:name, phone:phone, address:address, goods_name:goods_name},
                type: 'post',
                dataType:'json',
                success:function(result){
                	if(!result.errcode){
                		window.location.href="http://zt.jia360.com/public/payment/pay.php?id="+result.id;
                	} else {
                        alert(result.errmsg);
                	}
                }
            });
    })
    $('.bg').click(function(){ 
        // $('.bg').fadeOut();
        // $('.pop-sc').fadeOut();
        window.location.href="index.php"
    })
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