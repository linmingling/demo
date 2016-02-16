<?php
namespace Apps\Phone\Controllers;

class SeckillController extends ControllerBase {
	
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
					$redirect_url = $this->config->pcHome.'/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=seckill_group';
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
		$info = $this->group->fetchOne("select * from seckill_list where id = ".$id,\Phalcon\Db::FETCH_ASSOC);
		return $info ? $info : false;
	}
	
	public function indexAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		$this->view->setVar("pcHome", $this->config->pcHome);
		
		$id = $this->dispatcher->getParam(0,'int');
		$toUser = $this->dispatcher->getParam(1,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$nowDay = date('Y-m-d');
		
		$info = $this->activity($id);
		if(!$info){
			$this->flash->error("活动不存在"); exit();
		}
		
		$sql = "insert into seckill_click(`action_id`,`user_id`,`from_user_id`,`from_type`,`time`) values('".$id."','".$user_id."','".$toUser."','".$_GET['from']."','".date('Y-m--d H:i:s')."')";
		$this->group->execute($sql);
		
		$isGM = 0; 
		if($this->platform == "wx" && ($_GET['from'] == 'timeline' || $_GET['from'] == 'groupmessage')){
			$isGM = 1; //是从微信朋友圈或微信群中进来
		}
		
		if($toUser){
			$res = $this->group->fetchColumn("select id from seckill_share where action_id = $id and user_id = $toUser");
			if(!$res) $toUser = 0;
		}
		
		$this->view->hasTixing = $this->group->fetchColumn("select count(id) from seckill_phone where action_id = $id and user_id = $user_id");
		$this->view->hasOrder = $this->group->fetchColumn("select count(id) from seckill_record where action_id = $id and user_id = $user_id and `order` > 0");
		
		$sql = "select a.*,b.day,b.starttime,b.endtime from seckill_goods as a left join seckill_time as b on a.action_id = b.action_id and a.`time` = b.id where a.action_id = $id order by `day` asc,`time` asc";
		$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		
		$M = new \Library\Model\Goods();
		$goods = $M->idList(array('idList'=>array_column($tmp,'goods_id')));
		foreach($goods['list'] as $k) $box[$k['id']] = $k;
		
		foreach($tmp as $k){
			$num = $this->group->fetchColumn("select count(id) from seckill_record where action_id = $id and gid = ".$k['id']." and state = '1' and `order` > 0");
			$list[$k['day']][] = array(
				'starttime' => $k['day']." ".$k['starttime'],
				'endtime' => $k['day']." ".$k['endtime'],
				'goods_id' => $k['goods_id'],
				'name' => $box[$k['goods_id']]['name'],
				'img' => $this->config->pcHome."/".$box[$k['goods_id']]['image']['img'],
				'goods_num' => $k['goods_number'],
				'seckill_num' => $num,
				'seckill_price' => round((float)$k['seckill_price'],2),
				'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
				'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
			);
		}
		
		$tmpPrice = 0;
		$fenx = array('img'=>"http://".$_SERVER['SERVER_NAME']."/seckill/images/zf.png",'name'=>'');
		if(isset($list[$nowDay])){
			foreach($list[$nowDay] as $m){
				if($m['market_price'] > $tmpPrice){
					$fenx['img'] = $m['img'];
					$fenx['name'] = $m['name']." 只要（1元），单击链接参与秒杀！";
					$tmpPrice = $m['market_price'];
				}
			}
		}
		
		$show = 0;
		foreach($list as $k=>$v){
			if($k == date('Y-m-d')) break;
			$show = $show + 1;
		}
		if($this->platform == "wx") $this->view->signPackage = $this->wxAPI->get_share();
		$this->view->setVars(array('platform'=>$this->platform,'fenx'=>$fenx,'isGM'=>$isGM,'show'=>$show,'nowDay'=>$nowDay,'nowTime'=>date('Y-m-d H:i:s'),'toUser'=>$toUser,'uid'=>$user_id,'list'=>$list));
		$this->view->info = $info;
		$this->view->paybtnurl = urlencode($this->config->payDomain."/phone/pay/buy?fromid=3&actionid=".$info['id']."&goodsid=");
		$this->view->goback = urlencode("http://".$_SERVER['SERVER_NAME']."/phone/seckill/index/$id/$toUser".( $_GET['from'] != '' ? "?from=".$_GET['from'] : "" ));
		$this->view->wxfrom = $_GET['from'];
	}
	
	public function miaoAction(){
		$id = $this->dispatcher->getParam(0,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$wechaname = $this->session->has('wechaname') ? $this->session->get('wechaname') : "";
		$wxId = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : "";
		
		if(!$user_id){
			die(json_encode(array('state'=>2,'msg'=>'授权已经过期，请重新刷新页面')));
		}
		if(!$id || !$_POST['goodsId']){
			die(json_encode(array('state'=>3,'msg'=>'缺少参数')));
		}
		
		$sql = "select a.*,b.day,b.starttime from seckill_goods as a left join seckill_time as b on a.time = b.id where a.is_remove = '0' and a.action_id = $id and a.goods_id = ".$_POST['goodsId'];
		$goods = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		if(!$goods) die(json_encode(array('state'=>4,'msg'=>'该商品不存在')));
		if($goods['goods_number'] <= 0) die(json_encode(array('state'=>7,'msg'=>'该商品已经秒光')));
		
		$resid = $this->group->fetchColumn("select id from seckill_share where action_id = $id and user_id = $user_id and `time` like '".date('Y-m-d')."%' limit 1");
		if(!$resid) die(json_encode(array('state'=>9,'msg'=>'请先分享后参与秒杀')));
		
		if(!$_POST['toUser'] || $_POST['toUser'] != $user_id) die(json_encode(array('state'=>6,'msg'=>'请从您分享到朋友圈的链接进入参与秒杀活动！')));
		
		if(date('Y-m-d H:i:s') < $goods['day']." ".$goods['starttime']) die(json_encode(array('state'=>8,'msg'=>$goods['starttime'].' 开始秒杀')));
		
		$res = $this->group->fetchColumn("select `time` from seckill_record where action_id = $id and `order` > 0 and order_state = '1' and state = '1' and user_id = $user_id order by `time` desc limit 1");
		if(!empty($res)){
		  if(strtotime($res." +7 day") >= time()) die(json_encode(array('state'=>5,'msg'=>"亲，您已秒中过一次了，请下周继续努力!")));
		}
		$sql = "insert into seckill_record(`action_id`,`gid`,`user_id`,`username`,`wx_id`,`time`,`state`) values('".$id."','".$goods['id']."','".$user_id."','".$wechaname."','".$wxId."','".date('Y-m-d H:i:s')."','1')";
		$res = $this->group->execute($sql);
		if($res){
			die(json_encode(array('state'=>1,'msg'=>'秒杀成功')));
		}else{
			die(json_encode(array('state'=>0,'msg'=>'秒杀失败')));
		}
	}
	
	public function tixingAction(){
		$id = $this->dispatcher->getParam(0,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		
		if($this->platform != "wx") die(json_encode(array('state'=>4,'msg'=>'请在微信中打开')));
		
		if(!$user_id) die(json_encode(array('state'=>2,'msg'=>'授权已经过期，请重新刷新页面')));
		
		if(!$id || !$_POST['goodsId'] || !$_POST['phone']){
			die(json_encode(array('state'=>3,'msg'=>'缺少活动参数')));
		}
		
		$gid = $this->group->fetchColumn("select id from seckill_goods where is_remove = '0' and action_id = $id and goods_id = ".$_POST['goodsId']);
		if(!$gid) die(json_encode(array('state'=>6,'msg'=>'该商品不存在')));
	
		$res = $this->group->fetchColumn("select phone from seckill_phone where action_id = $id and gid = $gid and user_id = $user_id");
		if($res) die(json_encode(array('state'=>5,'msg'=>'该商品您已经提醒过了哦')));
			
		$sql = "insert into seckill_phone(`action_id`,`gid`,`user_id`,`phone`,`time`) values('".$id."','".$gid."','".$user_id."','".$_POST['phone']."','".date('Y-m-d H:i:s')."')";
		$res = $this->group->execute($sql);
		if($res){
			die(json_encode(array('state'=>1,'msg'=>'添加成功')));
		}else{
			die(json_encode(array('state'=>0,'msg'=>'添加失败')));
		}
	}
	
	public function shareAction(){
		$this->view->disable(); header('Content-type:application/json;charset=utf-8;');
		
		$id = $this->dispatcher->getParam(0,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$wxId = $this->session->has('wx_openid') ? $this->session->get('wx_openid') : "";
		$wechaname =  $this->session->has('wechaname') ? $this->session->get('wechaname') : "";
		
		$sql = "insert into seckill_share(`action_id`,`user_id`,`wx_name`,`wx_id`,`time`) values('".$id."','".$user_id."','".$wechaname."','".$wxId."','".date('Y-m-d H:i:s')."')";
		$resA = $this->group->execute($sql);
		if($resA){
			die(json_encode(array('state'=>1,'msg'=>'分享成功')));
		}
		die(json_encode(array('state'=>0,'msg'=>'分享失败')));
	}

	public function payAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		
		$fromId = $this->dispatcher->getParam(0,'int');
		$actionId = $this->dispatcher->getParam(1,'int');
		$goodsId = $this->dispatcher->getParam(2,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		
		$gid = $this->group->fetchColumn("select id from seckill_goods where action_id = $actionId and goods_id = ".$goodsId);
		$state = $this->group->fetchColumn("select order_state from seckill_record where action_id = $actionId and state = '1' and user_id = '".$user_id."' and gid = ".$gid." and `order` > 0 limit 1");
		
		$this->view->actionId = $actionId;
		$this->view->state = $state;
	}


	public function remindAction(){
		$this->view->setVar("payDomain", $this->config->payDomain);
		$this->view->setVar("pcHome", $this->config->pcHome);
		
		$id = $this->dispatcher->getParam(0,'int');
		$toUser = $this->dispatcher->getParam(1,'int');
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;

		$info = $this->activity($id);
		if(!$info){
			$this->flash->error("活动不存在"); exit();
		}
		
		$isGM = 0; 
		if($this->platform == "wx" && ($_GET['from'] == 'timeline' || $_GET['from'] == 'groupmessage')){
			$isGM = 1; //是从微信朋友圈或微信群中进来
		}
		
		if($toUser){
			$res = $this->group->fetchColumn("select id from seckill_share where action_id = $id and user_id = $toUser");
			if(!$res) $toUser = 0;
		}
		
		$this->view->hasTixing = $this->group->fetchColumn("select count(id) from seckill_phone where action_id = $id and user_id = $user_id");
		$this->view->hasOrder = $this->group->fetchColumn("select count(id) from seckill_record where action_id = $id and user_id = $user_id and `order` > 0");
		
		$sql = "select a.*,b.goods_id,b.goods_number,b.seckill_price,c.day,c.starttime,c.endtime from seckill_phone as a";
		$sql .= " left join seckill_goods as b on a.gid = b.id";
		$sql .= " left join seckill_time as c on c.id = b.time";
		$sql .= " where c.action_id = $id and a.action_id = $id and a.user_id = $user_id";
		$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		if(!empty($tmp)){
			$M = new \Library\Model\Goods();
			$goods = $M->idList(array('idList'=>array_column($tmp,'goods_id')));
			foreach($goods['list'] as $k) $box[$k['id']] = $k;
			
			$now = date('Y-m-d H:i:s');
			foreach($tmp as $k){
				$num = $this->group->fetchColumn("select count(id) from seckill_record where action_id = $id and gid = ".$k['id']." and state = '1' and `order` > 0");
				$starttime = $k['day']." ".$k['starttime'];
				$endtime = $k['day']." ".$k['endtime'];
				
				if($starttime < $now and $endtime > $now && $k['goods_number'] > $num){
					$key = 1; //正在疯抢
				}elseif($starttime > $now){
					$key = 2; //即将开始
				}elseif($endtime < $now){
					$key = 3; //已结束
				}else{
					$key = 0; //其他
				}
				$list[$key][] = array(
					'starttime' => $k['day']." ".$k['starttime'],
					'endtime' => $k['day']." ".$k['endtime'],
					'goods_id' => $k['goods_id'],
					'name' => $box[$k['goods_id']]['name'],
					'img' => $this->config->pcHome."/".$box[$k['goods_id']]['image']['img'],
					'goods_num' => $k['goods_number'],
					'seckill_num' => $num,
					'seckill_price' => round((float)$k['seckill_price'],2),
					'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
					'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
				);
			}
		}else{
			$list = false;
		}
		$this->view->setVars(array('platform'=>$this->platform,'isGM'=>$isGM,'toUser'=>$toUser,'info'=>$info,'list'=>$list));
		$this->view->paybtnurl = urlencode($this->config-payDomain."/phone/pay/buy?fromid=3&actionid=".$info['id']."&goodsid=");
		$this->view->goback = urlencode("http://".$_SERVER['SERVER_NAME']."/phone/seckill/index/$id/$toUser".( $_GET['from'] != '' ? "?from=".$_GET['from'] : "" ));
		$this->view->wxfrom = $_GET['from'];
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
			'paySuccessUrl'=>'http://'.$_SERVER['SERVER_NAME'].'/phone/seckill/pay/'.$fromId."/".$actionId."/".$goodsId,
			'changeBuyNum'=>0,
			'shipOnline'=>1,
			'checkExist'=>0
		));
		if($info['starttime'] > date('Y-m-d H:i:s') || $info['endtime'] < date('Y-m-d H:i:s')){
			die(json_encode(array('state'=>0,'data'=>'活动已经结束或还没开始')));
		}
		
		$tmp = $this->group->fetchOne("select * from seckill_goods where action_id = $actionId and goods_id = $goodsId",\Phalcon\Db::FETCH_ASSOC);
		if(!$tmp) die(json_encode(array('state'=>0,'data'=>'该商品没有参与秒杀活动')));
		
		if($tmp['goods_number'] <= 0) die(json_encode(array('state'=>0,'data'=>'该商品已经秒杀完了')));
		
		$res = $this->group->fetchColumn("select id from seckill_record where state = '1' and action_id = $actionId and gid = '".$tmp['id']."' and user_id = $uid and `order` = 0");
		if(!$res) die(json_encode(array('state'=>0,'data'=>'您没有秒到该商品')));
		
		$res = $this->group->fetchColumn("select `time` from seckill_record where action_id = $actionId and `order` > 0 and order_state = '1' and state = '1' and user_id = $uid order by `time` desc limit 1");
		if(!empty($res)){
		  if(strtotime($res." +7 day") >= time()) die(json_encode(array('state'=>0,'data'=>'亲，您已秒中过一次了，请下周继续努力!')));
		}
		$E = new \Library\Model\Ext();
		$regions = $E->regions();
		$M = new \Library\Model\Goods();
		$tmp1 = $M->info(array('goodsId'=>$goodsId));
		
		$data['data']['offsetMoney'] = (float)$tmp1['price']['promote'] - $tmp['seckill_price'];
		if($tmp['shipping'] >= 1){
			$ship = $this->group->fetchOne("select * from seckill_shipping where shipping_id = ".$tmp['shipping'],\Phalcon\Db::FETCH_ASSOC);
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
			$ship = $this->group->fetchAll("select * from seckill_shipping where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
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
			$tmp = $this->group->fetchOne("select id,goods_number from seckill_goods where action_id = $actionId and goods_id = ".$k['goodsId'],\Phalcon\Db::FETCH_ASSOC);
			$this->group->execute("update seckill_goods set goods_number = goods_number - 1,sale_sum = sale_sum + 1 where id = ".$tmp['id']);
			$this->group->execute("update seckill_record set `order` = $orderId,`order_state` = '".($tmp['goods_number'] > 0 ? 1 : 0)."' where action_id = $actionId and state = '1' and user_id = '".$info['userId']."' and gid = ".$tmp['id']." order by time desc limit 1");
			break;
		}
		
		$url = "http://".$_SERVER['SERVER_NAME']."/phone/seckill/index/".$actionId;
		$wx_openid = $this->group->fetchColumn("select wx_id from seckill_record where user_id = ".$info['userId']);
		$data = array('url'=>$url,'first'=>'恭喜你购买成功','name'=>$info['goods'][0]['goodsName'],'money'=>$info['moneyPaid'],'time'=>date('Y-m-d H:i:s'),'remark'=>'');
		
		$E = new \Library\Model\Ext();
		
		$shiptype = $this->group->fetchColumn("select shipping from seckill_goods where action_id = $actionId and goods_id = ".$info['goods'][0]['goodsId']);
		if($shiptype > 0){
			$regions = $E->regions();
			$addr = $this->group->fetchOne("select * from seckill_shipping where action_id = $actionId and shipping_id = $shiptype",\Phalcon\Db::FETCH_ASSOC);
			$data['remark'] = "提货信息:".$addr['linkman']." ".$addr['tel']." ".$regions['list'][$addr['province']].$regions['list'][$addr['city']].$regions['list'][$addr['district']].$addr['address']." ".$addr['best_time'];
		}elseif($shiptype == -1){
			$regions = $E->regions();
			
			$U = new \Library\Model\User();
			$consignee = $U->address(array('uid'=>$info['userId']));
			
			$ship = $this->group->fetchAll("select * from seckill_shipping where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
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