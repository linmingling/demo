<?php
namespace Apps\Phone\Controllers;

use Library\Com\Funs;

class YizhangouController extends ControllerBase {
	
	private $appId = "wxd43f7b5d8539e718";
	private $appSecret = "a42b85c54c3e79b709023df894f42778";
	private $wxToken = "ubtaeo1422330200";
	

	public function onConstruct(){
		
	}

	public function indexAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		//$this->wxlogin();
		$id = $this->dispatcher->getParam(0,'int');
		if(!$id){
			//$defaultCity = 321; //默认城市 广州
			$id = $this->group->fetchColumn("SELECT a.group_id FROM yizhangou_list AS a LEFT JOIN yizhangou_regions AS b ON a.group_id = b.id WHERE a.hide = '1' AND b.hide = '1'");
			//$id = $this->group->fetchColumn("select id from yizhangou_regions where id = $groupid");
		}
		
		$E = new \Library\Model\Ext();
		$regions = $E->regions();
		$tmp = $this->group->fetchAll("select * from yizhangou_regions where hide = '1' and (endtime > '".date('Y-m-d H:i:s')."' or endtime is NULL)",\Phalcon\Db::FETCH_ASSOC);
		$city = array();
		foreach($tmp as $k){
			$city[$k['id']] = array('headimg'=>$k['headimg'],'cityname'=>$regions['list'][$k['region']]);
		}
		
		$marquee = array();
		$data = array();
		$tmp = $this->group->fetchAll("select * from yizhangou_list where group_id = $id and hide = '1' order by sort asc",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$k['subjectimg'] = json_decode($k['subjectimg'],true);
			$k['day'] = $k['starttime'] > date('Y-m-d H:i:s') ? (int)((strtotime($k['starttime']) - time())/86400) : 0;
			$k['starttimeStr'] = date("【n月d日】",strtotime($k['starttime']));
			$k['bmNum'] = $this->group->fetchColumn("select count(*) from yizhangou_baoming where action_id = ".$k['id']);
			$data[] = $k;
		}
		
		$tmp = $this->group->fetchAll("select * from yizhangou_list where endtime >= '".date('Y-m-d')."' and group_id = $id and hide = '1'",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			if($k['starttime'] <= date('Y-m-d H:i:s')) $marquee[$k['id']] = $k['name'];
		}
		if(count($marquee) > 0) $this->view->marquee = $marquee;
		
		$tmp = $this->group->fetchAll("select id,tag from yizhangou_tag where group_id = $id",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k) $tag[$k['id']] = $k['tag'];
		
		
		
		$this->view->setVars(array('id'=>$id,'city'=>$city,'tag'=>$tag,'data'=>$data));
	}
	
	
	public function inviteAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		
		//$this->wxlogin();
		$id = $this->dispatcher->getParam(0,'int');
		//if($id == 34) $id = 13;

		$data = $this->group->fetchOne("select * from yizhangou_list where id = $id",\Phalcon\Db::FETCH_ASSOC);
		if($data['name'] == '全民家居购'){
			header("Location:http://".$_SERVER['SERVER_NAME']."/phone/zhan/fyinvite/9");
		}
		
		$E = new \Library\Model\Ext();
		$regions = $E->regions();
		
		$tmp = $this->group->fetchAll("select * from yizhangou_list where `name` = '".$data['name']."'",\Phalcon\Db::FETCH_ASSOC);
		
		$location = new \Library\Com\YzgPoint($this->group,$regions);
		$cityname = $location->getCity();
		
		$resetId = 0;
		foreach($regions['list'] as $k=>$v){
			if($cityname['city'] == $v){
				$nowcity = $cityname['location_city'];
				$resetId = $k;break;
			}
		}
		if($_GET['location'] != 1){
			if(count($tmp) > 1){
				if($resetId){
					//if($resetId == 141) $resetId = 343;
					$groupId = $this->group->fetchColumn("select id from yizhangou_regions where region = '".$resetId."'");
					if($groupId){
						$data = $this->group->fetchOne("select * from yizhangou_list where group_id = $groupId and `name` = '".$data['name']."'",\Phalcon\Db::FETCH_ASSOC);
						$id = $data['id'];
					}
				}
			}
		}
		
		$islogin = $this->session->has('user_id') ? $this->session->get('user_id') : false;
		
		$sql = "select a.id,b.region from yizhangou_list as a left join yizhangou_regions as b on a.group_id = b.id where a.hide = '1' and a.name like '".$data['name']."'";
		$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$city[$k['id']] = $regions['list'][$k['region']];
		}
		
		$data['successimg'] = json_decode($data['successimg'],true);
		$data['subjectimg'] = json_decode($data['subjectimg'],true);
		$data['bottomimg'] = json_decode($data['bottomimg'],true);
		$data['logofile'] = json_decode($data['logofile'],true);
		$data['logo2file'] = json_decode($data['logo2file'],true);
		$data['logo3file'] = json_decode($data['logo3file'],true);
		$data['liangfiel'] = json_decode($data['liangfiel'],true);
		$data['item'] = json_decode($data['item'],true);
		$data['address'] = json_decode($data['address'],true);
		
		foreach($data['item'] as $k){
			if($k['sort']) $item[] = array('name'=>base64_decode($k['name']),'sort'=>$k['sort']);
		}
		$item = funs::array_sort($item,'sort');
		
		foreach($data['address'] as $k){
			$address[] = array('name'=>$k['name'],'address'=>$k['address'],'latitude'=>explode(',',$k['latitude']));
		}
		
		//是否已经报过名
		$isbm = $islogin ? $this->group->fetchColumn("select id from yizhangou_baoming where action_id = $id and phone = '".$this->session->get('user_phone')."'") : false;
		
		$row = 0;
		foreach($data['logofile'] as $k){
			if(isset($logoimg[$row]) && count($logoimg[$row]) >= 6) $row++;
			$logoimg[$row][] = $k;
		}
		
		foreach($data['logo2file'] as $k){
			if(isset($logo2img[$row]) && count($logo2img[$row]) >= 6) $row++;
			$logo2img[$row][] = $k;
		}
		
		foreach($data['logo3file'] as $k){
			if(isset($logo3img[$row]) && count($logo3img[$row]) >= 9) $row++;
			$logo3img[$row][] = $k;
		}
		
		foreach($data['liangfiel'] as $k){
			$lianimg[base64_decode($k['item'])][$k['sort']] = array('name'=>$k['name'],'url'=>$k['url']);
		}
		foreach($lianimg as $k=>$v){
			ksort($lianimg[$k]);
		}
		
		$starttime = strtotime($data['starttime']);
		$endtime = strtotime($data['endtime']);
		$dateStr = date('n',$starttime).".".date('j',$starttime)." - ".date('n',$endtime).".".date('j',$endtime);
		
		//报名人数
		$bmNum = $this->group->fetchColumn("select count(id) as num from yizhangou_baoming where action_id = $id and auth = '1'");
		
		$this->view->setVars(array('islogin'=>$islogin,'from'=>$_GET['from'],'isbm'=>$isbm,'bmNum'=>$bmNum,'city'=>$city,'nowcity'=>$nowcity,'dateStr'=>$dateStr,'data'=>$data,'item'=>$item,'address'=>$address,'logoimg'=>$logoimg,'logo2img'=>$logo2img,'logo3img'=>$logo3img,'lianimg'=>$lianimg));
		
		
		$wxAPI = new \Library\Com\WeiXinApi($this->session,$this->wxToken,$this->appId,$this->appSecret);
		$this->view->signPackage = $wxAPI->get_share();
	}
	
	public function successAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		$type = $this->dispatcher->getParam(0);
		$id = $this->dispatcher->getParam(1,'int');
		$bmId = $this->session->get('yizhangou_'.$id.'_bmId');
		
		if(!$bmId) header("Location:/phone/yizhangou/invite/$id");
		$islogin = $this->session->has('user_id') ? $this->session->get('user_id') : false;
		
		$E = new \Library\Model\Ext();
		
		$row = $this->group->fetchOne("select b.region,a.* from yizhangou_list as a left join yizhangou_regions as b on a.group_id = b.id where a.id = $id",\Phalcon\Db::FETCH_ASSOC);
		$tmp = $E->regions(array('id'=>$row['region']));
		$this->view->setVars(array('id'=>$id,'type'=>$type,'province'=>$tmp['id'],'info'=>$row,'city'=>$row['region'],'successimg'=>json_decode($row['successimg'],true),'dikouimg'=>json_decode($row['dikouimg'],true),'name'=>$row['name'],'buy'=>explode('|',$row['buy'])));
		
		if($type == 'modify' && $this->request->isPost() == true){
			$post = $this->request->getPost();
			
			$phone = $this->group->fetchColumn("select phone from yizhangou_baoming where id = $bmId");
			$state = $this->cache->get($phone."_".$row['name']."_bm");
			$rescode = $state == 1 ? 2 : 1;
			
			$set = "";
			if($post['city']) $set .= ($set == "" ? '' : ',') . "`city` = '".$post['city']."'";
			if($post['district']) $set .= ($set == "" ? '' : ',') . "`district` = '".$post['district']."'";
			if($post['address']) $set .= ($set == "" ? '' : ',') . "`address` = '".$post['address']."'";
			if($post['month']) $set .= ($set == "" ? '' : ',') . "`month` = '".$post['month']."'";
			if($post['buy']) $set .= ($set == "" ? '' : ',') . "`buy` = '".$post['buy']."'";
			
			if($set == "") die(json_encode(array('state'=>$rescode,'msg'=>'报名成功')));
			
			$res = $this->group->execute("update yizhangou_baoming set ".$set." where id = $bmId");
			if($res) die(json_encode(array('state'=>$rescode,'msg'=>'地址更新成功')));
			die(json_encode(array('state'=>0,'msg'=>'地址填写失败')));
		}
		
		if($type == 'show'){
			$tmp = $E->regions();
			$this->view->regions = $tmp['list'];
			
			$data = $this->group->fetchOne("select * from yizhangou_baoming where id = $bmId",\Phalcon\Db::FETCH_ASSOC);
			if(!$data['address']){
				if($islogin){
					$U = new \Library\Model\User();
					$tmp = $U->address(array('uid'=>$islogin));
					$sql = "update yizhangou_baoming set `user_id` = '".$islogin."',`city` = '".$tmp['city']."',`district`='".$tmp['district']."',`address`='".$tmp['address']."' where id = $bmId";
					$res = $this->group->execute($sql);
					if(!$tmp['city'] || !$tmp['district'] || !$tmp['address']){
						header("Location:/phone/yizhangou/success/modify/$id");
					}else{
						$addr = array('city'=>$tmp['city'],'district'=>$tmp['district'],'address'=>$tmp['address']);
						$this->view->setVars(array('data'=>$addr));
					}
				}else{
					header("Location:/phone/yizhangou/success/modify/$id");
				}
			}else{
				$addr = array('city'=>$data['city'],'district'=>$data['district'],'address'=>$data['address']);
				$this->view->setVars(array('data'=>$addr));
			}
		}
	}
	
	public function baomingAction(){
		$type = $this->dispatcher->getParam(0);
		$id = $this->dispatcher->getParam(1,'int');
		$db = $this->group;
		
		$islogin = $this->session->has('user_id') ? $this->session->get('user_id') : false;
		$wechat_unionid = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		
		$Loc = new \Library\Com\Location();
		$ip = $Loc->getClientIp();
		
		$ActionInfo = $this->group->fetchOne("select * from yizhangou_list where id = $id",\Phalcon\Db::FETCH_ASSOC);
		
		if($islogin && $type == 'check'){
			$phone = $this->session->get('user_phone');
			$this->cache->save($phone."_".$ActionInfo['name']."_bm",0);
			
			$info = $db->fetchOne("select * from yizhangou_baoming where action_id = $id and phone like '".$phone."'");
			if($info && $info['auth'] == 1){
				$this->session->set('yizhangou_'.$id.'_bmId',$bmId);
				$this->cache->save($phone."_".$ActionInfo['name']."_bm",1);
				$db->execute("update yizhangou_baoming set num = num + 1 where action_id = $id and phone like '".$phone."'");
			}elseif($info && $info['auth'] == 0){
				$this->session->set('yizhangou_'.$id.'_bmId',$bmId);
				$this->cache->save($phone."_".$ActionInfo['name']."_bm",1);
				$db->execute("update yizhangou_baoming set auth = '1' where id = ".$info['id']);
				$db->execute("update yizhangou_baoming set num = num + 1 where action_id = $id and phone like '".$phone."'");
			}else{
				$U = new \Library\Model\User();
				$tmp = $U->address(array('uid'=>$islogin));
				$sql = "insert into yizhangou_baoming(`action_id`,`user_id`,`phone`,`ip`,`city`,`district`,`address`,`time`,`auth`) values('".$id."','".$islogin."','".$phone."','".$ip."','".$tmp['city']."','".$tmp['district']."','".$tmp['address']."','".date('Y-m-d H:i:s')."','1')";
				$res = $db->execute($sql);
				$this->session->set('yizhangou_'.$id.'_bmId',$db->lastInsertId());
			}
			header("Location:/phone/yizhangou/success/show/$id");
		}
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			
			$U = new \Library\Model\User();
			$sms = new \Library\Com\Sms();
			
			if(!$post['phone']) die(json_encode(array('state'=>0,'msg'=>'缺少手机号码')));
			
			if($type == 'check'){
				$bmId = $db->fetchColumn("select id from yizhangou_baoming where action_id = '".$id."' and phone like '".$post['phone']."'");
				if(!$bmId){
					$sql = "insert into yizhangou_baoming(`action_id`,`user_name`,`phone`,`ip`,`time`,`from`,`ispiao`,`isquan`) values('".$id."','".$post['name']."','".$post['phone']."','".$ip."','".date('Y-m-d H:i:s')."','".$post['from']."','".$post['ispiao']."','".$post['isquan']."')";
					$res = $db->execute($sql);
				}
				$this->cache->save($post['phone']."_".$ActionInfo['name']."_bm",0);
				
				$code = mt_rand(10000,99999);
				$res = $sms->sendSms($post['phone'],"【腾讯家居·优居网】您的短信验证码为：".$code);
				if($res == 0){
					$this->cache->save($post['phone']."_".$id."_code",$code,300);
					die(json_encode(array('state'=>1,'msg'=>'允许报名')));
				}else{
					die(json_encode(array('state'=>0,'msg'=>'短信发送失败')));
				}
			}elseif($type == 'code'){
				$code = $this->cache->get($post['phone']."_".$id."_code");
				if($code == $post['code']){
					$bmId = $db->fetchColumn("select id from yizhangou_baoming where action_id = '".$id."' and auth = '0' and phone like '".$post['phone']."'");
					if($bmId){
						$res = $db->execute("update yizhangou_baoming set auth = '1' where id = $bmId");
						$this->cache->save($post['phone']."_".$ActionInfo['name']."_bm",1);
						
						$password = mt_rand(100000,999999);
						$info = $U->register(array('phone'=>$post['phone'],'password'=>$password,'unionid'=>$wechat_unionid));
						if($info['changePwd'] == 1){
							$sms->sendSms($post['phone'],"您在优居网已经成功注册，可使用该手机号码登录，初始登录密码为".$password."，为保护帐号安全，登录后尽快修改密码，谢谢！【腾讯家居·优居网】");
						}
						$db->execute("update yizhangou_baoming set num = num + 1 where action_id = $id and phone like '".$post['phone']."'");
						
						//post到crm
						$regionId = $db->fetchColumn("select region from yizhangou_regions where id = ".$ActionInfo['group_id']);
						$this->postToCrm($ActionInfo['name'],$regionId,array('name'=>$post['name'],'phone'=>$post['phone']));
					}
					$data = $U->register(array('phone'=>$post['phone'],'unionid'=>$wechat_unionid));
					
					//$this->session->set('userid',$data['user_id']);
					//$this->session->set('user_id',$data['user_id']);
					//$this->session->set('user_name',$data['user_name']);
					//$this->session->set('user_phone',$data['user_phone']);
					//$this->session->set('user_email',$data['user_email']);
					//$this->session->set('user_headpic',$data['user_headpic']);
					$this->session->set('yizhangou_'.$id.'_bmId',$bmId);
					
					$sql = "select b.* from `yizhangou_baoming` as a left join `yizhangou_list` as b on a.action_id = b.id where a.id = ".$bmId;
					$action = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
					$address = base64_decode($action['address']);
					
					$smsData = "感谢您报名".$action['name']."，地点：".$address[0]['address']."，活动时间：".date('Y-m-d',strtotime($action['starttime']))."。关注优居微信服务号youju2099。【腾讯家居·优居网】";
					if($action['name'] == '全民家居购'){
						$smsData = "【腾讯优居】您已成功领取全民家居购门票，24小时内会有工作人员与您取得联系，与您核实地址，并寄送门票，凭此门票可参与品牌抵扣，下订抽奖等活动，".date('Y-m-d',strtotime($action['starttime'])).$address[0]['address']."，与您不见不散。";
					}
					
					$sms->sendSms($post['phone'],$smsData);
					
					die(json_encode(array('state'=>1,'msg'=>'报名成功')));
				}else{
					die(json_encode(array('state'=>0,'msg'=>'验证码错误')));
				}
				
			}
		}
		exit();
	}
	
	public function clickAction(){
		$id = $this->dispatcher->getParam(0,'int');
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			
			$sql = "insert into yizhangou_click(`action_id`,`tn`,`phone`,`time`) values('".$id."','".$post['tn']."','".$phone."','".date('Y-m-d H:i:s')."')";
			$this->group->execute($sql);
		}
	}
	
	private function postToCrm($actionName,$id,$data){
		$city = array(
			'6'=>'南京',
			'7'=>'沧州',
			'8'=>'聊城',
			'9'=>'齐齐哈尔',
			'10'=>'邢台',
			'11'=>'德州',
			'12'=>'唐山',
			'13'=>'秦皇岛',
			'14'=>'济南',
			'15'=>'张家口',
			'16'=>'常州',
			'17'=>'廊坊',
			'18'=>'邯郸',
			'19'=>'成都',
			'20'=>'衡水',
			'21'=>'太原',
			'22'=>'石家庄',
			'23'=>'哈尔滨',
			'24'=>'潍坊',
			'25'=>'青岛',
			'26'=>'昆明',
			'27'=>'无锡',
			'28'=>'绥化',
			'29'=>'泰安',
			'30'=>'保定',
			'31'=>'滨州',
			'32'=>'承德',
			'33'=>'淄博',
			'34'=>'菏泽',
			'35'=>'上海',
			'36'=>'北京',
			'37'=>'天津',
			'38'=>'深圳',
			'51'=>'东营'
		);
		if($actionName == '全民家居购'){
			$E = new \Library\Model\Ext();
			$regions = $E->regions();
			
			$cityId = 0;
			foreach($city as $k=>$v){
				if($regions['list'][$id] == $v){
					$cityId = $k; break;
				}
			}
			if($cityId){
				$sign = md5(md5('yoju360_crm').'add'.$cityId.date('Y-m-d'));
				$url = $this->config->crm_host."/pc/api/user/".$sign."/add/".$cityId;
				$fun = new Funs();
				$res = $fun->curlPOST($url,json_encode($data));
			}
		}
	}
}
