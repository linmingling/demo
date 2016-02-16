<?php
namespace Apps\Phone\Controllers;

use \Library\Com\LibSms;

class YiyuanqiangController extends ControllerBase 
{
    private $appId = "wxd43f7b5d8539e718";
    private $appSecret = "a42b85c54c3e79b709023df894f42778";
    private $wxToken = "ubtaeo1422330200";
	private $wxAPI;
	protected $errMsg = '';
	private $point_model;
	private $jssdk;
	
	public function onConstruct()
	{
		$ActionName = $this->dispatcher->getActionName();
		if($ActionName == 'index' || $ActionName == 'detail')
		{
			unset($_GET['auth']);
		}
		//http://pay.yoju360.com/phone/login?backurl=http://www.baidu.com 登陆调用和返回地址
		if(isset($_GET['test']) && $_GET['test'] == 1)
		{
			
		}
		else 
		{
// 			$this->wxlogin();
		}
		$this->wxAPI = new \Library\Com\WeiXinApi($this->session,$this->wxToken,$this->appId,$this->appSecret);
		$this->jssdk = new \Library\Com\JSSDK();
		$this->point_model = new \Library\Com\YyqPoint($this->group);
	}

	//列表页
	public function indexAction()
	{
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && $wx_id=='')
		{
// 			die();
		}
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$this->view->setVars(array('actionid'=>$actionId));
		$db = $this->group;
		$indexInfo = $db->fetchOne("select * from yiyuanqiang_list where is_close=0 and id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
		
		if(!$indexInfo)
		{
			$this->flash->error("活动不存在"); exit();
		}
		
		for($i=1;$i<=4;)
		{
			if(!empty($indexInfo['adv' . $i . '_img']))
			{
				$indexInfo['adv' . $i . '_img'] = '/uploads/yiyuanqiang/' . $indexInfo['adv' . $i . '_img'];
			}
			else 
			{
				unset($indexInfo['adv' . $i . '_img']);
			}
			$i++;
		}
		$indexInfo['desc'] = htmlspecialchars_decode($indexInfo['desc']);
		
		//城市列表
        /*
		$cityList = $this->redis->get('yiyuanqiang_city_list' . $actionId);
		if(empty($cityList))
		{
			$cityList = $db->fetchAll("select * from yiyuanqiang_city_list where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
		    $this->redis->set('yiyuanqiang_city_list' . $actionId,json_encode($cityList),600);
		}
        else
        {
            $cityList = json_decode($cityList, true);
        }
        */

        $cityList = $db->fetchAll("select * from yiyuanqiang_city_list where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
		//城市定位
		$allowAddress = isset($_GET['city']) ? trim($_GET['city']) : '';
		$cityCode = $db->fetchOne("select city_code,city_name from yiyuanqiang_city_list where action_id=$actionId and city_id='$allowAddress'",\Phalcon\Db::FETCH_ASSOC);
		$cityId = $cityCode?$cityCode['city_code']:'';
		$content = $this->point_model->getCity($actionId,$cityId);
		
		$G = new \Library\Model\Goods();
		$allowAddress = $content['code'];
		$cityName = $cityCode ? trim($cityCode['city_name']) : $content['city'];
		$this->view->setVars(array('cityname'=>$cityName));
		
		//正在进行的商品列表
		$sumJoin = $db->fetchColumn("select count(*) from yiyuanqiang_record where action_id = $actionId");
		$ngoodsList = $this->redis->get('yiyuanqiang_nglist' . $actionId);
		if(empty($ngoodsList))
		{
			$ngoodsList = $db->fetchAll("select * from yiyuanqiang_goods where action_id={$actionId} and starttime<'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "'  and is_remove=0 order by is_top desc,join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
	// 		$ngoodsList = $db->fetchAll("select * from yiyuanqiang_goods where action_id={$actionId} and starttime<'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "' and (goods_quantity>0 or active_quantity>0) and is_remove=0 order by is_top desc,join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
	// 		$ngoodsList = $db->fetchAll("select * from yiyuanqiang_goods where action_id={$actionId} and starttime<'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "'  and is_remove=0 order by is_top desc,join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
			$this->redis->set('yiyuanqiang_nglist' . $actionId,json_encode($ngoodsList),300);
		}
        else
        {
            $ngoodsList = json_decode($ngoodsList, true);
        }
		foreach ($ngoodsList as $k=>$v)
		{
			$data = $this->redis->get('ng_'.$v['goods_id'].'_'.$allowAddress);
			if(empty($data))
			{
				$data = $G->lists(array('goodsId'=>$v['goods_id'],'allowAddress'=>$allowAddress));
				$this->redis->set('ng_'.$v['goods_id'].'_'.$allowAddress, json_encode($data), 300);
			} else {
				$data = json_decode($data, true);
			}
			
			if(!$data) 
			{
				unset($ngoodsList[$k]);continue;
			}
// 			var_dump($data);die;
			
			$ngoodsList[$k]['goods_name'] = mb_strlen($data['list'][0]['name'],'utf-8')>12?mb_substr($data['list'][0]['name'], 0,11,'utf-8') . '...':$data['list'][0]['name'];
			$ngoodsList[$k]['market_price'] = number_format($data['list'][0]['price']['market'],2,'.','');		//原价
			$ngoodsList[$k]['kan_price'] = number_format($data['list'][0]['price']['promote'],2,'.','');		//原价
// 			$ngoodsList[$k]['discount_price'] = number_format(round($data['list'][0]['price']['promote'] * $ngoodsList[$k]['discount'] * (0.1),0),0,'.','');		//折扣价
			$ngoodsList[$k]['discount'] = round($ngoodsList[$k]['discount_price'] / $data['list'][0]['price']['promote'],2)*10;		//折扣
			$ngoodsList[$k]['discount_price'] = number_format($ngoodsList[$k]['discount_price'],0,'.','');		//折扣价
			$ngoodsList[$k]['img'] = $this->config->pcHome."/".$data['list'][0]['image']['img'];		//商品图片
			
			$ngoodsList[$k]['countdown_str'] = $this->ctime($ngoodsList[$k]['endtime']);
			$sumJoin += $v['init_join'];
			//参与人次
			$cutCount = $db->fetchColumn("select count(*) from yiyuanqiang_record where action_id = $actionId and gid={$v['id']}");
			$ngoodsList[$k]['cutcount'] = $cutCount;
			//该用户是否有发起过该商品
			$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
// 			$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
			
			$fromInfo = array();
			if(!empty($phone) /*|| !empty($wx_id)*/)
			{
				$sql = "select id from yiyuanqiang_record where gid='{$v['id']}' and id=parent_id";
				if(!empty($phone)) $sql .= " and phone='{$phone}'";
// 				elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
				$fromInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC); 
			}
			$ngoodsList[$k]['from_id'] = empty($fromInfo)?0:$fromInfo['id'];
			
			//被砍至最低价成交金额
			if($ngoodsList[$k]['sales_sum'] > 0)
			{
				$sql = "select pay_amount from yiyuanqiang_record where gid={$v['id']} and id=parent_id and pay_amount>0 and order_id>0 order by pay_amount asc";
				$payInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
				$ngoodsList[$k]['pay_amount'] = $payInfo['pay_amount'];
				
			}
		}
		//即将开始的商品列表
		$pgoodsList = $db->fetchAll("select * from yiyuanqiang_goods where action_id={$actionId} and starttime>'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "' and (goods_quantity>0 or active_quantity>0) and is_remove=0 order by join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
		foreach ($pgoodsList as $k=>$v)
		{
			$data = $G->lists(array('goodsId'=>$v['goods_id'],'allowAddress'=>$allowAddress));
			if(!$data) 
			{
				unset($pgoodsList[$k]);continue;
			}
			$pgoodsList[$k]['goods_name'] = mb_strlen($data['list'][0]['name'],'utf-8')>12?mb_substr($data['list'][0]['name'], 0,11,'utf-8') . '...':$data['list'][0]['name'];
			$pgoodsList[$k]['market_price'] = number_format($data['list'][0]['price']['market'],2,'.','');		//原价
			$pgoodsList[$k]['img'] = $this->config->pcHome."/".$data['list'][0]['image']['img'];		//商品图片
				
			$pgoodsList[$k]['countdown_str'] = date('n月j日',strtotime($pgoodsList[$k]['starttime'])) . '开抢';
			
			$pgoodsList[$k]['from_id'] = 0;
			
		}
		
		$this->view->setVars(array('indexinfo'=>$indexInfo,'ngoodslist'=>$ngoodsList,'pgoodslist'=>$pgoodsList,'sumjoin'=>$sumJoin,'citylist'=>$cityList));
// 		$this->view->signPackage = $this->wxAPI->get_share();
		$signPackage = $this->jssdk->GetSignPackage();
		$this->view->setVar("signPackage", $signPackage);
	}
	
	//详情页
	public function detailAction()
	{
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		
		if(isset($_GET['auth']))
		{
			unset($_GET['auth']);
		}

		$this->wxlogin(true);

		$params = $this->dispatcher->getParams();
		$actionId = $params[0] ? (int)$params[0] : 0;
		$goodsId = $params[1] ? (int)$params[1] : 0;
		$fromId = $params[2] ? (int)$params[2] : 0;
		
		if(!$actionId || !$goodsId) exit("缺少参数");
		$this->view->setVars(array('actionid'=>$actionId));
		$this->view->setVars(array('goodsid'=>$goodsId));
		$this->view->setVars(array('fromid'=>$fromId));
// 		$this->view->signPackage = $this->wxAPI->get_share();
		$signPackage = $this->jssdk->GetSignPackage();
		$this->view->setVar("signPackage", $signPackage);
		
		$islogin = false;
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && $wx_id=='')
		{
			die();
		}
		$headpic = $this->session->has('user_headpic') ? $this->session->get('user_headpic') : '/yiyuanqiang/images/touxiang1.jpg';
		$this->view->setVars(array('headpic'=>$headpic));//头像
		if(!empty($phone) || !empty($wx_id)) $islogin = true;
// 		if(!$islogin)
// 		{
// 			header("Location:http://pay.yoju360.com/phone/login?backurl=http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);exit;
// 		}
		
		$db = $this->group;
		
		//帮砍商品信息
		$goodsInfo = $db->fetchOne("select * from yiyuanqiang_goods where id = ".$goodsId,\Phalcon\Db::FETCH_ASSOC);
		
		//已过期且没库存
		if(($goodsInfo['endtime'] < date('Y-m-d H:i:s')) && $goodsInfo['goods_quantity'] == 0)
		{
			header("Location:http://".$_SERVER['SERVER_NAME'] . "/phone/yiyuanqiang/index/" . $actionId);exit;
		}
		
		//商品头部轮播图
		for($i=1;$i<=9;)
		{
			if(!empty($goodsInfo['goods_img' . $i]))
			{
				$goodsInfo['goods_imgs']['goods_img' . $i]['img'] = '/uploads/yiyuanqiang/' . $goodsInfo['goods_img' . $i];
			}
			unset($goodsInfo['goods_img' . $i]);
			
			$i++;
		}
		
		$G = new \Library\Model\Goods();
		$goodsDetail = $G->info(array('goodsId'=>$goodsInfo['goods_id'],'descShow'=>1));
		$goodsInfo['goods_name'] = $goodsDetail['name'];
		$goodsInfo['market_price'] = number_format($goodsDetail['price']['market'],2,'.','');		//原价
		$goodsInfo['kan_price'] = number_format($goodsDetail['price']['promote'],2,'.','');		//帮砍价
// 		$goodsInfo['discount_price'] = round($goodsDetail['price']['promote'] * $goodsInfo['discount'] * (0.1),0);		//折扣价
		$goodsInfo['discount'] = round($goodsInfo['discount_price']/$goodsDetail['price']['promote'],2)*10;		//折扣
		$goodsInfo['img'] = $this->config->pcHome."/".$goodsDetail['image']['img'];	
		$goodsInfo['desc'] = preg_replace_callback("/<img([^>]+)src=\"([:|\w|\/|\.]+)\.(jpg|jpeg|gif|png|bmp)\"[^>]+>/i",function($m){
				if(strpos($m[2],'http')){
					return "<img src='".$m[2].".".$m[3]."' />";
				}else{
					return "<img src='".$this->config->pcHome.$m[2].".".$m[3]."' />";
				}
			},htmlspecialchars_decode($goodsDetail['desc']));
		
		$goodsInfo['countdown'] = date('Y/m/d H:i:s',strtotime($goodsInfo['endtime']));
		
		//状态块 A:我的砍价 B:帮别人砍 C:我要发起 D:还没开始 E:已卖完
		// 1:帮TA砍价 2:我要参加 3:我要发起 4:砍价 5:邀请帮砍
		$status = 'B';
		
		//是否已开始活动
		if(($goodsInfo['starttime'] < date('Y-m-d H:i:s')) || ($goodsInfo['endtime'] < date('Y-m-d H:i:s')))
		{
			//是否传入发起id
			if($fromId)
			{
				
				//帮砍榜
				$rankList = $db->fetchAll("select * from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId} and wx_id is not null order by time desc limit 10",\Phalcon\Db::FETCH_ASSOC);
				
				if(!empty($rankList))
				{
					foreach ($rankList as $k=>$v)
					{
						$rankList[$k]['username'] = mb_substr($v['username'], 0,5,'utf-8');
						$rankList[$k]['phone'] = mb_substr($v['phone'],-4);
						$this->view->setVars(array('ranklist'=>$rankList));
					}
				}
				
				//砍价王
				$topRank = $db->fetchOne("select * from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId} order by lower_money desc limit 1",\Phalcon\Db::FETCH_ASSOC);
				if(!empty($topRank))
				{
					$topRank['username'] = mb_substr($topRank['username'], 0,5,'utf-8');
					$topRank['phone'] = mb_substr($topRank['phone'],-4);
					$this->view->setVars(array('toprank'=>$topRank));
				}
				//已砍价钱,砍价人数
				$cutMoneyInfo = $db->fetchOne("select sum(lower_money) as cm from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId}",\Phalcon\Db::FETCH_ASSOC);
				$cutPeopleInfo = $db->fetchAll("select id from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId} group by wx_id",\Phalcon\Db::FETCH_ASSOC);
				$cutMoney = $cutMoneyInfo['cm'];
				$this->view->setVars(array('cutsum'=>$cutMoneyInfo['cm'],'helpsum'=>count($cutPeopleInfo) -1));
			}
			
			if(isset($cutMoney))
			{
				$goodsInfo['cut_price'] = round($goodsInfo['kan_price'] - $cutMoney,2) < $goodsInfo['lowest_price']?$goodsInfo['lowest_price']:round($goodsInfo['kan_price'] - $cutMoney,2);
			}
			else 
			{
				$goodsInfo['cut_price'] = round($goodsInfo['kan_price'],2);
			}
			
			//帮砍库存为0或活动已结束
			if(($goodsInfo['active_quantity'] <= 0) || $goodsInfo['endtime'] < date('Y-m-d H:i:s'))
			{
				
				$sql = "select count(*) from yiyuanqiang_record where id={$fromId}";
				if(!empty($phone)) $sql .= " and phone='{$phone}'";
				elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
				$checkHost = $db->fetchColumn($sql);
				
				//是否发起人.不是返回首页
				if($checkHost || (!$checkHost && $goodsInfo['active_quantity'] == 0))
				{
					$status = 'E';
				}
				elseif(!$checkHost && $goodsInfo['endtime'] < date('Y-m-d H:i:s') && $goodsInfo['active_quantity'] == 0)
				{
					header("Location:http://".$_SERVER['SERVER_NAME'] . "/phone/yiyuanqiang/index/" . $actionId);exit;
				}
				
			}
			else 
			{
				//是否已登录
				if($islogin)
				{
					if ($fromId)
					{
						$sql = "select count(*) as c from yiyuanqiang_record where id={$fromId}";
						if(!empty($phone)) $sql .= " and phone='{$phone}'";
						elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
						$checkHost = $db->fetchColumn($sql);
						if($checkHost)
						{
							$this->view->setVars(array('ishost'=>1));
							$status = 'A';
							//可砍次数
							$sql = "select * from yiyuanqiang_user_count where 1=1";
							if(!empty($phone)) $sql .= " and phone='{$phone}'";
							elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
							$cutInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
							//已砍次数
							$sql = "select count(*) as c from yiyuanqiang_record where parent_id={$fromId}";
							if(!empty($phone)) $sql .= " and phone='{$phone}'";
							elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
							$hasCut = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
							$cutCount = $cutInfo['my_count'] + $cutInfo['share_count'] + $cutInfo['att_count'] - $hasCut['c'];
							if($cutCount<0)
							{
								$cutCount = 0;
							}
							$this->view->setVars(array('cutcount'=>$cutCount));
							$this->view->setVars(array('cutinfo'=>$cutInfo));
							
							//抵购券检测(手机报名和激活才能领抵购券)
							$checkUse = 0;
							if(!empty($phone))
							{
								//该活动能否用券
								$checkUse = $db->fetchColumn("select yizhangou_id from yiyuanqiang_list where id=$actionId");
								
								if($checkUse != 0) 	//有绑定一站购活动id
								{
									$coupons = 0;
									
									//检测报名
									$sql = "select count(*) from yizhangou_baoming where phone='{$phone}' and action_id in($checkUse) and is_used=0";
									$YregisterInfo = $db->fetchColumn($sql);
									
									$sql = "select count(*) from qmjjg_registration where phone='{$phone}' and is_used=0";
									$QregisterInfo = $db->fetchColumn($sql);
									
									if($YregisterInfo || $QregisterInfo)
									{
										$coupons +=1;
									}
									
									//检测激活
									$sql = "select count(*) from vcard_user where phone='{$phone}' and action_id in($checkUse) and is_used=0 and status=1";
									$activeInfo = $db->fetchColumn($sql);
									
									if($activeInfo)
									{
										$coupons +=1;
									}
									
									$this->view->setVars(array('coupons'=>$coupons));
								}
							}
							$this->view->setVars(array('couponuse'=>$checkUse));
						}
						$this->view->setVars(array('ishost'=>$checkHost));
					}
					else 
					{
						$status = 'C';
					}
					
				}
				elseif(!$fromId)
				{
					$status = 'C';
				}
			}
		}
		else //活动还没开始
		{
			$goodsInfo['cut_price'] = $goodsInfo['kan_price'];
			$goodsInfo['countdown_str'] = date('n月j日',strtotime($goodsInfo['starttime']));
			$status = 'D';
		}
		
		$this->view->setVars(array(
				'goodsinfo'=>$goodsInfo,
				'status'=>$status,
		));
		
	}
	
	//我的帮砍
	public function myprdAction()
	{
		$this->wxlogin();
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$this->view->setVars(array('actionid'=>$actionId));
		
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
// 		die($phone . "=====" . $wx_id);
		if(empty($phone) /*&& empty($wx_id)*/)
		{
			header("Location:".$this->config->payDomain."/phone/login?backurl=http://" . $_SERVER['SERVER_NAME'] . "/phone/yiyuanqiang/index/" . $actionId);
		}
		
		$userId = $this->session->get('user_id');
		$db = $this->group;
		
	
		$sql = "select * from yiyuanqiang_goods";
		$sql .= " where action_id={$actionId} and is_remove=0";
// 		$sql .= " where action_id={$actionId} and  ((endtime>'" . date('Y-m-d H:i:s') . "' and active_quantity>0) or goods_quantity>0) and is_remove=0";
		$sql .= " and id in (select gid from yiyuanqiang_record where id=parent_id";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
// 		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		$sql .= " group by gid) order by sort asc";
		$goodsList = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
		$G = new \Library\Model\Goods();
		foreach ($goodsList as $k=>$v)
		{
			$data = $G->idList(array('idList'=>array($v['goods_id'])));
			$goodsList[$k]['goods_name'] = mb_strlen($data['list'][0]['name'],'utf-8')>12?mb_substr($data['list'][0]['name'], 0,11,'utf-8') . '...':$data['list'][0]['name'];
			$goodsList[$k]['market_price'] = $data['list'][0]['price']['market'];		//原价
			$goodsList[$k]['kan_price'] = $data['list'][0]['price']['promote'];		//原价
			$goodsList[$k]['discount'] = round($goodsList[$k]['discount_price'] / $data['list'][0]['price']['promote'],2)*10;		//折扣
			$goodsList[$k]['img'] = $this->config->pcHome."/".$data['list'][0]['image']['img'];		//商品图片
		
			if(time() < strtotime($goodsList[$k]['starttime']))
			{
				$goodsList[$k]['countdown_str'] = date('n月j日',strtotime($goodsList[$k]['starttime']));
				$goodsList[$k]['is_begin'] = false;
			}
			else
			{
				if(time() > strtotime($goodsList[$k]['endtime']))
				{
					$goodsList[$k]['countdown_str'] = '活动已结束';
				}
				else 
				{
					$goodsList[$k]['countdown_str'] = $this->ctime($goodsList[$k]['endtime']);
				}
				$goodsList[$k]['is_begin'] = true;
			}
			
			$fromInfo = array();
			if(!empty($phone) || !empty($wx_id))
			{
				$sql = "select id from yiyuanqiang_record where gid='{$v['id']}' and id=parent_id";
				if(!empty($phone)) $sql .= " and phone='{$phone}'";
				elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
				$fromInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			}
			$goodsList[$k]['from_id'] = empty($fromInfo)?0:$fromInfo['id'];
			

			//还能砍
// 			if($v['active_quantity'] > 0 && !empty($fromInfo))
			if(!empty($fromInfo))
			{
				//已砍到价钱
				$hasCut = $db->fetchOne("select sum(lower_money) as money from yiyuanqiang_record where parent_id={$fromInfo['id']}",\Phalcon\Db::FETCH_ASSOC);
				$goodsList[$k]['currcut'] = round($data['list'][0]['price']['promote'] - $hasCut['money'],2);
				//帮砍人数
				$countNum = $db->fetchAll("select id from yiyuanqiang_record where parent_id={$fromInfo['id']} group by wx_id",\Phalcon\Db::FETCH_ASSOC);
				$goodsList[$k]['countnum'] = count($countNum);
			}
				
		
		}
			
		$this->view->setVars(array('indexinfo'=>$indexInfo,'goodslist'=>$goodsList));
	}
	
	//砍价
	public function cutAction()
	{
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
		if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && $wx_id=='')
		{
			die(json_encode(array(
					'code'=>1000,
					'msg'=>'还没登陆',
			)));
		}
		elseif(!strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && empty($phone))
		{
			die(json_encode(array(
					'code'=>1000,
					'msg'=>'还没登陆',
			)));
		}

			
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$actionId = trim($post['actionid']);
			$type = trim($post['type']);
			$goodsId = trim($post['goodsid']) == ''?0:(int)trim($post['goodsid']);
			$fromId =  trim($post['fromid']) > 0?(int)trim($post['fromid']):0;
			
			
// 			$user_name = $this->session->has('user_name') ? $this->session->get('user_name') : '';
			if(empty($wx_id))
			{
				$user_name = $this->session->has('user_name') ? $this->session->get('user_name') : '';
			}
			else 
			{
				$user_name = $this->session->has('user_name') ? $this->session->get('user_name') : $this->session->get('wx_name');
			}
			$db = $this->group;
			
			//检测是否有用户资料
			$sql = "select count(*) from yiyuanqiang_user_count where 1=1";
			if(!empty($phone)) $sql .= " and phone='{$phone}'";
			elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
			$checkUser = $db->fetchColumn($sql);
			
			if(!$checkUser)
			{
				if(!empty($phone)) $sql = "insert into yiyuanqiang_user_count(phone) values('{$phone}')";
				if(!empty($wx_id)) $sql = "insert into yiyuanqiang_user_count(wx_id) values('{$wx_id}')";
				if(!empty($phone) && !empty($wx_id)) $sql = "insert into yiyuanqiang_user_count(phone,wx_id) values('{$phone}','{$wx_id}')";
				$db->execute($sql);
			}
			
			
			if($type == 'my')	//自砍
			{
				$obj = 1;
				if($this->checkCut($goodsId, $fromId,$obj))
				{
					$cutMoneyList = $this->cutMoney($goodsId, $fromId,true);
					if($cutMoneyList[0] <= 0)
					{
						$msg =array(
								'msg'=>'该商品已砍至最低价啦',
								'curr_price'=>$cutMoneyList[0],
								'cut_money'=>$cutMoneyList[1],
						);
						die(json_encode(array(
								'code'=>1003,
								'msg'=>$msg,
						)));
					}
					else 		//砍价成功
					{
						if($wx_id)
						{
							$forbid = include(APP_PATH.'/data/config/yiyuanqiangblacklist.php');
							if(in_array($wx_id,$forbid)) $cutMoneyList[0] = rand(1,50)*0.01;
						}
						
						//处理逻辑
						if(!empty($phone))
						{
							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`lower_money`,`time`,phone) ";
							$recordSql .= " select {$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "','{$phone}'";
							$recordSql .= " from dual where (select count(*) from yiyuanqiang_record where action_id=$actionId and gid=$goodsId and parent_id=$fromId and user_id='{$user_id}' and username='{$user_name}' and phone='{$phone}')<4";
						}
						
// 						if(!empty($wx_id))
// 						{
// 							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`)";
// 							$recordSql .= " values({$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$wx_id}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "')";
// 						}
						
						if(!empty($phone) && !empty($wx_id))
						{
							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`,phone)";
							$recordSql .= " select {$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$wx_id}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "','{$phone}'";
							$recordSql .= " from dual where (select count(*) from yiyuanqiang_record where action_id=$actionId and gid=$goodsId and parent_id=$fromId and user_id='{$user_id}' and username='{$user_name}' and phone='{$phone}' and wx_id='{$wx_id}')<4";
						}
						
						
						if($wx_id)
						{
							$key = 'cut_' . $wx_id . '_' . $goodsId . '_' . $fromId;
							
							$num = $this->redis->get($key);
							if (!$num) {
								$sql = "select count(*) as c from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId}";
								if(!empty($phone)) $sql .= " and phone='{$phone}'";
								elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
								$count = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
								
								$this->redis->set($key,$count['c']);
								$num = $count['c'];
							}
							
							if($num >= 5)  //自砍5次
							{
								$this->redis->unwatch($key);
								die(json_encode(array(
										'code'=>1005,
										'msg'=>'非法操作',
								)));
							}
							else 
							{
								//redis事务
								$this->redis->watch($key);
								$this->redis->multi();
								
								$db->execute("begin");
								$this->logSql($recordSql);
								$res = $db->execute($recordSql);
								
								//请求是否频繁
								 $this->redis->incr($key);
								$checkOver = $this->redis->exec();
								
								if($res && $checkOver)
								{
									$db->execute("commit");
								}
								else 
								{
									$db->execute("rollback");
									die(json_encode(array(
											'code'=>1005,
											'msg'=>'非法操作',
									)));
								}
							}
						}
						else 
						{
						
							$db->execute("begin");
							$this->logSql($recordSql);
							$res = $db->execute($recordSql);
							if ($res)
							{
								$db->execute("commit");
								
							}
							else 
							{
								$db->execute("rollback");
								die(json_encode(array(
										'code'=>1005,
										'msg'=>'非法操作',
								)));
							}
							
						}
						$msg =array(
								'curr_price'=>$cutMoneyList[0],
								'cut_money'=>$cutMoneyList[1],
						);
						die(json_encode(array(
								'code'=>0,
								'msg'=>$msg,
						)));
					}
					
				}
				
				die(json_encode(array(
						'code'=>1001,
						'msg'=>array('msg'=>$this->errMsg),
				)));
			}
			else  	//帮砍
			{
				$obj = 2;
				if($this->checkCut($goodsId, $fromId,$obj))
				{
					$cutMoneyList = $this->cutMoney($goodsId, $fromId);
					if($cutMoneyList[0] <= 0)
					{
						$msg =array(
								'msg'=>'该商品已砍至最低价啦',
								'curr_price'=>$cutMoneyList[0],
								'cut_money'=>$cutMoneyList[1],
						);
						die(json_encode(array(
								'code'=>1004,
								'msg'=>$msg,
						)));
					}
					else 		//帮砍成功
					{
						if($wx_id)
						{
							$forbid = include(APP_PATH.'/data/config/yiyuanqiangblacklist.php');
							if(in_array($wx_id,$forbid)) $cutMoneyList[0] = rand(1,50)*0.01;
						}
						
					//处理逻辑
						if(!empty($phone))
						{
							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`lower_money`,`time`,phone)";
							$recordSql .= " select {$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "','{$phone}'";
							$recordSql .= " from dual where (select count(*) from yiyuanqiang_record where action_id=$actionId and gid=$goodsId and parent_id=$fromId and user_id='{$user_id}' and username='{$user_name}' and phone='{$phone}')<2";
						}
						
						if(!empty($wx_id))
						{
							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`)";
							$recordSql .= " select {$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$wx_id}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "'";
							$recordSql .= " from dual where (select count(*) from yiyuanqiang_record where action_id=$actionId and gid=$goodsId and parent_id=$fromId and user_id='{$user_id}' and username='{$user_name}' and wx_id='{$wx_id}')<2";
						}
						
						if(!empty($phone) && !empty($wx_id))
						{
							$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`,phone)";
							$recordSql .= " select {$actionId},{$goodsId},{$fromId},'{$user_id}','{$user_name}','{$wx_id}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "','{$phone}'";
							$recordSql .= " from dual where (select count(*) from yiyuanqiang_record where action_id=$actionId and gid=$goodsId and parent_id=$fromId and user_id='{$user_id}' and username='{$user_name}' and phone='{$phone}' and wx_id='{$wx_id}')<2";
						}
						
						
						
						if($wx_id)
						{
							$key = 'cut_' . $wx_id . '_' . $goodsId . '_' . $fromId;
							
							$num = $this->redis->get($key);
							if (!$num) {
								$sql = "select count(*) as c from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId}";
								if(!empty($phone)) $sql .= " and phone='{$phone}'";
								elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
								$count = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
								
								$this->redis->set($key,$count['c']);
								$num = $count['c'];
							}
							
							if($num >= 2)  //帮砍2次
							{
								$this->redis->unwatch($key);
								die(json_encode(array(
										'code'=>1006,
										'msg'=>'非法操作',
								)));
							}
							else
							{
								//redis事务
								$this->redis->watch($key);
								$this->redis->multi();
								
								$db->execute("begin");
								$this->logSql($recordSql);
								$res = $db->execute($recordSql);
								
								//请求是否频繁
								$this->redis->incr($key);
								$checkOver = $this->redis->exec();
						
								if($res && $checkOver)
								{
									$db->execute("commit");
										
								}
								else
								{
									$db->execute("rollback");
									die(json_encode(array(
											'code'=>1006,
											'msg'=>'非法操作',
									)));
								}
							}
						}
						else 
						{
						
							$db->execute("begin");
							$this->logSql($recordSql);
							$res = $db->execute($recordSql);
							if ($res)
							{
								$db->execute("commit");
							}
							else 
							{
								$db->execute("rollback");
								die(json_encode(array(
										'code'=>1006,
										'msg'=>'非法操作',
								)));
							}
							
						}
						$msg =array(
								'curr_price'=>$cutMoneyList[0],
								'cut_money'=>$cutMoneyList[1],
						);
						die(json_encode(array(
								'code'=>0,
								'msg'=>$msg,
						)));
					}
					
				}
				
				die(json_encode(array(
						'code'=>1002,
						'msg'=>array('msg'=>$this->errMsg),
				)));
			}
			
		}
	}
	
	//发起和参加
	public function startAction()
	{
		$this->wxlogin();
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
// 		$phone = '13416119576';
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : '';
		
		if(empty($phone) || empty($user_id))
		{
			die(json_encode(array(
						'code'=>1000,
						'msg'=>'请验证手机号',
			)));
		}

		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		
		$user_name = $this->session->has('user_name') ? $this->session->get('user_name') : '';
		
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$actionId = trim($post['actionid']);
			$goodsId = trim($post['goodsid']);
			

			
			if(empty($actionId) || empty($goodsId))
			{
				die(json_encode(array(
						'code'=>1001,
						'msg'=>'参数缺失',
				)));
			}
			
			$db = $this->group;
			
			//是否有帮砍库存
			$sql = "select active_quantity from yiyuanqiang_goods where action_id={$actionId} and id='{$goodsId}'";
			$checkQuantity = $db->fetchColumn($sql);
			
			if($checkQuantity == 0)
			{
				die(json_encode(array(
						'code'=>1004,
						'msg'=>'帮砍库存不足',
				)));
			}
			
			//检测是否有发起过
			$sql = "select id from yiyuanqiang_record where action_id={$actionId} and gid='{$goodsId}' and id=parent_id";
			if(!empty($phone)) $sql .= " and phone='{$phone}'";
			elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
			$sql .= "order by id desc limit 1";
			$checkStart = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			if($checkStart['id'] > 0)
			{
				die(json_encode(array(
						'code'=>1003,
						'msg'=>$checkStart['id'],
				)));
			}
			
			//检测是否发起过该商品帮砍并购买
			$sql = "select count(*) from yiyuanqiang_record where action_id={$actionId} and gid='{$goodsId}' and order_id>0";
			if(!empty($phone)) $sql .= " and phone='{$phone}'";
			elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
			$checkBuy = $db->fetchColumn($sql);
			if($checkBuy)
			{
				die(json_encode(array(
						'code'=>1002,
						'msg'=>'您已购买过该商品，不能再参加了哦',
				)));
			}
			
			//检测是否有用户资料
			$sql = "select count(*) from yiyuanqiang_user_count where 1=1";
			if(!empty($phone)) $sql .= " and phone='{$phone}'";
			elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
			$checkUser = $db->fetchColumn($sql);
			if(!$checkUser)
			{
				if(!empty($phone)) $sql = "insert into yiyuanqiang_user_count(phone) values('{$phone}')";
				if(!empty($wx_id)) $sql = "insert into yiyuanqiang_user_count(wx_id) values('{$wx_id}')";
				if(!empty($phone) && !empty($wx_id)) $sql = "insert into yiyuanqiang_user_count(phone,wx_id) values('{$phone}','{$wx_id}')";
				$db->execute($sql);
			}
			
			//发起先砍
			$db->execute("begin");
			$lowerMoney = $this->cutMoney($goodsId, 0);
			
			if(!empty($phone))
			{
				$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`lower_money`,`time`,phone)";
				$recordSql .= " values({$actionId},{$goodsId},0,'{$user_id}','{$user_name}','{$lowerMoney[0]}','" . date('Y-m-d H:i:s') . "','{$phone}')";
			}
			
// 			if(!empty($wx_id))
// 			{
// 				$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`)";
// 				$recordSql .= " values({$actionId},{$goodsId},0,'{$user_id}','{$user_name}','{$wx_id}','{$lowerMoney[0]}','" . date('Y-m-d H:i:s') . "')";
// 			}
			
			if(!empty($phone) && !empty($wx_id))
			{
				$recordSql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`wx_id`,`lower_money`,`time`,phone)";
				$recordSql .= " values({$actionId},{$goodsId},0,'{$user_id}','{$user_name}','{$wx_id}','{$lowerMoney[0]}','" . date('Y-m-d H:i:s') . "','{$phone}')";
			}
			
			$db->execute($recordSql);
			$parentId = $db->lastInsertId();
			if(!$parentId)
			{
				$db->execute("rollback");
			}
			else 
			{
				$db->execute("update yiyuanqiang_record set parent_id = $parentId where id = $parentId");
				//参与人数+1
				$db->execute("update yiyuanqiang_goods set join_sum = join_sum + 1 where id = $goodsId");
				$db->execute("commit");
			}
			//是否关注
			if(!empty($wx_id))
			{
				$isFocus = $this->wxSubscribe($wx_id,2);
				if($isFocus)
				{
					//有关注则额外+1砍价机会
					$db->execute("update yiyuanqiang_user_count set att_count=1 where wx_id='{$wx_id}'");
				}
				else 
				{
					$db->execute("update yiyuanqiang_user_count set att_count=0 where wx_id='{$wx_id}'");
				}
			}
			
			//用户可砍次数
			$sql = "select * from yiyuanqiang_user_count where 1=1";
			if(!empty($phone)) $sql .= " and phone='{$phone}'";
			elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
			$userInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			
			$msg = array(
					'action_id'=>$actionId,
					'goods_id'=>$goodsId,
					'from_id'=>$parentId,
					'cut_money'=>$lowerMoney[0],
					'curr_price'=>$lowerMoney[1],
					'cut_count'=>$userInfo['my_count'] + $userInfo['share_count'] + $userInfo['att_count'],
			);
			die(json_encode(array(
					'code'=>0,
					'msg'=>$msg,
			)));
			
		}
		
	}
	
	//分享
	public function inviteAction()
	{
		$this->wxlogin();
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		
		$post = $this->request->getPost();
		$actionId = trim($post['actionid']);
		$goodsId = trim($post['goodsid']) == ''?0:(int)trim($post['goodsid']);
		$fromId =  trim($post['fromid']) > 0?(int)trim($post['fromid']):0;
		
		$db = $this->group;
		$sql = "select * from yiyuanqiang_user_count where 1=1";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		$checkCount = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		
		if(!empty($checkCount))
		{
			if($checkCount['share_count'] == 0)
			{
				if(!empty($phone)) $sql = "update yiyuanqiang_user_count set share_count=1 where phone='{$phone}'";
				if(!empty($wx_id)) $sql = "update yiyuanqiang_user_count set share_count=1 where wx_id='{$wx_id}'";
				if(!empty($phone) && !empty($wx_id)) $sql = "update yiyuanqiang_user_count set share_count=1 where phone='{$phone}' or wx_id='{$wx_id}'";
				$db->execute($sql);
			}
		}
		
		$sql = "update yiyuanqiang_record set share_tag=1 where action_id={$actionId} and gid={$goodsId} and parent_id={$fromId}";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		if(!empty($phone) || !empty($wx_id)) $db->execute($sql);
		
		$db->execute("update yiyuanqiang_goods set share_sum=share_sum+1 where id={$goodsId}");
		
		die(json_encode(array(
				'code'=>0,
				'addcount'=>'分享成功',
		)));
	}
	
	//开售提醒
	public function remindAction()
	{
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$goodsId = trim($post['goodsid']);
			$phone = trim($post['phone']);
			$startTime = trim($post['starttime']);
			$goodsName = trim($post['goodsname']);

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
			
			//$sms = new \Library\Com\Sms();
			//$res = $sms->sendSms($phone,"【腾讯家居·优居网】尊敬的客户，您设置提醒的【{$goodsName}】的帮砍活动将于" . date('Y年n月j日H时i分s秒',strtotime($startTime)) . "开始，敬请关注！",$startTime);
			$res = LibSms::sendSms('http://sms.yoju360.net/api/send.do', 'yiyuanqiang', '5c494701cf2062d3358ff30812ebaada', '一元抢提醒', $phone, "【腾讯优居】尊敬的客户，您设置提醒的“{$goodsName}”的帮砍活动将于".date('Y年n月j日H时i分s秒',strtotime($startTime))."开始，敬请关注！", 
				DateTime::createFromFormat('Y-m-d H:i:s',$startTime)->getTimestamp());
			if ($res) //if($res == 0)
			{
				$this->group->execute("update yiyuanqiang_goods set remind_sum=remind_sum+1 where id={$goodsId}");
				die(json_encode(array(
						'code'=>0,
						'msg'=>"提醒将会在开始的时候发送到您的手机哦！",
				)));
			}
			else 
			{
				die(json_encode(array(
						'code'=>1003,
						'msg'=>"操作失败！",
				)));
			}
		}
	}
	
	public function registerAction()
	{
		$this->wxlogin();
		if($this->request->isPost() == true)
		{
			$type = $this->dispatcher->getParam(0);
			
			$post = $this->request->getPost();
			$phone = trim($post['phone']);
			$code = trim($post['code']);
			
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
			
			if($type == 'captcha')
			{
				$phoneList = array('15011111111','15011111112','15011111113','15011111114','15011111115');
				if(in_array($phone,$phoneList))
				{
					$captcha = 123465;
					$this->cache->save($phone."_yiyuanqiang_code",$captcha,300);
					die(json_encode(array('code'=>0,'msg'=>$captcha)));
				}
				
				$captcha = mt_rand(1000,9999);
				//$sms = new \Library\Com\Sms();
				//$res = $sms->sendSms($phone,"【腾讯优居】您的短信验证码是：".$captcha);
				$res = LibSms::sendSms('http://sms.yoju360.net/api/send.do', 'yiyuanqiang', '5c494701cf2062d3358ff30812ebaada', '一元抢注册', $phone, "【腾讯优居】您的短信验证码是：".$captcha);
				
				if ($res) //if($res == 0)
				{
					$this->cache->save($phone."_yiyuanqiang_code",$captcha,300);
					die(json_encode(array('code'=>0,'msg'=>'验证码已发送')));
				}
				else
				{
					die(json_encode(array('code'=>1001,'msg'=>'短信发送失败')));
				}
			}
			elseif ($type == 'check')
			{
				$captcha = $this->cache->get($phone."_yiyuanqiang_code");
				if($code == $captcha)
				{
					$U = new \Library\Model\User();
					$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
					$data = $U->register(array('phone'=>$phone,'unionid'=>$wx_id));
					$this->session->set('user_id',$data['user_id']);
					$this->session->set('user_name',$data['user_name']);
					$this->session->set('user_phone',$data['user_phone']);
					$this->session->set('user_email',$data['user_email']);
					$this->session->set('user_headpic',$data['user_headpic']);
					die(json_encode(array('code'=>0,'msg'=>'验证成功')));
				}
				else 
				{
					die(json_encode(array('code'=>1002,'msg'=>'验证码错误')));
				}
			}
			
		}
	}
	
	/****=========支付下单=========****/
	
	//支付前检测
	public function apibeforeAction()
	{
		$this->view->disable();
		$post = $this->request->getPost();
		$userId = $post['uid']; 
		$fromId = $post['sid']; 
		$actionId = $post['aid']; 
		$goods_id = $post['goodsId']; 
		$attrList = $post['attrList']; 
		$buyNumber = $post['buyNumber'];
		$note = $post['note'];
		$tmpNote = explode(':',$note);
		if(empty($tmpNote)) die(json_encode(array('state'=>0,'data'=>'参数错误')));
		
		$goodsId = $tmpNote[0];
		$qTag = $tmpNote[1];
		$parentId = $qTag?$tmpNote[2]:0;
		$cTag = $qTag?$tmpNote[3]:0;
		
		$db = $this->group;
		
		$indexInfo = $db->fetchOne("select * from yiyuanqiang_list where  is_close=0 and id = '$actionId'",\Phalcon\Db::FETCH_ASSOC);
		
		if(!$indexInfo) die(json_encode(array('state'=>0,'data'=>'活动不存在')));
		
		$data = array('state'=>1,'data'=>array(
				'paySuccessUrl'=>'http://'.$_SERVER['SERVER_NAME'].'/phone/yiyuanqiang/paysuccess/'.$fromId."/".$actionId,
				'changeBuyNum'=>0,
				'shipOnline'=>1,
				'checkExist'=>0
		));
		
		$tmp = $db->fetchOne("select * from yiyuanqiang_goods where action_id='$actionId' and goods_id='$goods_id' and id='$goodsId' and starttime<'" . date('Y-m-d H:i:s') . "'",\Phalcon\Db::FETCH_ASSOC);
		
		if(!$tmp) die(json_encode($data));
		if($qTag && ($tmp['active_quantity'] <= 0)) die(json_encode(array('state'=>0,'data'=>'该商品帮砍库存不足')));
		if($qTag && ($tmp['endtime'] < date('Y-m-d H:i:s'))) die(json_encode(array('state'=>0,'data'=>'已超过活动购买时间')));
		if(!$qTag && ($tmp['goods_quantity'] <= 0)) die(json_encode(array('state'=>0,'data'=>'该商品活动库存不足')));
		
		$checkBuy = $db->fetchColumn("select count(*) from yiyuanqiang_record where user_id='$userId' and gid='{$goodsId}' and order_id>0 and action_id='$actionId'");
		if($checkBuy) die(json_encode(array('state'=>0,'data'=>'已购买过该商品')));
		
		$R = new \Library\Model\Ext();
		$regions = $R->regions();
		$G = new \Library\Model\Goods();
		$tmp1 = $G->info(array('goodsId'=>$goods_id));
		
		
		if($parentId)  //帮砍价 
		{
			$data['data']['offsetMoney'] = $parentId ?  $this->group->fetchColumn("select sum(lower_money) from yiyuanqiang_record where parent_id = '{$parentId}'") : 0;
			if((float)$tmp1['price']['promote'] - (float)$data['data']['offsetMoney'] < 0) $data['data']['offsetMoney'] = (float)$tmp1['price']['promote'] - $tmp['lowest_price'];
			if($tmp1['price']['promote'] - $tmp['lowest_price'] < $data['data']['offsetMoney']) $data['data']['offsetMoney'] = $tmp1['price']['promote'] - $tmp['lowest_price'];
			
			if($cTag)
			{
				//该活动能否用券
				$checkUse = $db->fetchColumn("select yizhangou_id from yiyuanqiang_list where id=$actionId");
				
				if($checkUse) 	//有绑定一站购活动id
				{
					$coupons = 0;
						
					//发起人电话
					$sql = "select phone from yiyuanqiang_record where id = '{$parentId}'";
					$phone = $db->fetchColumn($sql);
					//检测报名
					$sql = "select count(*) from yizhangou_baoming where phone='{$phone}' and action_id in($checkUse) and is_used=0";
					$YregisterInfo = $db->fetchColumn($sql);
						
					$sql = "select count(*) from qmjjg_registration where phone='{$phone}' and is_used=0";
					$QregisterInfo = $db->fetchColumn($sql);
						
					if($YregisterInfo || $QregisterInfo)
					{
						$coupons +=1;
					}
						
					//检测激活
					$sql = "select count(*) from vcard_user where phone='{$phone}' and action_id in($checkUse) and is_used=0 and status=1";
					$activeInfo = $db->fetchColumn($sql);
						
					if($activeInfo)
					{
						$coupons +=1;
					}
					
					if($coupons > 0)
					{
						$data['data']['offsetMoney'] +=100;
						if((float)$tmp1['price']['promote'] - (float)$data['data']['offsetMoney'] < 0) $data['data']['offsetMoney'] = (float)$tmp1['price']['promote'] - $tmp['lowest_price'];
						if($tmp1['price']['promote'] - $tmp['lowest_price'] < $data['data']['offsetMoney']) $data['data']['offsetMoney'] = $tmp1['price']['promote'] - $tmp['lowest_price'];
					}
						
				}
			}
		}
		else 		//优惠价
		{	
			$data['data']['offsetMoney'] = $tmp1['price']['promote'] - round($tmp1['price']['promote'] * $tmp['discount'] * (0.1),0);
		}
		
		if($tmp['shipping'] >= 1){
			$ship = $this->group->fetchOne("select * from yiyuanqiang_shipping where shipping_id = '".$tmp['shipping'] ."'",\Phalcon\Db::FETCH_ASSOC);
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
			$ship = $this->group->fetchAll("select * from yiyuanqiang_shipping where action_id = '".$actionId . "'",\Phalcon\Db::FETCH_ASSOC);
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
	public function apidoingAction()
	{
		$post = $this->request->getPost();
		$uid = $post['uid']; $fromId = $post['sid']; $actionId = $post['aid']; $orderId = $post['orderId'];
		die(json_encode(array('state'=>1,'data'=>'入库成功!')));
	}
	
	//取消订单
	public function apicancelAction()
	{
		$post = $this->request->getPost();
		$fromId = $post['sid']; $actionId = $post['aid']; $orderId = $post['orderId'];
	}
	
	//订单支付成功后
	public function apiafterAction()
	{
		$post = $this->request->getPost();
		$fromId = $post['sid']; 
		$actionId = $post['aid']; 
		$orderId = $post['orderId'];
		
		$Order = new \Library\Model\Order();
		$info = $Order->info(array('orderId'=>$orderId));
		
		if(empty($info)) exit();
		$db = $this->group;
		
		$tmpNote = explode(':',$info['systemNote']);
		
		$goods_id = $tmpNote[0];
		$qTag = $tmpNote[1];
		$cTag = $qTag?$tmpNote[3]:0;
		if($qTag)
		{
			$parentId = $tmpNote[2];
			$goodsInfo = $db->fetchOne("select * from yiyuanqiang_record where id={$parentId}");
			$db->execute("update yiyuanqiang_goods set active_quantity = active_quantity - 1,sales_sum = sales_sum + 1 where id={$goodsInfo['gid']}");
			$db->execute("update yiyuanqiang_record set order_id = {$orderId},pay_amount='{$info['moneyPaid']}' where id={$parentId} and order_id=0");
			
			//使用券
			if($cTag)
			{
				//该活动能否用券
				$checkUse = $db->fetchColumn("select yizhangou_id from yiyuanqiang_list where id=$actionId");
			
				if($checkUse) 	//有绑定一站购活动id
				{
					//发起人电话
					$sql = "select phone from yiyuanqiang_record where id = '{$parentId}'";
					$phone = $db->fetchColumn($sql);
					//检测报名
					$sql = "select count(*) from yizhangou_baoming where phone='{$phone}' and action_id in($checkUse) and is_used=0";
					$YregisterInfo = $db->fetchColumn($sql);
			
					$sql = "select count(*) from qmjjg_registration where phone='{$phone}' and is_used=0";
					$QregisterInfo = $db->fetchColumn($sql);
			
					if($YregisterInfo || $QregisterInfo)
					{
						$db->execute("update yizhangou_baoming set is_used=1 where phone='{$phone}' and action_id in($checkUse) and is_used=0");
						$db->execute("update qmjjg_registration set is_used=1 where phone='{$phone}' and is_used=0");
					}
					else 
					{
						$db->execute("update vcard_user set is_used=1 where phone='{$phone}' and action_id in($checkUse) and is_used=0 and status=1");
					}
			
				}
			}
		}
		else 
		{
			
			$db->execute("update yiyuanqiang_goods set goods_quantity = goods_quantity - 1,sales_sum = sales_sum + 1 where id={$goods_id}");
		}
		
	}
	
	//支付信息返回显示
	public function paysuccessAction()
	{
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
	}
	
	/**
	 * 倒计时格式化
	 * @param string $endtime
	 * @return string
	 */
	private function ctime($endtime)
	{
		$second = strtotime($endtime) - time();
		$day=floor($second/(3600*24));
		$second = $second%(3600*24);
		$hour = floor($second/3600);
		$second = $second%3600;
		$minute = floor($second/60);
		$second = $second%60;
		if($day>0)
		{
			return "剩余".$day."天".$hour."小时";
		}
		else
		{
			return "剩余".$hour."小时".$second."分钟";
		}
	}
	
	//检测该用户是否可砍
	private function checkCut($goodsId,$fromId,$obj=0)
	{
		if(!$goodsId || !$fromId)
		{
			$this->errMsg = '参数缺失';
			return false;
		}
		
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		$db = $this->group;
		
		//检测该商品是否可砍
		$goodsInfo = $db->fetchOne("select * from yiyuanqiang_goods where id={$goodsId} and endtime>'" . date('Y-m-d H:i:s') . "' and active_quantity>0  and is_remove=0",\Phalcon\Db::FETCH_ASSOC);
		
		if(empty($goodsInfo))
		{
			$this->errMsg = '该商品已下架';
			return false;
		}
		
		//检测是否有发起砍价
		$recordInfo = $db->fetchOne("select * from yiyuanqiang_record where id={$fromId} and gid={$goodsId} and order_id=0",\Phalcon\Db::FETCH_ASSOC);
		
		if(empty($recordInfo))
		{
			$this->errMsg = '该商品还没发起帮砍';
			return false;
		}
		
		//检测可砍次数
		$sql = "select * from yiyuanqiang_user_count where 1=1";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		$userInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		
		//该用户已砍次数
		$sql = "select count(*) as c from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId}";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		$count = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		
		
		//已砍次数
		switch ($obj)
		{
			case 1: 		//我的次数
				if($count['c'] >= ($userInfo['my_count'] + $userInfo['share_count'] + $userInfo['att_count']))
				{ 
					$this->errMsg = '您的砍价次数已用完';
					return false;
				}
				break;
				
			case 2: 		//帮砍次数
				$sql = "select share_tag from yiyuanqiang_record where parent_id={$fromId} and gid={$goodsId}";
				if(!empty($phone)) $sql .= " and phone='{$phone}'";
				elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
				$sql .= " order by share_tag desc";
				$shareTag = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
				
				if(($count['c'] >= $userInfo['fre_count'] && !$shareTag['share_tag'])) 
				{
					$this->errMsg = '您的砍价次数已用完，分享后可获得一次帮砍机会（每人最多获得一次）';
					return false;
				}
				
				if(($count['c'] >= ($userInfo['fre_count'] + $shareTag['share_tag'])))
				{
					$this->errMsg = '您的砍价次数已用完';
					return false;
				}
				
				
				break;
				
			default:
				$this->errMsg = '参数错误';
				return false;
				break;
		}
			
		return true;
	}
	
	private function cutMoney($goodsId,$fromId,$isParent=false)
	{
		$db = $this->group;
		$goodsInfo = $db->fetchOne("select * from yiyuanqiang_goods where id={$goodsId}",\Phalcon\Db::FETCH_ASSOC);
		
		$G = new \Library\Model\Goods();
		$goodsDetail = $G->idList(array('idList'=>array($goodsInfo['goods_id'])));
		
		//发起帮砍马上砍一刀
		if($fromId == 0)
		{
			$tmp =  round($goodsInfo['range_min'] + mt_rand() / mt_getrandmax() * ($goodsInfo['range_max'] - $goodsInfo['range_min']),2);
			$cutMoney =round($tmp * (0.05 + 1) * 2,2);
			if($cutMoney > $goodsDetail['list'][0]['price']['promote'])
			{
				return array(round($goodsDetail['list'][0]['price']['promote'] - $goodsInfo['lowest_price'],2),$goodsInfo['lowest_price']);
			}
			else
			{
				return array($cutMoney,$goodsDetail['list'][0]['price']['promote'] - $cutMoney);
			}
		}
		
		//已砍的价钱
		$sumCut = $db->fetchOne("select sum(lower_money) as s from yiyuanqiang_record where gid={$goodsId} and parent_id={$fromId}",\Phalcon\Db::FETCH_ASSOC);
		//砍后价钱
		$currPrice= $goodsDetail['list'][0]['price']['promote'] - $sumCut['s'];
		
		if($goodsInfo['lowest_price'] >= $currPrice)
		{
			return array(0,$currPrice);
		}
		
		//已砍次数
		$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
		$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
		$sql = "select count(*) as c from yiyuanqiang_record where gid={$goodsId} and parent_id={$fromId}";
		if(!empty($phone)) $sql .= " and phone='{$phone}'";
		elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
		$count = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		
		//是否发起人
		$ratio = 1;
		if($isParent)
		{
			if($count['c'] < 2)
			{
				$ratio = 2;
			}
			else 
			{
				if($this->getRatio(1))
				{
					$ratio = 2;
				}
			}
		}
		else //帮砍人
		{
			if($this->getRatio(2))
			{
				$ratio = 2;
			}
		}
		
		$tmp =  round($goodsInfo['range_min'] + mt_rand() / mt_getrandmax() * ($goodsInfo['range_max'] - $goodsInfo['range_min']),2);
		$cutMoney =round($tmp * (0.05 + $currPrice/$goodsDetail['list'][0]['price']['promote']) * $ratio,2);
		
		if($cutMoney > $currPrice - $goodsInfo['lowest_price'])
		{
			return array(round($currPrice - $goodsInfo['lowest_price'],2),$goodsInfo['lowest_price']);
		}
		else
		{
			return array($cutMoney,$currPrice - $cutMoney);
		}
	}
	
	private function getRatio($obj)
	{
		if($obj == 1)
		{
			$p0 = array_fill(0,95, 0);
			$p1 = array_fill(0,5, 1);
		}
		elseif($obj == 2)
		{
			$p0 = array_fill(0,90, 0);
			$p1 = array_fill(0,10, 1);
		}
		
		$arr_m = array_merge($p0,$p1);
		shuffle($arr_m);
		
		$pn = mt_rand(0,count($arr_m) - 1);
		$nums = $arr_m[$pn];
		
		if($nums == 1)
		{
			return true;
		}
		
		return false;
	}
	
	protected function logSql($content) {
		$time = date('YmdHis',time());
		$logfilename = APP_PATH . "/data/log/cut_sql_".$time.'.txt';
		$fp = fopen($logfilename,"a");
		chmod($logfilename,777);
		flock($fp, LOCK_EX) ;
		fwrite($fp,$content);
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
	public function loopTreatAction()
	{
		$wxarr = $this->group->fetchAll("SELECT wx_id from yiyuanqiang_record where wx_id is not null GROUP BY wx_id LIMIT 201");
		$unarr = $this->group->fetchAll("SELECT username from yiyuanqiang_record where username is not null GROUP BY username ORDER BY id desc LIMIT 201");
		
		
		for ($i=0;$i<1000;)
		{
			$randnum = rand(0, 200);
			$cutMoneyList = $this->cutMoney(469, 304259);
			
			if($cutMoneyList[0] <= 0)
			{
				break;
			}
			
			$sql = "insert into yiyuanqiang_record(`action_id`,`gid`,`parent_id`,`user_id`,`username`,`lower_money`,`time`,wx_id) VALUES (5,469,304259,0,'{$unarr[$randnum]['username']}','{$cutMoneyList[0]}','" . date('Y-m-d H:i:s') . "','{$wxarr[$randnum]['wx_id']}')";
// 		var_dump($sql);die;
		
			$this->group->execute($sql);
			$i++;
		}
		
		echo 'ok';
	}
	
	/**
	 * 		一元抢列表页
	 * 		2016-1-20 添加
	 */
	public function listAction()
	{
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
		$this->view->setVar("payDomain", $this->config->payDomain);
		
		$db = $this->group;
		$indexInfo = $db->fetchOne("select * from yiyuanqiang_list where is_close=0 order by id desc limit 1",\Phalcon\Db::FETCH_ASSOC);
		
		for($i=1;$i<=4;)
		{
			if(!empty($indexInfo['adv' . $i . '_img']))
			{
				$indexInfo['adv' . $i . '_img'] = '/uploads/yiyuanqiang/' . $indexInfo['adv' . $i . '_img'];
			}
			else
			{
				unset($indexInfo['adv' . $i . '_img']);
			}
			$i++;
		}
		$indexInfo['desc'] = htmlspecialchars_decode($indexInfo['desc']);
		
		//城市列表
		/*
		 $cityList = $this->redis->get('yiyuanqiang_city_list' . $actionId);
		 if(empty($cityList))
		 {
		 $cityList = $db->fetchAll("select * from yiyuanqiang_city_list where action_id = ".$actionId,\Phalcon\Db::FETCH_ASSOC);
		 $this->redis->set('yiyuanqiang_city_list' . $actionId,json_encode($cityList),600);
		 }
		 else
		 {
		 $cityList = json_decode($cityList, true);
		 }
		*/
		
		$cityList = $db->fetchAll("SELECT a.* FROM yiyuanqiang_city_list a left join yiyuanqiang_list b on a.action_id = b.id where b.is_close=0 group by city_name",\Phalcon\Db::FETCH_ASSOC);
		//城市定位
		$allowAddress = isset($_GET['city']) ? trim($_GET['city']) : '';
		$cityCode = $db->fetchOne("select city_code,city_name from yiyuanqiang_city_list where city_id='$allowAddress' limit 1",\Phalcon\Db::FETCH_ASSOC);
		$cityId = $cityCode?$cityCode['city_code']:'';
		$content = $this->point_model->getCity2($cityId);
		
		$G = new \Library\Model\Goods();
		$allowAddress = $content['code'];
		$cityName = $cityCode ? trim($cityCode['city_name']) : $content['city'];
		$this->view->setVars(array('cityname'=>$cityName));
		
		//正在进行的商品列表
		$sumJoin = $db->fetchColumn("select count(*) from yiyuanqiang_record");
		$ngoodsList = $this->redis->get('yiyuanqianglist_nglist' . $actionId);
		if(empty($ngoodsList))
		{
			$ngoodsList = $db->fetchAll("select * from yiyuanqiang_goods where starttime<'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "'  and is_remove=0 order by is_top desc,join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
			$this->redis->set('yiyuanqianglist_nglist' . $actionId,json_encode($ngoodsList),300);
		}
		else
		{
			$ngoodsList = json_decode($ngoodsList, true);
		}
		foreach ($ngoodsList as $k=>$v)
		{
			$data = $this->redis->get('list_ng_'.$v['goods_id'].'_'.$allowAddress);
			if(empty($data))
			{
				$data = $G->lists(array('goodsId'=>$v['goods_id'],'allowAddress'=>$allowAddress));
				$this->redis->set('list_ng_'.$v['goods_id'].'_'.$allowAddress, json_encode($data), 300);
			} else {
				$data = json_decode($data, true);
			}
				
			if(!$data)
			{
				unset($ngoodsList[$k]);continue;
			}
			// 			var_dump($data);die;
				
			$ngoodsList[$k]['goods_name'] = mb_strlen($data['list'][0]['name'],'utf-8')>12?mb_substr($data['list'][0]['name'], 0,11,'utf-8') . '...':$data['list'][0]['name'];
			$ngoodsList[$k]['market_price'] = number_format($data['list'][0]['price']['market'],2,'.','');		//原价
			$ngoodsList[$k]['kan_price'] = number_format($data['list'][0]['price']['promote'],2,'.','');		//原价
			// 			$ngoodsList[$k]['discount_price'] = number_format(round($data['list'][0]['price']['promote'] * $ngoodsList[$k]['discount'] * (0.1),0),0,'.','');		//折扣价
			$ngoodsList[$k]['discount'] = round($ngoodsList[$k]['discount_price'] / $data['list'][0]['price']['promote'],2)*10;		//折扣
			$ngoodsList[$k]['discount_price'] = number_format($ngoodsList[$k]['discount_price'],0,'.','');		//折扣价
			$ngoodsList[$k]['img'] = $this->config->pcHome."/".$data['list'][0]['image']['img'];		//商品图片
				
			$ngoodsList[$k]['countdown_str'] = $this->ctime($ngoodsList[$k]['endtime']);
			$sumJoin += $v['init_join'];
			//参与人次
			$cutCount = $db->fetchColumn("select count(*) from yiyuanqiang_record where gid={$v['id']}");
			$ngoodsList[$k]['cutcount'] = $cutCount;
			//该用户是否有发起过该商品
			$phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : '';
			// 			$wx_id = $this->session->has('wechat_unionid') ? $this->session->get('wechat_unionid') : '';
				
			$fromInfo = array();
			if(!empty($phone) /*|| !empty($wx_id)*/)
			{
				$sql = "select id from yiyuanqiang_record where gid='{$v['id']}' and id=parent_id";
				if(!empty($phone)) $sql .= " and phone='{$phone}'";
				// 				elseif(!empty($wx_id)) $sql .= " and wx_id='{$wx_id}'";
				$fromInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			}
			$ngoodsList[$k]['from_id'] = empty($fromInfo)?0:$fromInfo['id'];
				
			//被砍至最低价成交金额
			if($ngoodsList[$k]['sales_sum'] > 0)
			{
				$sql = "select pay_amount from yiyuanqiang_record where gid={$v['id']} and id=parent_id and pay_amount>0 and order_id>0 order by pay_amount asc";
				$payInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
				$ngoodsList[$k]['pay_amount'] = $payInfo['pay_amount'];
		
			}
		}
		//即将开始的商品列表
		$pgoodsList = $db->fetchAll("select * from yiyuanqiang_goods where starttime>'" . date('Y-m-d H:i:s') . "' and endtime>'" . date('Y-m-d H:i:s') . "' and (goods_quantity>0 or active_quantity>0) and is_remove=0 order by join_sum desc,lowest_price asc,starttime asc,sort asc",\Phalcon\Db::FETCH_ASSOC);
		foreach ($pgoodsList as $k=>$v)
		{
			$data = $G->lists(array('goodsId'=>$v['goods_id'],'allowAddress'=>$allowAddress));
			if(!$data)
			{
				unset($pgoodsList[$k]);continue;
			}
			$pgoodsList[$k]['goods_name'] = mb_strlen($data['list'][0]['name'],'utf-8')>12?mb_substr($data['list'][0]['name'], 0,11,'utf-8') . '...':$data['list'][0]['name'];
			$pgoodsList[$k]['market_price'] = number_format($data['list'][0]['price']['market'],2,'.','');		//原价
			$pgoodsList[$k]['img'] = $this->config->pcHome."/".$data['list'][0]['image']['img'];		//商品图片
		
			$pgoodsList[$k]['countdown_str'] = date('n月j日',strtotime($pgoodsList[$k]['starttime'])) . '开抢';
				
			$pgoodsList[$k]['from_id'] = 0;
				
		}
		
		$this->view->setVars(array('indexinfo'=>$indexInfo,'ngoodslist'=>$ngoodsList,'pgoodslist'=>$pgoodsList,'sumjoin'=>$sumJoin,'citylist'=>$cityList));
		// 		$this->view->signPackage = $this->wxAPI->get_share();
		$signPackage = $this->jssdk->GetSignPackage();
		$this->view->setVar("signPackage", $signPackage);
		
		
	}

}
