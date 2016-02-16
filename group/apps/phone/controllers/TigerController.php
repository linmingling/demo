<?php
namespace Apps\Phone\Controllers;

class TigerController extends ControllerBase
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
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(!strpos($agent,"MicroMessenger")){
			echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
		}
// 		$this->session->set('tiger_openid','abc123123');
// 		$this->session->set('tiger_wechaname','hehehe');
		
		//微信授权
		if(!$_POST['openid'])
		{
			$openId = $this->session->get('tiger_openid');
			$wechaname = $this->session->get('tiger_wechaname');

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
			$this->session->set('tiger_openid',$openId);
			$this->session->set('tiger_wechaname',$wechaname);
		}

					
		//是否第一次进入
		$mem_sql = "select * from qx_tiger_info where openid='{$openId}'";
		$mem_row = $this->group->fetchOne($mem_sql,\Phalcon\Db::FETCH_ASSOC);
		
		if(empty($mem_row)) //第一次进入
		{
			$this->group->insert(
					"qx_tiger_info",
					array($openId,$wechaname,date('Y-m-d H:i:s', time()),time(),date('Y-m-d H:i:s', time())),
					array('openid','wechaname','add_time','add_strtotime','last_log_time')
			);
			$awardScore = 100;
			$gameScore = 500;
			$gameTimes = 0;
			$logDays = 1;
		}
		else 
		{
			//每天第一次登陆
			if(strtotime(date('Y-m-d',strtotime($mem_row['last_log_time']))) < strtotime('today'))	
			{
				if($mem_row['log_days'] >=5)	//登陆天数>=5
				{
					$awardScore = 500;
					$gameScore = $mem_row['score'];
				}
				else 
				{
					$awardScore = ($mem_row['log_days']+1) * 100;
					$gameScore = $mem_row['score'];
				}
				
				$this->group->execute("update qx_tiger_info set last_log_time='" . date('Y-m-d H:i:s', time()) . "',score=score+{$awardScore},log_days=log_days+1 where openid='{$openId}'");
			}
			else //不是当天第一次登陆
			{
				$gameScore = $mem_row['score'];
				$awardScore = 0;
					
			}
			
			$gameTimes = $mem_row['play_times'];
			$logDays = $mem_row['log_days']+1;
			
		}
			
		$this->view->setVar("awardScore",$awardScore); //每天登陆奖励
		$this->view->setVar("gameScore",$gameScore);	//总分数
		$this->view->setVar("gameTimes",$gameTimes);	//游戏次数
		$this->view->setVar("logDays",$logDays);	//登陆天数
		$this->view->setVar("signPackage",$this->wxapi->get_share());	

	}
	
	
	//开始滚
	public function startrollAction()
	{

		if(!$this->session->has("tiger_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$bgScore = $post['bgScore'];
			$openId = $this->session->get('tiger_openid');
			$db = $this->group;
			
			//判断倍率积分是否足够开始游戏
			$check_sql = "select score from qx_tiger_info where score>='{$bgScore}' and openid='{$openId}'";
			$check_row = $db->fetchOne($check_sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(!$check_row)
			{
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = '您的积分不足！';
				die(json_encode($ajax_result));
			}
			
			$db->execute("update qx_tiger_info set play_times=play_times+1,score=score-{$bgScore} where openid='{$openId}'");
			
			
            
                $p0 = array_fill(0,75, 0);
                $p1 = array_fill(0,75, 1);  
                $p2 = array_fill(0,75, 2);
                $p3 = array_fill(0,25, 3); 
                $p4 = array_fill(0,7, 4); 
                $p5 = array_fill(0,3, 5); 
            
			
			$arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5);
            shuffle($arr_m);
			
			//概率相加总和填入第二个参数
			$pn = mt_rand(0,count($arr_m) - 1);
			$nums = $arr_m[$pn];
			
			$numstr = $this->getnumberstr($nums);
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = '游戏开始';
			$ajax_result['numstr'] = $numstr;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
		
	}
	
	//获取滚动转盘数字
	public function getnumberstr($num)
	{
		$tmpArr = array();
		if($num > 0)
		{
			for($i=0;$i<$num;$i++)
			{
				array_push($tmpArr,0);
			}
			
			for($j=0;$j<(5-$num);$j++)
			{
				array_push($tmpArr,mt_rand(1,6));
			}
		}
		else 
		{
			for($i=0;$i<5;$i++)
			{
				array_push($tmpArr,mt_rand(1,6));
			}
		}
		
		shuffle($tmpArr);
		$numStr = implode(',',$tmpArr);
		
		return $numStr;
		
	}
	
	//排行榜
	public function rankAction()
	{
		if($this->request->isAjax() == true)
		{
			//排行榜
			$rank_sql = "select wechaname,score from qx_tiger_info where score>0 order by score desc limit 7";
			$rank_rows = $this->group->fetchAll($rank_sql,\Phalcon\Db::FETCH_ASSOC);
			$num = 1;
			foreach ($rank_rows as $k=>$v)
			{
				$rank_rows[$k]['num'] = $num;
				$rank_rows[$k]['wechaname'] = mb_substr($v['wechaname'],0,4,'utf-8') . "**";
				$num++;
			}
			
			//兑奖列表
			$giftlist_sql = "select wechaname,prize from qx_tiger_info where prize_id>0 order by id desc limit 7";
			$giftlist_rows = $this->group->fetchAll($giftlist_sql,\Phalcon\Db::FETCH_ASSOC);
			$num = 1;
			foreach ($giftlist_rows as $k=>$v)
			{
				$giftlist_rows[$k]['prize'] = mb_substr('兑换了'.$v['prize'],0,11,'utf-8') . '...';
				$giftlist_rows[$k]['wechaname'] = mb_substr($v['wechaname'],0,4,'utf-8') . "**";
				$num++;
			}
			
			$ajax_result['errcode'] = 0;
			$ajax_result['ranklist'] = $rank_rows;
			$ajax_result['giftlist'] = $giftlist_rows;
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
		if(!$this->session->has("tiger_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$score = $post['score'];
			$openId = $this->session->get('tiger_openid');
			$db = $this->group;
			
			if($score>0)
			{
				$db->execute("update qx_tiger_info set score=score+{$score} where openid='{$openId}'");
			}
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
		
	}
	
	//获得金币
	public function getcoinAction()
	{
		if(!$this->session->has("tiger_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
	
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$score = $post['score'];
			$openId = $this->session->get('tiger_openid');
			$db = $this->group;
			
			$db->execute("update qx_tiger_info set score=score+{$score} where openid='{$openId}'");
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
	
	}
	
	//分享送分
	public function shareAction()
	{
		if(!$this->session->has("tiger_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
		
		if($this->request->isAjax() == true)
		{
			$post = $this->request->getPost();
			$openId = $this->session->get('tiger_openid');
			$db = $this->group;
				
			$check_sql = "select share_tag from qx_tiger_info where openid='{$openId}'";
			$check_row = $db->fetchOne($check_sql,\Phalcon\Db::FETCH_ASSOC);
			
			if($check_row['share_tag'] == 0)
			{
				$db->execute("update qx_tiger_info set share_tag=1,score=score+100 where openid='{$openId}'");
			}
				
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = '服务器繁忙';
			die(json_encode($ajax_result));
		}
	}
	
	//点击七夕报名送分
	public function registerAction()
	{
		if(!$this->session->has("tiger_openid"))
		{
			$ajax_result['errcode'] = 1099;
			$ajax_result['errmsg'] = '页面信息已失效，请重新打开页面！';
			die(json_encode($ajax_result));
		}
	
		if($this->request->isAjax() == true)
		{
			
			$post = $this->request->getPost();
			$openId = $this->session->get('tiger_openid');
			$db = $this->group;
	
			$check_sql = "select register_tag from qx_tiger_info where openid='{$openId}'";
			$check_row = $db->fetchOne($check_sql,\Phalcon\Db::FETCH_ASSOC);
				
			if($check_row['register_tag'] == 0)
			{
				$db->execute("update qx_tiger_info set register_tag=1,score=score+100 where openid='{$openId}'");
				
			}
	
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
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
