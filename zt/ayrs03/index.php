<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
$sql = "select vote_id,vote_count from ayrs_vote";
$res = mysqli_query($db,$sql);
$rows = array();
while($row = $res->fetch_assoc())
{
    $rows[$row['vote_id']] = $row['vote_count'];
}
// var_dump($rows);die;

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>爱依瑞斯-爱的代言人</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css"  href="css/style.css?v=1.4"  />
<script type="text/javascript" src="js/my.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<!--图片播放器 -->
<script type="text/javascript" src="js/koala.min.1.5.js"></script>
<script type="text/javascript">
Qfast.add('widgets', { path: "js/terminator2.2.min.js", type: "js", requires: ['fx'] });  
Qfast(false, 'widgets', function () {
	K.tabs({
		id: 'fsD1',   //焦点图包裹id  
		conId: "D1pic1",  //** 大图域包裹id  
		tabId:"D1fBt",  
		tabTn:"a",
		conCn: '.fcon', //** 大图域配置class       
		auto: 1,   //自动播放 1或0
		effect: 'fade',   //效果配置
		eType: 'click', //** 鼠标事件
		pageBt:true,//是否有按钮切换页码
		bns: ['.prev', '.next'],//** 前后按钮配置class                          
		interval: 3000  //** 停顿时间  
	}) 
})  
</script>
<!--点击弹出层--><script src="js/MyCxcPlug.js" type="text/javascript"></script>
<script type="text/javascript">
			$(document).ready(function(){
				$(".Monv").click(function(){
					Popuplayer({
						LayerId:"Monver",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv2").click(function(){
					Popuplayer({
						LayerId:"Monver2",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close2",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv3").click(function(){
					Popuplayer({
						LayerId:"Monver3",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close3",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv4").click(function(){
					Popuplayer({
						LayerId:"Monver4",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close4",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv5").click(function(){
					Popuplayer({
						LayerId:"Monver5",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close5",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv6").click(function(){
					Popuplayer({
						LayerId:"Monver6",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close6",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv7").click(function(){
					Popuplayer({
						LayerId:"Monver7",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close7",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv8").click(function(){
					Popuplayer({
						LayerId:"Monver8",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close8",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv9").click(function(){
					Popuplayer({
						LayerId:"Monver9",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close9",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv10").click(function(){
					Popuplayer({
						LayerId:"Monver10",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close10",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv11").click(function(){
					Popuplayer({
						LayerId:"Monver11",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close11",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv12").click(function(){
					Popuplayer({
						LayerId:"Monver12",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close12",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv13").click(function(){
					Popuplayer({
						LayerId:"Monver13",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close13",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv14").click(function(){
					Popuplayer({
						LayerId:"Monver14",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close14",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv15").click(function(){
					Popuplayer({
						LayerId:"Monver15",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close15",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv16").click(function(){
					Popuplayer({
						LayerId:"Monver16",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close16",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv17").click(function(){
					Popuplayer({
						LayerId:"Monver17",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close17",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv18").click(function(){
					Popuplayer({
						LayerId:"Monver18",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close18",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv19").click(function(){
					Popuplayer({
						LayerId:"Monver19",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close19",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv20").click(function(){
					Popuplayer({
						LayerId:"Monver20",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close20",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv21").click(function(){
					Popuplayer({
						LayerId:"Monver21",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close21",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
				$(".Monv22").click(function(){
					//alert($(this).attr("data"));
					var voteData = $(this).attr("data");
					// /console.log(voteData);
					$.ajax({
		                async:false,
		                url: 'server.php',
		                data:{act:'vote',vote_data:voteData},
		                type: "post",
		                dataType:'json',
		                success:function(result){
		                    //数据返回后执行
		                    if(result.errcode != 0){
		                    	alert(result.msg);
		                        return false;
							}else{
		                    	alert(result.msg);
		                        return false;
		                    }
		                    
		                }
		            });
					Popuplayer({
						LayerId:"Monver22",//层ID
						Masklayer:"cxc",//遮罩层ID
						CloseID:"close22",//退出id
						Fun:function(){} //关闭时是否回调函数
					});
				});
			});

			
			
			</script>
<script type="text/javascript" src="js/jquery.bubbleup.js"></script>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<!--选项卡-->
<script src="js/jquery.tabs.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script type="text/javascript">
$(function(){

	$("img[original]").lazyload({ placeholder:"images/color3.gif" });
	
	$('.demo1').Tabs();
	$('.demo2').Tabs({
		event:'click'
	});
	$('.demo3').Tabs({
		timeout:300
	});
	$('.demo4').Tabs({
		auto:3000
	});
	$('.demo5').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
	//部分区域图片延迟加载
	function lazyloadForPart(container) {
		container.find('img').each(function () {
			var original = $(this).attr("original");
			if (original) {
				$(this).attr('src', original).removeAttr('original');
			}
		});
	}
});	
</script>
</head>
<body>
    <div class="header"><a href="http://www.chinaaris.com/Love_brand.aspx?nid=3" target="_blank"></a></div>
<div class="headre2"><div class="box"><img src="images/ay_04.jpg" height="80" border="0" usemap="#Map" />
    <map name="Map" id="Map">
      <area shape="rect" coords="173,7,308,66" href="#p2" />
      <area shape="rect" coords="346,8,465,66" href="#p3" />
      <area shape="rect" coords="516,14,628,65" href="#p4" />
      <area shape="rect" coords="689,8,792,65" href="#p5" />
    </map>
</div></div>
<div class="con1">
</div>

<div class="con6">
  <div class="box">

     
           <div id="Monver"><span id="close"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc01.jpg" width="500" height="400" /></div><!--end bs-->
    </div>
            <div id="Monver2" style="top:100px;"><span id="close2"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc02.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">阿萨姆</div>
                 <div class="wz" style="">阿萨姆，ARIS智慧睡眠科技的完美演绎，超大正方型床体，配合舒适度高度统一的质感面料和咖啡色，流线与棱角采用繁复手工缝制处理，床体造型更具显厚重。智慧睡眠承托系统，紧贴人体曲线，能够在每一点均匀承托您的脊骨而又可以保持脊骨的原始弧度，令您享有最松软舒适的睡眠感觉，美梦在光阴的守候中，缓缓上映。</div>
              </div><!--end txts-->
            </div>
<div id="Monver3" style="top:100px;"><span id="close3"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc03.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">贝弗利</div>
                 <div class="wz" style="">自然粗狂与鲜明色彩的对比，让居室充满了艺术气息。棉麻材质、滚绳工艺、以及寓意为平安富贵、步步高升的竹节图案，为我们展示出无法拒绝的舒适体验与奢华之美。每件单背都轻巧灵便，可随意组合，使用自由。时尚的线条设计，令居家休闲生活变得精致动人。</div>
              </div>
    </div>
            <div id="Monver4" style="top:100px;"><span id="close4"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc04.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">P-A241</div>
                 <div class="wz" style="">现代风格与深棕色完美协调在一起，中世纪的手工华美与现代家居优雅完美体现在作品之上。蕴含了设计师灵感之中，理性与感性的合力迸发。拉点的工艺的运用给作品融入了时尚几何元素，通体散发出极致的高贵及典雅。流露出的不仅是一种风格,一种时尚，更具有一种生活品位的优雅气质。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver5" style="top:100px;"><span id="close5"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc05.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">南茜</div>
                 <div class="wz" style="">时尚女士对温馨充满自信的家的追求，崇尚细腻不入凡俗，陶醉如梦幻公主般浪漫迷离的生活。女主人对家的向往，设计师设计出符合这种意境的一件产品。南茜沙发以紫色为基调，从恣意盛开的花朵到舒展的叶片，再到饱满拼接的色块，在花团锦簇里营造出一片浪漫与梦幻的情调。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver6" style="top:300px;"><span id="close6"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc06.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">布达佩斯B</div>
                 <div class="wz" style="">布达佩斯B沙发的设计灵感来自于世界最为著名的威尼斯Libreria  Acqua  Alta书店，其两组双人位沙发侧的Mini书架，让每一个爱好阅读的人着迷不已。沙发采用超回弹聚氨酯软泡切割技术及厚实的靠背填充，整体造型线条流畅，犹如芭蕾舞般优美而富于情感。细细品味布达佩斯B的风采，可以感受到爱依瑞斯设计团队对作品创造的至高礼赞。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver7" style="top:300px;"><span id="close7"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc07.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">洛克尔</div>
                 <div class="wz" style="">集成了ARIS十多年的设计精粹，代表着ARIS整体软床的高度与趋势。洛克尔全曲线造型，可调整的头枕设计支撑着头部的舒适。洛克尔采用了许多高端的科技元素与独特的细节，全方位自由升降随心调节的豪华—16排骨架、比利时进口凝胶乳胶床垫，、超静音装置、美国进口电机与无线遥控等，带你进入深度睡眠的舒适。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver8" style="top:300px;"><span id="close8"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc08.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">P-A247</div>
                 <div class="wz" style="">设计师将西方的现代手法融合在典雅的审美传统之中。意式细研磨砂的真皮质感，匠心独运的立体剪裁工艺，现代简约的滚边塑形风格，塑造出作品高贵自然的气质。光线在弧面上渡上岁月光华，不多单恰到好处的腰靠纹饰刻画出雅致的现代都市情结。于细节之间诠释非凡品味，于动静之间演绎上层意识。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver9" style="top:500px;"><span id="close9"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc09.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts"></div>
                 <div class="wz" style=""></div>
              </div><!--end txts-->
    </div>
            <div id="Monver10" style="top:700px;"><span id="close10"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc10.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">科西嘉</div>
                 <div class="wz" style="">这个空间给人一种步入城堡的错觉，空间里金碧辉煌的浮雕及墙壁上庄严的刻纹似乎抢尽了沙发的风头，不过缀满蝴蝶花样的抱枕打破了马可·焦尔杰蒂设计的这款科西嘉沙发色调的单一，给空间注入了生气和活力。另外，抱枕、圆几、地毯、茶几在这里再次强调了色彩的呼应。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver11" style="top:700px;"><span id="close11"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc11.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">科莱特</div>
                 <div class="wz" style="">这款科莱特真皮寝具延续了ARIS标识性的床头屏风风格，床头真皮表面采用方块绗缝工艺，床体四周为矩形绗缝工艺，闪亮的铜钉工艺镶嵌真皮表面，装饰大方素雅。凭借ARIS独特的手工工艺，科莱特兼顾现代与传统，既领导潮流又不失精致细腻。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver12" style="top:700px;"><span id="close12"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc12.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">至尊威风</div>
                 <div class="wz" style="">华贵淡雅的浅色系，逐渐成为软床设计的主流配色，有着时尚家居王国之称的ARIS当然少不了此类色彩的演绎与呈现。本款作品用菱形走线压花工艺，完美搭配柔软的天然面料。至尊威风的风格特点鲜明而完整的展示于空间之中, 让温馨与典雅挥洒的淋漓尽致。外在的质地与内在的气韵浑然一体，时尚的品位完美融合。这一刻，无需要想什么，享受生活，已成为最大的快乐。</div>
              </div><!--end txts-->
    </div>
            <div id="Monver13" style="top:700px;"><span id="close13"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc13.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts"></div>
                 <div class="wz" style=""></div>
              </div><!--end txts-->
    </div>
<div id="Monver14" style="top:800px;"><span id="close14"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc14.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">拉齐奥7代</div>
                 <div class="wz" style="">拉齐奥7代完美融合了爱依瑞斯工艺的精髓，整体捏边工艺由工艺娴熟的老技工手工缝制，线条干净利落，为世人呈现出极致优雅的设计。它由爱依瑞斯首席意大利设计官马可·焦尔杰蒂先生创造，如同麻将块一样可以随意拼凑，自由组合，叠放使用。色彩斑斓极为丰富，赤橙黄绿青蓝紫样样俱全，抱枕上的蝴蝶栖息于花间，如同飞落凡间的天使，娇艳动人。阳光通透的落地窗，不仅能为室内提供充分的采光，也能营造出别样的梦幻色彩。拉齐奥系列是爱依瑞斯的经典杰作，一直倍受欢迎——这证明了真正的美从来不会因时间流逝而褪色分毫。</div>
        </div><!--end txts-->
            </div>
            <div id="Monver15" style="top:800px;"><span id="close15"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc15.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">拉齐奥床</div>
                 <div class="wz" style="">设计师的灵感来自意大利拉齐奥夏季地中海景与葡萄酒庄园大片赤霞珠遥相呼应的美景。床体运用捏边工艺绗缝，营造的棱角与线条呈现出一种自然的柔性与亲近感。床头搭配同等质量的炫彩水墨面料，大团花簇似乎袅袅升腾，让整张床的层次感完整呈现，形成完整的视觉体验。拉齐奥成为ARIS设计作品的又一巅峰之作。</div>
              </div><!--end txts-->
</div>
            
        <ul id="menu2">
          <li class="f1">
            <p><img src="images/tj/tj_01.jpg" width="200" height="600" /></p>
            
          </li>
          <li class="f2">
            <p class="Monv2"><a></a></p>
            
          </li>
          <li class="f3"><p class="Monv3"><a></a></p></li>
          <li class="f4">
            <p class="Monv4"><a></a></p>
            
          </li>
          <li class="f5">
               <p class="Monv5"><a></a></p>
          </li>
          <li class="f6">
              <p class="Monv6"><a></a></p>
            
          </li>
          <li class="f7">
            <p class="Monv7"><a></a></p>
            
          </li>
          <li class="f8">
            <p class="Monv8"><a></a></p>
            
          </li>
          <li class="f9">
            <p class="Monv9"><a></a></p>
            
          </li>
          <li class="f10"><p class="Monv10"><a></a></p></li>
          <li class="f11"><p class="Monv11"><a></a></p>
          </li>
          <li class="f12">
            <p class="Monv12"><a></a></p>
          </li>
          <li class="f13">
            <p class=""><a></a></p>
          </li>
          <li class="f14">
            <p class="Monv14"><a></a></p>
          </li>
          <li class="f15">
            <p class="Monv15"><a></a></p>
          </li>
    </ul>

  </div>
</div>

<div class="con3" id="p3">
<div id="Monver16" style="top:100px; margin-left:80px;"><span id="close16"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc16.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">P-A247</div>
                 <div class="wz" style="">设计师将西方的现代手法融合在典雅的审美传统之中。意式细研磨砂的真皮质感，匠心独运的立体剪裁工艺，现代简约的滚边塑形风格，塑造出作品高贵自然的气质。光线在弧面上渡上岁月光华，不多单恰到好处的腰靠纹饰刻画出雅致的现代都市情结。于细节之间诠释非凡品味，于动静之间演绎上层意识。</div>
              </div><!--end txts-->
</div>
<div id="Monver17" style="top:100px; margin-left:80px;"><span id="close17"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc17.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">贝克斯特</div>
                 <div class="wz" style="">床头侧面的弧形曲线，优美流畅，向上的弯曲带来卧室空间的生气，与靠背两侧的造型相呼应，圆润饱满。床头及床位相互呼应的绗缝工艺设计，简单大方，富有价值感。床头靠背饱满的填充承托人依靠时腰部的压力，让您更轻松舒适地依靠，人性化的设计只为您的脊椎健康考虑。顶级皮革搭配顶级床品，稳重，触感醇厚，柔软舒适，满足成功人士对高品质的家居生活的追求。</div>
              </div><!--end txts-->
</div>
<div id="Monver18" style="top:100px; margin-left:80px;"><span id="close18"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc18.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">拉齐奥床</div>
                 <div class="wz" style="">设计师的灵感来自意大利拉齐奥夏季地中海景与葡萄酒庄园大片赤霞珠遥相呼应的美景。床体运用捏边工艺绗缝，营造的棱角与线条呈现出一种自然的柔性与亲近感。床头搭配同等质量的炫彩水墨面料，大团花簇似乎袅袅升腾，让整张床的层次感完整呈现，形成完整的视觉体验。拉齐奥成为ARIS设计作品的又一巅峰之作。</div>
              </div><!--end txts-->
</div>
<div id="Monver19" style="top:100px; margin-left:80px;"><span id="close19"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc19.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">科西嘉</div>
                 <div class="wz" style="">这个空间给人一种步入城堡的错觉，空间里金碧辉煌的浮雕及墙壁上庄严的刻纹似乎抢尽了沙发的风头，不过缀满蝴蝶花样的抱枕打破了马可·焦尔杰蒂设计的这款科西嘉沙发色调的单一，给空间注入了生气和活力。另外，抱枕、圆几、地毯、茶几在这里再次强调了色彩的呼应。</div>
              </div><!--end txts-->
</div>
<div id="Monver20" style="top:100px; margin-left:80px;"><span id="close20"><img src="images/ImgClose.png" /></span>
              <div class="bs"><img src="images/tj/tc20.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">南茜</div>
                 <div class="wz" style="">时尚女士对温馨充满自信的家的追求，崇尚细腻不入凡俗，陶醉如梦幻公主般浪漫迷离的生活。女主人对家的向往，设计师设计出符合这种意境的一件产品。南茜沙发以紫色为基调，从恣意盛开的花朵到舒展的叶片，再到饱满拼接的色块，在花团锦簇里营造出一片浪漫与梦幻的情调。</div>
              </div><!--end txts-->
</div>
<div id="Monver21" style="top:100px; margin-left:80px;"><span id="close21"><img src="images/ImgClose.png" /></span>
    <div class="bs"><img src="images/tj/tc21.jpg" width="500" height="400" /></div><!--end bs-->
              <div class="txts">
                 <div class="bts">拉齐奥7代</div>
                 <div class="wz" style="">拉齐奥7代完美融合了爱依瑞斯工艺的精髓，整体捏边工艺由工艺娴熟的老技工手工缝制，线条干净利落，为世人呈现出极致优雅的设计。它由爱依瑞斯首席意大利设计官马可·焦尔杰蒂先生创造，如同麻将块一样可以随意拼凑，自由组合，叠放使用。色彩斑斓极为丰富，赤橙黄绿青蓝紫样样俱全，抱枕上的蝴蝶栖息于花间，如同飞落凡间的天使，娇艳动人。阳光通透的落地窗，不仅能为室内提供充分的采光，也能营造出别样的梦幻色彩。拉齐奥系列是爱依瑞斯的经典杰作，一直倍受欢迎——这证明了真正的美从来不会因时间流逝而褪色分毫。</div>
              </div><!--end txts-->
</div>
<div id="Monver22" style="top:100px; margin-left:80px;"><span id="close22"><img src="images/ImgClose.png" /></span>
    <div class="bs2"><img src="images/guize.jpg" width="450" height="400" /></div><!--end bs-->
              <div class="txts2">
                 <div class="bts">恭喜您成功获得爱依瑞斯300元代金券！微信扫描二维码即可获得！全国爱依瑞斯门店均可使用！</div>
                 <div class="wz" style=""><img src="images/ewm.png" /></div>
              </div><!--end txts-->
</div>
   <ul>
      <li><a class="ximg" style="margin-top:130px;"><img src="images/ay_14.jpg" /><div class="sk14 Monv16"></div></a><div class="tp"><a class="Monv22 vote" data="1">投票</a></div><div class="tp2"><?php echo $rows[1]; ?>票</div></li>
      <li><a class="ximg" style="margin-top:160px;"><img src="images/ay_16.jpg" /><div class="sk16 Monv17"></div></a><div class="tp"><a class="Monv22 vote" data="2">投票</a></div><div class="tp2"><?php echo $rows[2]; ?>票</div></li>
      <li><a class="ximg" style="margin-top:130px;"><img src="images/ay_18.jpg" /><div class="sk18 Monv18"></div></a><div class="tp"><a class="Monv22 vote" data="3">投票</a></div><div class="tp2"><?php echo $rows[3]; ?>票</div></li>
      <li><img src="images/ay_11.jpg" width="172" height="596" /></li>
      <li><a class="ximg" style="margin-top:130px;"><img src="images/ay_20.jpg" /><div class="sk20 Monv19"></div></a><div class="tp"><a class="Monv22 vote"  data="4">投票</a></div><div class="tp2"><?php echo $rows[4]; ?>票</div></li>
      <li><a class="ximg" style="margin-top:160px;"><img src="images/ay_22.jpg" /><div class="sk22 Monv20"></div></a><div class="tp"><a class="Monv22 vote"  data="5">投票</a></div><div class="tp2"><?php echo $rows[5]; ?>票</div></li>
      <li><a class="ximg" style="margin-top:130px;"><img src="images/ay_24.jpg" /><div class="sk24 Monv21"></div></a><div class="tp"><a class="Monv22 vote"  data="6">投票</a></div><div class="tp2"><?php echo $rows[6]; ?>票</div></li>
   </ul>
</div>
<div class="con4">
 <div class="tc1">
       <div class="win">
       <img src="images/guize.jpg" width="600" height="586" /></div>
   </div>
</div>
<div class="con5" id="p4"></div>

<div class="con7">
    <div class="box">
       <div class="txt">爱依瑞斯一直在倡导“打造国际化家居品牌”，我们也在有层次的推进中。首先，我们要打造国内最知名的品牌之一，然后在“走出去”。其实，现在有些国家已经有我们的产品了，也有的用ARIS来命名的，专卖店也在做。不过，这几年我们重点锁定在国内的市场...<a href="http://bj.jia360.com/2015/0512/1431423465065.html" target="_blank">[详情]</a></div>
    </div>
</div>
<div class="con8" id="p5">
   <div class="box1">
      <div class="boxs demo2">
			<ul class="tab_menu">
				<li class="current"><img src="images/xxbt1.jpg" /></li>
				<li><img src="images/xxbt2.jpg" /></li>
			</ul>
			<div class="tab_box">
			  <div>
					<iframe frameborder="0" width="600" height="428" src="http://v.qq.com/iframe/player.html?vid=v0156gw279j&tiny=0&auto=0" allowfullscreen></iframe>
				</div>
				<div class="hide">
					<div id="fsD1" class="focus">

	<div id="D1pic1" class="fPic">
		<div class="fcon">
			<a><img src="images/01.jpg" /></a>
		</div>
		<div class="fcon">
			<a><img src="images/02.jpg" /></a>
		</div>
		<div class="fcon">
			<a><img src="images/03.jpg" /></a>
		</div>
		<div class="fcon">
			<a><img src="images/04.jpg" /></a>
		</div>
        <div class="fcon">
			<a><img src="images/05.jpg" /></a>
		</div>
        <div class="fcon">
			<a><img src="images/06.jpg" /></a>
		</div>
        <div class="fcon">
			<a><img src="images/07.jpg" /></a>
		</div>
	</div>
	
	<div class="fbg">
		<div class="D1fBt" id="D1fBt">
			<a href="javascript:void(0)" class="current"><i>1</i></a>
			<a href="javascript:void(0)"><i>2</i></a>
			<a href="javascript:void(0)"><i>3</i></a>
			<a href="javascript:void(0)"><i>4</i></a>
            <a href="javascript:void(0)"><i>5</i></a>
            <a href="javascript:void(0)"><i>6</i></a>
            <a href="javascript:void(0)"><i>7</i></a>
		</div>
	</div>
	
	<span class="prev"></span>
	<span class="next"></span>
	
</div>
			  </div>
				
		</div>
		</div><!--end dome2-->
   </div>
   <div class="indexmaindiv" id="indexmaindiv">
	<div class="indexmaindiv1 clearfix" >
		<div class="stylesgoleft" id="goleft"></div>
		<div class="maindiv1 " id="maindiv1">
		<ul id="count1">
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/1.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/2.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/3.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/4.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/5.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/6.jpg" /></div>
				</div>
			</li>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="css/images/areabackground/7.jpg" /></div>
				</div>
			</li>
			
		</ul>
		</div>
		<div class="stylesgoright" id="goright"></div>
	</div>
</div>
</div>
<div class="con9"></div>

<script type="text/javascript">
window.onload = function () {
	var oBtnLeft = document.getElementById("goleft");
	var oBtnRight = document.getElementById("goright");
	var oDiv = document.getElementById("indexmaindiv");
	var oDiv1 = document.getElementById("maindiv1");
	var oUl = oDiv.getElementsByTagName("ul")[0];
	var aLi = oUl.getElementsByTagName("li");
	var now = -1 * (aLi[0].offsetWidth + 13);
	oUl.style.width = aLi.length * (aLi[0].offsetWidth + 13) + 'px';
	oBtnRight.onclick = function () {
		var n = Math.floor((aLi.length * (aLi[0].offsetWidth + 13) + oUl.offsetLeft) / aLi[0].offsetWidth);

		if (n <= 1) {
			move(oUl, 'left', 0);
		}
		else {
			move(oUl, 'left', oUl.offsetLeft + now);
		}
	}
	oBtnLeft.onclick = function () {
		var now1 = -Math.floor((aLi.length / 5)) * 5 * (aLi[0].offsetWidth + 13);

		if (oUl.offsetLeft >= 0) {
			move(oUl, 'left', now1);
		}
		else {
			move(oUl, 'left', oUl.offsetLeft - now);
		}
	}
	var timer = setInterval(oBtnRight.onclick, 5000);
	oDiv.onmouseover = function () {
		clearInterval(timer);
	}
	oDiv.onmouseout = function () {
		timer = setInterval(oBtnRight.onclick, 5000);
	}

};

function getStyle(obj, name) {
	if (obj.currentStyle) {
		return obj.currentStyle[name];
	}
	else {
		return getComputedStyle(obj, false)[name];
	}
}

function move(obj, attr, iTarget) {
	clearInterval(obj.timer)
	obj.timer = setInterval(function () {
		var cur = 0;
		if (attr == 'opacity') {
			cur = Math.round(parseFloat(getStyle(obj, attr)) * 100);
		}
		else {
			cur = parseInt(getStyle(obj, attr));
		}
		var speed = (iTarget - cur) / 6;
		speed = speed > 0 ? Math.ceil(speed) : Math.floor(speed);
		if (iTarget == cur) {
			clearInterval(obj.timer);
		}
		else if (attr == 'opacity') {
			obj.style.filter = 'alpha(opacity:' + (cur + speed) + ')';
			obj.style.opacity = (cur + speed) / 100;
		}
		else {
			obj.style[attr] = cur + speed + 'px';
		}
	}, 30);
}  
</script>

<script src="js/my.js"></script>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
        <!--#include virtual="/public/head.html"-->
        <!--#include virtual="/public/tongji.html"-->
        <!--#include virtual="/public/footer.html"-->
</body>
</html>