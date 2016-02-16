<?php
namespace Apps\Admin\Controllers;

use Library\Com\SecurityContext;

class SeckillController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}
	
	private function canAccess($actionId){
		if(!$actionId) return false;
		$data = $this->group->fetchOne("select * from seckill_list where id = ".(int)$actionId,\Phalcon\Db::FETCH_ASSOC);
		if(empty($data)) return false;
		
		return true;
	}
	
	public function indexAction(){
		$params = $this->dispatcher->getParams();
        $user_id = $this->session->get("user_id");
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			$data = array(
				'name' => $post['name'],
				'starttime' => $post['starttime'],
				'endtime' => $post['endtime'],
				'head_url' => $post['head_url'],
				'adv1_url' => $post['adv1_url'],
				'adv2_url' => $post['adv2_url'],
				'adv3_url' => $post['adv3_url'],
				'adv4_url' => $post['adv4_url'],
				'desc' => $post['desc'],
			);
			foreach($_FILES as $k=>$v){
				$urlName = str_replace('_img','_url',$k);
				if($data[$urlName] != ''){
					if($v['size'] > 0){
						$imgType = substr($v["type"],6);
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						move_uploaded_file($v["tmp_name"],"uploads/seckill/".$imgName);
						$data[$k] = $imgName;
					}
				}else{
					$data[$k] = '';
				}
			}
			if(isset($data['files'])) unset($data['files']);
			if($params[0] == 'add'){
				$data['createtime'] = date('Y-m-d H:i:s');
				$data['create_man'] = SecurityContext::getCurrentUsername(); // 直接保存用户名，显示时显示用户名 $this->session->get('admin_id');
				$sql = "insert into seckill_list(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
			}elseif($params[0] == 'modify'){
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update seckill_list set ".$str." where id = ".(int)$params[1];
			}
			$this->group->execute($sql);
			header("Location:/admin/seckill/index");
		}
		
		if(isset($params[0]) && $params[0] == 'add'){
			$this->view->setVars(array('type'=>'add'));
			$this->view->pick("seckill/action");
		}elseif(isset($params[0]) && $params[0] == 'modify'){
			if($this->canAccess($params[1]) == false) exit("您没权限进入该活动");
			$info = $this->group->fetchOne("select * from seckill_list where id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'modify','info'=>$info));
			$this->view->pick("seckill/action");
		}elseif(isset($params[0]) && $params[0] == 'delete'){
			if($this->canAccess($params[1]) == false) exit("您没权限进入该活动");
			$this->group->execute("delete from seckill_list where id = ".(int)$params[1]);
			header("Location:/admin/seckill/index");
		}
		//$tmp = $this->group->fetchAll("select * from admin_user",\Phalcon\Db::FETCH_ASSOC);
		//foreach($tmp as $k) $adminUserList[$k['id']] = $k;
		//$where = $this->session->get('gadmin_privilege_id') == 1 ? "" : "where create_man = ".$this->session->get('gadmin_id');
		$where = SecurityContext::getCurrentUsername() == 'admin'? "" : "where create_man = " . SecurityContext::getCurrentUsername();
		$data = $this->group->fetchAll("select * from seckill_list ".$where,\Phalcon\Db::FETCH_ASSOC);
		$this->view->data = $data;
		//$this->view->adminUserList = $adminUserList;
	}
	
	public function goodsAction(){
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = $params[1] ? (int)$params[1] : 0;
		if($this->canAccess($actionId) == false) exit("您没权限进入该活动");
		$M = new \Library\Model\Goods();
		if($type == 'list'){
			$ajax = isset($params[2]) ? (int)$params[2] : 0;
			if($ajax){
				$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
				$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
				$order = isset($_GET['sort']) ? " order by ".$_GET['sort']." ".$_GET['order'] : "";
				
				$total = $this->group->fetchColumn("select count(id) from seckill_goods where action_id = $actionId");
				$tmp1 = $this->group->fetchAll("select * from seckill_goods where action_id = $actionId $order limit $offset,$limit",\Phalcon\Db::FETCH_ASSOC);
				$tmp2 = $M->idList(array('idList'=>array_column($tmp1,"goods_id")));
				foreach($tmp2['list'] as $k) $list[$k['id']] = $k;
				
				foreach($tmp1 as $k){
					$k['goods_name'] = $list[$k['goods_id']]['name'];
					$k['price'] = $list[$k['goods_id']]['price'];
					//$k['sales_sum'] = $list[$k['goods_id']]['sales_num'];
					$k['sales_sum'] = 0;
					$data[] = $k;
				}
				die(json_encode(array('total'=>$total,'rows'=>$data)));
			}
			$this->view->setVars(array('actionId'=>$actionId,'catStr'=>$M->CatStr()));
		}elseif($type == 'add'){
			header('Content-type:application/json;charset=utf-8;');
			if(!$actionId) exit("缺少参数");
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				$data = array(
					'action_id' => $actionId,
					'goods_id' => $post['goods_id'],
					'goods_number' => $post['goods_number'],
					'seckill_price' => $post['seckill_price'],
					'is_remove' => isset($post['isRemove']) ? $post['isRemove'] : 0,
					'shipping' => isset($post['shipping']) ? $post['shipping'] : 0,
				);
				$db = $this->group;
				$res = $db->execute("insert into seckill_goods(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
				if($res){
					$data['id'] = $db->lastInsertId();
					$data['goods_name'] = $post['goods_name'];
					$data['promote'] = $post['promote'];
					$data['market'] = $post['market'];
					die(json_encode(array('state'=>1,'msg'=>$data)));
				}
				die(json_encode(array('state'=>0,'msg'=>'添加失败')));
			}
		}elseif($type == 'modify'){
			$goodsId = isset($params[2]) ? (int)$params[2] : 0;
			if(!$actionId || !$goodsId) exit("缺少参数");
			
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				$sql = "update seckill_goods set goods_number='".$post['goods_number']."',seckill_price='".$post['seckill_price']."',is_remove='".($post['isRemove'] ? $post['isRemove'] : 0)."'";
				$sql .= ",`time`=".($post['time']?$post['time']:0).",shipping='".($post['shipping'] ? $post['shipping'] : 0)."',`desc`='".$post['desc']."' where action_id = $actionId and goods_id = $goodsId";
				$this->group->execute($sql);
				header("Location:/admin/seckill/goods/list/".$actionId);
			}
			$addrlist = $this->group->fetchAll("select * from seckill_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$info = $M->info(array('goodsId'=>$goodsId));
			$data = $this->group->fetchOne("select * from seckill_goods where action_id = $actionId and goods_id = ".$goodsId,\Phalcon\Db::FETCH_ASSOC);
			$time = $this->group->fetchAll("select * from seckill_time where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'goodsId'=>$goodsId,'info'=>$info,'data'=>$data,'addrlist'=>$addrlist,'time'=>$time));
			$this->view->pick("seckill/addgoods");
		}elseif($type == 'delete'){
			$gid = isset($params[2]) ? (int)$params[2] : 0;
			if(!$actionId || !$gid) exit("缺少参数");
			
			$this->group->execute("delete from seckill_goods where action_id = $actionId and id = $gid");
			header("Location:/admin/seckill/goods/list/".$actionId);
		}
	}
	
	public function shippingAction(){
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = (int)$params[1];
		$shipId = isset($params[2]) ? (int)$params[2] : 0;
	
		$info = $this->group->fetchOne("select * from seckill_shipping where shipping_id = $shipId",\Phalcon\Db::FETCH_ASSOC);
		$E = new \Library\Model\Ext();
		$province = $E->regions(array('pid'=>1));
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			if($type == 'add'){
				$sql = "insert into `seckill_shipping`(`action_id`,`province`,`city`,`district`,`address`,`linkman`,`tel`,`best_time`) ";
				$sql .= "values('".$actionId."','".$post['province']."','".$post['city']."','".$post['district']."','".$post['address']."'";
				$sql .= ",'".$post['linkman']."','".$post['tel']."','".$post['best_time']."')";
			}else{
				$sql = "update seckill_shipping set province='".$post['province']."',city='".$post['city']."',district='".$post['district']."'";
				$sql .= ",address='".$post['address']."',linkman='".$post['linkman']."',tel='".$post['tel']."',best_time='".$post['best_time']."' where shipping_id=$shipId";
			}
			$this->group->execute($sql);
			header("Location:/admin/seckill/shipping/list/".$actionId);
		}
		
		$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'province'=>$province['list']));
		if($type == 'list'){
			$list = $this->group->fetchAll("select * from seckill_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('list'=>$list,'regions'=>$E->regions()));
			$this->view->pick("seckill/shippinglist");
		}elseif($type == 'modify'){
			$city = $E->regions(array('pid'=>$info['province']));
			$district = $E->regions(array('pid'=>$info['city']));
			
			$this->view->city = $city['list'];
			$this->view->district = $district['list'];
		}
		$this->view->setVars(array('info'=>$info));
	}
	
	public function orderAction(){
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		
		$order = new \Library\Model\Order();
		$payment = $order->channel();
		foreach($payment['list'] as $k) $payment2[$k['id']] = $k['payName'];
		$list = $order->info(array('fromId'=>3,'actionId'=>$actionId));
		
		$U = new \Library\Model\User();
		$user = $U->info(array('idList'=>array_column($list['list'],'userId')));
		foreach($user['list'] as $k) $user2[$k['userId']] = $k; 
		
		foreach($list['list'] as $k){
			$k['username'] = $user2[$k['userId']]['nickName'];
			$k['wx_openid'] = $user2[$k['userId']]['oauthOpenid'];
			$k['wx_unionid'] = $user2[$k['userId']]['oauthUnionid'];
			$k['headImg'] = $user2[$k['userId']]['headPic'];
			$k['pay_name'] = $payment2[$k['payId']];
			$k['goods_name'] = $k['goods'][0]['goodsName'];
			$k['order_state'] = $k['status']['pay'] == 2 ? $this->group->fetchColumn("select order_state from seckill_record where `order` = ".$k['orderId']) : "1";
			$data[] = $k;
		}
		
		$this->view->setVars(array('actionId'=>$actionId,'data'=>$data,'num'=>$list['num']));
	}
	
	public function userAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$ajax = $this->dispatcher->getParam(1,'int');
		if($ajax){
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
			$order = isset($_GET['sort']) ? " order by ".$_GET['sort']." ".$_GET['order'] : "";
			
			$where = "";
			if(isset($_GET['wxId']) && $_GET['wxId']){
				$where .= " and a.wx_id = '".$_GET['wxId']."'";
			}
			if(isset($_GET['userId']) && $_GET['userId']){
				$where .= " and a.user_id = '".$_GET['userId']."'";
			}
			if(isset($_GET['gId']) && $_GET['gId']){
				$where .= " and a.gid = '".$_GET['gId']."'";
			}
			
			$total = $this->group->fetchColumn("select count(id) from seckill_record as a where action_id = $actionId $where");
			$sql = "select ifnull(b.goods_id,0) as goods_id,a.* from seckill_record as a left join seckill_goods as b on a.gid = b.id where a.action_id = $actionId $where $order limit $offset,$limit";
			$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(empty($res)) die(json_encode(array('total'=>0,'rows'=>array())));
			
			$M = new \Library\Model\Goods();
			$tmp = $M->idList(array('idList'=>array_column($res,"goods_id")));
			foreach($tmp['list'] as $k) $list[$k['id']] = $k;
			
			foreach($res as $k){
				$k['goods_name'] = isset($list[$k['goods_id']]) ? $list[$k['goods_id']]['name'] : "";
				$data[] = $k;
			}
			
			die(json_encode(array('total'=>$total,'rows'=>$data)));
		}
		$this->view->setVars(array('actionId'=>$actionId));
	}
	
	public function shareAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$ajax = $this->dispatcher->getParam(1,'int');
		if($ajax){
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
			
			$where = "";
			if(isset($_GET['wxId']) && $_GET['wxId']){
				$where .= " and wx_id = '".$_GET['wxId']."'";
			}
			if(isset($_GET['userId']) && $_GET['userId']){
				$where .= " and user_id = '".$_GET['userId']."'";
			}
			$total = $this->group->fetchColumn("select count(id) from seckill_share where action_id = $actionId ".$where);
			$sql = "select * from seckill_share where action_id = $actionId ".$where." limit $offset,$limit";
			$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(empty($res)) die(json_encode(array('total'=>0,'rows'=>array())));
			
			$M = new \Library\Model\Goods();
			$tmp = $M->idList(array('idList'=>array_column($res,"goods_id")));
			foreach($tmp['list'] as $k) $list[$k['id']] = $k;
			
			foreach($res as $k){
				$k['goods_name'] = $list[$k['goods_id']]['name'];
				$data[] = $k;
			}
			
			die(json_encode(array('total'=>$total,'rows'=>$data)));
		}
		$this->view->setVars(array('actionId'=>$actionId));
	}
	
	public function timeAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$actionId = $this->dispatcher->getParam(1,'int');
		
		if($type == 'add' && $this->request->isPost() == true){
			header('Content-type:application/json;charset=utf-8;');
			$input = file_get_contents('php://input'); $input = json_decode($input,true);
			
			$sql = "insert into seckill_time(`action_id`,`day`,`starttime`,`endtime`) values('".$input['action_id']."','".$input['day']."','".$input['starttime']."','".$input['endtime']."')";
			$res = $this->group->execute($sql);
			if($res){
				die(json_encode(array('state'=>1,'msg'=>'添加成功')));
			}else{
				die(json_encode(array('state'=>0,'msg'=>'添加失败')));
			}
		}
		
		if($type == 'modify' && $this->request->isPost() == true){
			header('Content-type:application/json;charset=utf-8;');
			$input = file_get_contents('php://input'); $input = json_decode($input,true);
			
			$sql = "update seckill_time set day = '".$input['day']."',starttime = '".$input['starttime']."',endtime = '".$input['endtime']."' where id = '".$input['id']."' and action_id = $actionId";
			$res = $this->group->execute($sql);
			if($res){
				die(json_encode(array('state'=>1,'msg'=>'修改成功')));
			}else{
				die(json_encode(array('state'=>0,'msg'=>'修改失败')));
			}
		}
		
		if($type == 'del'){
			$id = $this->dispatcher->getParam(2,'int');
			$res = $this->group->execute("delete from seckill_time where id = $id");
			if($res){
				die(json_encode(array('state'=>1,'msg'=>'删除成功')));
			}else{
				die(json_encode(array('state'=>0,'msg'=>'删除失败')));
			}
		}
		
		if($type == 'list'){
			$list = $this->group->fetchAll("select * from seckill_time where action_id = $actionId order by day asc,starttime asc",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('actionId'=>$actionId,'list'=>$list));
		}
	}
	
	public function statisticsAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$type = $this->dispatcher->getParam(1,'int');
		
		if($type == 1){
			//用户分享排名
			$sql = "SELECT COUNT(id) AS num,user_id,wx_name,wx_id FROM seckill_share WHERE action_id = $actionId GROUP BY user_id ORDER BY num DESC";
			$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k) $userlist[$k['user_id']] = $k;
			
			//分享链接点击
			$sql = "SELECT COUNT(id) AS num,from_user_id FROM seckill_click WHERE action_id = $actionId GROUP BY from_user_id ORDER BY num DESC";
			$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k) $clicklist[$k['from_user_id']] = $k;
			
			$this->view->setVars(array('actionId'=>$actionId,'type'=>$type,'userlist'=>$userlist,'clicklist'=>$clicklist));
		}elseif($type == 2){
			$data = array();
			$tmp = $this->group->fetchAll("select * from seckill_record where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k){
				list($day,$time) = explode(" ",$k['time']);
				if(!isset($data[$day]) || !isset($data[$day]['miao'])){
					$data[$day]['miao'] = 1;
				}else{
					$data[$day]['miao'] = $data[$day]['miao'] + 1;
				}
			}
			
			$tmp = $this->group->fetchAll("select * from seckill_share where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k){
				list($day,$time) = explode(" ",$k['time']);
				if(!isset($data[$day]) || !isset($data[$day]['share'])){
					$data[$day]['share'] = 1;
				}else{
					$data[$day]['share'] = $data[$day]['share'] + 1;
				}
			}
			
			$tmp = $this->group->fetchAll("select * from seckill_click where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			foreach($tmp as $k){
				list($day,$time) = explode(" ",$k['time']);
				if(!isset($data[$day]) || !isset($data[$day][$k['from_type']])){
					$data[$day][$k['from_type']] = 1;
				}else{
					$data[$day][$k['from_type']] = $data[$day][$k['from_type']] + 1;
				}
			}
			ksort($data);
			$this->view->setVars(array('actionId'=>$actionId,'type'=>$type,'data'=>$data));
		}
	}
}

?>