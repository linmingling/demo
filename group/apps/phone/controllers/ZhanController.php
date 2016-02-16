<?php
namespace Apps\Phone\Controllers;

use \Library\Com\LibSms;

class ZhanController extends ControllerBase {
	private $verifyFlag = 3; // 1: 发送短信，不使用图片验证码。 2: 发送短信，使用图片验证码。 3: 不发送短信，不使用图片验证码
	
	private function CityBox(){
		$data = array();
		$tmp = $this->group->fetchAll("select * from region",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$data[$k['region_id']] = $k;
		}
		return $data;
	}
	
	private function ZhanCity($zhanId, $type){
		$data = array();
		if($zhanId){
			$db = $this->group;
			$where = $type == 2 ? " and fy_show = '1'" : " and ph_show = '1'";
			$tmp = $db->fetchAll("select c_id,city_id from zhan_city where zhan_id = $zhanId $where",\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k){
				$tmp = $db->fetchOne("select * from region where region_id = '".$k['city_id']."'",\Phalcon\Db::FETCH_ASSOC);
				$data[$k['c_id']] = array('c_id'=>$k['c_id'],'zhan_id'=>$zhanId,'city_id'=>$k['city_id'],'city_name'=>$tmp['region_name'],'city_pinyin'=>$tmp['region_pinyin']);
			}
		}
		return $data;
	}
	
	private function getCityByCode($code){
		$data = $this->group->fetchOne("select * from region where region_pinyin = '".$code."'",\Phalcon\Db::FETCH_ASSOC);
		return $data;
	}
	
	private function getCityLocation($zhanId){
		$db = $this->group;
		$data = array();
		
		$Loc = new \Library\Com\Location();
		$ip = $Loc->getClientIp();
		$address = $Loc->getLocation($ip);

		$lng = $address['content']['point']['x'];
		$lat = $address['content']['point']['y'];
		$province = str_replace('省','',$address['content']['address_detail']['province']);
		$city = str_replace('市','',$address['content']['address_detail']['city']);
		$location = array('ip'=>$ip,'lng'=>$lng,'lat'=>$lat,'province_name'=>$province,'city_name'=>$city);
		
		return $location;
	}
	
	private function getdistance($zhanId, $lat, $lng, $type){
		$db = $this->group;
		$Loc = new \Library\Com\Location();
		$where = $type == 2 ? " and fy_show = '1'" : " and ph_show = '1'";
		$All = $db->fetchAll("select c_id,city_id from zhan_city where zhan_id = $zhanId $where",\Phalcon\Db::FETCH_ASSOC);
		foreach($All as $k){
			$info = $db->fetchOne("select * from region where region_id = '".$k['city_id']."'",\Phalcon\Db::FETCH_ASSOC);
			$data[$k['c_id']] = array(
				'c_id' => $k['c_id'],
				'zhan_id' => $zhanId,
				'city_id' => $k['city_id'],
				'city_name' => $info['region_name'],
				'city_pinyin' => $info['region_pinyin'],
				'province_name' => $db->fetchColumn("select region_name from region where region_id = '".$info['parent_id']."'"),
				'distance' => $Loc->getDistance($lat, $lng, $info['latitude'], $info['longitude']),   //两个经纬度之间的距离
			);
		}
		
		$funs = new \Library\Com\Funs();
		$data = $funs->array_sort($data,'distance');
		return $data;
	}
	
	//type = 1 为平滑, 2为翻页
	private function invite($cId,$type){
		$db = $this->group;
		$step = array(); $itemSort = array(); $itemBox = array(); $imgBox = array(); $sysBox = array();
		
		$tmp = $db->fetchAll("select * from zhan_item where type = '".$type."' and c_id = '".$cId."'",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$itemSort[] = array('id'=>$k['item_id'],'sys'=>$k['sys_default'],'sort'=>$k['item_sort']);
			$itemBox[$k['item_id']] = $k;
			$step[$k['item_id']] = 0;
			if($k['sys_default'] > 0){
				$sysBox[$k['item_id']] = $k;
			}
		}
		
		$tmp = $db->fetchAll("select * from zhan_img where type = '".$type."' and c_id = '".$cId."' and item_id != 0 and item_id IS NOT NULL order by item_id asc,img_sort asc",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			if($k['img_type'] == 1){ //背景图
				$imgBox[$k['item_id']]['bg'] = array('name'=>$k['img_name'],'url'=>$k['img_url'],'click_bmWnd'=>$k['click_bmWnd']);
			}elseif($k['img_type'] == 2){ //产品图
				$row = (int)$itemBox[$k['item_id']]['row'];
				$column = (int)$itemBox[$k['item_id']]['column'];
				if($row && $column){
					if(count($imgBox[$k['item_id']]['list'][$step[$k['item_id']]]) >= $row * $column){
						$step[$k['item_id']] = $step[$k['item_id']] + 1;
					}
					$imgBox[$k['item_id']]['list'][$step[$k['item_id']]][] = array('name'=>$k['img_name'],'url'=>$k['img_url'],'sort'=>$k['img_sort'],'click_bmWnd'=>$k['click_bmWnd']);
				}else{
					$imgBox[$k['item_id']]['list'][] = array('name'=>$k['img_name'],'url'=>$k['img_url'],'click_bmWnd'=>$k['click_bmWnd']);
				}
			}
		}
		
		$funs = new \Library\Com\Funs();
		$itemSort = $funs->array_sort($itemSort,'sort');
		
		return array('itemSort'=>$itemSort,'itemBox'=>$itemBox,'imgBox'=>$imgBox,'sysBox'=>$sysBox);
	}
	
	/**
	 * 倒计时格式化
	 * @param string $endtime
	 * @return string
	 */
	private function ctime($starttime)
	{
		$second = strtotime($starttime) - time();
		$day=floor($second/(3600*24));
		$second = $second%(3600*24);
		$hour = floor($second/3600);
		$second = $second%3600;
		$minute = floor($second/60);
		$second = $second%60;
		if($day>0){
			return "距开始还剩".$day."天";
		}
		return false;
	}
	
	private function getListCityDistance($lat, $lng)
	{
		$db = $this->group;
		$Loc = new \Library\Com\Location();
		
		$sql = "select a.c_id,a.city_id,a.endtime from zhan_city a left join zhan_list b on a.zhan_id=b.zhan_id where  b.endtime>'" . date('Y-m-d H:i:s') . "' and b.starttime<'" . date('Y-m-d H:i:s') . "' and b.show='1' and (a.ph_show = '1' or a.fy_show = '1')";
		$All = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);

		foreach($All as $k=>$v){
			//分站活动是否已结束
			if(!is_null($v['endtime']) && $v['endtime']<date('Y-m-d H:i:s'))
			{
				unset($All[$k]);
				continue;
			}
			
			$info = $db->fetchOne("select * from region where region_id = '".$v['city_id']."'",\Phalcon\Db::FETCH_ASSOC);
			$data[$v['c_id']] = array(
					'c_id' => $v['c_id'],
					'zhan_id' => $zhanId,
					'region_id' => $v['city_id'],
					'region_name' => $info['region_name'],
					'region_pinyin' => $info['region_pinyin'],
					'province_name' => $db->fetchColumn("select region_name from region where region_id = '".$info['parent_id']."'"),
					'distance' => $Loc->getDistance($lat, $lng, $info['latitude'], $info['longitude']),   //两个经纬度之间的距离
			);
		}
		
		$funs = new \Library\Com\Funs();
		$data = $funs->array_sort($data,'distance');
		return $data;
	}
	
	private function getCityList()
	{
		$db = $this->group;
		
		$sql = "select a.c_id,a.city_id,a.endtime from zhan_city a left join zhan_list b on a.zhan_id=b.zhan_id where  b.endtime>'" . date('Y-m-d H:i:s') . "' and b.starttime<'" . date('Y-m-d H:i:s') . "' and b.show='1' and (a.ph_show = '1' or a.fy_show = '1') group by a.city_id";
		$All = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		foreach($All as $k=>$v){
			//分站活动是否已结束
			if(!is_null($v['endtime']) && $v['endtime']<date('Y-m-d H:i:s'))
			{
				unset($All[$k]);
				continue;
			}
			
			$info = $db->fetchOne("select * from region where region_id = '".$v['city_id']."'",\Phalcon\Db::FETCH_ASSOC);
			$data[$v['c_id']] = array(
					'region_name' => $info['region_name'],
					'region_pinyin' => $info['region_pinyin']
			);
		}
		
		return $data;
	}
	
	private function getABT($zhanId)
	{
		$sql = "select * from zhan_abtest where zhan_id = '{$zhanId}' order by id asc";
		$list = $this->group->fetchAll($sql);
		if(!empty($list))
		{
			$count = count($list);
			$arrMer = array();
			for($i = 0; $i < $count;)
			{
				$flow = substr($list[$i]['flow'] , 0 , -1);
				$arrMer = array_merge(array_fill( 0 , $flow , $i ),$arrMer);
				$i++;
			}
			
			shuffle($arrMer);
			
			$persent = mt_rand(0,count($arrMer) - 1);
			
			//获取场景
			$scene = $list[$arrMer[$persent]];
			$scene['scene_num'] = $arrMer[$persent];
			return $scene;
		}
		else 
		{
			return false;
		}
		
	}
	
	public function indexAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		header("Location:/phone/zhan/list");
	}
	
	//我的展会
	public function myactAction(){
		//if($_GET['phone']){
		//	$phone = $_GET['phone'];
		//}else{
			$this->wxlogin(); $phone = $this->session->get('user_phone');
		//}
		if(!$phone){
			$url = $this->config['payDomain']."/phone/login?backurl=".urlencode("http://group.yoju360.com/phone/zhan/myact");
			header('Location:'.$url);
		}
		$db = $this->group; $str = ""; $time = date("Y-m-d H:i:s"); $actionInfo = array();
		
		$regInfo = $db->fetchAll("select c_id from zhan_register where phone = '".$phone."'",\Phalcon\Db::FETCH_ASSOC);
		foreach($regInfo as $k){
			$str .= ($str == "" ? "" : ",").$k['c_id'];
		}
		if($str != ""){
			$sql = "select a.*,b.zhan_name,b.starttime as begintime,b.act_type,b.sort from zhan_city a left join zhan_list b on a.zhan_id=b.zhan_id where a.c_id in (".$str.")";
			$sql .= " and b.endtime>'".$time."' and b.starttime<'".$time."' and b.show='1' order by b.sort asc,starttime asc";
			$tmp = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k){
				if(is_null($k['starttime'])){
					$timeStr = $this->ctime($k['begintime']);
					$k['time_str'] = $timeStr ? $timeStr : '';
					$k['act_title'] = "【" . date('n月j日',strtotime($k['begintime'])) . "】" . ($k['title'] =='' ? $k['zhan_name']:$k['title']);
				}else{
					$timeStr = $this->ctime($v['starttime']);
					$k['time_str'] = $timeStr ? $timeStr : '';
					$k['act_title'] = "【" . date('n月j日',strtotime($k['starttime'])) . "】" . ($k['title'] =='' ? $k['zhan_name']:$k['title']);
				}
				$sql_1 = "select count(1) from zhan_register where zhan_id = '".$k['zhan_id']."' and c_id = '".$k['c_id']."'";
				$k['reg_num'] = $db->fetchColumn($sql_1) + $k['init_num'];
				
				$sql_2 = "select img_name from zhan_img where zhan_id = '".$k['zhan_id']."' and c_id = '".$k['c_id']."' and img_type = '3'";
				$k['head_img'] =  $db->fetchColumn($sql_2);
				$actionInfo[] = $k;
			}
		}
		
		$this->view->setVar("actioninfo", $actionInfo);
		$this->view->pick("zhan/myact");
	}
	
	//列表
	public function listAction()
	{
		$db = $this->group;
		
		if(!$_GET['city'])
		{
			//当前城市定位
			$Location = $this->getCityLocation();
			
			//获取定位城市信息
			$sql = "select * from region where region_name = '{$Location['city_name']}'";
			$locationInfo = $db->fetchOne($sql);
			$cityInfo = array_slice($this->getListCityDistance($Location['lat'], $Location['lng']),0,1)[0];
		}
		else 
		{
			$cityInfo = $this->getCityByCode($_GET['city']); 
			if(empty($cityInfo))
			{
				header("Location:http://". $_SERVER['SERVER_NAME'] . "/phone/zhan/list");die;
			}
		}
		
		//获取所选城市的活动信息
		$sql = "select a.*,b.zhan_name,b.starttime as begintime,b.act_type,b.sort from zhan_city a left join zhan_list b on a.zhan_id=b.zhan_id where a.city_id = '{$cityInfo['region_id']}' and b.endtime>'" . date('Y-m-d H:i:s') . "' and b.starttime<'" . date('Y-m-d H:i:s') . "' and b.show='1'  order by b.sort asc,starttime asc";
		$actionInfo = $db->fetchAll($sql);

		
// 		print_r($actionInfo);exit();
		if(count($actionInfo) == 1){
			$t = $actionInfo[0]['locat_type'] == 1 ? 'phinvite' : 'fyinvite';
			header("Location:/phone/zhan/".$t."/".$actionInfo[0]['zhan_id']);
		}
		
		if(!empty($actionInfo))
		{
			foreach ($actionInfo as $k=>$v)
			{
				//分站活动是否已结束
				if(!is_null($v['endtime']) && $v['endtime']<date('Y-m-d H:i:s'))
				{
					unset($actionInfo[$k]);
					continue;
				}
				
				//活动名称和时间
				if(is_null($v['starttime']))
				{
					$actionInfo[$k]['act_title'] = "【" . date('n月j日',strtotime($v['begintime'])) . "】" . ($v['title'] =='' ? $v['zhan_name']:$v['title']);
					$timeStr = $this->ctime($v['begintime']);
					$actionInfo[$k]['time_str'] = $timeStr ? $timeStr : '';
					
				}
				else 
				{
					$actionInfo[$k]['act_title'] = "【" . date('n月j日',strtotime($v['starttime'])) . "】" . ($v['title'] =='' ? $v['zhan_name']:$v['title']);
					$timeStr = $this->ctime($v['starttime']);
					$actionInfo[$k]['time_str'] = $timeStr ? $timeStr : '';
				}

				//已报名人数
				$sql = "select count(1) from zhan_register where zhan_id = '{$v['zhan_id']}' and c_id = '{$v['c_id']}'";
				$actionInfo[$k]['reg_num'] = $db->fetchColumn($sql) + $v['init_num'];
				
				//活动列表图片
				if(empty($v['fy_goto']))		//平滑
				{
					$actionInfo[$k]['locat_type'] =  1;
				}
				else 		//翻页
				{
					$actionInfo[$k]['locat_type'] =  2;
				}
				$sql = "select img_name from zhan_img where zhan_id = '{$v['zhan_id']}' and c_id = '{$v['c_id']}' and img_type = '3'";
				$imgName = $db->fetchColumn($sql);
				$actionInfo[$k]['head_img'] =  $imgName;
				
			}
			
			//没有任何活动信息
			if(empty($actionInfo))
			{
				//header("Location:http://". $_SERVER['SERVER_NAME'] . "/phone/zhan/list");die;
// 				die('活动信息已过期');
				$actionInfo = array();
			}
		}
		else 
		{
// 			die('没有任何活动信息');
// 			header("Location:http://". $_SERVER['SERVER_NAME'] . "/phone/zhan/list");die;
			$actionInfo = array();
		}
		
		//城市列表
		$cityList = $this->getCityList();
		
		$this->view->setVar("actioninfo", $actionInfo);
		$this->view->setVar("citylist", $cityList);
		$this->view->setVar("locatcity", $cityInfo);
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->pick("zhan/index");
		
	}
	
	//翻页
	public function fyinviteAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("verifyFlag", $this->verifyFlag);
		
		$zhanId = $this->dispatcher->getParam(0,'int');
		$db = $this->group;
		$from = $_GET['from'];
		$cityCode = $_GET['city'];
		
		$Location = $this->getCityLocation($zhanId);
		if(!$cityCode){
			$zhanCity = $this->getdistance($zhanId,$Location['lat'],$Location['lng'],2);
			$tmp = array_slice($zhanCity,0,1); $cId = $tmp[0]['c_id']; $cityPinyin = $tmp[0]['city_pinyin'];
		}else{
			$specifiedCity = $this->getCityByCode($cityCode); $cityPinyin = $specifiedCity['region_pinyin'];
			$cId = $db->fetchColumn("select c_id from zhan_city where zhan_id = $zhanId and city_id = '".$specifiedCity['region_id']."'");
			$zhanCity = $this->ZhanCity($zhanId,2);
		}
		$info = $db->fetchOne("select b.zhan_name,b.show as zhan_show,b.logo1,b.logo2,a.* from zhan_city as a left join zhan_list as b on a.zhan_id = b.zhan_id where a.c_id = '".$cId."'",\Phalcon\Db::FETCH_ASSOC);
		if(!$info) exit("该活动不存在3");
		if(!$cityCode){ // 没指定城市需检查是否显示
			if(!$info['fy_show'] && $info['ph_show']) header("/phone/zhan/phinvite/$zhanId?city=".$cityPinyin);
			if(!$info['fy_show'] && !$info['ph_show']) exit("该活动不存在4");
		}
		
		$data = $this->invite($cId,2);
		
		$bmNum = $db->fetchColumn("select count(*) from zhan_register where c_id = '".$cId."'");
		$info['tobm_txt_2'] = str_replace("{{num}}","<span>".($bmNum+$info['init_num'])."</span>",$info['tobm_txt_2']);
		$info['tobm_txt_2'] = str_replace("[[num]]","<span>".($bmNum+$info['init_num'])."</span>",$info['tobm_txt_2']);
		
		//微信分享小图
		$wxImg = $db->fetchColumn("select img_name from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '5'");
		
		//抵扣卷
		$dikouImg = $db->fetchOne("select * from zhan_img where type='2' and c_id = '".$cId."' and img_type = '6'",\Phalcon\Db::FETCH_ASSOC);
		
		//成功页广告
		$successImg = $db->fetchAll("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '4'",\Phalcon\Db::FETCH_ASSOC);

		//成功页背景图
		$successBg = $db->fetchAll("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '8'",\Phalcon\Db::FETCH_ASSOC);
		
		//ABT场景
		if(isset($_COOKIE['fy_abtest'])){
			$tabName = $_COOKIE['fy_abtest'];
		}else {
			$abt = $this->getABT($zhanId);
			$tabName = $abt ? ($abt['scene'] == 1 ? 'T0' : 'T1') : 'T0';
// 			setcookie('fy_abtest',$tabName,time()+120);		//测试时间
			setcookie('fy_abtest',$tabName,time()+24*3600);		//生产时间
		}
		$this->view->setVar("tab_name", $tabName);
		
		//微信分享
		$jssdk = new \Library\Com\JSSDK();
        $this->view->setVar("signPackage", $jssdk->GetSignPackage());
		
		$info['sponsor'] = "主办单位：".$info['sponsor'];
		$logo = $info['logo1'];
		if(preg_match("/^2.*/",$from) || preg_match("/^nologo.*/",$from)){
			$logo = $info['logo2'];
			$info['sponsor'] = str_replace("腾讯家居","",$info['sponsor']);
		}
		if(isset($_GET['domain'])){ 
			if($_GET['domain'] == "a"){ //group.zucai310.com.cn
				$info['sponsor'] = "版权：深圳前海优品优居网络科技有限公司";
			}elseif($_GET['domain'] == "b"){  //group.yoju360.net
				$info['sponsor'] = "版权：优品优居网络科技有限公司";
			}elseif($_GET['domain'] == "c"){
				$info['sponsor'] = "版权：广州沈洋家具有限公司";
			}
		}
		
		$this->view->setVars($data);
		$this->view->setVars(array('info'=>$info,'location'=>$Location,'specifiedCity'=>$specifiedCity,'zhanCity'=>$zhanCity,'from'=>$from,'bmNum'=>$bmNum,'wxImg'=>$wxImg,'dikouImg'=>$dikouImg,'successImg'=>$successImg,'successBg'=>$successBg,'logo'=>$logo));	
	}
	
	//平滑页
	public function phinviteAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("verifyFlag", $this->verifyFlag);
		
		$zhanId = $this->dispatcher->getParam(0,'int');
		$db = $this->group;
		$from = $_GET['from'];
		$cityCode = $_GET['city'];
		
		$Location = $this->getCityLocation($zhanId);
		if(!$cityCode){
			$zhanCity = $this->getdistance($zhanId,$Location['lat'],$Location['lng'],1);
			$tmp = array_slice($zhanCity,0,1); $cId = $tmp[0]['c_id']; $cityPinyin = $tmp[0]['city_pinyin'];
		}else{
			$specifiedCity = $this->getCityByCode($cityCode); $cityPinyin = $specifiedCity['region_pinyin'];
			$cId = $db->fetchColumn("select c_id from zhan_city where zhan_id = $zhanId and city_id = '".$specifiedCity['region_id']."'");
			$zhanCity = $this->ZhanCity($zhanId,1);
		}
		
		$info = $db->fetchOne("select b.zhan_name,b.show as zhan_show,b.logo1,b.logo2,a.* from zhan_city as a left join zhan_list as b on a.zhan_id = b.zhan_id where a.c_id = '".$cId."'",\Phalcon\Db::FETCH_ASSOC);
		if(!$info) exit("该活动不存在1");
		if (!$cityCode){ //指定了城市则按城市直接显示活动，否则
			if($info['fy_show'] && !$info['ph_show']) header("/phone/zhan/fyinvite/$zhanId?city=".$cityPinyin);
			if(!$info['fy_show'] && !$info['ph_show']) exit("该活动不存在2");
		}
		
		$data = $this->invite($cId,1);
		
		$bmNum = $db->fetchColumn("select count(*) from zhan_register where c_id = '".$cId."'");
		$info['tobm_txt_1'] = str_replace("{{num}}","<span>".($bmNum+$info['init_num'])."</span>",$info['tobm_txt_1']);
		$info['tobm_txt_1'] = str_replace("[[num]]","<span>".($bmNum+$info['init_num'])."</span>",$info['tobm_txt_1']);
		
		//微信分享小图
		$wxImg = $db->fetchColumn("select img_name from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '5'");
		
		//抵扣卷
		$dikouImg = $db->fetchOne("select * from zhan_img where type='1' and c_id = '".$cId."' and img_type = '6'",\Phalcon\Db::FETCH_ASSOC);
		
		//成功页广告
		$successImg = $db->fetchAll("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '4'",\Phalcon\Db::FETCH_ASSOC);

		//成功页背景图
		$successBg = $db->fetchAll("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '8'",\Phalcon\Db::FETCH_ASSOC);

		//ABT场景
		if(isset($_COOKIE['ph_abtest'])){
			$tabName = $_COOKIE['ph_abtest'];
		}else{
			$abt = $this->getABT($zhanId);
			$tabName = $abt ? ($abt['scene'] == 1 ? 'T0' : 'T1') : 'T0';
			setcookie('ph_abtest',$tabName,time()+120);			//测试时间
// 			setcookie('ph_abtest',$tabName,time()+24*3600); 		//生产时间
		}
		$this->view->setVar("tab_name", $tabName);
		
		//微信分享
		$jssdk = new \Library\Com\JSSDK();
        $this->view->setVar("signPackage", $jssdk->GetSignPackage());
		
		$info['sponsor'] = "主办单位：".$info['sponsor'];
		$logo = $info['logo1'];
		if(preg_match("/^2.*/",$from) || preg_match("/^nologo.*/",$from)){
			$logo = $info['logo2'];
			$info['sponsor'] = str_replace("腾讯家居","",$info['sponsor']);
		}
		
		$this->view->setVars($data);
		$this->view->setVars(array('info'=>$info,'location'=>$Location,'specifiedCity'=>$specifiedCity,'zhanCity'=>$zhanCity,'from'=>$from,'bmNum'=>$bmNum,'wxImg'=>$wxImg,'dikouImg'=>$dikouImg,'successImg'=>$successImg,'successBg'=>$successBg,'logo'=>$logo));
	}
	
	public function registerAction(){
		if($this->request->isPost() == true){
			$post = $this->request->getPost(); $db = $this->group; $data = array();
			
			//判断活动是否结束
			$zhanCity = $db->fetchOne("select * from zhan_city where c_id = '".$post['cId']."'",\Phalcon\Db::FETCH_ASSOC);
			if($zhanCity && $zhanCity['endtime'] && $zhanCity['endtime'] < date('Y-m-d H:i:s')) die(json_encode(array('code'=>0,'msg'=>'该城市活动已经结束')));
			
			if($post['cId'] && (int)$post['step'] == 1){
				if ($this->verifyFlag == 2) { //有图片验证码
					if(!$post['captcha']) die(json_encode(array('code'=>6,'msg'=>'验证码不正确')));
					$key = 'zhan_captcha_'.$post['captcha'];
					if(!$this->redis->exists($key)){
						die(json_encode(array('code'=>6,'msg'=>'验证码不正确')));
					}
				}
				
				$type = (int)$post['type'];
				$info = $db->fetchOne("select * from zhan_register where c_id = '".$post['cId']."' and phone = '".trim($post['phone'])."'",\Phalcon\Db::FETCH_ASSOC);
				if(!$info || ($type == 1 && $zhanCity['ph_register'] == 2) || ($type == 2 && $zhanCity['fy_register'] == 2) ){
					//判断是否在其他城市报过名
					$isOtherBm = $db->fetchOne("select * from zhan_register where zhan_id = '".$info['zhan_id']."' and phone = '".trim($post['phone'])."'",\Phalcon\Db::FETCH_ASSOC);
					
					$Loc = new \Library\Com\Location();
					$ip = $Loc->getClientIp();
					$address = $Loc->getLocation($ip);
					$phoneLocation = \Library\Com\Funs::phoneLocation(trim($post['phone']));
					
					$data['zhan_id'] = $db->fetchColumn("select zhan_id from zhan_city where c_id = '".$post['cId']."'");
					$data['c_id'] = $post['cId'];
					$data['btn_id'] = $post['btnId'];
					$data['type'] = $post['type'];
					$data['name'] = trim($post['name']);
					$data['phone'] = trim($post['phone']);
					$data['phone_province'] = $phoneLocation['province'];
					$data['phone_city'] = $phoneLocation['city'];
					$data['ip'] = $ip;
					$data['ip_province'] = str_replace('省','',$address['content']['address_detail']['province']);
					$data['ip_city'] = str_replace('市','',$address['content']['address_detail']['city']);
					$data['addtime'] = date('Y-m-d H:i:s');
					$data['from'] = trim($post['from']);
					if(($type == 1 && $zhanCity['ph_register'] == 2) || ($type == 2 && $zhanCity['fy_register'] == 2)){
						if($isOtherBm){
							$db->execute("update zhan_register set c_id = '".$post['cId']."' where zhan_id = '".$info['zhan_id']."' and phone = '".trim($post['phone'])."'");
						}else{
							$sql = "insert into zhan_register(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
							$db->execute(str_replace("'NULL'","NULL",$sql));
						}
						$cityName = $db->fetchColumn("select region_name from region where region_id = '".$zhanCity['city_id']."'");
						$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = '".$zhanCity['zhan_id']."'");
						$url = $this->config->crm_host . '/pc/api/user/'.md5(md5('yoju360_crm').'add'.date('Y-m-d')).'/add';
						$data = '{"groupName": "'.$zhanName.'","cityName":"'.$cityName.'","isAuth":"0","phone":"'.$data['phone'].'","name":"'.$data['name'].'","address":""}';
						$res = \Library\Com\Funs::curlPOST($url, $data);						
						
						die(json_encode(array('code'=>5,'msg'=>'快速注册成功')));
					}
					if(!$isOtherBm){
						$sql = "insert into zhan_register(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
						$db->execute(str_replace("'NULL'","NULL",$sql));
						
						$cityName = $db->fetchColumn("select region_name from region where region_id = '".$zhanCity['city_id']."'");
						$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = '".$zhanCity['zhan_id']."'");
						$url = $this->config->crm_host . '/pc/api/user/'.md5(md5('yoju360_crm').'add'.date('Y-m-d')).'/add';
						$data = '{"groupName": "'.$zhanName.'","cityName":"'.$cityName.'","isAuth":"0","phone":"'.$data['phone'].'","name":"'.$data['name'].'","address":""}';
						$res = \Library\Com\Funs::curlPOST($url, $data);
						
						if ($this->verifyFlag == 3) //跳到填写地址step3
							die(json_encode(array('code'=>7,'msg'=>'添加成功')));
						else 
							die(json_encode(array('code'=>1,'msg'=>'添加成功')));
					}else{
						if ($this->verifyFlag == 3) //跳到填写地址step3
							die(json_encode(array('code'=>7,'msg'=>'添加成功')));
						else
							die(json_encode(array('code'=>2,'info'=>$isOtherBm,'msg'=>'添加成功,您在其它城市已经报过名了')));
					}
				}elseif((int)$info['auth'] == 0){
					if ($this->verifyFlag == 3) //跳到填写地址step3
						die(json_encode(array('code'=>7,'msg'=>'添加成功')));
					else
						die(json_encode(array('code'=>3,'info'=>$info,'msg'=>'已报过名，但未验证')));
				}elseif((int)$info['auth'] == 1){
					$this->session->set('g_zhan_bm',$info['reg_id']);
					die(json_encode(array('code'=>4,'info'=>$info,'msg'=>'已报过名且已验证')));
				}
			}elseif($post['cId'] && (int)$post['step'] == 2){
				if ($this->verifyFlag == 3) { //手机没验证，不发送成功短信，防止被刷
					die(json_encode(array('code'=>7,'msg'=>'step3: enter address info')));
				} else { //有短信验证码
					if($post['phone'] && $post['cId'] && $post['code']){
						$code = $this->cache->get($post['phone']."_".$post['cId']."_code");
						if($code == $post['code']){
							$regInfo = $db->fetchOne("select * from zhan_register where zhan_id = '".$zhanCity['zhan_id']."' and phone = '".trim($post['phone'])."'",\Phalcon\Db::FETCH_ASSOC);
							if($regInfo){
								$db->execute("update zhan_register set auth = '1',c_id = '".$post['cId']."' where reg_id = '".$regInfo['reg_id']."'");
								
								//发送报名成功短信
								$smsBm = $db->fetchColumn("select sms_bm_".$regInfo['type']." from zhan_city where c_id = '".$post['cId']."'");
								$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = '".$zhanCity['zhan_id']."'");
								if($smsBm && $zhanName){
									LibSms::sendSms('http://sms.yoju360.net/api/send.do', 'act', '316c9c3ed45a83ee318b1f859d9b8b79', $zhanName, $post['phone'], $smsBm, 0, 1);
								}						
								
								die(json_encode(array('code'=>1,'msg'=>'验证成功')));
							}
							die(json_encode(array('code'=>2,'msg'=>'请重新填写手机号')));
						}
						die(json_encode(array('code'=>3,'msg'=>'验证码错误')));
					}
				}
			}elseif($post['cId'] && (int)$post['step'] == 3){
				if($post['phone'] && $post['cId']){
					$regInfo = $db->fetchOne("select * from zhan_register where zhan_id = '".$zhanCity['zhan_id']."' and phone = '".trim($post['phone'])."'",\Phalcon\Db::FETCH_ASSOC);
					if($regInfo){
						$data['c_id'] = $post['cId'];
						if($post['area']) $data['addr_district'] = $post['area'];
						if($post['address']) $data['address'] = trim($post['address']);
						if($post['buy']) $data['buy_type'] = $post['buy'];
						$str = ""; foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = ".($v == 'NULL' ? "NULL" : "'".$v."'");
						$db->execute("update zhan_register set $str where reg_id = '".$regInfo['reg_id']."'");
						$this->session->set('g_zhan_bm',$regInfo['reg_id']);
						
						$cityName = $db->fetchColumn("select region_name from region where region_id = '".$zhanCity['city_id']."'");
						$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = '".$zhanCity['zhan_id']."'");
						$url = $this->config->crm_host . '/pc/api/user/'.md5(md5('yoju360_crm').'add'.date('Y-m-d')).'/add';
						$data = '{"groupName": "'.$zhanName.'","cityName":"'.$cityName.'","isAuth":"1","phone":"'.$post['phone'].'","name":"'.$regInfo['name'].'","address":"'.$data['address'].'"}';
						$res = \Library\Com\Funs::curlPOST($url, $data);
						
						die(json_encode(array('code'=>1,'regId'=>$regInfo['reg_id'],'msg'=>'成功')));
					}
				}
			}
		}
		die(json_encode(array('code'=>0,'msg'=>'参数出错')));
	}

	public function verifyAction(){
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			if($post['cId'] && $post['phone']){
				if ($this->verifyFlag == 2) {
					if(!$post['captcha']) die(json_encode(array('code'=>2,'msg'=>'验证码不正确')));
					
					$key = 'zhan_captcha_'.$post['captcha'];
					if($this->redis->exists($key)){
						$this->redis->del($key);
					}else{
						die(json_encode(array('code'=>2,'msg'=>'验证码不正确')));
					}
				}
				
				if ($this->verifyFlag != 3) {
					$zhanName = $this->group->fetchColumn("select b.zhan_name from zhan_city as a left join zhan_list as b on a.zhan_id = b.zhan_id where a.c_id = '".$post['cId']."'");
				
					$code = mt_rand(10000,99999);
					$this->cache->save($post['phone']."_".$post['cId']."_code",$code,300);
					LibSms::sendSms('http://sms.yoju360.net/api/send.do', 'act', '316c9c3ed45a83ee318b1f859d9b8b79', $zhanName, $post['phone'], "【腾讯优居】您的短信验证码是：".$code);
					die(json_encode(array('code'=>1,'msg'=>'验证码发送成功')));
				}
			}
		}
		die(json_encode(array('code'=>0,'msg'=>'参数出错')));
	}

	public function districtbycityidAction(){
		$cityId = $this->dispatcher->getParam(0,'int');
		
		$data = array();
		$cityBox = $this->CityBox();
		if($cityId && $cityBox){
			foreach($cityBox as $k){
				if($k['parent_id'] == $cityId) $data[$k['region_id']] = $k;
			}
			die(json_encode(array('code'=>1,'msg'=>$data)));
		}
		die(json_encode(array('code'=>0,'msg'=>'参数出错')));
	}
	
	public function budianAction(){
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			if($post['btnId'] && $post['zhanId'] && $post['cId'] && $post['type']){
				$this->group->execute("insert into zhan_budian(`btn_id`,`zhan_id`,`c_id`,`type`,`url_source`,`add_time`) values('".$post['btnId']."','".$post['zhanId']."','".$post['cId']."','".$post['type']."','".$post['from']."','".date('Y-m-d H:i:s')."')");
				die(json_encode(array('code'=>1,'msg'=>'布点数据添加成功')));
			}
		}
		die(json_encode(array('code'=>0,'msg'=>'参数出错')));
	}

	public function captchaAction() {
		//$string = "abcdefghijklmnopqrstuvwxyz0123456789";
		$string = "0123456789";
		$str = "";
		for($i=0;$i<4;$i++){
			//$pos = rand(0,35);
			$pos = rand(0,9);
			$str .= $string{$pos};
		}
		$img_handle = Imagecreate(80, 20);  //图片大小80X20
		$back_color = ImageColorAllocate($img_handle, 255, 255, 255); //背景颜色（白色）
		$txt_color = ImageColorAllocate($img_handle, 0,0, 0);  //文本颜色（黑色）
	
		//加入干扰线
		for($i=0;$i<3;$i++)
		{
			$line = ImageColorAllocate($img_handle,rand(0,255),rand(0,255),rand(0,255));
			Imageline($img_handle, rand(0,15), rand(0,15), rand(100,150),rand(10,50), $line);
		}
		//加入干扰象素
		for($i=0;$i<200;$i++)
		{
			$randcolor = ImageColorallocate($img_handle,rand(0,255),rand(0,255),rand(0,255));
			Imagesetpixel($img_handle, rand()%100 , rand()%50 , $randcolor);
		}
		Imagefill($img_handle, 0, 0, $back_color);             //填充图片背景色
		ImageString($img_handle, 28, 10, 0, $str, $txt_color);//水平填充一行字符串
		ob_clean();   // ob_clean()清空输出缓存区
		header("Content-type: image/png"); //生成验证码图片
		Imagepng($img_handle);//显示图片
	
		$this->redis->setex("zhan_captcha_".$str, 300, 1);
		$this->view->disable();
	}
}


?>