<?php
namespace Apps\Phone\Controllers;

class TigerprizeController extends ControllerBase
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
		
// 		$this->session->set('tiger_gift_openid','abc123123');
// 		$this->session->set('tiger_gift_wechaname','hehehe');
		
		//微信授权
		if(!$_POST['openid'])
		{
			$openId = $this->session->get('tiger_gift_openid');
			$wechaname = $this->session->get('tiger_gift_wechaname');
			if(empty($openId))
			{
				$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
				$redirect_url = $this->config->pcHome.'/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=tiger';
				echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
			}
		}
		else 
		{
			$openId = $_POST['openid'];
			$wechaname = base64_decode($_POST['wechaname']);

			$this->session->set('tiger_gift_openid',$openId);
			$this->session->set('tiger_gift_wechaname',$wechaname);
		}

		//奖品数量
		$gift_sql = "select * from qx_tiger_prize";
		$gift_rows = $this->group->fetchAll($gift_sql,\Phalcon\Db::FETCH_ASSOC);
		$this->view->setVar("giftList",$gift_rows);

	}
	
	
	//提交信息
	public function submitinfoAction()
	{

		if(!$this->session->has("tiger_gift_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$name = trim($post['name']);
			$prizeId = trim($post['prizeId']);
			$phone = trim($post['phone']);
			$address = trim($post['address']);
			$openId = $this->session->get('tiger_gift_openid');
			$db = $this->group;
			
			$check_sql = "select prize_id,score from qx_tiger_info where openid='{$openId}'";
			$check_row = $this->group->fetchOne($check_sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(empty($check_row))
			{
				$ajax_result['errcode'] = 1004;
				$ajax_result['errmsg'] = '您还没进行过游戏呢，赶快去体验一下吧！';
				die(json_encode($ajax_result));
			}
			elseif ($check_row['prize_id']>0)
			{
				$ajax_result['errcode'] = 1005;
				$ajax_result['errmsg'] = '您已兑换过奖励了！';
				die(json_encode($ajax_result));
			}
			
			if(empty($name) || empty($phone) || empty($address))
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
			
			switch ($prizeId)
			{
				case 1:
					$prize = '七夕情侣公仔小七+小夕';
					$score = 10000;
					break;
				case 2:
					$prize = '20元现金红包装修基金';
					$score = 20000;
					break;
				case 3:
					$prize = '汝窑天青烘云托月茶壶套组';
					$score = 30000;
					break;
				case 4:
					$prize = 'AO史密斯厨下反渗透净水机AR125-B1';
					$score = 40000;
					break;
				case 5:
					$prize = 'A.O史密斯电热水器CEWH60-K6';
					$score = 50000;
					break;
			}
			
			if($check_row['score'] < $score)
			{
				$ajax_result['errcode'] = 1006;
				$ajax_result['errmsg'] = '您的积分不足兑换该礼品！';
				die(json_encode($ajax_result));
			}
			
			$gift_sql = "select quantity from qx_tiger_prize where prize_num='{$prizeId}'";
			$gift_row = $this->group->fetchOne($gift_sql,\Phalcon\Db::FETCH_ASSOC);
			if($gift_row['quantity'] <= 0)
			{
				$ajax_result['errcode'] = 1007;
				$ajax_result['errmsg'] = '该礼品已经兑换完啦！';
				die(json_encode($ajax_result));
			}
			
			$db->execute("begin");
			$db->execute("update qx_tiger_info set name='{$name}',phone='{$phone}',address='{$address}',prize='{$prize}',prize_id='{$prizeId}',score=score-{$score} where openid='{$openId}'");
			$db->execute("commit");
			
			$db->execute("begin");
			$db->execute("update qx_tiger_prize set quantity=quantity-1 where prize_num='{$prizeId}'");
			$db->execute("commit");
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = '现金红包兑换后3天内发放，实物礼品于活动结束后10个工作日之内将礼品发出，敬请留意~';
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
		
	}
	
	
}
