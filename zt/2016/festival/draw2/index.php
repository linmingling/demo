<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';

// 获取未中奖的人员
$mem_sql = "select wxInfo.head_icon,usInfo.user_id,usInfo.name,usInfo.row_num,usInfo.column_num,usInfo.company_nm from $fest_user as usInfo,$fest_weixin as wxInfo where wxInfo.user_id = usInfo.user_id and usInfo.is_prize=0 order by rand() limit 28";
$mem_res = mysqli_query($db, $mem_sql);

$tmp = array();
$i = 0;
$strJson = '';
$str = array();
	$tmp_2 = null;
while($row = $mem_res->fetch_assoc()) {
	$tmp = null;

	$tmp[$i]['id'] = $row['user_id'];
	$tmp[$i]['name'] = $row['name'];
	$tmp[$i]['src'] = $row['head_icon'];
	$tmp[$i]['company_nm'] = $row['company_nm'];
	
	$tmp_2[] = $row;
	
	$strJson .= '{"wxname":"'.$tmp[$i]['name'].'","src":"'.$tmp[$i]['src'].'","id":"'.$tmp[$i]['id'].'","com_nm":"'.$tmp[$i]['company_nm'].'"},';
	$str []= $tmp;
	$i++;
}

//json字符串
$strJson = substr($strJson,0,strlen($strJson)-1); 
$strJson = '['.$strJson.']';
?>

<!DOCTYPE html>	
<html>	
<head>	
    <meta charset="utf-8">	
    <meta name="apple-mobile-web-app-capable" content="yes" />	
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />	
    <meta name="format-detection"content="telephone=no, email=no" />	
    <meta name="renderer" content="webkit">	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">	
    <meta name="HandheldFriendly" content="true">	
    <meta name="MobileOptimized" content="640">	
    <meta name="screen-orientation" content="portrait">	
    <meta name="x5-orientation" content="portrait">	
    <meta name="full-screen" content="yes">	
    <meta name="x5-fullscreen" content="true">	
    <meta name="browsermode" content="application">	
    <meta name="x5-page-mode" content="app">	
    <meta name="msapplication-tap-highlight" content="no">	
    <meta name="viewport" content="width=640,target-densitydpi=device-dpi,maximum-scale=1.0, user-scalable=no">	
    <script type="text/javascript">	
        function setWidth(a) {	
            if (/Andriod/i.test(navigator.userAgent)) {	
                var c, b = window.innerWidth;	
                (b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function () {	
                    var d = document.getElementsByTagName("body")[0];	
                    d.style.webkitTransformOrigin = "left top";	
                    d.style.webkitTransform = "scale(" + c + ")";	
                }, !1)	
            }	
        }	
        setWidth(640);	
    </script>	
    <script>
    	var  imgArr= <?php echo json_encode($tmp_2);?>;
    	var  yongArr=<?php echo $strJson;?>;
		var loadData=[];
   		var mesArr=[];
    	for(var x in yongArr){
     		loadData.push({"path":yongArr[x].src,"name":yongArr[x].id})

    		mesArr.push({"id":yongArr[x].id,"wxname":yongArr[x].wxname}) 
    	}
       
    </script>
		<script src='./libs/lufylegend-1.9.9.min.js' type='text/javascript'></script>
	<script src='./js/jquery-2.1.js' type='text/javascript'></script>
	<!--<script src='./js/LoadingData.js' type='text/javascript'></script>-->
	<script src='./js/plugin.js' type='text/javascript'></script>
	<script src='./js/sha1.js' type='text/javascript'></script>
	<script src='./js/Utils.js' type='text/javascript'></script>
    <script src="./js/bg.js"></script>									
		<script src='./js/Main.js' type='text/javascript'></script>
 	
    <title>二等奖</title>	
	<style>	
		*{ overflow: hidden;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;margin:0; padding:0;}	
		.hor{display: -webkit-box;display: -ms-flexbox;-webkit-box-orient:horizontal;-ms-flex-direction:row;-webkit-box-pack: center;-ms-flex-pack: center;-webkit-box-align: center;-ms-flex-align: center;}	
		.ver{display: -webkit-box;display: -ms-flexbox;-webkit-box-orient:vertical;-ms-flex-direction:column;-webkit-box-pack: center;-ms-flex-pack: center;-webkit-box-align: center;-ms-flex-align: center;}	
		#loading{position: absolute;z-index: 2;top: 0;bottom: 0;left: 0;right: 0;}	
		body{background:url(images/bg.jpg) no-repeat;background-size:170%;background-position-x: center;width: 100%;height: 100%;}
    		.mesModule{display:none;position: fixed;z-index: 9999;width: 770px;height: 300px;left: 50%;top: 50%;margin-left:-385px;margin-top: -120px;margin-top: -150px;}
			.mesModule h1{text-align: center;font-size: 40px;margin-bottom: 30px;}
			.mesDivWra{margin: 0 auto;margin-left:200px;}
			.mesDivWra div{width: 150px;text-align: left;font-size: 40px;text-align: center;line-height: 60px;float: left;}
    </style>	
</head>	
	
<body>	
		<div class="mesModule">
			<div class="mesDivWra" style="width: 300px;">
			</div>
			
		</div>	
		<div id="loading" class="ver"></div>	
			<div id="legend"></div>		
</body>	
</html>	