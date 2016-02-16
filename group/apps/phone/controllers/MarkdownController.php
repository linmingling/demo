<?php
namespace Apps\Phone\Controllers;

use Library\Com\Funs;

class MarkdownController extends ControllerBase {
	
	private $platform = "";
	private $appId = "wxd43f7b5d8539e718";
	private $appSecret = "a42b85c54c3e79b709023df894f42778";
	private $wxToken = "ubtaeo1422330200";
	private $wxAPI;
	
	public function onConstruct(){
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$wechaname = $this->session->has('wechaname') ? $this->session->get('wechaname') : "";
		$wxId = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : "";
		
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($agent,"MicroMessenger")){
			$this->platform = "wx";
			if(isset($_GET['openid'])){
				$url = 'http://'.$_SERVER['HTTP_HOST'].$_GET['_url']."?from=".$_GET['from']."&isappinstalled=".$_GET['isappinstalled'];
				header("Location:$url");
			}
			if($user_id == 0){
				if(!$_POST['openid']){
					$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
					$redirect_url = $this->config->pcHome .'/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=markdown_group';
					echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
				}else{
					$data['oauth_type']    = 5;
					$data['oauth_openid']  = $_POST['openid'];
					$data['reg_time']      = time();
					$data['sex']           = '';
					$data['head_pic']      = urldecode($_POST['headimgurl']);
					$data['nick_name']     = base64_decode($_POST['wechaname']);
					$data['oauth_unionid'] = $_POST['unionid'];
					$open_id = $this->sso_author_login($data);
				}
			}
			$this->wxAPI = new \Library\Com\WeiXinApi($this->session,$this->wxToken,$this->appId,$this->appSecret);
		}
	}
	
	//获取活动信息
	private function activity($id){
		if(!$id) return false;
		$info = $this->group->fetchOne("select * from markdown_list where id = ".$id,\Phalcon\Db::FETCH_ASSOC);
		return $info ? $info : false;
	}
	
	//获取砍价王列表
	private function paylis($id){
		$order = new \Library\Model\Order();
		$list = $order->info(array('fromId'=>2,'actionId'=>$id));
		
		$U = new \Library\Model\User();
		$user = $U->info(array('idList'=>array_column($list['list'],'userId')));
		foreach($user['list'] as $k) $user2[$k['userId']] = $k; 
		
		$data = array();
		foreach($list['list'] as $k){
			$username = $user2[$k['userId']]['nickName'];
			$headImg = $user2[$k['userId']]['headPic'];
			if($k['moneyPaid'] > 0){
				$data[] = array('user_id'=>$k['userId'],'username'=>$username,'headImg'=>$headImg,'moneyPaid'=>$k['moneyPaid'],'goodsId'=>$k['goods'][0]['goodsId'],'goodsName'=>$k['goods'][0]['goodsName'],'goodsImg'=>$k['goods'][0]['goodsImg']);
			}
		}
		$data = Funs::array_sort($data,'moneyPaid'); $data2 = array(); $tmp = array();
 		foreach($data as $k){
			if(!in_array($k['user_id'],$tmp)){
				$data2[] = $k;
				$tmp[] = $k['user_id'];
			}
		} 
		return $data2;
	}
	
	//帮降金额
	private function bangMoney($gid,$parentId,$basePrice){
		$forbid = include(APP_PATH.'/data/config/markdownforbid.php');
		if(in_array($this->session->get('wx_openid'),$forbid)) return rand(1,5)*0.1;
		$rules = $this->group->fetchOne("select * from markdown_goods where id = $gid",\Phalcon\Db::FETCH_ASSOC);
		$offsetMoney = 0;
		if($parentId){
			$offsetMoney = $this->group->fetchColumn("select sum(lower_money) from markdown_record where parent_id = $parentId");
		}
		
		$randMoney = number_format(mt_rand($rules['range_min'] * 10, $rules['range_max'] * 10) / 10, 2);
		$randMoney = max(0.1, round($randMoney * ($basePrice - $offsetMoney) / $basePrice, 1));
		
		$lowerSpace = $basePrice - $rules['lowest_price'] - $offsetMoney; //可降空间
		if(!$lowerSpace || $lowerSpace < 0) return 0;
		
		if($randMoney > $lowerSpace){
			$addMoney = $lowerSpace;
		}else{
			$addMoney = $randMoney;
		}
		return $addMoney;
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		
		$info = $this->activity($actionId);
		if(!$info){
			$this->flash->error("活动不存在"); exit();
		}
		if(isset($_GET['btn']) && intval($_GET['btn']) == 4){
			$this->group->execute("update markdown_click set btn_4 = btn_4 + 1 where action_id = $actionId");
		}
		if(isset($_GET['source']) && ($_GET['source'] == 'qq' || $_GET['source'] == 'tao' || $_GET['source'] == 'yoju')){
			$this->group->execute("update markdown_click set ".$_GET['source']." = ".$_GET['source']." + 1 where action_id = $actionId");
		}
		if($info['starttime'] > date('Y-m-d H:i:s')){ //未开始
			$activeState = 1;
			$tt = strtotime($info['starttime']);
			$activeTime = date('F',$tt)." ".date('j',$tt)." ".date('Y',$tt)." ".date('H:i',$tt);
		}elseif($info['endtime'] > date('Y-m-d H:i:s')){		//已经开始
			$activeState = 2;
			$tt = strtotime($info['endtime']);
			$activeTime = date('F',$tt)." ".date('j',$tt)." ".date('Y',$tt)." ".date('H:i',$tt);
		}elseif($info['endtime'] < date('Y-m-d H:i:s')){ //已经结束
			$activeState = 3;
			$tt = strtotime($info['endtime']);
			$activeTime = date('F',$tt)." ".date('j',$tt)." ".date('Y',$tt)." ".date('H:i',$tt);
		}
		$join = $this->group->fetchColumn("select sum(join_sum) + sum(init_join) from markdown_goods where action_id = ".$info['id']);
		
		$paylist = array_slice($this->paylis($actionId),0,10);
		
		$tmp = $this->group->fetchAll("select * from markdown_goods where action_id = ".$info['id']." and is_remove = 0 order by sort asc",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k) $list[$k['goods_id']] = $k;
		
		$gidStr = $tmp ? implode(",",array_column($tmp,'id')) : '0';
		$sql = "select b.goods_id,user_id,count(a.id) as num, sum(a.lower_money) as price from markdown_record as a left join markdown_goods as b on a.gid = b.id and b.is_remove = 0 where b.action_id = ".$info['id']." and a.gid in(".$gidStr.") group by parent_id";
		$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		$offset = array();
		if($tmp){
			foreach($tmp as $k){
				if(!isset($offset[$k['goods_id']])){
					$offset[$k['goods_id']] = array('num'=>$k['num'],'price'=>(float)$k['price']);
				}else{
					$offset[$k['goods_id']]['num'] += $k['num'];
					if($offset[$k['goods_id']]['price'] < (float)$k['price']) $offset[$k['goods_id']]['price'] = (float)$k['price'];
				}
			}
		}
		
		$M = new \Library\Model\Goods();
		$data = $M->idList(array('idList'=>array_keys($list)));
		foreach($data['list'] as $k) $box[$k['id']] = $k;
		
		foreach($list as $k){
			$goods[] = array(
				'goods_id' => $k['goods_id'],
				'name' => $box[$k['goods_id']]['name'],
				'img' => $this->config->pcHome .$box[$k['goods_id']]['image']['img'],
				'goods_num' => $k['goods_number'],
				'share_num' => $k['share_sum'],
				'sales_num' => $k['sales_sum'],
				'init_join' => $k['init_join'],
				'lowest_price' => round((float)$k['lowest_price'],2),
				'min_price' => isset($offset[$k['goods_id']]) ? round((float)$box[$k['goods_id']]['price']['promote'] - $offset[$k['goods_id']]['price'],2) : 0,
				'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
				'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
				'num' => isset($offset[$k['goods_id']]) ? $offset[$k['goods_id']]['num'] : 0,
			);
		}
		if($this->platform == "wx") $this->view->signPackage = $this->wxAPI->get_share();
		$this->view->join = array_sum(array_column($tmp,'join_sum'));
		$this->view->setVars(array('paylist'=>$paylist,'goods'=>$goods,'info'=>$info,'timeNow'=>date("Y-m-d H:i:s"),'activeTime'=>$activeTime,'activeState'=>$activeState,'join'=>$join));
    }
	
	public function inviteAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$goodsId = (int)$params[1];
		$toUser = isset($params[2]) ? (int)$params[2] : 0;
		
		$wechaname = $this->session->get('wechaname');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		
		$order = new \Library\Model\Order();
		$list = $order->info(array('uid'=>$user_id,'fromId'=>2,'actionId'=>$actionId));
		$this->view->orderurl = $list['num'] > 0 ? 1 : 0;
		
		$sql = "select a.id from markdown_record as a left join markdown_goods as b on a.gid = b.id where a.id = a.parent_id and a.parent_id != 0 and b.action_id = $actionId and b.goods_id = $goodsId and a.user_id = ";
		if($toUser && (!$user_id || ($user_id && $user_id != $toUser))){
			$parentId = $this->group->fetchColumn($sql.$toUser);
			if(!$parentId) header("Location:/phone/markdown/index/$actionId");
			$this->view->isBang = 1;
		}else{
			$parentId = $this->group->fetchColumn($sql.$user_id);
			$this->view->isBang = 0;
		}
		
		$info = $this->activity($actionId);
		if(!$info){
			$this->flash->error("活动不存在"); exit();
		}
		
		//是否关注
		$tmp = $this->wxSubscribe($this->session->get('wx_openid'));
		$subscribe = 0;
		if(!empty($tmp)) $subscribe = 1;
		if($tmp['follow_time'] > strtotime($info['starttime'])) $subscribe = 2;
		
		if($info['starttime'] > date('Y-m-d H:i:s')){ //未开始
			$activeState = 1;
			$tt = strtotime($info['starttime']);
			$activeTime = date('F',$tt)." ".date('j',$tt)." ".date('Y',$tt)." ".date('H:i',$tt);
		}elseif($info['endtime'] > date('Y-m-d H:i:s')){		//已经开始
			$activeState = 2;
			$tt = strtotime($info['endtime']);
			$activeTime = date('F',$tt)." ".date('j',$tt)." ".date('Y',$tt)." ".date('H:i',$tt);
		}		
		
		$M = new \Library\Model\Goods();
		$tmp1 = $M->info(array('goodsId'=>$goodsId,'descShow'=>1));
		//$tmp2 = $this->group->fetchOne("select * from markdown_goods where action_id = ".$info['id']." and goods_id = ".$tmp1['id']." and is_remove = 0 order by id desc",\Phalcon\Db::FETCH_ASSOC);
		$tmp2 = $this->group->fetchOne("select * from markdown_goods where action_id = ".$info['id']." and goods_id = ".$tmp1['id']." order by id desc",\Phalcon\Db::FETCH_ASSOC);
		if(!$tmp2) exit("该商品不存在");
		$goods = array(
			'gid' => $tmp2['id'],
			'goods_id' => $tmp1['id'],
			'name' => $tmp1['name'],
			'img' => $this->config->pcHome .$tmp1['image']['img'],
			'goods_num' => $tmp2['goods_number'],
			'promotePrice' => round((float)$tmp1['price']['promote'],2),
			'marketPrice' => round((float)$tmp1['price']['market'],2),
			'lowestPrice' => round((float)$tmp2['lowest_price'],2),
			'desc' => preg_replace_callback("/<img([^>]+)src=\"([:|\w|\/|\.]+)\.(jpg|jpeg|gif|png|bmp)\"[^>]+>/i",function($m){
				if(strpos($m[2],'http')){
					return "<img src='".$m[2].".".$m[3]."' />";
				}else{
					return "<img src='".$this->config->pcHome .$m[2].".".$m[3]."' />";
				}
			},htmlspecialchars_decode($tmp1['desc'])),
		);
		
		$this->view->hasCut = 0; $banglist = array(); $offsetMoney = 0; $bangUser = array();
		if($parentId){
			$tips = array('小试牛刀，随手砍了','很爱你哦，用心砍了','大刀一挥，轻轻松松砍了','斧头帮神级人物，指头一弹砍了');
			$res = $this->group->fetchAll("select * from markdown_record where parent_id = $parentId order by lower_money desc",\Phalcon\Db::FETCH_ASSOC);
			foreach($res as $k){
				$rand = mt_rand(0,3);
				$banglist[] = array('uid'=>$k['user_id'],'username'=>$k['username'],'tips'=>$tips[$rand],'money'=>$k['lower_money']);
				$offsetMoney += (float)$k['lower_money'];
				$bangUser[$k['user_id']] = $k['username'];
				if($user_id && $user_id == $k['user_id']){
					$this->view->hasCut = 1;  //已经砍过
					
					$share = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and `time` like '".date('Y-m-d')."%'");
					$sharestae = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and state = '1' and `time` like '".date('Y-m-d')."%'");
					
					$num = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id = $parentId");
					$num2 = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id != $parentId group by parent_id order by num desc limit 0,1");
					$num3 = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id != $parentId group by parent_id order by num desc limit 1,1");
					
					if($subscribe == 2 && $share > 0 && $sharestae > 0 && $num == 2 && $num2 < 2) $this->view->hasCut = 2; //关注 已分享
						
					if($subscribe == 2 && $share > 0 && $sharestae > 0 && $num == 1 && $num2 == 2 && $num3 < 2 ) $this->view->hasCut = 2; //关注 已分享
					
					if($subscribe == 2 && $share == 0 && $num == 1 && $num2 < 2) $this->view->hasCut = 2;  //关注 未分享
				}
			}
			$uid = $this->group->fetchColumn("select user_id from markdown_record where id = $parentId");
			$U = new \Library\Model\User();
			$user = $U->info(array('uid'=>$uid));
			$this->view->headPic = $user['headPic'];
		}else{
			$this->view->headPic = $this->session->get('headimgurl');
		}
		
		$lastPrice = $goods['promotePrice'] - (isset($offsetMoney) ? $offsetMoney : 0);
		$lastPrice = $lastPrice > $goods['lowestPrice'] ? round($lastPrice,2) : $goods['lowestPrice'];
	
		if($this->platform == "wx") $this->view->signPackage = $this->wxAPI->get_share();
		$this->view->bangNumber = $bangUser ? count($bangUser) : 0;
		$this->view->offsetMoney = isset($offsetMoney) ? $offsetMoney : 0;
		$this->view->toUser = ($user_id && !$toUser) ? $user_id : $toUser;
		$this->view->wechaname = $this->session->has('wechaname') ? $this->session->get('wechaname') : 0;
		$this->view->setVars(array('timeNow'=>date("Y-m-d H:i:s"),'actionId'=>$actionId,"info"=>$info,'goods'=>$goods,'banglist'=>$banglist,'lastPrice'=>$lastPrice,'activeTime'=>$activeTime));
	}
	
	public function rankAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$data = $this->paylis($actionId);
		$this->view->actionId = $actionId;
		$this->view->data = $data;
		$this->view->setVar("pcHome", $this->config->pcHome);
	}
	
	//判断该商品可否砍价
	private function canCut($user_id,$parent_id,$subscribe){
		$num = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id = $parent_id");
		$actionId = $this->group->fetchColumn("select action_id from markdown_record where parent_id = $parent_id");
		if($subscribe != 2){
			$share = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and `time` like '".date('Y-m-d')."%'");
			$sharestae = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and state = '1' and `time` like '".date('Y-m-d')."%'");
			if($share > 0 && $sharestae == 0){
				$this->group->execute("update markdown_share set state = '1' where action_id = $actionId and user_id = $user_id");
				return true;
			}
			if($num) return false;
		}else{
			$share = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and `time` like '".date('Y-m-d')."%'");
			$sharestae = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and state = '1' and `time` like '".date('Y-m-d')."%'");
			if($share > 0 && $sharestae == 0){
				$this->group->execute("update markdown_share set state = '1' where action_id = $actionId and user_id = $user_id");
				return true;
			}
			$num2 = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id != $parent_id group by parent_id order by num desc limit 0,1");
			$num3 = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id and parent_id != $parent_id group by parent_id order by num desc limit 1,1");		
			
			if($share > 0 && $sharestae > 0 && $num == 1 && $num2 >= 2 && $num3 >= 2 ) return false;
			
			if($share > 0 && $sharestae > 0 && $num == 1 &&  $num2 >= 3) return false;
			
			if($share > 0 && $sharestae > 0 && $num == 2 &&  $num2 > 1) return false;
		
			if($share == 0 && $num == 1 && $num2 > 1) return false;
			
			if($share == 0 && $num >= 2) return false;
			
			if($num >= 3) return false;
		}
		return true;
	}
	
	public function cutAction(){
		$this->view->disable(); header('Content-type:application/json;charset=utf-8;');
		
		if($this->platform != 'wx') die(json_encode(array('state'=>5,'msg'=>'请在微信中打开此页面')));
		
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$gid = (int)$params[1];
		
		$wechaname =  $this->session->has('wechaname') ? $this->session->get('wechaname') : "";
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$wxId = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : "";
		
		$info = $this->activity($actionId);
		if(!$info) die(json_encode(array('state'=>4,'msg'=>'活动不存在')));
		
		if($this->request->isPost() == true){
			$db = $this->group;
			$toUser = $this->request->getPost("touser","int",0);
			if(!$toUser) exit("参数错误");
			$btn = $this->request->getPost("btn","int",0);
			$tmp = $this->group->fetchColumn("select id from markdown_click where action_id = $actionId");
			if($tmp){
				$this->group->execute("update markdown_click set btn_".$btn." = btn_".$btn." + 1 where action_id = $actionId");
			}else{
				$this->group->execute("insert into markdown_click(`action_id`,`btn_".$btn."`) values('".$actionId."','".$btn."')");
			}
			
			//是否关注
			$tmp = $this->wxSubscribe($this->session->get('wx_openid'));
			$subscribe = 0;
			if(!empty($tmp)) $subscribe = 1;
			if($tmp['follow_time'] > strtotime($info['starttime'])) $subscribe = 2;
			
			$rules = $db->fetchOne("select * from markdown_goods where id = $gid",\Phalcon\Db::FETCH_ASSOC);
			$M = new \Library\Model\Goods();
			$tmp = $M->info(array('goodsId'=>$rules['goods_id']));
			$parentId = $db->fetchColumn("select id from markdown_record where id = parent_id and id > 0 and user_id = $toUser and gid = $gid");
			$lowerMoney = $this->bangMoney($gid,$parentId,$tmp['price']['promote']);
			if(!$parentId){   //发起帮砍
				if($user_id && $user_id == $toUser){
					$num = $this->group->fetchColumn("select count(id) from markdown_record where id = parent_id and action_id = $actionId and user_id = $user_id and gid = $gid");
					if(!$num){
						$sql = "insert into markdown_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`)";
						$sql .= " values('".$actionId."','".$gid."','0','".$user_id."','".$wechaname."','".$wxId."','".$lowerMoney."','".date('Y-m-d H:i:s')."')";
						$db->execute($sql);
						$parentId = $db->lastInsertId();
						$lowerMoney = $lowerMoney * 5;
						$db->execute("update markdown_record set parent_id = $parentId,lower_money = $lowerMoney where id = $parentId");
					}else{
						die(json_encode(array('state'=>3,'msg'=>'您已经砍过了哦','subscribe'=>$subscribe)));
					}
				}else{
					die(json_encode(array('state'=>0,'msg'=>'该用户没有发起帮砍','subscribe'=>$subscribe)));
				}
			}else{		//帮别人砍
				$cut = $this->canCut($user_id,$parentId,$subscribe);
				if(!$cut) die(json_encode(array('state'=>3,'msg'=>'您已经砍过了哦','subscribe'=>$subscribe)));
				$sql = "insert into markdown_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`)";
				$sql .= " values('".$actionId."','".$gid."','".$parentId."','".$user_id."','".$wechaname."','".$wxId."','".$lowerMoney."','".date('Y-m-d H:i:s')."')";
				$db->execute($sql);
			}
			$db->execute("update markdown_goods set join_sum = join_sum + 1 where id = $gid");
			
			//一个商品砍2次的机会是否已经使用
			$num = $this->group->fetchColumn("select count(id) as num from markdown_record where user_id = $user_id group by gid having num > 1");
			$share = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and `time` like '".date('Y-m-d')."%'");
			$sharestae = $this->group->fetchColumn("select count(id) as num from markdown_share where user_id = $user_id and action_id = $actionId and state = '1' and `time` like '".date('Y-m-d')."%'");
			if(($subscribe && intval($num) < 2) || ($share && $sharestae == 0)){
				die(json_encode(array('state'=>2,'msg'=>$lowerMoney,'subscribe'=>$subscribe))); //新关注用户可以在砍一刀
			}
			die(json_encode(array('state'=>1,'msg'=>$lowerMoney,'subscribe'=>$subscribe)));
		}
	}
	
	public function shareAction(){
		$this->view->disable(); header('Content-type:application/json;charset=utf-8;');
		$input = file_get_contents('php://input','r'); $input = json_decode($input,true);
		
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$wxId = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : "";
		$wechaname =  $this->session->has('wechaname') ? $this->session->get('wechaname') : "";
		$actionId = $input['actionId']; $gid = $input['gId'];
		
		$sql = "insert into markdown_share(`action_id`,`gid`,`user_id`,`wx_name`,`wx_id`,`time`) values('".$actionId."','".$gid."','".$user_id."','".$wechaname."','".$wxId."','".date('Y-m-d H:i:s')."')";
		$resA = $this->group->execute($sql);
		if($resA){
			$resB = $this->group->execute("update markdown_goods set share_sum = share_sum + 1 where id = $gid");
		}
		if($resA && $resB){
			$share = $this->group->fetchColumn("select count(id) from markdown_share where user_id = $user_id and action_id = $actionId and state = '1' and time like '".date('Y-m-d')."%'");
			die(json_encode(array('state'=>1,'msg'=>$share)));
		}
		die(json_encode(array('state'=>0,'msg'=>'分享失败')));
	}
	
	public function paysuccessAction(){
		$this->view->setVar("payDomain", $this->config->payDomain);
	}
	
	//支付前检测
	public function apibeforeAction(){
		$this->view->disable();
		header('Content-type:application/json;charset=utf-8;');
		$post = $this->request->getPost();
		$uid = $post['uid']; $fromId = $post['sid']; $actionId = $post['aid']; $goodsId = $post['goodsId']; $attrList = $post['attrList']; $buyNumber = $post['buyNumber'];
		
		$info = $this->activity($actionId);
		if(!$info) die(json_encode(array('state'=>0,'data'=>'活动不存在')));
		
		$data = array('state'=>1,'data'=>array(
			'paySuccessUrl'=>'http://'.$_SERVER['SERVER_NAME'].'/phone/markdown/paysuccess/'.$fromId."/".$actionId,
			'changeBuyNum'=>0,
			'shipOnline'=>1,
			'checkExist'=>1
		));
		if($info['starttime'] > date('Y-m-d H:i:s') || $info['endtime'] < date('Y-m-d H:i:s')){
			die(json_encode(array('state'=>0,'data'=>'活动已经结束或还没开始')));
		}
		$tmp = $this->group->fetchOne("select * from markdown_goods where action_id = $actionId and goods_id = $goodsId",\Phalcon\Db::FETCH_ASSOC);
		if(!$tmp) die(json_encode($data));
		if($tmp['goods_number'] <= 0) die(json_encode(array('state'=>0,'data'=>'该商品库存不足')));
		
		$E = new \Library\Model\Ext();
		$regions = $E->regions();
		$M = new \Library\Model\Goods();
		$tmp1 = $M->info(array('goodsId'=>$goodsId));		
		
		$parentId = $this->group->fetchColumn("select parent_id from markdown_record where user_id = $uid and parent_id = id and parent_id != 0 and gid = ".$tmp['id']);
		$data['data']['offsetMoney'] = $parentId ?  $this->group->fetchColumn("select sum(lower_money) from markdown_record where parent_id = $parentId") : 0;
		if((float)$tmp1['price']['promote'] - (float)$data['data']['offsetMoney'] < 0) $data['data']['offsetMoney'] = (float)$tmp1['price']['promote'] - $tmp['lowest_price'];
		if($tmp1['price']['promote'] - $tmp['lowest_price'] < $data['data']['offsetMoney']) $data['data']['offsetMoney'] = $tmp1['price']['promote'] - $tmp['lowest_price'];
		if($tmp['shipping'] >= 1){
			$ship = $this->group->fetchOne("select * from markdown_shipping where shipping_id = ".$tmp['shipping'],\Phalcon\Db::FETCH_ASSOC);
			$addr = array(
				'province'=>$regions['list'][$ship['province']],
				'city'=>$regions['list'][$ship['city']],
				'district'=>$regions['list'][$ship['district']],
				'address'=> $ship['address'],
				'qhTime'=> $ship['best_time'],
				'linkman'=> $ship['linkman'],
				'tel'=> $ship['tel']
			);
			$data['data']['shipOnline'] = 0;
			$data['data']['addressAutoMatch'] = 0;
			$data['data']['shipAddress'] = $addr;
		}elseif($tmp['shipping'] == -1){
			$ship = $this->group->fetchAll("select * from markdown_shipping where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
			foreach($ship as $k){
				$addr[] = array(
					'province'=>$regions['list'][$k['province']],
					'city'=>$regions['list'][$k['city']],
					'district'=>$regions['list'][$k['district']],
					'address'=> $k['address'],
					'qhTime'=> $k['best_time'],
					'linkman'=> $k['linkman'],
					'tel'=> $k['tel'],
					'default' => $k['default'],
				);
			}
			$data['data']['shipOnline'] = 0;
			$data['data']['addressAutoMatch'] = 1;
			$data['data']['shipAddress'] = $addr;
		}
		echo json_encode($data);
	}
	
	//订单号生成 且入库
	public function apidoingAction(){
		$post = $this->request->getPost();
		$uid = $post['uid']; $fromId = $post['sid']; $actionId = $post['aid']; $orderId = $post['orderId'];
		die(json_encode(array('state'=>1,'data'=>'入库成功!')));
	}
	
	//取消订单
	public function apicancelAction(){
		$post = $this->request->getPost();
		$fromId = $post['sid']; $actionId = $post['aid']; $orderId = $post['orderId'];
	}
	
	//订单支付成功后
	public function apiafterAction(){
		$post = $this->request->getPost();
		$fromId = $post['sid']; $actionId = $post['aid']; $orderId = $post['orderId'];
		
		$Order = new \Library\Model\Order();
		$info = $Order->info(array('orderId'=>$orderId));
		
		if(empty($info)) exit();
		foreach($info['goods'] as $k){
			$this->group->execute("update markdown_goods set goods_number = goods_number - 1 where action_id = $actionId and goods_id = ".$k['goodsId']);
			$this->group->execute("update markdown_goods set sales_sum = sales_sum + 1 where action_id = $actionId and goods_id = ".$k['goodsId']);
		}
		
		$url = "http://".$_SERVER['SERVER_NAME']."/phone/markdown/index/".$actionId;
		$wx_openid = $this->group->fetchColumn("select wx_id from markdown_record where user_id = ".$info['userId']);
		$data = array('url'=>$url,'first'=>'恭喜你购买成功','name'=>$info['goods'][0]['goodsName'],'money'=>$info['moneyPaid'],'time'=>date('Y-m-d H:i:s'),'remark'=>'');
		
		$E = new \Library\Model\Ext();
		
		$shiptype = $this->group->fetchColumn("select shipping from markdown_goods where action_id = $actionId and goods_id = ".$info['goods'][0]['goodsId']);
		if($shiptype > 0){
			$regions = $E->regions();
			$addr = $this->group->fetchOne("select * from markdown_shipping where action_id = $actionId and shipping_id = $shiptype",\Phalcon\Db::FETCH_ASSOC);
			$data['remark'] = "提货信息:".$addr['linkman']." ".$addr['tel']." ".$regions['list'][$addr['province']].$regions['list'][$addr['city']].$regions['list'][$addr['district']].$addr['address']." ".$addr['best_time'];
		}elseif($shiptype == -1){
			$regions = $E->regions();
			
			$U = new \Library\Model\User();
			$consignee = $U->address(array('uid'=>$info['userId']));
			
			$ship = $this->group->fetchAll("select * from markdown_shipping where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
			$state = false;
			foreach($ship as $k){
				if($k['district'] == $addr['data']['district']){
					$ship2 = $k; $state = true; break;
				}
			}
			if(!$state){
				foreach($ship as $k){
					if($k['city'] == $addr['data']['city']){
						$ship2 = $k; $state = true; break;
					}
				}
				if(!$state){
					foreach($ship as $k){
						if($k['province'] == $addr['data']['province']){
							$ship2 = $k; $state = true; break;
						}
					}
				}
			}
			if(!$state){
				foreach($ship as $k){
					if($k['default']) $ship2 = $k;
				}
			}
			$data['remark'] = "提货信息:".$ship2['linkman']." ".$ship2['tel']." ".$regions['list'][$ship2['province']].$regions['list'][$ship2['city']].$regions['list'][$ship2['district']].$ship2['address']." ".$ship2['best_time'];
		}
		$E->wxMsg($wx_openid,$data);
	}
}

?>