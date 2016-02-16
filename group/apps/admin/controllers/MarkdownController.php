<?php
namespace Apps\Admin\Controllers;

use Library\Com\SecurityContext;
//帮砍后台

class MarkdownController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}
	
	private function canAccess($actionId){
		if(!$actionId) return false;
		$data = $this->group->fetchOne("select * from markdown_list where id = ".(int)$actionId,\Phalcon\Db::FETCH_ASSOC);
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
				'createtime' => date('Y-m-d H:i:s'),
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
						move_uploaded_file($v["tmp_name"],"uploads/markdown/".$imgName);
						$data[$k] = $imgName;
					}
				}else{
					$data[$k] = '';
				}
			}
			if(isset($data['files'])) unset($data['files']);
			if($params[0] == 'add'){
				$data['createtime'] = date('Y-m-d H:i:s');
				$data['create_man'] = SecurityContext::getCurrentUsername();// 直接保存用户名，显示时显示用户名  $this->session->get('admin_id');
				$sql = "insert into markdown_list(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
			}elseif($params[0] == 'modify'){
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update markdown_list set ".$str." where id = ".(int)$params[1];
			}
			$this->group->execute($sql);
			header("Location:/admin/markdown/index");
		}
		
		if(isset($params[0]) && $params[0] == 'add'){
			$this->view->setVars(array('type'=>'add'));
			$this->view->pick("markdown/action");
		}elseif(isset($params[0]) && $params[0] == 'modify'){
			if($this->canAccess($params[1]) == false) exit("您没权限进入该活动");
			$info = $this->group->fetchOne("select * from markdown_list where id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'modify','info'=>$info));
			$this->view->pick("markdown/action");
		}elseif(isset($params[0]) && $params[0] == 'delete'){
			if($this->canAccess($params[1]) == false) exit("您没权限进入该活动");
			$this->group->execute("delete from markdown_list where id = ".(int)$params[1]);
			header("Location:/admin/markdown/index");
		}
		//$tmp = $this->group->fetchAll("select * from admin_user",\Phalcon\Db::FETCH_ASSOC);
		//foreach($tmp as $k) $adminUserList[$k['id']] = $k;
		//$where = $this->session->get('gadmin_privilege_id') == 1 ? "" : "where create_man = ".$this->session->get('gadmin_id');
		$where = SecurityContext::getCurrentUsername() == 'admin'? "" : "where create_man = " . SecurityContext::getCurrentUsername();
		$data = $this->group->fetchAll("select * from markdown_list ".$where,\Phalcon\Db::FETCH_ASSOC);
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
				
				$total = $this->group->fetchColumn("select count(id) from markdown_goods where action_id = $actionId");
				$tmp1 = $this->group->fetchAll("select * from markdown_goods where action_id = $actionId $order limit $offset,$limit",\Phalcon\Db::FETCH_ASSOC);
				$tmp2 = $M->idList(array('idList'=>array_column($tmp1,"goods_id")));
				foreach($tmp2['list'] as $k) $list[$k['id']] = $k;
				
				foreach($tmp1 as $k){
					$k['goods_name'] = $list[$k['goods_id']]['name'];
					$k['price'] = $list[$k['goods_id']]['price'];
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
					'range_min' => $post['range_min'],
					'range_max' => $post['range_max'],
					'lowest_price' => $post['lowest_price'],
					'init_join' => $post['init_join'],
					'sort' => $post['sort'],
					'is_remove' => isset($post['isRemove']) ? $post['isRemove'] : 0,
					'shipping' => isset($post['shipping']) ? $post['shipping'] : 0,
				);
				$db = $this->group;
				$res = $db->execute("insert into markdown_goods(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
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
				$sql = "update markdown_goods set goods_number='".$post['goods_number']."',range_min='".$post['range_min']."',range_max='".$post['range_max']."',sort='".$post['sort']."'";
				$sql .= ",lowest_price='".$post['lowest_price']."',is_remove='".($post['isRemove'] ? $post['isRemove'] : 0)."',shipping='".($post['shipping'] ? $post['shipping'] : 0)."'";
				$sql .= ",init_join='".$post['init_join']."',`desc`='".$post['desc']."' where action_id = $actionId and goods_id = $goodsId";
				$this->group->execute($sql);
				header("Location:/admin/markdown/goods/list/".$actionId);
			}
			$addrlist = $this->group->fetchAll("select * from markdown_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$info = $M->info(array('goodsId'=>$goodsId));
			$data = $this->group->fetchOne("select * from markdown_goods where action_id = $actionId and goods_id = ".$goodsId,\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'goodsId'=>$goodsId,'info'=>$info,'data'=>$data,'addrlist'=>$addrlist));
			$this->view->pick("markdown/addgoods");
		}elseif($type == 'delete'){
			$gid = isset($params[2]) ? (int)$params[2] : 0;
			if(!$actionId || !$gid) exit("缺少参数");
			
			$this->group->execute("delete from markdown_goods where action_id = $actionId and id = $gid");
			header("Location:/admin/markdown/goods/list/".$actionId);
		}
	}
	
	public function hasgoodsAction(){
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$goodsId = isset($params[1]) ? (int)$params[1] : 0;
		if(!$actionId || !$goodsId || $this->canAccess($actionId) == false) die(json_encode(array('state'=>0,'msg'=>'参数错误')));
		
		$tmp = $this->group->fetchOne("select * from markdown_goods where action_id = $actionId and goods_id = $goodsId",\Phalcon\Db::FETCH_ASSOC);
		if(empty($tmp)){
			die(json_encode(array('state'=>1,'msg'=>'该商品可选')));
		}
		die(json_encode(array('state'=>0,'msg'=>'该商品已经选择过了')));
	}
	
	public function shippingAction(){
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = (int)$params[1];
		$shipId = isset($params[2]) ? (int)$params[2] : 0;
	
		$info = $this->group->fetchOne("select * from markdown_shipping where shipping_id = $shipId",\Phalcon\Db::FETCH_ASSOC);
		$E = new \Library\Model\Ext();
		$province = $E->regions(array('pid'=>1));
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			if($type == 'add'){
				$sql = "insert into `markdown_shipping`(`action_id`,`province`,`city`,`district`,`address`,`linkman`,`tel`,`best_time`) ";
				$sql .= "values('".$actionId."','".$post['province']."','".$post['city']."','".$post['district']."','".$post['address']."'";
				$sql .= ",'".$post['linkman']."','".$post['tel']."','".$post['best_time']."')";
			}else{
				$sql = "update markdown_shipping set province='".$post['province']."',city='".$post['city']."',district='".$post['district']."'";
				$sql .= ",address='".$post['address']."',linkman='".$post['linkman']."',tel='".$post['tel']."',best_time='".$post['best_time']."' where shipping_id=$shipId";
			}
			$this->group->execute($sql);
			header("Location:/admin/markdown/shipping/list/".$actionId);
		}
		
		$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'province'=>$province['list']));
		if($type == 'list'){
			$list = $this->group->fetchAll("select * from markdown_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('list'=>$list,'regions'=>$E->regions()));
			$this->view->pick("markdown/shippinglist");
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
		$list = $order->info(array('fromId'=>2,'actionId'=>$actionId));
		
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
			if(isset($_GET['parentId']) && $_GET['parentId']){
				$where .= " and a.parent_id = '".$_GET['parentId']."'";
			}
			if(isset($_GET['gId']) && $_GET['gId']){
				$where .= " and a.gid = '".$_GET['gId']."'";
			}
			
			$total = $this->group->fetchColumn("select count(id) from markdown_record as a where action_id = $actionId $where");
			$sql = "select ifnull(b.goods_id,0) as goods_id,a.* from markdown_record as a left join markdown_goods as b on a.gid = b.id where a.action_id = $actionId $where $order limit $offset,$limit";
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
				$where .= " and a.wx_id = '".$_GET['wxId']."'";
			}
			if(isset($_GET['userId']) && $_GET['userId']){
				$where .= " and a.user_id = '".$_GET['userId']."'";
			}
			if(isset($_GET['gId']) && $_GET['gId']){
				$where .= " and a.gid = '".$_GET['gId']."'";
			}
			
			$total = $this->group->fetchColumn("select count(id) from markdown_share as a where action_id = $actionId ".$where);
			$sql = "select b.goods_id,a.* from markdown_share as a left join markdown_goods as b on a.gid = b.id where a.action_id = $actionId ".$where." limit $offset,$limit";
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
	
	public function paiAction(){
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		
		$funs = new \Library\Com\Funs();
		
		$order = new \Library\Model\Order();
		$list = $order->info(array('fromId'=>2,'actionId'=>$actionId,'payStatus'=>2));
		foreach($list['list'] as $k){
			$data[$k['userId']] = array('goods_name'=>$k['goods'][0]['goodsName'],'goods_id'=>$k['goods'][0]['goodsId']);
		}
		
		$str = "砍了多少刀\t商品id\t商品名称\t用户id\t发起id\t砍了多少钱\t\n";
	    $str = iconv('utf-8','gb2312',$str);
		
		$sql = "SELECT COUNT(a.id) AS num,a.gid,b.goods_id,a.parent_id,a.user_id,SUM(a.lower_money) as money FROM markdown_record AS a LEFT JOIN markdown_goods AS b ON a.gid=b.id GROUP BY a.parent_id";
		$tmp = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			if(isset($data[$k['user_id']]) && $data[$k['user_id']]['goods_id'] == $k['goods_id']){
				$name = iconv('utf-8','gb2312//IGNORE',$data[$k['user_id']]['goods_name']);
				$str .= $k['num']."\t".$k['gid']."\t".$name."\t".$k['user_id']."\t".$k['parent_id']."\t".$k['money']."\r\n";
			}
		}
	    $filename = date('Ymd').'.xls';
	    $funs->exportExcel($filename, $str);
	}
}

?>