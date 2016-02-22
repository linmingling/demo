<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require_once "../../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

//奖品数量
$gift_sql = "select * from game_claw_prize";
$gift_res = mysqli_query($db,$gift_sql);
while($gift_row = $gift_res->fetch_assoc())
{
	$gift_rows[] = $gift_row;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="front-end technicist" content="jinger"/>
    <title>全民家居购 天天有礼</title>
    <meta name="keywords" content="全民家居购">
    <meta name="description" content="全民家居购">
    <meta name="front-end technicist" content="jinger">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>
    <script type="text/javascript" src="libs/jquery-2.1.js"></script>
    <link type="text/css" rel="stylesheet" href="css/layout.css" media="all"/>

</head>

<body class="prd-by">
<div class="prd-bg">

    <div class="prd-bj">
        <div class="prd-pic">
            <div class="prd-end">
                <div class="prd-end-con">已送完</div>
            </div>
            <div class="prd-die">
                <div class="prd-die-l"><p>60000 积分/个</p></div>
                <div class="prd-die-m"><p>|</p></div>
                <div class="prd-die-r" zdy="100M流量包" data="5"><p class="B-J-font">兑换</p></div>
            </div>
            <img src="images/prd21.jpg" width="100%">
        </div>
        <div class="prd-con">
            <div class="prd-con-left">
                <p>剩余</p>

                <p><span class="B-font"><?php echo $gift_rows[4]['quantity'];?></span>对</p>
            </div>
            <div class="prd-con-middle">
                <div>
                    <table class="shuxian">
                        <tr>
                            <td valign="top"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="prd-con-right">
                <p>100M流量包</p>

            </div>
        </div>
    </div>

    <div class="prd-bj">
        <div class="prd-pic">
            <div class="prd-end">
                <div class="prd-end-con">已送完</div>
            </div>
            <div class="prd-die">
                <div class="prd-die-l"><p>70000 积分/个</p></div>
                <div class="prd-die-m"><p>|</p></div>
                <div class="prd-die-r" zdy="150M流量包" data="6"><p class="B-J-font">兑换</p></div>
            </div>
            <img src="images/prd22.jpg" width="100%">
        </div>
        <div class="prd-con">
            <div class="prd-con-left">
                <p>剩余</p>

                <p><span class="B-font"><?php echo $gift_rows[5]['quantity'];?></span>个</p>
            </div>
            <div class="prd-con-middle">
                <div>
                    <table class="shuxian">
                        <tr>
                            <td valign="top"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="prd-con-right">
                <p>150M流量包</p>
            </div>
        </div>
    </div>


    <div class="prd-bj">
        <div class="prd-pic">
            <div class="prd-end">
                <div class="prd-end-con">已送完</div>
            </div>
            <div class="prd-die">
                <div class="prd-die-l"><p>80000 积分/个</p></div>
                <div class="prd-die-m"><p>|</p></div>
                <div class="prd-die-r" zdy="500M流量包" data="7"><p class="B-J-font">兑换</p></div>
            </div>
            <img src="images/prd23.jpg" width="100%">
        </div>
        <div class="prd-con">
            <div class="prd-con-left">
                <p>剩余</p>

                <p><span class="B-font"><?php echo $gift_rows[6]['quantity'];?></span>个</p>
            </div>
            <div class="prd-con-middle">
                <div>
                    <table class="shuxian">
                        <tr>
                            <td valign="top"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="prd-con-right">
                <p>500M流量包</p>
            </div>
        </div>

    </div>

    <div class="prd-bj">
        <div class="prd-pic">
            <div class="prd-end">
                <div class="prd-end-con">已送完</div>
            </div>
            <div class="prd-die">
                <div class="prd-die-l"><p>110000 积分/个</p></div>
                <div class="prd-die-m"><p>|</p></div>
                <div class="prd-die-r" zdy="1G流量包" data="8"><p class="B-J-font">兑换</p></div>
            </div>
            <img src="images/prd24.jpg" width="100%">
        </div>
        <div class="prd-con">
            <div class="prd-con-left">
                <p>剩余</p>

                <p><span class="B-font"><?php echo $gift_rows[7]['quantity'];?></span>个</p>
            </div>
            <div class="prd-con-middle">
                <div>
                    <table class="shuxian">
                        <tr>
                            <td valign="top"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="prd-con-right">
                <p>1G流量包</p>
            </div>
        </div>
    </div>


    <br/>
    <br/>

    <div class="producnt-bg">
        <div><p>点击空白处返回</p></div>
    </div>
    <div class="product-tan">
        <div class="product-tan-bg">
            <div class="product-tilte"><p></p></div>
            <div class="product-con">
                <div><input type="text" placeholder="姓名"  id="name"/></div>
                <div><input type="text" placeholder="手机号码"  id="phone"/></div>
                <div><input type="text" placeholder="收货地址" id="address" /></div>
            </div>
            <div>
                <input type="button" value="提交" class="product-btn" id="tj"/>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(function(){
	 		var prd=$('.prd-bj');
	 		prd.each(function(index){
	 			if($(this).find('.prd-con-left span').text()=='0')
	 			{
	 				$(this).find('.prd-end').css('display','block');
	 			}
	 		})

	 	});
	 	var _gg=$(".product-tan");
        	var _bg = $(".producnt-bg");

        	var prizeId;
		$(".prd-die-r").click(function(){
 			
        	var _con=$(this).attr('zdy');
        	prizeId=$(this).attr('data');
        	
        	$('.product-tilte p').html(_con);
        	_bg.fadeIn();
        	_gg.fadeIn();

        	
			
        });
        $("#tj").click(function(){
        	var name=$("#name").val();
			var phone=$("#phone").val();
			var address=$("#address").val();
			console.log(name+phone+address+prizeId);
			var smTag = true;
			var ii = 0;
    		$.ajax({
            	async:false,
                url: 'server.php',
                type: "post",
                data:{act:'reward',name:name,phone:phone,address:address,prizeId:prizeId},
                dataType:'json',
                success:function(result){
                	if(result.errcode != 0){
                        alert(result.errmsg);
                        
                        smTag = false;
                        return false;
                    }else{
                    	alert(result.errmsg);
                        return false;
                    }
                }
            });
            if(smTag)
            {
	            _bg.fadeOut();
	            _gg.fadeOut();
	            location.reload() 
            }
		});
        _bg.click(function(){
	            _bg.fadeOut();
	            _gg.fadeOut();
			});
</script>

</body>
</html>
