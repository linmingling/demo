<?php
namespace Apps\Phone\Controllers;

class RpgameController extends ControllerBase
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
		echo "<script>alert('该页面已失效！')</script>";exit;
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(!strpos($agent,"MicroMessenger")){
			echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
		}
		
		$openId = empty($_GET['openid']) ? '' : $_GET['openid'];
		$wechaname = empty($_GET['wechaname']) ? '' : $_GET['wechaname'];
// 		$openId = 'abc123123';
// 		$wechaname = 'hehehe';
		
		//微信授权
		if(empty($openId)){
			$openId = $this->session->get('rpgame_openid');
			$wechaname = $this->session->get('rpgame_wechaname');
			if(empty($openId)){
				$url = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?rand=".time();
				$redirect_url = $this->config->pcHome.'/api/Across_oauth.php?scope=snsapi_userinfo&url='.$url.'&cookie_name=rpgame';
				echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
			}
		}
		
		$this->session->set('rpgame_openid',$openId);
		$this->session->set('rpgame_wechaname',$wechaname);
		//是否第一次进入
		$agent_tag = false;
		$agent_sql = "select name,score,city from qx_activecard_agent where openid='{$openId}'";
		$agent_row = $this->group->fetchOne($agent_sql,\Phalcon\Db::FETCH_ASSOC);
		if($agent_row)
		{
			$agent_tag = true;	//不是第一次
			$this->session->set('rpgame_agent_name',$agent_row['name']);
			$this->session->set('rpgame_agent_city',$agent_row['city']);
			$this->session->set('rpgame_agent_score',$agent_row['score']);
		}
		
		$this->view->setVar("agentTag",$agent_tag);
		$this->view->setVar("agentName",$agent_row['name']);
		$this->view->setVar("agentScore",$agent_row['score']);
		$this->view->setVar("agentCity",$agent_row['city']);
			
		
	}
	
	//填写推广员信息
	public function submitinfoAction()
	{
		if(!$this->session->has("rpgame_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$name = $post['name'];
			$city = $post['city'];
			$openid = $this->session->get("rpgame_openid");
			$wechaname = $this->session->get("rpgame_wechaname");
			
			if(empty($name) || empty($city))
			{
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = '信息填写不完整';
				die(json_encode($ajax_result));
			}
			
			$this->group->insert(
					"qx_activecard_agent",
					array($name,$city,$openid,$wechaname,date('Y-m-d H:i:s', time()),time()),
					array('name','city','openid','wechaname','add_time','add_strtotime')
			);
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "提交成功！";
			$ajax_result['name'] = $name;
			$ajax_result['city'] = $city;
			die(json_encode($ajax_result));
			
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
	}
	
	//验证卡ID
	public function checkidAction()
	{

		if(!$this->session->has("rpgame_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$cardNum = $post['card'];
			$db = $this->group;
			
			$card_sql = "select card_number,status from qx_activecard_msg where card_number='{$cardNum}' and status=1";
			$card_row = $db->fetchOne($card_sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(!$card_row)
			{
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = '请输入正确的ID号！';
				die(json_encode($ajax_result));
			}
			
			//更新激活卡信息
			$db->update(
					'qx_activecard_msg',
					array('agent','status','agent_active'),
					array($this->session->get('rpgame_agent_name'),2,date('Y-m-d H:i:s', time())),
					"card_number='{$cardNum}'"
			);
			$this->session->set('rpgame_agent_card',$cardNum);
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = '游戏开始';
			$ajax_result['cardnum'] = $cardNum;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
		
	}
	
	//排行榜
	public function rankAction()
	{
		if($this->request->isAjax() == true)
		{
			$rank_sql = "select name,score,openid from qx_activecard_agent where score>0 and city='" . $this->session->get('rpgame_agent_city') . "'order by score desc limit 10";
			$rank_rows = $this->group->fetchAll($rank_sql,\Phalcon\Db::FETCH_ASSOC);
			$num = 1;
			foreach ($rank_rows as $k=>$v)
			{
				$rank_rows[$k]['num'] = $num;
				$num++;
			}
			
			if($this->session->has("rpgame_openid"))
			{
				$cur_sql = "select count(*) as c from qx_activecard_agent where score>=(select score from qx_activecard_agent where openid='{$this->session->get("rpgame_openid")}' limit 1) and city='" . $this->session->get('rpgame_agent_city') . "'";
				$cur_row = $this->group->fetchOne($cur_sql,\Phalcon\Db::FETCH_ASSOC);
				if($cur_row)
				{
					$cur_sort = $cur_row['c'];
				}
				else 
				{
					$cur_row = 0;
				}
			}
			else 
			{
				$cur_row = 0;
			}
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = $rank_rows;
			$ajax_result['cur_sort'] = $cur_sort;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
	}
	
	//我的资产
	public function worthAction()
	{
		if(!$this->session->has("rpgame_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$openId = $this->session->get("rpgame_openid");
				
			$worth_sql = "select add_time,score from qx_activecard_detail where openid='{$openId}' order by id desc limit 9";
			$worth_rows = $this->group->fetchAll($worth_sql,\Phalcon\Db::FETCH_ASSOC);
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = $worth_rows;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
		
	}
	
	//分数提交
	public function submitscoreAction()
	{
		if(!$this->session->has("rpgame_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$score = $post['score'];
// 			$cardNum = $post['cardnum'];
			$cardNum = $this->session->get("rpgame_agent_card");
			$agentName = $this->session->get("rpgame_agent_name");
			$openId = $this->session->get("rpgame_openid");
			$db = $this->group;
			
			//添加资产明细
			$db->insert(
				"qx_activecard_detail",
				array($openId,$cardNum,$agentName,$score,date('Y-m-d H:i:s', time())),
				array('openid','card_num','agent_name','score','add_time')
			);
			
			$db->execute("update qx_activecard_agent set score=score+{$score} where openid='{$openId}'");
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['score'] = $this->session->get('rpgame_agent_score',$agent_row['score']) + score;
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
