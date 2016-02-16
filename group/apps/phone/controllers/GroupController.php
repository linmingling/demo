<?php
namespace Apps\Phone\Controllers;

class GroupController extends ControllerBase {
    
    private $funs_model;
	private $sms;
	private $point_model;
	private $jssdk;
	private $location_model;
	private $login_api;
	private $domain;

    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms = new \Library\Com\LibSms();
		$this->point_model = new \Library\Com\GroupPoint($this->group);
		$this->location_model = new \Library\Com\Location();
		$this->jssdk = new \Library\Com\JSSDK();
// 		if($_SERVER['HTTP_HOST'] == 'group.yoju360.net'){
// 		    $this->domain = "http://pay.yoju360.net";
// 		} else {
// 		    $this->domain = "http://pay.yoju360.com";
// 		}
		$this->domain = $this->config->payDomain;
		$this->login_api = $this->domain."/phone/login";
		$this->view->setVar("domain", $this->domain);
		$this->wxlogin();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	$this->view->setVar("payDomain", $this->config->payDomain);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $this->session->set('url_source', $from);
        
        $city_code = $this->dispatcher->getParam(0);
        //开放城市列表
        $sql = "SELECT * FROM group_list WHERE is_open=1";
        $city_list = $this->group->fetchAll($sql);
        $this->view->setVar("city_list", $city_list);
        
        //定位城市信息
        $location = $this->point_model->getCity($city_code, $city_list);
        $this->session->set('city_code', $location['city_code']);
        $this->view->setVar("location", $location);
//         echo '<pre>';print_r($this->session->get('city_code'));exit;
        //当前所选的城市站信息
        $sql = "SELECT * FROM group_list WHERE city_code='".$location['city_code']."'";
        $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        $this->view->setVar("info", $info);
        
        //商品分类
        if($info['class_id']){
            $sql = "SELECT * FROM group_class_list WHERE id IN (".$info['class_id'].")";
            $class_list = $this->group->fetchAll($sql);
            $this->view->setVar("class_list", $class_list);
            
            //商品列表(已开始)
            $sql = "SELECT * FROM group_goods_list WHERE action_id='".$info['id']."' AND start_time<".time()." AND end_time>".time()." AND is_show=1 OR is_site=1 AND start_time<".time()." AND end_time>".time()." AND is_show=1 ORDER BY sort DESC,end_time ASC";
            $goods_array = $this->group->fetchAll($sql);
            foreach ($goods_array as $k => $key){
                $brand_arr[] = $key['brand_id'];//品牌
            }
            $brand_id = implode(',', $brand_arr);
            $brand_id = empty($brand_id) ? 0 : $brand_id;
            $sql = "SELECT * FROM group_brand_list WHERE id IN (".$brand_id.")";
            $brand_list = $this->group->fetchAll($sql);
            foreach ($brand_list as $k => $key){
                $barnd[$key['id']] = $key['img_url'];
            }
            foreach ($goods_array as $k => $key){
                $goods_array[$k]['goods_img'] = explode(',', $key['goods_img'])[0];
                $goods_array[$k]['brand_img'] = $barnd[$key['brand_id']];
                $goods_array[$k]['discount'] = round(intval($key['exclusive_price']) / intval($key['market_price']) * 10, 1);
                $timediff = $key['end_time'] - time();
                if(intval($timediff / 86400)){
                    $goods_array[$k]['countdown'] = intval($timediff / 86400).'天'.intval(($timediff % 86400) / 3600).'小时';
                } else {
                    $goods_array[$k]['countdown'] = intval(($timediff % 86400) / 3600).'小时'.intval((($timediff % 86400) % 3600) / 60).'分';
                }
            }
            $goods_list[0] = $goods_array;
            foreach ($class_list as $k => $key){
                foreach ($goods_array as $k_i => $key_i){
                    if($key_i['class_id'] == $key['id']){
                        $goods_arr[$key['id']][] = $key_i;
                    }
                }
            }
            foreach ($class_list as $k => $key){
                $goods_list[$key['id']] = empty($goods_arr[$key['id']]) ? array(array()) : $goods_arr[$key['id']];
            }
            $this->view->setVar("goods_list", $goods_list);
//             echo '<pre>';print_r($goods_list);exit;
            
            
            //商品列表(即将开始)
            $sql = "SELECT * FROM group_goods_list WHERE action_id='".$info['id']."' AND start_time>".time()." AND is_show=1 ORDER BY sort DESC,start_time ASC";
            $soon_goods_array = $this->group->fetchAll($sql);
            foreach ($soon_goods_array as $k => $key){
                $soon_brand_arr[] = $key['brand_id'];//品牌
            }
            $soon_brand_id = implode(',', $soon_brand_arr);
            $soon_brand_id = empty($soon_brand_id) ? 0 : $soon_brand_id;
            $sql = "SELECT * FROM group_brand_list WHERE id IN (".$soon_brand_id.")";
            $soon_brand_list = $this->group->fetchAll($sql);
            foreach ($soon_brand_list as $k => $key){
                $soon_barnd[$key['id']] = $key['img_url'];
            }
            foreach ($soon_goods_array as $k => $key){
                $soon_goods_array[$k]['brand_img'] = $soon_barnd[$key['brand_id']];
                $soon_goods_array[$k]['discount'] = round(intval($key['exclusive_price']) / intval($key['market_price']) * 10, 1);
            }
            $soon_goods_list[0] = $soon_goods_array;
            foreach ($class_list as $k => $key){
                foreach ($soon_goods_array as $k_i => $key_i){
                    if($key_i['class_id'] == $key['id']){
                        $soon_goods_arr[$key['id']][] = $key_i;
                    }
                }
            }
            foreach ($class_list as $k => $key){
                $soon_goods_list[$key['id']] = empty($soon_goods_arr[$key['id']]) ? array(array()) : $soon_goods_arr[$key['id']];
            }
            $this->view->setVar("soon_goods_list", $soon_goods_list);
        }
//         echo '<pre>';print_r($soon_goods_list);exit;
        
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
    }
    
    public function detailAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $goods_id = $this->dispatcher->getParam(0);
        if(empty($goods_id)){
            $this->header();
        }
        $sql = "SELECT * FROM group_goods_list WHERE id=".$goods_id;
        $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        if($info && $info['is_show']){
        	
        	/**
        	 * 2016-1-19 新加
        	 * 		浏览量
        	 */
        	
        	$this->group->execute("update group_goods_list set view_num=view_num+1 where id=$goods_id");
        	
        	/**
        	 * end
        	 */
        	
//             echo '<pre>';print_r($info);exit;
            $info['discount'] = round(intval($info['exclusive_price']) / intval($info['market_price']) * 10, 1);
            $info['goods_img'] = explode(',', $info['goods_img']);
            
            $timediff = $info['end_time'] - time();
            if(intval($timediff / 86400)){
                $info['countdown'] = intval($timediff / 86400).'天'.intval(($timediff % 86400) / 3600).'小时';
            } else {
                $info['countdown'] = intval(($timediff % 86400) / 3600).'小时'.intval((($timediff % 86400) % 3600) / 60).'分';
            }
            
            $discount_id = $info['discount_id'];
            $store_id = $info['store_id'];
            //优惠信息
            if($discount_id){
                $sql = "SELECT * FROM group_discount_list WHERE id IN(".$discount_id.")";
                $info['discount_list'] = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
            }
            //适用门店
            if($store_id){
                $sql = "SELECT * FROM group_store_list WHERE id IN(".$store_id.")";
                $info['store_list'] = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
                $info['store_num'] = count($info['store_list']);
            }
//             echo '<pre>';print_r($info);exit;
            
            /**
             * 猜你喜欢 2015-11-24 新增
             */
            $sql = "SELECT * FROM group_list WHERE id='".$info['action_id']."'";
            $act_info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
            //商品分类
            if($act_info['class_id']){
                $sql = "SELECT * FROM group_class_list WHERE id IN (".$act_info['class_id'].")";
                $class_list = $this->group->fetchAll($sql);
            }
            
            $where = "WHERE end_time > '".time()."' AND is_show=1 AND id <> '".$info['id']."' AND action_id='".$info['action_id']."'";
            $like_sql = "SELECT * FROM group_goods_list ".$where." AND brand_id='".$info['brand_id']."' LIMIT 5";
            $like_info = $this->group->fetchAll($like_sql,\Phalcon\Db::FETCH_ASSOC);
            if(count($like_info) !=5 ){
                foreach ($like_info as $k => $key){
                    $id_array[] = $key['id'];
                }
                if($id_array){
                    $id_arr = implode(',', $id_array);
                } else {
                    $id_arr = $info['id'];
                }
                $_like_sql = "SELECT * FROM group_goods_list ".$where." AND id NOT IN(".$id_arr.") AND class_id='".$info['class_id']."' LIMIT ".(5-count($like_info));
                $_like_info = $this->group->fetchAll($_like_sql,\Phalcon\Db::FETCH_ASSOC);
                if(count($_like_info) != 5 - count($like_info)){
                    foreach ($_like_info as $k => $key){
                        $_id_array[] = $key['id'];
                    }
                    if($_id_array){
                        $_id_arr = implode(',', $_id_array);
                    } else {
                        $_id_arr = $info['id'];
                    }
                    $_id_arr = $id_arr.','.$_id_arr;
                    $last = "SELECT * FROM group_goods_list ".$where." AND id NOT IN(".$_id_arr.") LIMIT ".(5-count($like_info)-count($_like_info));
                    $last_info = $this->group->fetchAll($last,\Phalcon\Db::FETCH_ASSOC);
                } else {
                    $last_info = array();
                }
            } else {
                $_like_info = array();
            }
            $like_array = array_merge($like_info, $_like_info);
            $goods_array = array_merge($like_array, $last_info);
            foreach ($goods_array as $k => $key){
                $brand_arr[] = $key['brand_id'];//品牌
            }
            $brand_id = implode(',', $brand_arr);
            $brand_id = empty($brand_id) ? 0 : $brand_id;
            $sql = "SELECT * FROM group_brand_list WHERE id IN (".$brand_id.")";
            $brand_list = $this->group->fetchAll($sql);
            foreach ($brand_list as $k => $key){
                $barnd[$key['id']] = $key['img_url'];
            }
            foreach ($goods_array as $k => $key){
                $goods_array[$k]['goods_img'] = explode(',', $key['goods_img'])[0];
                $goods_array[$k]['brand_img'] = $barnd[$key['brand_id']];
                $goods_array[$k]['discount'] = round(intval($key['exclusive_price']) / intval($key['market_price']) * 10, 1);
                $timediff = $key['end_time'] - time();
                if(intval($timediff / 86400)){
                    $goods_array[$k]['countdown'] = intval($timediff / 86400).'天'.intval(($timediff % 86400) / 3600).'小时';
                } else {
                    $goods_array[$k]['countdown'] = intval(($timediff % 86400) / 3600).'小时'.intval((($timediff % 86400) % 3600) / 60).'分';
                }
            }
            $goods_array = $this->funs_model->array_sort($goods_array, 'discount', 'asc');
            $this->view->setVar("goods_list", $goods_array);
//             echo '<pre>';print_r($goods_array);exit;
            /**
             * end
             */
            
            $this->view->setVar("info", $info);
            $backurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
            $this->session->set('backurl', $backurl);
            $this->view->setVar("login_url", $this->login_api."?backurl=".$backurl);
            $this->view->setVar("history", "http://".$_SERVER['HTTP_HOST']."/phone/group/index");
            
            $signPackage = $this->jssdk->GetSignPackage();
            $this->view->setVar("signPackage", $signPackage);
            
        } else {
            $this->header();
        }
    }
    
    public function header($data){
        if($data){
            if($data['errcode'] == 1){
                //成功支付页面
                $paySuccessUrl = "http://".$_SERVER['HTTP_HOST']."/phone/group/notify/".$data['errcode'].'/'.$data['goods_id'];
                //支付失败页面
                $payFailUrl = "http://".$_SERVER['HTTP_HOST']."/phone/group/detail/".$data['goods_id'];
                $this->session->set('5_0_paySuccessUrl',$paySuccessUrl);
                $this->session->set('5_0_payFailUrl',$payFailUrl);
                $headr_url = $this->config->payDomain .'/phone/pay/doing/'.$data['order_id'];
            } else {
                $headr_url = "http://".$_SERVER['HTTP_HOST']."/phone/group/notify/".$data['errcode'].'/'.$data['goods_id'];
            }
        } else {
            $headr_url = "http://".$_SERVER['HTTP_HOST']."/phone/group/index";
        }
        header("location: $headr_url");exit;
    }
    
    
    //支付（需要填写收货地址）
    public function buyAction(){
//         $this->wxlogin();
    	$this->view->setVar("payDomain", $this->config->payDomain);
    	
        $goods_id = $this->dispatcher->getParam(0);
        if(empty($goods_id)){
            $data['goods_id'] = "";
            $data['errcode'] = "1000";
            $data['errmsg'] = "商品不存在或已下架！";
            $this->header($data);exit;
        }
        
        $user_id = $this->session->get('user_id');
        if(empty($user_id)){
            $backurl = $this->login_api."?backurl=".urlencode("http://".$_SERVER['HTTP_HOST']."/phone/group/detail/".$goods_id);
            header("location: $backurl");exit;
        }
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(!strpos($agent,"MicroMessenger")){
            $pay_id = 1;
        } else {
            $pay_id = 6;
        }
        
        $sql = "SELECT * FROM group_goods_list WHERE id=".$goods_id;
        $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        $info['goods_img'] = explode(',', $info['goods_img']);
        
        $this->view->setVar("pay_id", $pay_id);
        $this->view->setVar("info", $info);
//         echo "<pre>";print_r($info);exit;
        
        $address_id = $this->upin->fetchColumn("SELECT address_id FROM ecs_users WHERE user_id = ".intval($user_id));
        if($address_id){
            $default_add = $this->upin->fetchOne("SELECT * FROM ecs_user_address WHERE address_id = ".$address_id,\Phalcon\Db::FETCH_ASSOC);
        }
//         echo "<pre>";print_r($default_add);exit;
        $this->view->setVar("default_add", $default_add);
        $this->view->setVar("gobackurl", urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
        $this->view->setVar("backoutpay", "http://".$_SERVER['HTTP_HOST']."/phone/group/detail/".$goods_id);
        $this->view->setVar("history", "http://".$_SERVER['HTTP_HOST']."/phone/group/index");
    }
    
    
    
    //支付（直接支付，不需要填写收货地址）
    public function payAction(){
        
//         $this->wxlogin();
        $user_id = $this->session->get('user_id');
        if(empty($user_id)){
            $backurl = $this->login_api."?backurl=".$this->session->get('backurl');
            header("location: $backurl");exit;
        }
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(!strpos($agent,"MicroMessenger")){
            $pay_id = 1;
            $pay_code = 'alipay';
            $pay_name = '支付宝';
        } else {
            $pay_id = 6;
            $pay_code = 'wxpay';
            $pay_name = '微信支付';
        }
        
        $goods_id = $this->dispatcher->getParam(0);
        if(empty($goods_id)){
            $data['goods_id'] = "";
            $data['errcode'] = "1000";
            $data['errmsg'] = "商品不存在或已下架！";
            $this->header($data);exit;
        }
        $sql = "SELECT * FROM group_goods_list WHERE id=".$goods_id;
        $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        $data['goods_id'] = $goods_id;
        if($info && $info['is_show']){
            if($info['end_time'] > time() && $info['start_time'] < time()){
                if($info['stock'] > 0){
                    //是否限购商品
                    if($info['limit_number']){
                        $sql = "SELECT order_id FROM ecs_order_info WHERE from_id=5 AND pay_status=2 AND user_id='".$user_id."'";
                        $is_limit = $this->upin->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
                        foreach ($is_limit as $k => $key){
                            $order_arr[] = $key['order_id'];
                        }
                        $order_id = implode(',', $order_arr);
                        if($order_id){
                            $sql = "SELECT COUNT(rec_id) AS num FROM ecs_order_goods WHERE order_id IN (".$order_id.") AND goods_id='".$goods_id."'";
                            $limit_count = $this->upin->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                            if($limit_count['num'] >= $info['limit_number']){
                                $data['errcode'] = "1004";
                                $data['errmsg'] = "该商品为限购商品，您已达购买上限！";
                                $this->header($data);exit;
                            }
                        }
                    }
                    
                    $mch_billno = date('Ymdhis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                    $mobile = $this->session->get('user_phone');
                    if($info['service'] == 0){
                        //线下提货
                        $sql = "INSERT INTO ecs_order_info (".
                        "from_id, action_id, order_sn, user_id, order_status, pay_status, mobile, pay_id, pay_code, pay_name, goods_amount, money_paid, order_amount, add_time, pay_time, pay_note) VALUES('5','0','".
                        $mch_billno."','".$user_id."','0','0','".$mobile."','".$pay_id."','".$pay_code."','".$pay_name."','".$info['exclusive_price']."','0','".$info['order_price']."','".time()."','0','优品团')";
                    } else {
                        //上门服务
                        $address_id = $this->upin->fetchColumn("SELECT address_id FROM ecs_users WHERE user_id = ".intval($user_id));
                        if($address_id){
                            $default_add = $this->upin->fetchOne("SELECT * FROM ecs_user_address WHERE address_id = ".$address_id,\Phalcon\Db::FETCH_ASSOC);
                            if(empty($default_add)){
                                $data['errcode'] = "1005";
                                $data['errmsg'] = "收货地址异常，请检查收货地址！";
                                $this->header($data);exit;
                            }
                        }
                        $sql = "INSERT INTO ecs_order_info (from_id, action_id, order_sn, user_id, "."
                            order_status, pay_status, consignee, country, province, city, district, address, "."
                            mobile, pay_id, pay_code, pay_name, goods_amount, money_paid, order_amount, add_time, pay_time, pay_note) VALUES('5','0','".
                            $mch_billno."','".$user_id."','0','0','".$default_add['consignee']."','".$default_add['country']."','".$default_add['province']."','".
                            $default_add['city']."','".$default_add['district']."','".$default_add['address']."','".$default_add['mobile']."','".$pay_id."','".$pay_code."','".$pay_name."','".$info['exclusive_price']."','0','".$info['exclusive_price']."','".time()."','0','优品团')";
                    }
                    $this->upin->execute($sql);
                    $order_id = $this->upin->lastInsertId();
                    if($order_id){
                        $sql = "INSERT INTO ecs_pay_log (order_id, order_amount, order_type, is_paid) VALUES('".$order_id."','".$info['order_price']."','0','0')";
                        $this->upin->execute($sql);
                        
                        $sql = "INSERT INTO ecs_order_goods (order_id, goods_id, goods_name, goods_sn, goods_number, market_price, goods_price, goods_attr, is_real, extension_code) VALUES('".
                        $order_id."','".$goods_id."','".$info['goods_name']."','优品团','1','".$info['market_price']."','".$info['order_price']."','优品团特供商品','1','优品团特供商品')";
                        $this->upin->execute($sql);
                        
                        //下单量+1
                        $sql = "UPDATE group_goods_list SET order_num=order_num+1 WHERE id='".$goods_id."'";
                        $this->group->execute($sql);
                        
                        //订单布点
                        $city_code = $this->session->get('city_code');
                        $from = $this->session->get('url_source');
                        $sql = "INSERT INTO group_order_budian (`order_id`, `order_sn`, `goods_id`, `goods_name`, `city_code`, `url_source`, `add_time`) VALUES('".$order_id."','".$mch_billno."','".$goods_id."','".$info['goods_name']."','".$city_code."','".$from."','".time()."')";
                        $this->group->execute($sql);
                        
                        //设置定时短信
                        $apiUrl = 'http://sms.yoju360.net/api/send.do';
                        $appName = 'group';
                        $apiKey = 'db0f6f37ebeb6ea09489124345af2a45';
                        $projectName = '优品团';
                        $phone = $mobile;
                        if ($_SERVER['SERVER_NAME'] == 'group.yoju360.com')
                        	$url = 'http://w.url.cn/s/AaFI9vw';//http://pay.yoju360.com/phone/pay/order/5
                        else 
                        	$url = 'http://url.cn/iwM9ff'; //http://pay.yoju360.net/phone/pay/order/5
                        $content = '【腾讯优居】尊敬的客户，您号码为'.$mch_billno.'的订单还未付款，赶快去支付吧！支付地址：'.$url;
                        $result = $this->sms->sendSms($apiUrl, $appName, $apiKey, $projectName, $phone, $content, time()+300);
                        if($result){
                            $sql = "UPDATE ecs_order_info SET sms_id='".$result['result']['smsRecordId']."' WHERE order_id='".$order_id."'";
                            $this->upin->execute($sql);
                        }
                        
                        $data['errcode'] = "1";
                        $data['errmsg'] = "ok";
                        $data['order_id'] = $order_id;
                        $this->header($data);exit;
                    } else {
                        $data['errcode'] = "1002";
                        $data['errmsg'] = "系统繁忙，请稍后再试！";
                        $this->header($data);exit;
                    }
                } else {
                    $data['errcode'] = "1003";
                    $data['errmsg'] = "已售罄！";
                    $this->header($data);exit;
                }
            } else {
                $data['errcode'] = "1001";
                $data['errmsg'] = "商品不在活动时间内！";
                $this->header($data);exit;
            }
        } else {
            $data['errcode'] = "1000";
            $data['errmsg'] = "商品不存在或已下架！";
            $this->header($data);exit;
        }
    }
    
    //支付结果页
    public function notifyAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $errcode = $this->dispatcher->getParam(0);
        $goods_id = $this->dispatcher->getParam(1);
        $city_code = $this->session->get('city_code');
        
        /* 猜你喜欢 */
        if($goods_id){
            $sql = "SELECT action_id FROM group_goods_list WHERE id=".$goods_id;
            $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
            $where = "WHERE end_time > '".time()."' AND is_show=1 AND id <> '".$goods_id."' AND action_id='".$info['action_id']."'";
        } else {
            $sql = "SELECT id FROM group_list WHERE city_code='".$city_code."'";
            $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
            $where = "WHERE end_time > '".time()."' AND is_show=1 AND action_id='".$info['id']."'";
        }
        if($info){
            $sql = "SELECT * FROM group_goods_list ".$where." LIMIT 5";
            $goods_array = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
            
            foreach ($goods_array as $k => $key){
                $brand_arr[] = $key['brand_id'];//品牌
            }
            $brand_id = implode(',', $brand_arr);
            $brand_id = empty($brand_id) ? 0 : $brand_id;
            $sql = "SELECT * FROM group_brand_list WHERE id IN (".$brand_id.")";
            $brand_list = $this->group->fetchAll($sql);
            foreach ($brand_list as $k => $key){
                $barnd[$key['id']] = $key['img_url'];
            }
            foreach ($goods_array as $k => $key){
                $goods_array[$k]['goods_img'] = explode(',', $key['goods_img'])[0];
                $goods_array[$k]['brand_img'] = $barnd[$key['brand_id']];
                $goods_array[$k]['discount'] = round(intval($key['exclusive_price']) / intval($key['market_price']) * 10, 1);
                $timediff = $key['end_time'] - time();
                if(intval($timediff / 86400)){
                    $goods_array[$k]['countdown'] = intval($timediff / 86400).'天'.intval(($timediff % 86400) / 3600).'小时';
                } else {
                    $goods_array[$k]['countdown'] = intval(($timediff % 86400) / 3600).'小时'.intval((($timediff % 86400) % 3600) / 60).'分';
                }
            }
            $goods_list = $this->funs_model->array_sort($goods_array, 'discount', 'asc');
            $this->view->setVar("goods_list", $goods_list);
        }
        
        $signPackage = $this->jssdk->GetSignPackage();
        $history = $this->session->get('backurl');
        $headr_url = "http://".$_SERVER['HTTP_HOST']."/phone/group/index";
        $history = empty($history) ? $headr_url : $history;
        
        $this->view->setVar("history", $history);
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("errcode", $errcode);
    }
    
    //短信提醒
    public function messageAction(){
        if($this->request->isAjax()){
            $phone = trim($_POST['phone']);
            $action_id = trim($_POST['action_id']);
            $goods_id = trim($_POST['goods_id']);
            $remind_time = trim($_POST['remind_time']);
            
            $city_code = $this->session->get('city_code');
            $from = $this->session->get('url_source');
            
            if($phone){
                $sql = "SELECT id FROM group_message_list WHERE phone='".$phone."' AND action_id='".$action_id."' AND goods_id='".$goods_id."'";
                $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                if($info){
                    $ajax_result['errcode'] = 1001;
                    $ajax_result['errmsg'] = "您已设置过提醒了！";
                } else {
                    $sql = "INSERT INTO group_message_list (action_id, goods_id, city_code, url_source, phone, remind_time, add_time) VALUES('".$action_id."','".$goods_id."','".$city_code."','".$from."','".$phone."','".$remind_time."','".time()."')";
                    $this->group->execute($sql);
                    $resultId = $this->group->lastInsertId();
                    if($resultId){
                        $sql = "SELECT goods_name FROM group_goods_list WHERE id='".$goods_id."'";
                        $goods = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                        
                        $goods_name = str_replace('【', '（', $goods['goods_name']);
                        $goods_name = str_replace('】', '）', $goods_name);
                        $content = '【腾讯优居】尊敬的客户，您关注的商品“'.$goods_name.'”将在5分钟后开售，赶紧去看看吧！商品地址：http://'.$_SERVER['SERVER_NAME'].'/phone/group/detail/'.$goods_id;
                        $ajax_result['smscode'] = $this->sms->sendSms('http://sms.yoju360.net/api/send.do', 'group', 'db0f6f37ebeb6ea09489124345af2a45', '优品团', $phone, $content, $remind_time-5*60);
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = "开售提醒设置成功！我们将会在开售前5分钟为您推送提醒短信，请注意查收！";
                    } else {
                        $ajax_result['errcode'] = 1002;
                        $ajax_result['errmsg'] = "系统繁忙，请稍后重试";
                    }
                }
            } else {
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "请输入手机号码！";
            }
            die(json_encode($ajax_result));
        }
    }
    
    
    //订单验证
    public function verificationAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        if($this->request->isAjax()){
            $order_sn = trim($_POST['orderNum']);
            $sql = "SELECT order_id,from_id,is_separate,pay_status FROM ecs_order_info WHERE order_sn='".$order_sn."'";
            $order_id = $this->upin->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
            
            if($order_id){
                if($order_id['from_id'] != 5){
                    $ajax_result['errcode'] = 1001;
                    $ajax_result['errmsg'] = "该订单不属于此类活动，无法验证！";
                    die(json_encode($ajax_result));
                }
                if($order_id['pay_status'] != 2){
                    $ajax_result['errcode'] = 1002;
                    $ajax_result['errmsg'] = "该订单未支付，无法验证！";
                    die(json_encode($ajax_result));
                }
                if($order_id['is_separate'] != 0){
                    $ajax_result['errcode'] = 1001;
                    $ajax_result['errmsg'] = "该订单已经被验证过了！";
                    die(json_encode($ajax_result));
                }
                $sql = "SELECT goods_id FROM ecs_order_goods WHERE order_id='".$order_id['order_id']."'";
                $goods_id = $this->upin->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                
                $sql = "SELECT * FROM group_goods_list WHERE id='".$goods_id['goods_id']."'";
                $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                $info['goods_img'] = explode(',', $info['goods_img'])[0];
                $info['discount'] = round(intval($info['exclusive_price']) / intval($info['market_price']) * 10, 1);
                
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "ok";
                $ajax_result['info'] = $info;
            } else {
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "订单不存在！";
            }
            die(json_encode($ajax_result));
        }
    }
    
    //订单处理
    public function checkAction(){
        if($this->request->isAjax()){
            $order_sn = trim($_POST['orderNum']);
            $status = trim($_POST['status']);
            $store = trim($_POST['store']);
            
            $sql = "SELECT order_id,from_id,is_separate,pay_status FROM ecs_order_info WHERE order_sn='".$order_sn."'";
            $info = $this->upin->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
    
            if($info){
                if($info['from_id'] != 5){
                    $ajax_result['errcode'] = 1001;
                    $ajax_result['errmsg'] = "该订单不属于此类活动，无法验证！";
                    die(json_encode($ajax_result));
                }
                if($info['pay_status'] != 2){
                    $ajax_result['errcode'] = 1002;
                    $ajax_result['errmsg'] = "该订单未支付，无法验证！";
                    die(json_encode($ajax_result));
                }
                if($info['is_separate'] != 0){
                    $ajax_result['errcode'] = 1001;
                    $ajax_result['errmsg'] = "该订单已经被验证过了！";
                    die(json_encode($ajax_result));
                }
                
                $sql = "UPDATE ecs_order_info SET is_separate='".$status."',referer='".$store."',shipping_time='".time()."' WHERE order_sn='".$order_sn."'";
                $result = $this->upin->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "验证成功！";
                } else {
                    $ajax_result['errcode'] = 1002;
                    $ajax_result['errmsg'] = "系统繁忙，请稍后重试！";
                }
            } else {
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "订单不存在！";
            }
            die(json_encode($ajax_result));
        }
    }
    
    public function goods_budianAction(){
        if($this->request->isAjax()){
            $goods_id = trim($_POST['goods_id']);
            if($goods_id){
                $sql = "SELECT goods_name FROM group_goods_list WHERE id='".$goods_id."'";
                $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                $goods_name = $info['goods_name'];
                
                $city_code = $this->session->get('city_code');
                $from = $this->session->get('url_source');
                
                $sql = "INSERT INTO group_goods_budian (`goods_id`, `goods_name`, `city_code`, `url_source`, `add_time`) VALUES('".$goods_id."','".$goods_name."','".$city_code."','".$from."','".time()."')";
                $this->group->execute($sql);
                
            }
        }
    }
    
    public function buy_budianAction(){
        if($this->request->isAjax()){
            $goods_id = trim($_POST['goods_id']);
            if($goods_id){
                $sql = "SELECT goods_name FROM group_goods_list WHERE id='".$goods_id."'";
                $info = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
                $goods_name = $info['goods_name'];
    
                $city_code = $this->session->get('city_code');
                $from = $this->session->get('url_source');
    
                $sql = "INSERT INTO group_buy_budian (`goods_id`, `goods_name`, `city_code`, `url_source`, `add_time`) VALUES('".$goods_id."','".$goods_name."','".$city_code."','".$from."','".time()."')";
                $this->group->execute($sql);
    
            }
        }
    }
}
?>