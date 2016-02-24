<?php
header("Content-Type: text/html;charset=utf-8");

function sina_weather($city){
	// 天气地址
	$url = 'http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&day=0&city='. $city .'&dfc=1&charset=utf-8';
	// 从新浪获取天气数据
	$file = file_get_contents($url);
	// 从获取的数据中找到城市名
	preg_match_all("@\['(.*)'\]@",$file,$city);
	// 把城市名添加到数组当中
	$weather['city'] = $city[1][0];
	// 从获取的数据中找到天气数据
	preg_match_all("@:'(.*?)'@s",$file,$data);
	// 从新排列所找到的天气数据
	list($weather['s1'], $weather['s2'], $weather['f1'], $weather['f2'], $weather['t1'], $weather['t2'], $weather['p1'], $weather['p2'], $weather['d1'], $weather['d2'], $weather['now'], $weather['time'], $weather['update'], $weather['error'], $weather['total']) = $data[1];
	// 函数返回结果
	return $weather;
}

$city = "北京";
$arr = sina_weather($city);
echo $arr['city'];

/*
返回数组：Array
(
		[city] => 北京
		[total] => 1
		[error] => 0
		[update] => 北京时间11月18日17:05更新
		2014-11-20 23:33:53 => 1416317968
		[now] => 2014-11-18 21:39:28
		[d2] => 无持续风向
		[d1] => 无持续风向
		[p2] => ≤3
		[p1] => ≤3
		[t2] => 0
		[t1] => 13
		[f2] => duoyun
		[f1] => qing
		[s2] => 多云
		[s1] => 晴
)
只能查询当天的天气~
*/
?>