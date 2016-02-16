<?php
namespace Apps\Phone\Controllers;

class ActivecodeController extends ControllerBase
{
	private $funs_model;
	private $jssdk;
	private $wxapi;
	private $token;
	private $appId;
	private $appSecret;
	
	public function initialize()
	{
		$this->funs_model = new \Library\Com\Funs();
		$this->jssdk = new \Library\Com\JSSDK();
		$this->token = "ubtaeo1422330200";
		$this->appId = "wxd43f7b5d8539e718";
		$this->appSecret = "a42b85c54c3e79b709023df894f42778";
		$this->wxapi = new \Library\Com\WeiXinApi($this->session,$this->token,$this->appId,$this->appSecret);
	}
	
	public function indexAction()
	{
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(!strpos($agent,"MicroMessenger")){
			echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
		}
		
		if(!$_POST['openid']){
		    $openId = $this->session->get('activeCode_openid');
		    if(empty($openId)){
    		    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		    $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		    $redirect_url = $this->config->pcHome .'/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=active_code';
    		    echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
		    }
		} else {
		    $this->session->set('activeCode_openid',$_POST['openid']);
		    $this->session->set('activeCode_wechaname',base64_decode($_POST['wechaname']));
//            $this->session->set('activeCode_wechaname',$_POST['wechaname']);
		}
//		$this->session->set('activeCode_hongbao_id','10');
	}
	
	//检查激活码并激活
	public function checkcodeAction()
	{
			if($this->request->isAjax() == true)
			{
			    $openId = $this->session->get("activeCode_openid");
				if(empty($openId)){
//                     $file = @fopen("../views/activecode/log/log.txt","a");
//                     @fwrite($file,"=======" . strftime("%Y%m%d%H%M%S",time()) . "======\r\n");
//                     @fwrite($file,$_COOIEK['ECS_ID']."\r\n");
//                     @fwrite($file,"\r\n");
//                     @fwrite($file,"\r\n");
//                     @fwrite($file,"\r\n");
//                     @fclose($file);
					$ajax_result['errcode'] = 1099;
					$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
					die(json_encode($ajax_result));
				}
				
				$post = $this->request->getPost();
// 				$post = array('name'=>'test777','phone'=>'13800138000','code'=>'608','num'=>'QQ000004');
				
				$name = trim($post['name']);
				$phone = trim($post['phone']);
				$activeCode = trim($post['code']);
				$cardNum = strtoupper(trim($post['num']));
				
				
				
				if(empty($name) || empty($phone) || empty($activeCode) || empty($cardNum))
				{
					$ajax_result['errcode'] = 1001;
					$ajax_result['errmsg'] = '信息填写不完整';
					die(json_encode($ajax_result));
				}
				
				if(strlen($phone) != "11")
				{
					$ajax_result['errcode'] = 1002;
					$ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
					die(json_encode($ajax_result));
				}
				
				if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
				{
					$ajax_result['errcode'] = 1003;
					$ajax_result['errmsg'] = "非法手机号码，请重新输入！";
					die(json_encode($ajax_result));
				}
				
				$db = $this->group;
				
				//检查是否匹配卡号和验证码
				$check_sql1 = "select city from qx_membership_card where card_number='{$cardNum}' and captcha='{$activeCode}'";
				$check_row1 = $db->fetchOne($check_sql1,\Phalcon\Db::FETCH_ASSOC);
				if(!$check_row1)
				{
					$ajax_result['errcode'] = 1004;
					$ajax_result['errmsg'] = "没有该卡号信息！";
					die(json_encode($ajax_result));
				}
				
				//检查是否已经激活
				$check_sql2 = "select city from qx_activecard_msg where card_number='{$cardNum}' and captcha='{$activeCode}'";
				$check_row2 = $db->fetchOne($check_sql2,\Phalcon\Db::FETCH_ASSOC);
				
				if($check_row2)
				{
					$ajax_result['errcode'] = 1005;
					$ajax_result['errmsg'] = "该卡号已被激活！";
					die(json_encode($ajax_result));
				}
				
				//检查是否已进行激活并领取操作
				$openId = $this->session->get('activeCode_openid');
				$wechaname = $this->session->get('activeCode_wechaname');
				
				$check_sql3 = "select city from qx_activecard_msg where openid='{$openId}'";
				$check_row3 = $db->fetchOne($check_sql3,\Phalcon\Db::FETCH_ASSOC);
				
				if($check_row3)
				{
					$ajax_result['errcode'] = 1006;
					$ajax_result['errmsg'] = "您已进行过激活操作！";
					die(json_encode($ajax_result));
				}
				
				$db->insert(
					"qx_activecard_msg",
					array($name,$phone,$cardNum,$activeCode,$check_row1['city'],1,date('Y-m-d H:i:s', time()),time(),$this->session->get('activeCode_openid'),$this->session->get('activeCode_wechaname')),
					array('name','phone','card_number','captcha','city','status','mem_active','add_time','openid','wechaname')
				);
				$insertId = $db->lastInsertId();
				
				if($insertId)
				{
	// 				$this->session->set('moneyId',$insertId);
					$this->session->set('qx_phone',$phone);
					$this->session->set('url_source','vipcode');
	// 				var_dump($this->session->get('moneyId'));
	
					//发红包
//					$hongbaoId = $this->session->get('activeCode_hongbao_id');
					$hongbaoId = 10;
					$hongbaoRes = json_decode($this->wxapi->get_hongbao($hongbaoId,$openId,$wechaname,1),true);
						
					if($hongbaoRes['errcode'] == 0)
					{
						$this->group->update(
								'qx_activecard_msg',
								array('money_status'),
								array($hongbaoRes['total']),
								"id={$insertId}"
						);
					}
					
					$ajax_result['errcode'] = 0;
					$ajax_result['errmsg'] = "激活成功！";
					die(json_encode($ajax_result));
				}
				else 
				{
					$ajax_result['errcode'] = 1011;
					$ajax_result['errmsg'] = '服务器繁忙';
					die(json_encode($ajax_result));
				}
			}
			else
			{
				$ajax_result['errcode'] = 1011;
				$ajax_result['errmsg'] = '服务器繁忙';
				die(json_encode($ajax_result));
			}
			
	}
	
	public function getmoneyAction()
	{
		return ;//该方法已失效
		if($this->request->isAjax() == true)
		{
			$mId = $this->session->get('moneyId');
			$hongbaoId = $this->session->get('activeCode_hongbao_id');
			$openId = $this->session->get('activeCode_openid');
			$wechaname = $this->session->get('activeCode_wechaname');

			/**/
			$checkcode_sql = "select city,money_status from qx_activecard_msg where id={$mId}";
			$checkcode_row = $this->group->fetchOne($checkcode_sql,\Phalcon\Db::FETCH_ASSOC);
			
			if($checkcode_row['money_status'] > 0)
			{
				$ajax_result['errcode'] = 1005;
				$ajax_result['errmsg'] = "你已领取过红包！";
				die(json_encode($ajax_result));
			}
			
			
			$hongbaoRes = json_decode($this->wxapi->get_hongbao($hongbaoId,$openId,$wechaname,1),true);
			
			if($hongbaoRes['errcode'] == 0)
			{
				$res = $this->group->update(
					'qx_activecard_msg',
					array('money_status','openid','wechaname'),
					array($hongbaoRes['total'],$this->session->get('activeCode_openid'),$this->session->get('activeCode_wechaname')),
					"id={$mId}"
				);
				
				
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "您已成功领取现金红包，返回优居生活公众号查看！";
			
			}
			else
			{
				$ajax_result['errcode'] = 1007;
				$ajax_result['errmsg'] = "你已领取过红包！";
			}
			
			die(json_encode($ajax_result));
			
		}
		else
		{
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
	}
	
	
}