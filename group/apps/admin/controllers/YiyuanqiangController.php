<?php
namespace Apps\Admin\Controllers;

use Library\Com\SecurityContext;
//一元抢后台

class YiyuanqiangController extends ControllerBase
{
	public function initialize()
	{
		parent::initialize();
	}
	
	public function indexAction()
	{
		header("Content-type: text/html; charset=utf-8");
		
		$params = $this->dispatcher->getParams();
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$data = array(
					'module' => $post['module'],
					'createtime' => date('Y-m-d H:i:s'),
					'head_url' => $post['head_url'],
					'adv1_url' => $post['adv1_url'],
					'adv2_url' => $post['adv2_url'],
					'adv3_url' => $post['adv3_url'],
					'adv4_url' => $post['adv4_url'],
					'desc' => $post['desc'],
					'radio1' => $post['radio1'],
					'radio2' => $post['radio2'],
					'radio3' => $post['radio3'],
					'radio1_url' => $post['radio1_url'],
					'radio2_url' => $post['radio2_url'],
					'radio3_url' => $post['radio3_url'],
					'work_phone' => $post['work_phone'],
					'work_QQ' => $post['work_QQ'],
					'work_time' => $post['work_time'],
					'is_close' => $post['is_close'],
					'yizhangou_id' => $post['yizhangou_id'],
			);
			foreach($_FILES as $k=>$v)
			{
				$urlName = str_replace('_img','_url',$k);
				if($data[$urlName] != '')
				{
					if($v['size'] > 0)
					{
						$imgType = substr($v["type"],6);
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						move_uploaded_file($v["tmp_name"],"uploads/yiyuanqiang/".$imgName);
						$data[$k] = $imgName;
					}
				}
				else
				{
					$data[$k] = '';
				}
			}
			
			if(isset($data['files'])) unset($data['files']);
			if($params[0] == 'add')
			{
				
				$data['createtime'] = date('Y-m-d H:i:s');
				$data['creater'] = SecurityContext::getCurrentUsername(); //$this->session->get('admin_id');
				$sql = "insert into yiyuanqiang_list(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
			}
			elseif($params[0] == 'modify')
			{
// 				var_dump($data);die;
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update yiyuanqiang_list set ".$str." where id = ".(int)$params[1];
			}
			$this->group->execute($sql);
			header("Location:/admin/yiyuanqiang/index");
			
		}
		
		if(isset($params[0]) && $params[0] == 'add')
		{
			$this->view->setVars(array('type'=>'add'));
			$this->view->pick("yiyuanqiang/module");
		}
		elseif(isset($params[0]) && $params[0] == 'modify')
		{
			
			$info = $this->group->fetchOne("select * from yiyuanqiang_list where id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'modify','info'=>$info,'actionid'=>(int)$params[1]));
			$this->view->pick("yiyuanqiang/module");
		}
		elseif(isset($params[0]) && $params[0] == 'delete')
		{
			$this->group->execute("delete from yiyuanqiang_list where id = ".(int)$params[1]);
			header("Location:/admin/yiyuanqiang/index");
		}
		elseif(isset($params[0]) && $params[0] == 'delimg')
		{
			$this->group->execute("update yiyuanqiang_list set ". $params[2] ."='' where id = ".(int)$params[1]);
// 			die("update yiyuanqiang_list set ". $params[2] ."='' where id = ".(int)$params[1]);
			header("Location:/admin/yiyuanqiang/index/modify/".(int)$params[1]);
		}
		
		
// 		$tmp = $this->group->fetchAll("select * from admin_user",\Phalcon\Db::FETCH_ASSOC);
// 		foreach($tmp as $k) $adminUserList[$k['id']] = $k;
		//$where = $this->session->get('gadmin_privilege_id') == 1 ? "" : "where create_man = ".$this->session->get('gadmin_id');
		$where = SecurityContext::getCurrentUsername() == 'admin'? "" : " where creater = " . SecurityContext::getCurrentUsername();
		$data = $this->group->fetchAll("select * from yiyuanqiang_list ",\Phalcon\Db::FETCH_ASSOC);
		$this->view->data = $data;
	}
	
	public function goodsAction()
	{
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = $params[1] ? (int)$params[1] : 0;
		$G = new \Library\Model\Goods();
		
		if($type == 'list')
		{
			$ajax = isset($params[2]) ? (int)$params[2] : 0;
			if($ajax)
			{
				$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
				$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
				$order = isset($_GET['sort']) ? " order by ".$_GET['sort']." ".$_GET['order'] : "";
				
				if(isset($_GET['keyWords']) && $_GET['keyWords']){
					$keyWords = trim($_GET['keyWords']);
				}
		
				
				if(isset($keyWords))
				{
					$tmp2 = $G->lists(array('keyWords'=>$keyWords));
					$goodsIdList = '';
					foreach($tmp2['list'] as $k=>$v) $goodsIdList .=$v['id'] . ',';
					$goodsIdList = mb_substr($goodsIdList, 0,-1);
					$where = '';
					if(!empty($goodsIdList))
					{
						$where = " and goods_id in ($goodsIdList)";
						$total = $this->group->fetchColumn("select count(id) from yiyuanqiang_goods where action_id = $actionId $where");
						if($total == 0)
						{
							die(json_encode(array('total'=>0,'rows'=>array())));
						}
						$tmp1 = $this->group->fetchAll("select * from yiyuanqiang_goods where action_id = $actionId $where $order limit $offset,$limit",\Phalcon\Db::FETCH_ASSOC);
// 						var_dump($tmp1);die;
					}
					else 
					{
						die(json_encode(array('total'=>0,'rows'=>array())));
					}
				}
				else
				{
					$total = $this->group->fetchColumn("select count(id) from yiyuanqiang_goods where action_id = $actionId");
					$tmp1 = $this->group->fetchAll("select * from yiyuanqiang_goods where action_id = $actionId $order limit $offset,$limit",\Phalcon\Db::FETCH_ASSOC);
					$tmp2 = $G->idList(array('idList'=>array_column($tmp1,"goods_id")));
				}
				foreach($tmp2['list'] as $k) $list[$k['id']] = $k;
		
				foreach($tmp1 as $k)
				{
					$k['goods_name'] = $list[$k['goods_id']]['name'];
					$k['price'] = $list[$k['goods_id']]['price'];
					$data[] = $k;
				}
				die(json_encode(array('total'=>$total,'rows'=>$data)));
			}
			//省市下拉
			$E = new \Library\Model\Ext();
			$province = $E->regions(array('pid'=>1));
			$this->view->setVars(array('type'=>'add','province'=>$province['list']));
			
			$this->view->setVars(array('actionId'=>$actionId,'catStr'=>$G->CatStr()));
		}
		elseif($type == 'add')
		{
			header('Content-type:application/json;charset=utf-8;');
			if(!$actionId) exit("缺少参数");
			if($this->request->isPost() == true)
			{
				$post = $this->request->getPost();
				$data = array(
						'action_id' => $actionId,
						'goods_id' => $post['goods_id'],
						'active_quantity' => $post['active_quantity'],
						'goods_quantity' => $post['goods_quantity'],
						'range_min' => $post['range_min'],
						'range_max' => $post['range_max'],
						'lowest_price' => $post['lowest_price'],
						'discount_price' => $post['discount_price'],
						'init_join' => $post['init_join'],
						'sort' => $post['sort'],
						'is_remove' => isset($post['isRemove']) ? $post['isRemove'] : 0,
						'shipping' => isset($post['shipping']) ? $post['shipping'] : 0,
						'starttime' => $post['starttime'],
						'endtime' => $post['endtime'],
						'city' => $post['city'],
				);
				$db = $this->group;
				$res = $db->execute("insert into yiyuanqiang_goods(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
				if($res)
				{
					$data['id'] = $db->lastInsertId();
					$data['goods_name'] = $post['goods_name'];
					$data['promote'] = $post['promote'];
					$data['market'] = $post['market'];
					die(json_encode(array('state'=>1,'msg'=>$data)));
				}
				die(json_encode(array('state'=>0,'msg'=>'添加失败')));
			}
		}
		elseif($type == 'modify')
		{
			$id = isset($params[2]) ? (int)$params[2] : 0;
			if(!$actionId || !$id) exit("缺少参数");
				
			if($this->request->isPost() == true)
			{
				$post = $this->request->getPost();
				
				$fileSql = "";
				foreach($_FILES as $k=>$v)
				{
					if($v['size'] > 0)
					{
						$imgType = substr($v["type"],6);
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						move_uploaded_file($v["tmp_name"],"uploads/yiyuanqiang/".$imgName);
						$fileSql .= ",{$k}='{$imgName}'";
					}
				
				}
					
				
				$sql = "update yiyuanqiang_goods set goods_quantity='".$post['goods_quantity']."',range_min='".$post['range_min']."',range_max='".$post['range_max']."',sort='".$post['sort']."'";
				$sql .= ",lowest_price='".$post['lowest_price']."',is_remove='".($post['isRemove'] ? $post['isRemove'] : 0)."',shipping='".($post['shipping'] ? $post['shipping'] : 0)."',is_top='".($post['isTop'] ? $post['isTop'] : 0)."'";
				$sql .= ",init_join='".$post['init_join']."',`desc`='".$post['desc'] . "',discount_price='{$post['discount_price']}'";
				$sql .= ",starttime='{$post['starttime']}',endtime='{$post['endtime']}',active_quantity='{$post['active_quantity']}',goods_category='{$post['goods_category']}',goods_item='{$post['goods_item']}',discount='{$post['discount']}'";
				$sql .= $fileSql;
				$sql .= " where action_id = $actionId and id = $id";
				$this->group->execute($sql);
				header("Location:/admin/yiyuanqiang/goods/list/".$actionId);
			}
			$addrlist = $this->group->fetchAll("select * from yiyuanqiang_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$goodsInfo = $this->group->fetchOne("select goods_id from yiyuanqiang_goods where id={$id}",\Phalcon\Db::FETCH_ASSOC);
			$goodsId = $goodsInfo['goods_id'];
			$info = $G->info(array('goodsId'=>$goodsId));
			$data = $this->group->fetchOne("select * from yiyuanqiang_goods where action_id = $actionId and id = ".$id,\Phalcon\Db::FETCH_ASSOC);
// 			var_dump($data);die;
			$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'goodsId'=>$goodsId,'info'=>$info,'data'=>$data,'addrlist'=>$addrlist, 'pcHome'=>$this->config->pcHome));
			$this->view->pick("yiyuanqiang/addgoods");
		}
		elseif($type == 'delete')
		{
			$gid = isset($params[2]) ? (int)$params[2] : 0;
			if(!$actionId || !$gid) exit("缺少参数");
				
			$this->group->execute("delete from yiyuanqiang_goods where action_id = $actionId and id = $gid");
			header("Location:/admin/yiyuanqiang/goods/list/".$actionId);
		}
	}
	
	public function hasgoodsAction()
	{
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$goodsId = isset($params[1]) ? (int)$params[1] : 0;
		if(!$actionId || !$goodsId || $this->canAccess($actionId) == false) die(json_encode(array('state'=>0,'msg'=>'参数错误')));
	
		$tmp = $this->group->fetchOne("select * from yiyuanqiang_goods where action_id = $actionId and goods_id = $goodsId",\Phalcon\Db::FETCH_ASSOC);
		if(empty($tmp))
		{
			die(json_encode(array('state'=>1,'msg'=>'该商品可选')));
		}
		die(json_encode(array('state'=>0,'msg'=>'该商品已经选择过了')));
	}
	
	public function shippingAction()
	{
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = (int)$params[1];
		$shipId = isset($params[2]) ? (int)$params[2] : 0;
	
		$info = $this->group->fetchOne("select * from yiyuanqiang_shipping where shipping_id = $shipId",\Phalcon\Db::FETCH_ASSOC);
		$E = new \Library\Model\Ext();
		$province = $E->regions(array('pid'=>1));
	
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			if($type == 'add')
			{
				$sql = "insert into `yiyuanqiang_shipping`(`action_id`,`province`,`city`,`district`,`address`,`linkman`,`tel`,`best_time`) ";
				$sql .= "values('".$actionId."','".$post['province']."','".$post['city']."','".$post['district']."','".$post['address']."'";
				$sql .= ",'".$post['linkman']."','".$post['tel']."','".$post['best_time']."')";
			}
			else
			{
				$sql = "update yiyuanqiang_shipping set province='".$post['province']."',city='".$post['city']."',district='".$post['district']."'";
				$sql .= ",address='".$post['address']."',linkman='".$post['linkman']."',tel='".$post['tel']."',best_time='".$post['best_time']."' where shipping_id=$shipId";
			}
			$this->group->execute($sql);
			header("Location:/admin/yiyuanqiang/shipping/list/".$actionId);
		}
	
		$this->view->setVars(array('type'=>$type,'actionId'=>$actionId,'province'=>$province['list']));
		if($type == 'list')
		{
			$list = $this->group->fetchAll("select * from yiyuanqiang_shipping where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('list'=>$list,'regions'=>$E->regions()));
			$this->view->pick("yiyuanqiang/shippinglist");
		}
		elseif($type == 'modify')
		{
			$city = $E->regions(array('pid'=>$info['province']));
			$district = $E->regions(array('pid'=>$info['city']));
				
			$this->view->city = $city['list'];
			$this->view->district = $district['list'];
		}
		$this->view->setVars(array('info'=>$info));
	}
	
	public function orderAction()
	{
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
	
		$order = new \Library\Model\Order();
		$payment = $order->channel();
		foreach($payment['list'] as $k) $payment2[$k['id']] = $k['payName'];
		$list = $order->info(array('fromId'=>4,'actionId'=>$actionId));
	
		$U = new \Library\Model\User();
		$user = $U->info(array('idList'=>array_column($list['list'],'userId')));
		foreach($user['list'] as $k) $user2[$k['userId']] = $k;
	
		foreach($list['list'] as $k)
		{
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
	
	public function exorderAction()
	{
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		
		$order = new \Library\Model\Order();
		$payment = $order->channel();
		foreach($payment['list'] as $k) $payment2[$k['id']] = $k['payName'];
		$list = $order->info(array('fromId'=>4,'actionId'=>$actionId));
		
		$U = new \Library\Model\User();
		$user = $U->info(array('idList'=>array_column($list['list'],'userId')));
		foreach($user['list'] as $k) $user2[$k['userId']] = $k;
		
		foreach($list['list'] as $k)
		{
			$k['username'] = $user2[$k['userId']]['nickName'];
			$k['wx_openid'] = $user2[$k['userId']]['oauthOpenid'];
			$k['wx_unionid'] = $user2[$k['userId']]['oauthUnionid'];
			$k['headImg'] = $user2[$k['userId']]['headPic'];
			$k['pay_name'] = $payment2[$k['payId']];
			$k['goods_name'] = $k['goods'][0]['goodsName'];
			$data[] = $k;
		}
		
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=yiyuanqiang_".$actionId.".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		$title = "id,sn,返回单号,渠道,购买商品,微信名,微信id,支付价格,商品价格,下单时间,支付时间,状态\r\n";
		echo mb_convert_encoding($title,"GBK","UTF-8");
		
		foreach($data as $k=>$v)
		{
			$moneyPaid = $v['moneyPaid']>0?$v['moneyPaid']:$v['orderAmount'];
			
			if($v['status']['order'] == 2)
			{
				$status = '已取消';
			}
			else
			{
				if($v['status']['pay'] == 2)
				{
					$status = '已付款';
				}
				elseif ($v['status']['pay'] == 0)
				{
					$status = '未付款';
				}
			}
			
			$str = $v['userId'].",".$v['orderSn'].",".$v['transactionId'].",".$v['pay_name'].",".$v['goods_name'].",".$v['username'].",".$v['wx_openid'].",".$moneyPaid.",".$v['goodsAmount'].",".$v['addTime'].",".$v['payTime'].",".$status."\r\n";
			echo mb_convert_encoding($str,"GBK","UTF-8");
			
		}
		exit();
		
		
	}
	
	public function userAction()
	{
		$actionId = $this->dispatcher->getParam(0,'int');
		$ajax = $this->dispatcher->getParam(1,'int');
		if($ajax)
		{
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
			$order = isset($_GET['sort']) ? " order by ".$_GET['sort']." ".$_GET['order'] : "";
				
			$where = "";
			if(isset($_GET['phone']) && $_GET['phone'])
			{
				$where .= " and a.phone = '".$_GET['phone']."'";
			}
			if(isset($_GET['wxId']) && $_GET['wxId'])
			{
				$where .= " and a.wx_id = '".$_GET['wxId']."'";
			}
			if(isset($_GET['userId']) && $_GET['userId'])
			{
				$where .= " and a.user_id = '".$_GET['userId']."'";
			}
			if(isset($_GET['parentId']) && $_GET['parentId'])
			{
				$where .= " and a.parent_id = '".$_GET['parentId']."'";
			}
			if(isset($_GET['gId']) && $_GET['gId'])
			{
				$where .= " and a.gid = '".$_GET['gId']."'";
			}
			if(isset($_GET['userName']) && $_GET['userName'])
			{
				$where .= " and a.username = '".$_GET['userName']."'";
			}
				
			$total = $this->group->fetchColumn("select count(id) from yiyuanqiang_record as a where action_id = $actionId $where");
			$sql = "select ifnull(b.goods_id,0) as goods_id,a.* from yiyuanqiang_record as a left join yiyuanqiang_goods as b on a.gid = b.id where a.action_id = $actionId $where $order limit $offset,$limit";
			$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
				
			if(empty($res)) die(json_encode(array('total'=>0,'rows'=>array())));
				
			$M = new \Library\Model\Goods();
			$tmp = $M->idList(array('idList'=>array_column($res,"goods_id")));
			foreach($tmp['list'] as $k) $list[$k['id']] = $k;
				
			foreach($res as $k)
			{
				$k['goods_name'] = isset($list[$k['goods_id']]) ? $list[$k['goods_id']]['name'] : "";
				$data[] = $k;
			}
				
			die(json_encode(array('total'=>$total,'rows'=>$data)));
		}
		$this->view->setVars(array('actionId'=>$actionId));
	}
	
	public function exportAction(){
// 		set_time_limit(0);
		$actionId = $this->dispatcher->getParam(0,'int');
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=yiyuanqiang_".$actionId.".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		$title = "id,发起id,商品id,商品名称,手机号,微信id,用户id,用户名,帮砍价,帮砍时间\r\n";
		echo mb_convert_encoding($title,"GBK","UTF-8");
		
		$sql = "select ifnull(b.goods_id,0) as goods_id,a.id,a.parent_id,a.gid,a.phone,a.wx_id,a.username,a.user_id,a.lower_money,a.time from yiyuanqiang_record as a left join yiyuanqiang_goods as b on a.gid = b.id where a.action_id = $actionId limit 500";
		$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		$G = new \Library\Model\Goods();
// 		print_r($res);die;
		$i =0;
		foreach($res as $k=>$v)
		{
			$tmp =  $G->lists(array('goodsId'=>$v['goods_id']));
			$goodsName = $tmp?$tmp['list'][0]['name']:'hehe';
			$str = $v['id'].",".$v['parent_id'].",".$v['gid'].",".$goodsName.",".$v['phone'].",".$v['wx_id'].",".$v['user_id'].",".$v['username'].",".$v['lower_money'].",".$v['time']."\r\n";
			echo mb_convert_encoding($str,"GBK","UTF-8");
// $res[$k]['goods_name'] = $goodsName;
// $i++;
// usleep(3000);
		}
		exit();
// 		print_r($res);die;
// 		print_r($data);die;
	}
	
	public function infoAction()
	{
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = $params[1] ? (int)$params[1] : 0;
		$G = new \Library\Model\Goods();
		$db = $this->group;
		if($type == 'list')
		{
			$ajax = isset($params[2]) ? (int)$params[2] : 0;
			if($ajax)
			{
				$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
				$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
				$order = isset($_GET['sort']) ? " order by ".$_GET['sort']." ".$_GET['order'] : "";
				$total = $db->fetchColumn("select count(id) from yiyuanqiang_goods where action_id = $actionId");
				$tmp1 = $db->fetchAll("select * from yiyuanqiang_goods where action_id = $actionId $order limit $offset,$limit",\Phalcon\Db::FETCH_ASSOC);
				$tmp2 = $G->idList(array('idList'=>array_column($tmp1,"goods_id")));
				foreach($tmp2['list'] as $k) $list[$k['id']] = $k;
		
				foreach($tmp1 as $k)
				{
					$k['goods_name'] = $list[$k['goods_id']]['name'];
					$k['price'] = $list[$k['goods_id']]['price'];
					//参与人数
					/*
					    select sum(t.c) from (

						select sum(1) as c from yiyuanqiang_record where action_id = 5 and gid=36 and wx_id is null
						
						union
						
						select sum(1) as c from yiyuanqiang_record where action_id = 5 and gid=36 and phone is null
						 
						union
						
						select sum(1) as c from yiyuanqiang_record t1 where action_id = 5 and gid=36 and phone is not null and wx_id is not null
						and not exists (select 1 from yiyuanqiang_record t2 where action_id = 5 and gid=36 and wx_id is null and t1.phone = t2.phone)
						and not exists (select 1 from yiyuanqiang_record t3 where action_id = 5 and gid=36 and phone is null and t1.wx_id = t3.wx_id)
						
						) t 
					 */
					$cutCount = $db->fetchAll("select sum(t.c) from (select sum(1) as c from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} and wx_id is null union select sum(1) as c from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} and phone is null union select sum(1) as c from yiyuanqiang_record t1 where action_id = $actionId and gid={$k['id']} and phone is not null and wx_id is not null and not exists (select 1 from yiyuanqiang_record t2 where action_id = $actionId and gid={$k['id']} and wx_id is null and t1.phone = t2.phone) and not exists (select 1 from yiyuanqiang_record t3 where action_id = $actionId and gid={$k['id']} and phone is null and t1.wx_id = t3.wx_id)) t ",\Phalcon\Db::FETCH_ASSOC);
					$cutCount = $db->fetchAll("select id from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} group by wx_id",\Phalcon\Db::FETCH_ASSOC);
// 				die(json_encode(array('total'=>123,'rows'=>$cutCount)));
					$k['cutcount'] = count($cutCount);
					//发起人数
					$countNum = $db->fetchColumn("select count(*) as c from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} and id=parent_id");
					$k['countnum'] = $countNum;
					//发起率
					$k['cutrate'] = round(($countNum/count($cutCount)) * 100,2);
					//最低成交价
					$lowestPay = $db->fetchColumn("select pay_amount from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} and pay_amount>0 order by pay_amount asc");
					$k['lowestpay'] = $lowestPay?$lowestPay:0;
					//最低砍价
					$recordList = $db->fetchAll("select parent_id from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} group by parent_id");
					$lowestCut = $list[$k['goods_id']]['price']['promote'];
					foreach ($recordList as $m)
					{
						$tmpCutPrice = $db->fetchColumn("select sum(lower_money) as s from yiyuanqiang_record where action_id = $actionId and gid={$k['id']} and parent_id={$m['parent_id']}");
						$tmpPrice = $list[$k['goods_id']]['price']['promote'] - $tmpCutPrice;
						if($tmpPrice < $lowestCut)
						{
							$lowestCut = $tmpPrice;
						}
					}
					$k['lowestcut'] = $lowestCut;
					//下单率
					$k['orderrate'] = round(($k['order_sum']/$countNum)*100,2);
					//成交率
					$k['salserate'] = round(($k['sales_sum']/$k['order_sum'])*100,2);
					$data[] = $k;
				}
				die(json_encode(array('total'=>$total,'rows'=>$data)));
			}
				
			$this->view->setVars(array('actionId'=>$actionId,'catStr'=>$G->CatStr()));
		}
		
		
	}
	
	public function cityAction()
	{
		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$actionId = $params[1] ? (int)$params[1] : 0;
		
		$sql = "SELECT COUNT(*) FROM yiyuanqiang_city_list where action_id=$actionId";
		$count = $this->group->fetchOne($sql);
		$page = new \Library\Com\Page($count[0], 10);
		 
		$sql = "SELECT * FROM yiyuanqiang_city_list where action_id=$actionId ORDER BY city_id asc LIMIT ".$page->firstRow.','.$page->listRows;
		$data = $this->group->fetchAll($sql);
		 
		$this->view->setVar('page',$page->show());
		$this->view->setVar("list", $data);
		$this->view->setVar("actionid", $actionId);
		
		
	}
	
//城市站添加/编辑
	public function city_addAction(){
	    if($this->request->isPost() == true)
	    {
	    	$actionId = $_POST['action_id'];
	        $id = $_POST['id'];
	        $city_name = trim($_POST['city_name']);
	        $city_code = trim($_POST['city_code']);
	        $lng = trim($_POST['lng']);
	        $lat = trim($_POST['lat']);
	        $city_id = trim($_POST['city_id']);
	        $isRemove = $_POST['isRemove'];
	        if(empty($id))
	        {
	            $sql = "INSERT INTO yiyuanqiang_city_list (city_name, city_code, lng, lat, add_time,city_id,action_id) VALUES('".$city_name."','".$city_code."','".$lng."','".$lat."','".time()."',$city_id,$actionId)";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId)
                {
                    header("Location:/admin/yiyuanqiang/city/list/$actionId");
                } 
                else 
                {
                    die('系统繁忙，请稍后重试！');
                }
	        } 
	        else 
	        {
	            $sql = "UPDATE yiyuanqiang_city_list SET city_name='".$city_name."',city_code='".$city_code."',lng='".$lng."',lat='".$lat."',city_id='$city_id' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result)
	            {
	                header("Location:/admin/yiyuanqiang/city/list/$actionId");
	            } 
	            else 
	            {
	                die('系统繁忙，请稍后重试！');
	            }
	        }
	    } 
	    else 
	    {
	        $id = $this->dispatcher->getParam(1);
	        if($id)
	        {
	            $sql = "SELECT * FROM yiyuanqiang_city_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	        
	        $actionId = isset($_GET['action_id'])?$_GET['action_id']:0;
	        $this->view->setVar("actionid", $actionId);
	        
	        //省市下拉
			$E = new \Library\Model\Ext();
			$province = $E->regions(array('pid'=>1));
			$this->view->setVars(array('province'=>$province['list']));
	    }
	}
	
	public function city_deleteAction()
	{
	    $actionId = $this->dispatcher->getParam(0);
	    $id = $this->dispatcher->getParam(1);
	    if($id)
	    {
	        $sql = "DELETE FROM yiyuanqiang_city_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        header("Location:/admin/yiyuanqiang/city/list/$actionId");
	    } 
	    else 
	    {
	        die('非法操作');
	    }
	}
}




?>