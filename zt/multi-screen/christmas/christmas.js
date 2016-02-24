var url = "http://tao.jia360.com/data/html/multiScreen/christmas/";
//var url = "http://local.weixin/data/html/multiScreen/christmas/";
if (window.applicationCache) {
document.write('<div class="leftEnter" id="leftEnter">');
document.write('	<div class="chrismasImg"></div>');
document.write('	<div id="chrismasEWM" class="chrismasEWM" style="display: none"></div>');
document.write('	<div class="chrismasTips" style="display:none"></div>');
document.write('</div>');
document.write('<div class="rightEnter" id="rightEnter"></div>');
document.write('<div class="chrismasAnim" id="chrismasAnim">');
document.write('	<img src="'+url+'images/p4_1.png" />');
document.write('</div>');
//document.write('<p>当前模拟key：<span id="key"></span></p>');
//document.write('<p>tips：<span id="tips"></span></p>');
document.write('<div class="chrismasCard" id="chrismasCard">');
document.write('<a class="cardClose"></a>');
document.write('<p>Merry Chrismas 节日快乐</p>');
document.write('<div class="cardImg">');
document.write('<img src="'+url+'images/p2_1.png" class="cardImg1"/>');
document.write('<img src="'+url+'images/p2_2.png" class="cardImg1" />');
document.write('<img src="'+url+'images/p2_3.png" class="cardImg1" />');
document.write('<img src="'+url+'images/p2_4.png" class="cardImg2" />');
document.write('</div>');
document.write('<div class="cardBg"></div>');
document.write('</div>');


var key = Math.random()*999 + 1;
var mobile_url = url + 'mobile.php?key='+key;
WS_STATIC_URL = url+ 'static';
WS_HOST = '115.29.233.98';
//WS_HOST = '127.0.0.1';
WS_PORT = 8088;
$("#key").html(key);
}