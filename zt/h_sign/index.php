<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>呼博士 五月净化宣言</title>
<meta name="keywords" content="呼博士 五月宣言" />
<meta name="description" content="呼博士 五月宣言" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css"  href="css/com.css?v=3.6"  />
</head>
<body>
<!-- 加载 -->
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
<!-- 报名  无奈摞出-->
<div class="am am4 hide" id="sign">
	<div class="sign">
		<p class="ct">
			<span class="des">姓<em class="gap"></em>名:</span>
			<input id="name" type="text" name="name" value="" />
		</p>
		<p class="ct">
			<span class="des">联系方式:</span>
			<input id="phone" type="text" name="phone" value="" />
		</p>
		<p class="ct">
			<span class="des">城<em class="gap"></em>市:</span>
			<select id="city">
				<option  value="厦门思明区" selected="selected">厦门思明区</option>
				<option  value="厦门湖里区">厦门湖里区</option>
				<option  value="上海静安区">上海静安区</option>
				<option  value="上海徐汇区">上海徐汇区</option>
				<option  value="上海黄浦区">上海黄浦区</option>
				<option  value="上海浦东新区">上海浦东新区</option>
				<option  value="上海闵行区">上海闵行区</option>
				<option  value="上海长宁区">上海长宁区</option>
				<option  value="上海杨浦区">上海杨浦区</option>
				<option  value="北京朝阳区">北京朝阳区</option>
				<option  value="北京海淀区">北京海淀区</option>
				<option  value="北京东城区">北京东城区</option>
				<option  value="北京西城区">北京西城区</option>
				<option  value="广州天河区">广州天河区</option>
				<option  value="广州荔湾区">广州荔湾区</option>
				<option  value="广州海珠区">广州海珠区</option>
				<option  value="广州海珠区">广州海珠区</option>
				<option  value="广州白云区">广州白云区</option>
				<option  value="深圳南山区">深圳南山区</option>
				<option  value="深圳罗湖区">深圳罗湖区</option>
				<option  value="深圳福田区">深圳福田区</option>
				<option  value="深圳宝安区">深圳宝安区</option>
				<option  value="合肥庐阳区">合肥庐阳区</option>
				<option  value="合肥蜀山区">合肥蜀山区</option>
				<option  value="合肥瑶海区">合肥瑶海区</option>
				<option  value="合肥包河区">合肥包河区</option>
			</select>
			<span class="arrow"><em></em></span>
		</p>
		<p class="ct">
			<span class="des">选<em class="gap"></em>择:</span>
			<span class="select">
				免费试用<span class="chk" value='免费试用'></span>&nbsp;&nbsp;&nbsp;&nbsp;
				上门检测<span class="chk checked" value='上门检测'></span>
				<input type="hidden" value="上门检测" id="select">
			</span>
		</p>
		<p class="sub"><span class="sure">提交信息</span></p>
	</div>
</div>
<!-- end -->
<!-- 申请资料 无奈摞出-->
<div class="s-ct-a am8 hide" id="request">
	<div class="s-bg"></div>
	<div class="s-ct  s-ct-1">
		<div class="cloud"></div>
		<p class="p1">项目组织单位：</p>
		<p class="p2">厦门呼博士空气净化科技有限公司</p>
		<p class="p3">
			<span>姓名：<input id="name1" type="text" value="" /></span>
			<span class="sex">性别：
				男<input type="radio" name="sex" value="男" class="chk" />
				女<input type="radio" name="sex" value="女" class="chk"/>
				<input type="hidden" id="sex" value="">
			</span>
		</p>
		<p><span>联系电话：<input id="phone1" type="text" value="" /></span></p>
		<p><span>所在城市：<input id="city1" type="text" value="" /></span></p>
		<p><span>详细地址：<input id="address" type="text" value="" /></span></p>
		<p class="p3 ps">
			<span class="type">家庭成员选择：
				老人<input type="checkbox"  name="type" value="老人" class="chk"/>
				孕妇<input type="checkbox"   name="type"  value="孕妇" class="chk"/>
				婴幼儿<input type="checkbox"  name="type" value="婴幼儿" class="chk"/>
			</span>
		</p>
		<p class="p3">
			<span class="isdec">是否新装修：
				是<input type="radio" name="isdes" value="是" class="chk"/>
				否<input type="radio" name="isdes" value="否" class="chk"/>
				<input type="hidden" id="isdec" value="">
			</span>
		</p>
		<p class="p3">
			<span class="issmoking">家里是否有人吸烟：
				是<input type="radio" name="issmoking"  value="是" class="chk"/>
				否<input type="radio" name="issmoking"  value="否" class="chk"/>
				<input type="hidden" id="issmoking" value="">
			</span>
		</p>
		<p class="p3">
			<span class="ishealth">家里是否有呼吸疾病人员：
				是<input type="radio" name="ishealth"  value="是" class="chk"/>
				否<input type="radio" name="ishealth"  value="否" class="chk"/>
				<input type="hidden" id="ishealth" value="">
			</span>
		</p>
		<p class="p3">
			<span class="isanimal">家里是否有宠物：
				是<input type="radio" name="isanimal" value="是" class="chk"/>
				否<input type="radio" name="isanimal" value="否" class="chk"/>
				<input type="hidden" id="isanimal" value="">
			</span>
		</p>
		<p class="p3">
			<span class="isclean">是否使用过空气净化器：
				是<input type="radio" name="isclean" value="是" class="chk"/>
				否<input type="radio" name="isclean" value="否" class="chk"/>
				<input type="hidden" id="isclean" value="">
			</span>
		</p>
		<p class="p4">我的净化宣言：</p>
		<p class="p5 x1"><input id="x1" type="text" /></p>
		<p class="p5 x2"><input id="x2" type="text" /></p>
		<p class="p7">报名个人信息仅用于本次“2015年BRI呼博士社会监察员”征集活动，请放心填写。</p>
		<p class="p6"><span class="sub-1">提交申请</span>| <span class="back">返回</span></p>
	</div>
</div>
<!-- end -->

<!-- 主要内容 -->
<div class="swiper-container swiper-pages" id="swiper-container1">
	<div class="swiper-wrapper" id="wrapper">
		<!-- 第一屏 -->
		<div class="swiper-slide page-1">
			<div class="container">
				<div class="am am1 bg">
					<img src="images/p1_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/1-1.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/1-2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am4">
					<img src="images/1-3.png" class="animation an4 button" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/1-4.png" class="animation an5" data-item="an5" data-delay="1600" data-animation="fadeInDown"  />
				</div>
				<!-- 新增名单 -->
				<div class="am am6">
					<p class="animation an6 button-5" data-item="an6" data-delay="1500" data-animation="bounceInDown">试用名单</p>
				</div>
				<div class="am am8">
					<p class="animation an8 button-6" data-item="an8" data-delay="1700" data-animation="bounceInDown">社会监察员</p>
				</div>
				<!-- 试用名单 -->
				<div class="s-ct-a am7 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-6">
						<div class="cloud"></div>
						<div class="condition">
							<div id="one">
								<p class="p3">BRI呼博士五月净化宣言</p>
								<p class="p4">空气净化器第一期免费试用名单</p>
								<div class="rank_main cf">
									<p class="rclear cf">
										<span class="rList1 rtitle">姓名</span>
										<span class="rList2 rtitle">城市</span>
										<span class="rList3 rtitle">手机</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">陈生</span>
										<span class="rList2">广州</span>
										<span class="rList3">180*****358</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">yilim</span>
										<span class="rList2">广州</span>
										<span class="rList3">159*****747</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">李铭</span>
										<span class="rList2">广州</span>
										<span class="rList3">186*****630</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">任林</span>
										<span class="rList2">深圳</span>
										<span class="rList3">139*****587</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">周基华</span>
										<span class="rList2">合肥</span>
										<span class="rList3">139*****137</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">陈苏云 </span>
										<span class="rList2">合肥</span>
										<span class="rList3">133*****880</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">杨林</span>
										<span class="rList2">北京</span>
										<span class="rList3">138*****099</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">黄原</span>
										<span class="rList2">北京</span>
										<span class="rList3">137*****393</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">伍林</span>
										<span class="rList2">北京</span>
										<span class="rList3">186*****624</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">吴锦</span>
										<span class="rList2">上海</span>
										<span class="rList3">186*****768</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">严文斌</span>
										<span class="rList2">上海</span>
										<span class="rList3">137*****726</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">郭侃</span>
										<span class="rList2">上海</span>
										<span class="rList3">185*****321</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">邵海鹰</span>
										<span class="rList2">厦门</span>
										<span class="rList3">189*****988</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">陈碧莲</span>
										<span class="rList2">厦门</span>
										<span class="rList3">139*****646</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">丁建成</span>
										<span class="rList2">厦门</span>
										<span class="rList3">159*****121</span>
									</p>
									<p class="btnP">
										<span class="back btn">返回</span>
										<span class="btn" id="two_btn">下一期</span>
									</p>
								</div>
							</div>
							<div id="two" class="hide">
								<p class="p3">BRI呼博士五月净化宣言</p>
								<p class="p4">空气净化器第二期免费试用名单</p>
								<div class="rank_main cf">
									<p class="rclear cf">
										<span class="rList1 rtitle">姓名</span>
										<span class="rList2 rtitle">城市</span>
										<span class="rList3 rtitle">手机</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">梁安娜</span>
										<span class="rList2">广州</span>
										<span class="rList3">135*****383</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">王瑞华</span>
										<span class="rList2">深圳</span>
										<span class="rList3">186*****896</span>
									</p>
									<p class="rclear r3 cf">
										<span class="rList1">白云贵</span>
										<span class="rList2">合肥</span>
										<span class="rList3">180*****986</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">刘德</span>
										<span class="rList2">合肥</span>
										<span class="rList3">138*****365</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">余凌波</span>
										<span class="rList2">合肥</span>
										<span class="rList3">133*****861</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">谢罡 </span>
										<span class="rList2">北京</span>
										<span class="rList3">138*****61</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">周晓璇</span>
										<span class="rList2">上海</span>
										<span class="rList3">138*****461</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">戴冬英</span>
										<span class="rList2">厦门</span>
										<span class="rList3">138*****285</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">罗先生</span>
										<span class="rList2">厦门</span>
										<span class="rList3">152*****757</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">李淑颖</span>
										<span class="rList2">厦门</span>
										<span class="rList3">135*****795</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">许明光</span>
										<span class="rList2">厦门</span>
										<span class="rList3">139*****910</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">金淑云</span>
										<span class="rList2">厦门</span>
										<span class="rList3">185*****021</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">蔡一杰</span>
										<span class="rList2">厦门</span>
										<span class="rList3">133*****878</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">梁俊侠</span>
										<span class="rList2">厦门</span>
										<span class="rList3">135*****093</span>
									</p>
									<p class="rclear cf">
										<span class="rList1">陈丽尤</span>
										<span class="rList2">厦门</span>
										<span class="rList3">134*****692</span>
									</p>
									<p class="btnP">
										<span class="back btn">返回</span>
										<span class="btn" id="one_btn">上一期</span>
									</p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- end -->
				<!-- 监察员名单 -->
				<div class="s-ct-a am8 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-6">
						<div class="cloud"></div>
						<div class="condition">
								<p class="p4">五月净化宣言●社会监察员名单</p>
								<div class="rank_main cf">
									<p class="rclear">
										<span class="rList1 rtitle">姓名</span>
										<span class="rList2 rtitle">性别</span>
										<span class="rList3 rtitle">手机</span>
									</p>
									<p class="rclear r3">
										<span class="rList1">岳宁</span>
										<span class="rList2">女</span>
										<span class="rList3">139****8670</span>
									</p>
									<p class="rclear r3">
										<span class="rList1">易广涛</span>
										<span class="rList2">男</span>
										<span class="rList3">185****7588</span>
									</p>
									<p class="rclear r3">
										<span class="rList1">陈依琳</span>
										<span class="rList2">女</span>
										<span class="rList3">159****8747</span>
									</p>
									<p class="rclear">
										<span class="rList1">杜效</span>
										<span class="rList2">女</span>
										<span class="rList3">158****5780</span>
									</p>
									<p class="rclear">
										<span class="rList1">张伟妃</span>
										<span class="rList2">女</span>
										<span class="rList3">186****1705</span>
									</p>
									<p class="rclear">
										<span class="rList1">马俊杰</span>
										<span class="rList2">男</span>
										<span class="rList3">139****4756</span>
									</p>
									<p class="rclear">
										<span class="rList1">张国华</span>
										<span class="rList2">男</span>
										<span class="rList3">137****6900</span>
									</p>
									
									
								</div>
								<p class="p3">为回馈热情参与的小伙伴，呼博士特意增加了2个社会监察员名额，恭喜7位成为社会监察员的伙伴！</p>
								<p class="btnP">
									<span class="back btn">返回</span>
								</p>
								
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<!-- 第二屏 -->
		<div class="swiper-slide page-2">
			<div class="container">
				<div class="am am1 bg">
					<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/2-2.png" class="animation an2" data-item="an2" data-delay="800" data-animation="fadeInDown"/>
					<img src="images/2-3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/2-1.png" class="animation an4 button-4" data-item="an4" data-delay="1200" data-animation="bounceInDown"/>
				</div>
				<!-- 报名 无奈摞出-->
				<!-- 报名成功 -->
				<div class="s-ct-a am6 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-5">
						<div class="cloud"></div>
						<div class="condition">
							<p class="p1">信息提交成功</p>
							<p class="p2">呼博士将会在5月20日和5月30日分别公布抽取试用名单，敬请期待！</p>
							<p class="p2">恭喜你获得社会监察员的报名机会，更有机会享受免费厦门之旅！</p>
						</div>
						<span class="back sucBack">立即报名</span>
					</div>
				</div>
				<!-- end -->
				<!-- 试用规则 -->
				<div class="s-ct-a am5 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<p class="p3">免费试用规则</p>
							<p class="p1">◆30名免费试用名额，机型BRI呼博士BA-1045空气净化器（市场售价3999元），试用期一个月；</p>
							<p class="p1">◆第一批5月20日抽取15名，第二批在5月30日抽取15名；</p>
							<p class="p1">◆名单公布后，呼博士上门检测空气质量，试用机型送上门，并签订试用合约；</p>
							<p class="p1">◆分享试用感受，更能享受呼博士更多优惠；</p>
							<p class="p1">◆本活动最终解释权，最终归厦门呼博士公司所有。</p>
							<p class="p4">
								>><a href="http://wq.jd.com/mshop/gethomepage?venderid=124533">了解免费试用产品信息</a>
							</p>
							<p class="p4">
								>><a href="http://www.briair.com.cn/web/jcyy/flow.jsp">免费上门检测说明</a>
							</p>
						</div>
						<span class="back">返回</span>
					</div>
				</div>
				<!-- end -->
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第三屏 -->
		<div class="swiper-slide page-3">
			<div class="container">
				<div class="am am1 bg">
					<img src="images/p3_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/3-1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/3-2-1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/3-3.png" class="animation an3" data-item="an3" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/3-4.png" class="animation an5" data-item="an5" data-delay="1600" data-animation="fadeInDown"/>
				</div>
				<div class="am am6">
					<img src="images/3-5.png" class="animation an6 button-2" id="dialog1" data-item="an6" data-delay="1800" data-animation="bounceInDown"/>
				</div>
				<div class="am am7">
					<img src="images/3-6.png" class="animation an7 button-3" data-item="an7" data-delay="1900" data-animation="fadeInDown"/>
				</div>
				<!-- 申请资料 无奈摞出-->
				<!-- 申请成功 -->
				<div class="s-ct-a am10 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-5">
						<div class="cloud"></div>
						<div class="condition">
							<p class="p1">感谢您的参与</p>
							<p class="p2">5名监察员名单将会在6月2日公布</p>
							<p class="p2">敬请期待</p>
						</div>
						<span class="back">返回</span>
					</div>
				</div>
				<!-- end -->
				<!-- 申请条件 -->
				<div class="s-ct-a am9 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-2">
						<div class="cloud"></div>
						<div class="condition">
							<p class="p3">呼博士社会监察员</p>
							<p class="p4">尊享权益</p>
							<p class="p1">◆ 免费获赠一台医用级空气净化器</p>
							<p class="p2">评选成为呼博士社会监察员后，将免费获赠呼博士指定机型BA-1045，价值3999元。</p>
							<p class="p1">◆ 家庭空气质量检测对比</p>
							<p class="p2">社会检察员可获得两次家庭空气检测权利，分别为未使用空气净化器前和使用空气净化器后家庭空气质量对比。</p>
							<p class="p1">◆ 厦门净化之旅  免费游</p>
							<p class="p2 p-b">评选成为呼博士建社会监察员后，可亲临厦门呼博士，参观工厂见证产品质量，开启厦门净化之旅，费用均由厦门呼博士承担。</p>
							<p class="p1 p5">◆ 本活动最终解释权，最终归厦门呼博士公司所有。</p>
						</div>
						<span class="back">返回</span>
					</div>
				</div>
				<!-- end -->
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第四屏 -->
		<div class="swiper-slide page-4">
			<div class="container">
				<div class="am am1 bg">
					<img src="images/p4_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/4-1.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<p class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown">&nbsp;&nbsp;&nbsp;&nbsp;活着的证明，就是呼吸。每一口健康呼吸，才能让生命得以延续，对洁净空气的需求是每个人的本能。
					</p>
					<p class="animation an4" data-item="an4" data-delay="1200" data-animation="fadeInDown">&nbsp;&nbsp;&nbsp;&nbsp;BRI呼博士秉承<span>“您全家的呼吸健康卫士”</span>的品牌定位，携手国内一流的广州呼吸疾病研究所联合研发空气净化产品，致力于改善家庭空气质量；同时提供室内空气免费检测、呼吸疾病科普、在线咨询、导医导诊服务，构建完善的“呼吸健康云服务系统”，普及呼吸健康知识，提升公众呼吸健康防护意识，倡导公众加入呼吸健康行列，做自己与他人的呼吸健康卫士。
					</p>
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第五屏 -->
		<div class="swiper-slide page-5">
			<div class="container">
				<div class="am am1 bg">
					<img src="images/p5_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/5-2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<!-- 专家图片 -->
				<div class="am am4">
					<div class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown" >
						<span>专家团</span>
						<div class="special">
							<img src="images/1.jpg">
							<img src="images/2.jpg">
							<img src="images/3.jpg">
							<img src="images/5.jpg" class="m-r-0">
						</div>
						<p>点击图片查看访问</p>
					</div>
				</div>
				<!-- end -->
				<!-- 专家访问 -->
				<div class="am5 specialW">
					<!--专家  -->
					<div class="s-ct-a ct hide">
						<div class="s-bg"></div>
						<div class="s-ct s-ct-3">
							<div class="cloud"></div>
							<p class="img"><img src="images/1.jpg"></p>
							<p class="name">黄庆晖</p>
							<p class="p1 p-t">广州呼吸疾病研究所书记、副所长</p>
							<p class="p1">&nbsp;&nbsp;&nbsp;&nbsp;针对雾霾天，黄庆晖表示，广大群众在日常生活中应该勤洗手，多开窗通风透气，使用空气净化器等来改善室内空气，预防呼吸疾病。对于呼研所组织，呼博士承办的“家庭空气质量调研及呼吸疾病科普中国行”， 黄庆晖认为，这是非常有意义的公益活动，也对整个社会重视室内空气质量有所帮助。</p>
							<span class="back back-3">返回</span>
						</div>
					</div>
					<!--专家  -->
					<div class="s-ct-a ct hide">
						<div class="s-bg"></div>
						<div class="s-ct s-ct-3">
							<div class="cloud"></div>
							<p class="img"><img src="images/2.jpg"></p>
							<p class="name">李时悦</p>
							<p class="p1 p-t">广州医科大学附属第一医院、广州呼吸疾病研究所副所长、呼吸内科主任</p>
							<p class="p1">&nbsp;&nbsp;&nbsp;&nbsp;网上流传一种说法：人长期待在空气净化器营造的清洁、舒净的环境中会降低免疫能力。李时悦否定了这一观点，他表示，感染疾病与人自身机体功能、传染源以及是否是易感人群有关，使用空气净化器不仅不会降低人的免疫能力，反而能改善空气质量，降低感染疾病的几率。同时，李时悦建议，在室内可使用空气净化器，但不应该长时间待在室内，也要适当进行户外活动，增强体魄。</p>
							<span class="back back-3">返回</span>
						</div>
					</div>
					<!--专家  -->
					<div class="s-ct-a ct hide">
						<div class="s-bg"></div>
						<div class="s-ct s-ct-3">
							<div class="cloud"></div>
							<p class="img"><img src="images/3.jpg"></p>
							<p class="name">张挪富</p>
							<p class="p1 p-t"> 广州医科大学附属第一医院广州呼吸疾病研究所呼吸睡眠病区主任</p>
							<p class="p1">&nbsp;&nbsp;&nbsp;&nbsp;打鼾等睡眠呼吸疾病和人们在晚上睡眠期间空气质量好坏有关系。张挪富建议，群众在睡眠期间可以使用具有杀菌、过滤作用的空气净化器，这有利于减少睡眠呼吸疾病。目前市面上空气净化器种类繁多，具有杀菌功能的产品并不多，消费者在选择时应注意甄别。</p>
							<span class="back back-3">返回</span>
						</div>
					</div>
					<!--专家  -->
					<div class="s-ct-a ct hide">
						<div class="s-bg"></div>
						<div class="s-ct s-ct-3">
							<div class="cloud"></div>
							<p class="img"><img src="images/5.jpg"></p>
							<p class="name">曾运祥</p>
							<p class="p1 p-t">广州医科大学附属第一医院呼吸内科副主任医师</p>
							<p class="p1">&nbsp;&nbsp;&nbsp;&nbsp;有80%的小孩敏感性支气管炎等病症这个说法不对，但是像老人、小孩这类体质较弱的人确实容易患上呼吸道疾病。曾主任提到在室内装上好的空气净化器，这有助于杀菌换气，改善空气质量，但是要注意内网换洗，防止病菌残留，危害健康。</p>
							<span class="back back-3">返回</span>
						</div>
					</div>
					

				</div>
				<!-- end -->
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>

   </div>
</div>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
//微信分享控制
wx.config({
	  debug: false,
      appId: '<?php echo $signPackage["appId"];?>',
	  timestamp: <?php echo $signPackage["timestamp"];?>,
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
		"imgUrl":'http://zt.jia360.com/h_sign/images/share.jpg',
		"link":'http://zt.jia360.com/h_sign/index.php',
		"desc":"空气净化器免费试用，报名社会监察员，一起开启厦门净化之旅！",
		"title":"呼博士五月净化宣言"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>
<script src="js/touch.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.9"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>