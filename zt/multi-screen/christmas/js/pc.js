$(function(){
	//生成二维码
	jQuery('#qrcodeTable').qrcode({
		render:"table",
		text:"http://tao.jia360.com/data/html/multiScreen/aqgy/mobile/index.php?key=1415762258",
	});	
});