<?php 
namespace Apps\Phone\Controllers;

use Library\Com\Funs;

//v卡激活

class VcardController extends ControllerBase 
{
	private $appId = "wxd43f7b5d8539e718";
	private $appSecret = "a42b85c54c3e79b709023df894f42778";
	private $wxToken = "ubtaeo1422330200";
	private $wxAPI;
	private $jssdk;
	private $point_model;
	private $funs_model;
	
	public function onConstruct()
	{
		$this->wxlogin();
		$this->wxAPI = new \Library\Com\WeiXinApi($this->session,$this->wxToken,$this->appId,$this->appSecret);
		$this->jssdk = new \Library\Com\JSSDK();
		$this->point_model = new \Library\Com\VcardPoint($this->group);
	}
	
	//首页
	public function indexAction()
	{
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
// 		print_r($this->session->getData());die;
		if(!strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger"))
		{
			$this->flash->error("请用微信浏览器打开"); exit();
		}
		$params = $this->dispatcher->getParams();
		
		//有活动ID
		if(is_numeric($params[0]))
		{
			$actionId = (int)$params[0];
			$sql = "select count(*) from yizhangou_list where id=$actionId";
			$checkAction = $this->group->fetchColumn($sql);
			if(!$checkAction)
			{
				$this->flash->error("活动不存在"); exit();
			}
			//激活人数统计
			$activeCount = $this->group->fetchColumn("select count(*) from vcard_user where action_id=$actionId");
		}
		else //关键字
		{
			$keyword = trim($params[0]);
			if($keyword == 'qmjjg')
			{
				$keyword = '全民家居购';
			}
			else 
			{
				$this->flash->error("活动不存在"); exit();
			}
			$sql = "select * from yizhangou_list where name='{$keyword}'";
			$actionList = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			if(empty($actionList))
			{
				$this->flash->error("活动不存在"); exit();
			}
			
			$activeCount = $this->group->fetchColumn("select count(*) from vcard_user where action_id in (select id from yizhangou_list where name='{$keyword}')");
			$actionId = 0;
			
			//城市列表
			
            $sql = "select a.id as action_id,b.region as region_id,a.starttime,a.endtime from yizhangou_list a left join yizhangou_regions b on a.group_id=b.id where a.name='{$keyword}' and a.endtime>'" . date('Y-m-d H:i:s') . "'";
            $cityList = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);

            $E = new \Library\Model\Ext();
            $citys = $E->regions();
            foreach ($cityList as $k=>$v)
            {
                $cityInfo = $E->regions(array('id'=>$v['region_id']));
                $cityList[$k]['city'] = $citys['list'][$v['region_id']];
                $cityList[$k]['timestr'] = date('Y.m.d',strtotime($v['starttime'])) . ' - ' . date('Y.m.d',strtotime($v['endtime']));
            }
				
			
			
			$this->view->setVars(array('citylist'=>$cityList));
			
			//城市定位
			$content = $this->point_model->getCity();
			$this->view->setVars(array('locationcity'=>$content['action_id']));
// 			var_dump($content);die;
		}
		
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$this->view->setVars(array('actionid'=>$actionId));
		$this->view->setVars(array('userid'=>$user_id));
		$this->view->setVars(array('activecount'=>$activeCount));
		$signPackage = $this->jssdk->GetSignPackage();
		$this->view->setVar("signPackage", $signPackage);
	}
	
	//验证码操作
	public function captchaAction()
	{
		if($this->request->isPost() == true)
		{
			$type = $this->dispatcher->getParam(0);
			$actionId = $this->dispatcher->getParam(1);
			
			$post = $this->request->getPost();
			$phone = trim($post['phone']);
			$code = trim($post['code']);
			$actionId = $actionId==0?$post['city']:$actionId;
			
			if(strlen($phone) != "11")
			{
				die(json_encode(array(
						'code'=>1001,
						'msg'=>"该手机号码格式不正确，请重新输入！",
				)));
			}
				
			if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
			{
				die(json_encode(array(
						'code'=>1002,
						'msg'=>"非法手机号码，请重新输入！",
				)));
			}
			
			if($type == 'captcha')  //获取验证码
			{
				$sms = new \Library\Com\Sms();
				
				$captcha = mt_rand(1000,9999);
// 				$captcha = 123;
				$res = $sms->sendSms($phone,"【腾讯优居】您的短信验证码是：".$captcha);
// 				$res = 0;
				
				if($res == 0)
				{
					$this->cache->save($phone."_vcard_code",$captcha,300);
					die(json_encode(array('code'=>0,'msg'=>'验证码已发送')));
// 					die(json_encode(array('code'=>0,'msg'=>$captcha)));
				}
				else
				{
					die(json_encode(array('code'=>1001,'msg'=>'短信发送失败')));
				}
			}
			elseif ($type == 'check')   //匹配验证码
			{
				$captcha = $this->cache->get($phone."_vcard_code");
// 				$captcha = 123;
				if($code == $captcha)
				{
					$db = $this->group;
					//检测活动
					$checkAction = $this->group->fetchColumn("select count(*) from yizhangou_list where id=$actionId");
					if(!$checkAction)
					{
						die(json_encode(array('code'=>1003,'msg'=>'活动不存在')));
					}
					
					//是否已激活过v卡
					if($this->checkActive($phone,$actionId))
					{
						die(json_encode(array('code'=>1002,'msg'=>'您已激活过v卡啦')));
					}
					else 
					{
						$openid = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : '';
						$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
						$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
						$o_user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
						$user_name = $this->session->has('user_name') ? $this->session->get('user_name') : $this->session->get('wx_name');
						$user_phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
						$U = new \Library\Model\User();
						
						//微信已绑定手机号
						if(!empty($user_phone))
						{
							if($phone != $user_phone)
							{
								if($this->checkActive($user_phone,$actionId))
								{
									die(json_encode(array('code'=>1003,'msg'=>'您当前微信号已经激活过v卡啦')));
								}
								else 
								{
									die(json_encode(array('code'=>1004,'msg'=>'您当前微信号已绑定手机号:' . mb_substr($user_phone,0,3) . "****" . mb_substr($user_phone,-4) . "，请输入正确的手机号")));
								}
							}
						}
						//是否已报名
						$is_new = 0;
						$checkRegister = $this->checkRegister($phone,$actionId);
						if(!$checkRegister)
						{
							$sql = "select id from yizhangou_baoming where phone='{$phone}' and auth=0 and (action_id='{$actionId}' or action_id in (select id from yizhangou_list where name='全民家居购'))";
							$registerInfo = $db->fetchColumn($sql);

							if($registerInfo)
							{
								$sql = "update yizhangou_baoming set action_id='{$actionId}',phone='{$phone}',auth='1',vcard='1' where id=" . $registerInfo;
							}
							else
							{
								$tmp = $this->checkUser($phone);
								if(!$tmp)  //没注册
								{
									//注册
									$data = $U->register(array('phone'=>$phone,'unionid'=>$wx_id));
	// 								$this->session->set('user_id',$data['user_id']);
									if($data['user_id'] == 0)
									{
										$data = $U->register(array('phone'=>$phone));
									}
									
									$user_id = $data['user_id'];
									
									
								}
								else 
								{
									$user_id = $tmp['userId'];
									$user_name = $tmp['userName'];
									$wx_id = $tmp['oauthUnionid'];
									
								}
								
								//报名
								$is_new = 1;
								$sql = "insert into yizhangou_baoming(`action_id`,`user_name`,`phone`,`time`,user_id,auth,vcard) values('".$actionId."','".$user_name."','".$phone."','".date('Y-m-d H:i:s')."','{$user_id}','1','1')";
							}
							$db->execute($sql);
							
							$E = new \Library\Model\Ext();
							$citys = $E->regions();
							$n_city_id = $db->fetchColumn("SELECT b.region from yizhangou_list a LEFT JOIN yizhangou_regions b on a.group_id=b.id where a.id=$actionId");
							$city_id = $this->getCity($citys[$n_city_id]);
							$sign = md5('yoju360_crm');
							$key = md5($sign.'add'.$city_id.date('Y-m-d'));
							$url = $this->config->crm_host.'/pc/api/user/'.$key.'/add/'.$city_id;
							$address = '';
							$data = '{"name": "'.$user_name.'", "phone": "'.$phone.'", "address": "'.$address.'"}';
							$this->funs_model = new \Library\Com\Funs();
							$this->funs_model->curlPOST($url, $data);
						}
						else 
						{
							if(stripos($checkRegister,'y'))
							{
								//覆盖报名
								$sql = "update yizhangou_baoming set action_id='{$actionId}',phone='{$phone}',auth=1 where id=" . substr($checkRegister, 2);
								$db->execute($sql);
								
								//user_id
								$user_id = $db->fetchColumn("select user_id from yizhangou_baoming where id=". substr($checkRegister, 2));
							}
							else 
							{
								$tmp = $this->checkUser($phone);
								if(!$tmp)  //没注册
								{
									//注册
									$data = $U->register(array('phone'=>$phone,'unionid'=>$wx_id));
									// 								$this->session->set('user_id',$data['user_id']);
									if($data['user_id'] == 0)
									{
										$data = $U->register(array('phone'=>$phone));
									}
									
									$user_id = $data['user_id'];
								}
								else
								{
									$user_id = $tmp['userId'];
									$user_name = $tmp['userName'];
									$wx_id = $tmp['oauthUnionid'];
								
								}
							}
						}
						
						//激活
						$db->execute("begin");
						$sql = "insert into vcard_user (phone,user_id,wx_id,username,add_time,action_id,is_new) values ($phone,'$user_id','{$wx_id}','{$user_name}','" . date('Y-m-d H:i:s') . "','{$actionId}','{$is_new}')";
						$db->execute($sql);
						$db->execute("commit");
					}
					
					die(json_encode(array('code'=>0,'msg'=>'激活成功','notic'=>array('id'=>$user_id,'aid'=>$actionId))));
				}
				else 
				{
					die(json_encode(array('code'=>1001,'msg'=>'验证码错误')));
				}
			}
			
		}
	}
	
	//分享进入获取券页面
	public function shareAction()
	{
		$this->wxlogin();
		if(!strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger"))
		{
			$this->flash->error("请用微信浏览器打开"); exit();
		}
		
		$signPackage = $this->jssdk->GetSignPackage();
		$this->view->setVar("signPackage", $signPackage);
		
		$params = $this->dispatcher->getParams();
		$userId = (int)$params[0];
		$actionId = (int)$params[1];
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
// 		$openid = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		
		$db = $this->group;
		$sql = "update vcard_user set status=1 where user_id={$userId} and action_id='{$actionId}' and status=0";
			
		$db->execute($sql);
		//是否自己分享的
		if($userId == $user_id)
		{
			$sql = "select * from vcard_user where user_id={$userId} and action_id='{$actionId}'";
			$userInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			//未激活
			if(!$userInfo || $phone != $userInfo['phone'])
			{
				header("Location:http://".$_SERVER['SERVER_NAME']."/phone/qmjjg/index.html");exit;
			}
			else 	//获得抵购券
			{
// 				if($userInfo['status'] == 0)
// 				{
// 					$sql = "update vcard_user set status=1 where user_id={$userId} and action_id='{$actionId}' and status=0";
					
// 					$db->execute($sql);
// 				}
				
				$actionInfo = $db->fetchOne("select * from yizhangou_list where id=$actionId",\Phalcon\Db::FETCH_ASSOC);
				
				if($actionInfo['name'] == '全民家居购')
				{
					if($actionInfo['endtime'] < date('Y-m-d H:i:s'))
					{
						$this->view->setVars(array('endtag'=>1));
					}
					else 
					{
						$this->view->setVars(array('endtag'=>0));
					}
					$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
					$this->view->pick("vcard/hn_share");
				}
			}
		}
		else 
		{
			header("Location:http://".$_SERVER['SERVER_NAME']."/phone/qmjjg/index.html");exit;
		}
		
		
	}
	
	public function getCity($city)
	{
		$data = array(
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
		foreach ($data as $k => $key)
		{
			if($key == $city)
			{
				return $k;
			}
		}
	}
	
	//检测是否激活过
	private function checkActive($phone,$actionId)
	{
		$db = $this->group;
		$sql = "select count(*) from vcard_user where phone='{$phone}' and (action_id='{$actionId}' or action_id in (select id from yizhangou_list where name='全民家居购'))";
		$activeInfo = $db->fetchColumn($sql);
		
		return $activeInfo?true:false;
	}
	
	//检测是否报名过
	private function checkRegister($phone,$actionId)
	{
		$db = $this->group;
		$sql = "select id from yizhangou_baoming where phone='{$phone}' and auth=1 and (action_id='{$actionId}' or action_id in (select id from yizhangou_list where name='全民家居购'))";
		$YregisterInfo = $db->fetchColumn($sql);
		
		$sql = "select id from qmjjg_registration where phone='{$phone}' ";
		$QregisterInfo = $db->fetchColumn($sql);
		
		if($YregisterInfo)
		{
			return '_y' . $YregisterInfo;
		}
		elseif($QregisterInfo)
		{
			return '_q' . $QregisterInfo;
		}
		else 
		{
			return false;
		}
	}
	
	//检测是否注册
	private function checkUser($phone)
	{
		$U = new \Library\Model\User();
		$check = $U->info(array('phone'=>$phone));
		
		return $check?$check:false;
	}
	
}



?>